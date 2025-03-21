TO RUN THE SITE: 

1. Start Apache and mySQL in XAMPP Control Panel

2. In the phpMyAdmin import the sql file: `invoice_processing.sql`,

3. Extract files to the anyfolder in: `xampp/htdocs`, 

4. Open this folder in browser: `localhost/your_folder` 

You also need: 
 ** API key & Endpoint from Microsoft Azure AI to run the site
 ** Email and Password to set up SMTP server. It able you to send e-mails  

The CRON script was enabled locally. If you want to start processing invoices, you must manually enable the script that is in: `scripts/invoice_ocr_script`


