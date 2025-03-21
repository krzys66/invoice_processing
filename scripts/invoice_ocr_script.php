<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

$folder_path = 'C:\xampp\htdocs\invoice_processing_using_ocr\uploads\\';
$processed_folder = 'C:\xampp\htdocs\invoice_processing_using_ocr\processed\\';

$subscription_key = 'YOUR_API_KEY';
$endpoint = 'YOUR_ENDPOINT';  

if (!is_dir($processed_folder)) {
    mkdir($processed_folder, 0777, true); 
}

$files = scandir($folder_path);
if ($files === false) {
    die('Error reading directory: ' . $folder_path);
}

$images = array_filter($files, function($file) use ($folder_path) {
    $file_path = $folder_path . $file;
    return is_file($file_path) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
});

if (count($images) > 0) {
    foreach ($images as $image) {
        $image_path = $folder_path . $image;
        $image_data = file_get_contents($image_path);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/octet-stream',
            'Ocp-Apim-Subscription-Key: ' . $subscription_key
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $image_data);

        $response = curl_exec($ch);
        if(curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        }
        curl_close($ch);

        if ($response) {
            $response_data = json_decode($response, true);

            if (isset($response_data['regions']) && count($response_data['regions']) > 0) {
                $invoice_data = [];
                foreach ($response_data['regions'] as $region) {
                    foreach ($region['lines'] as $line) {
                        if (isset($line['words']) && is_array($line['words'])) {
                            $words = array_map(function($word) {
                                return $word['text']; 
                            }, $line['words']);
                            $sentence = implode(' ', $words);
                            $invoice_data[] = $sentence; 
                        } else {
                            echo "Brak słów w linii.\n";
                        }
                    }
                }

                $json_data = [
                    'text' => $invoice_data
                ];

                $current_datetime = date('Y-m-d_H-i-s');
                $json_file_name = $processed_folder . pathinfo($image, PATHINFO_FILENAME) . ".json";
                $download_file_name = pathinfo($json_file_name, PATHINFO_BASENAME);

                $json_data = json_encode($json_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                file_put_contents($json_file_name, $json_data);

                $connect = mysqli_connect('localhost', 'root', '', 'invoice_processing');
                $sql = "UPDATE invoices SET json_file = '$download_file_name', status = 'processed' WHERE file_name = '$image'";
                mysqli_query($connect, $sql);
                mysqli_close($connect);

                unlink($image_path); 

                $file_parts = explode('_', pathinfo($image, PATHINFO_FILENAME));
                if (count($file_parts) >= 4) {
                    $email = $file_parts[2];
                } else {
                    echo "Invalid file name format: $image\n";
                    continue;
                }

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'patulekk.bsp@gmail.com';
                    $mail->Password = 'idum usbo amgy suwj';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('no-reply@invoiceprocessing.com', 'Invoice Processing');
                    $mail->addAddress($email);

                    $mail->addAttachment($json_file_name);

                    $mail->isHTML(true);
                    $mail->Subject = 'Your Invoice JSON File';
                    $mail->Body = 'Dear user,<br><br>Please find attached the JSON file for your processed invoice.<br><br>Best regards';

                    $mail->send();
                    echo "Email sent to $email with attachment $json_file_name\n";
                } catch (Exception $e) {
                    echo "Failed to send email to $email. Mailer Error: {$mail->ErrorInfo}\n";
                }
            } else {
                echo "No OCR data found for the image: $image\n";
            }
        } else {
            echo "No response from OCR API for image: $image\n";
        }
    }
}
?>
