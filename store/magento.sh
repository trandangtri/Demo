#!/bin/sh

cd $(dirname $0)

wget -O ./magento.tar.gz http://www.magentocommerce.com/downloads/assets/1.9.1.0/magento-1.9.1.0.tar.gz
echo "Extracting data..."
tar xf magento.tar.gz
cd magento
chmod +x mage

echo "Setting up vhost..."
sudo cp ../magento.conf /etc/nginx/sites-available/magento.ongr.dev.conf
sudo ln -s /etc/nginx/sites-available/magento.ongr.dev.conf /etc/nginx/sites-enabled/magento.ongr.dev.conf
sudo nginx -s reload


echo "Cleaning up files..."
rm ../magento.tar.gz
rm *.sample *.txt

echo "Create database Magento..."
echo "CREATE DATABASE ongr;" | mysql -u root -proot


echo "Installing Magento..."

php -f install.php -- \
    --license_agreement_accepted "yes" \
    --locale "de_DE" \
    --timezone "Europe/Berlin" \
    --default_currency "EUR" \
    --db_host "localhost" \
    --db_name "ongr" \
    --db_user "root" \
    --db_pass "root" \
    --url "magento.ongr.dev" \
    --use_rewrites "yes" \
    --use_secure "no" \
    --secure_base_url "" \
    --use_secure_admin "no" \
    --admin_firstname "Store" \
    --admin_lastname "Owner" \
    --admin_email "email@address.com" \
    --admin_username "admin" \
    --admin_password "admin123" \
    --session_save "db"


echo "Installing sample data..."

mysql -u root -proot -Bse "DROP DATABASE ongr; CREATE DATABASE ongr;"
mysql -u root -proot ongr <  ../../src/ONGR/DemoMagentoBundle/Resources/data/magento_sample_data_for_1.9.0.0.sql


echo "Clearing Magento cache..."
rm -rf ./var/cache/

echo "Installing core extensions..."

./mage mage-setup .
./mage config-set preferred_state stable
./mage install http://connect20.magentocommerce.com/community Mage_All_Latest --force


echo "Refreshing indexes..."

php -f shell/indexer.php reindexall
