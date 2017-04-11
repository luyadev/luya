#!/bin/bash

# Database credentials
user="root"
password="defaultPassword"
db_name="luya_env_phpunit"

cd public_html
mysqladmin -u$user -p$password drop $db_name
mysqladmin -u$user -p$password create $db_name
php index.php migrate --interactive=0
php index.php import
php index.php admin/setup --email=test@luya.io --password=luyaio --firstname=John --lastname=Doe --interactive=0
php index.php data/setup
chmod 0777 ../sql
mysqldump --user=$user --password=$password $db_name > ../sql/1.0.0-RC3.sql