#!/usr/bin/env bash

ROOT_MySQL_PASSWORD=GKzNDotmjCFfhiZK29jsxYdQhDs88tpp
LARAVEL_DATABASE_NAME=pbnj
LARAVEL_DATABASE_USER=laraveluser
LARAVEL_DATABASE_USER_PASSWORD=sjGTnM4cVCm6oLxqm6F4AdRCAvfoDwQa

# Add PHP Repository
add-apt-repository -y ppa:ondrej/php

# Update Repositories
apt-get -y update

# Setup MySQL Setup Configuration
export DEBIAN_FRONTEND=noninteractive
debconf-set-selections <<< "mysql-server mysql-server/root_password password $ROOT_MySQL_PASSWORD"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $ROOT_MySQL_PASSWORD"

# Install Packages
apt-get install -y python-software-properties
apt-get install -y apache2 mysql-server php7.2 php7.2-bcmath php7.2-curl php7.2-gd php7.2-mbstring php7.2-mysql php7.2-xml php7.2-zip python2.7 unzip

curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure Apache and PHP
if ! [ -L /var/www/html ]; then
  rm -rf /var/www/html
  ln -fs /vagrant/public /var/www/html
fi

echo "ServerName localhost" >> /etc/apache2/apache2.conf
printf "<IfModule mod_dir.c>\n\tDirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm\n</IfModule>" > /etc/apache2/mods-enabled/dir.conf
sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
a2enmod rewrite
service apache2 restart

# Configure MySQL Server
MySQL_COMMAND="mysql -u root -p$ROOT_MySQL_PASSWORD"

$MySQL_COMMAND <<_EOF_
  DELETE FROM mysql.user WHERE User="";
  DELETE FROM mysql.user WHERE User="root" AND Host NOT IN ("localhost", "127.0.0.1", "::1");
  DROP DATABASE IF EXISTS test;
  DELETE FROM mysql.db WHERE Db="test" OR Db="test\\_%";
  FLUSH PRIVILEGES;
_EOF_

$MySQL_COMMAND <<_EOF_
  CREATE DATABASE $LARAVEL_DATABASE_NAME DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
  GRANT ALL ON $LARAVEL_DATABASE_NAME.* TO '$LARAVEL_DATABASE_USER'@'localhost' IDENTIFIED BY '$LARAVEL_DATABASE_USER_PASSWORD';
  FLUSH PRIVILEGES;
_EOF_

# Install Laravel Project
cd /vagrant
composer install --no-scripts
composer install

if [ ! -f ./.env ]; then
    echo "APP_ENV=local" > .env
    echo "APP_DEBUG=true" >> .env
    echo "APP_KEY=" >> .env
    echo "APP_URL=http://homebase.vm" >> .env
    echo "DB_HOST=127.0.0.1" >> .env
    echo "DB_DATABASE=$LARAVEL_DATABASE_NAME" >> .env
    echo "DB_USERNAME=$LARAVEL_DATABASE_USER" >> .env
    echo "DB_PASSWORD=$LARAVEL_DATABASE_USER_PASSWORD" >> .env
fi

php artsian key:generate

# Set Git File Permissions
git config core.fileMode false
chmod -R 777 resources/
chmod g+s resources/
chmod -R 777 storage/
chmod g+s storage/

# Upgrade Packages
apt-get -y upgrade