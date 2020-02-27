#!/usr/bin/env bash

# The name of the project being set up
# This will be used to set up the database, etc
project_name="tudu"

# The type of project to be set up
# Possible values are wordpress, laravel, general
project_type="laravel"

# The type of database to be set up
# Possible values are mysql, none
database_type="mysql"

# Function to print messages along the way
msg() {
  echo ""
  echo " $1"
  echo ""
}

# Update the repositories and upgrade packages
msg "Updating the repositories and upgrading packages..."
apt update
apt upgrade -y

# Determine what packages need to be installed
msg "Determining packages to be installed based on project type"
install_packages=(
  apache2
  php
  libapache2-mod-php
)
if [ $database_type = "mysql" ]; then
  install_packages+=('mysql-server')
  install_packages+=('php-mysql')
fi
if [ $project_type = "laravel" ]; then
  install_packages+=('php-tokenizer')
  install_packages+=('php-mbstring')
  install_packages+=('php-bcmath')
  install_packages+=('php-json')
  install_packages+=('php-xml')
fi

# Install required packages
msg "Installing the required packages..."
if ! apt install -y ${install_packages[@]}; then
  msg "ERROR: Failed to install required packages!"
  exit 1
fi

# If applicable, set up a MySQL database
if [ $database_type = "mysql" ]; then
  msg "Setting up a MySQL database..."

  # Generate the SQL to be executed
  sql="CREATE DATABASE $project_name; CREATE USER '$project_name'@'localhost' IDENTIFIED BY '$project_name'; GRANT ALL ON $project_name.* TO '$project_name'@'localhost'; FLUSH PRIVILEGES;"

  # Push the previously generated SQL to a file
  echo $sql >> /vagrant/provision/init.sql

  # Import the resulting SQL file to set up the database
  sudo mysql < "/vagrant/provision/init.sql"

  # Delete the file afterwards
  rm /vagrant/provision/init.sql

  msg "The database name, MySQL user, and password are all set to $project_name..."
fi

# Change the run user and group for Apache
msg "Changing the user and group that Apache runs as..."
sed -i 's/www-data/vagrant/g' /etc/apache2/envvars

if [ $project_type = "laravel" ]; then
  # Change the document root
  msg "Changing the document root..."
  sed -i 's/DocumentRoot \/var\/www\/html/DocumentRoot \/var\/www\/html\/public/' /etc/apache2/sites-available/000-default.conf
fi

# Change some PHP settings
msg "Changing some PHP settings..."
sed -i 's/memory_limit = 128M/memory_limit = 768M/' /etc/php/7.2/apache2/php.ini
sed -i 's/error_reporting = E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED/error_reporting = E_ALL/' /etc/php/7.2/apache2/php.ini
sed -i 's/display_errors = Off/display_errors = On/' /etc/php/7.2/apache2/php.ini
# Enable the PDO extension if mysql is in use
if [ $database_type = "mysql" ]; then
  sed -i 's/;extension=pdo_mysql/extension=pdo_mysql/' /etc/php/7.2/apache2/php.ini
fi

# Make the document root a symlink to the Vagrant shared folder
if ! [ -L /var/www/html ]; then
  msg "Making the document root a symbolic link to the Vagrant shared folder..."
  rm -rf /var/www/html
  ln -fs /vagrant /var/www/html
fi

# Enable URL rewrites for Apache and restart it
msg "Enabling URL rewrites and restarting Apache..."
a2enmod rewrite
sed -i '172s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
systemctl restart apache2

# If applicable, show info about the PHP configuration in the document root
if [ $project_type = "general" ]; then 
  echo "<?php phpinfo(); ?>" >> /var/www/html/index.php 
fi

msg "All done! :)"


