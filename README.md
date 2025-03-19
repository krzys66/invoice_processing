TO RUN THE SITE: 

1. Start Apache and mySQL in XAMPP Control Panel

2. In the phpMyAdmin import the sql file: `invoice_processing.sql`,

3. Extract files to the anyfolder in: `xampp/htdocs`, 

4. Open this folder in browser: `localhost/your_folder` 

`You need your API key & Endpoint from Microsoft Azure AI to run the site`

The CRON script was enabled locally. If you want to start processing invoices, you must manually enable the script that is in: `scripts/invoice_ocr_script`


