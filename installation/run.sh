composer install --no-dev -n
php app/console ezplatform:install demo
mysql -u summer -pcamp fieldtypes < ezpublish_legacy/extension/eztags/sql/mysql/schema.sql
php app/console ezpublish:legacy:script bin/php/ezpgenerateautoloads.php
