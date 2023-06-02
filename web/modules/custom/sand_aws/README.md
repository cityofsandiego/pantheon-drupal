# Sand Diego AWS

## This module
Used to extract text from Images and PDFS

## Custom Module Documenation
Documentation for each custom module is in the module's directory.
It is in README.md. This is also available through the GUI via the
custom module "sand_help" and can be viewed on /admin/modules

## Configuration

## Logic
1. Be given a local file or remote file name, entity_type & id
2. Copy that to our S3 extract bucket
3. Create a new StartDocumentTextDetection object
4. Get the ID that AWS returns and put it in a queue along with: filename, type, id
5. In a cronjob that runs every say 5 mins, get the item off the queue
6. Query for status
   A. if success, get text
   B. if 
