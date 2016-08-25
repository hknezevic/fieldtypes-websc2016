composer install --no-dev -n
mysql -u summer -pcamp fieldtypes < ezpublish_legacy/extension/eztags/sql/mysql/schema.sql
php app/console ezplatform:install demo
php app/console ezpublish:legacy:script bin/php/ezpgenerateautoloads.php
