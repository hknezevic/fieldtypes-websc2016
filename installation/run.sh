composer install --no-dev -n
php app/console ezplatform:install clean
mysql -u summer -pcamp fieldtypes < ezpublish_legacy/extension/eztags/sql/mysql/schema.sql
