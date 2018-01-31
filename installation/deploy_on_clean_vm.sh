#!/usr/bin/env bash

set -u # Exit if we try to use an uninitialised variable
set -e # Return early if any command returns a non-0 exit status

# The script needs to be run as root
if [ `whoami` != "root" ]; then
    echo "You need to run this script as root"
    exit 1
fi

install_deps() {
    echo "Installing dependencies..."
    apt-get update
    apt-get install -y apache2
    apt-get install -y libapache2-mod-php
    apt-get install -y postgresql-contrib-9.5
    apt-get install -y postgresql-9.5-postgis-2.2
    apt-get install -y postgresql-client-9.5
    apt-get install -y php
    apt-get install -y php-pgsql
    apt-get install -y php-mbstring
    apt-get install -y php-gettext
    apt-get install -y phpunit
    apt-get install -y php-xml
    apt-get install -y php-curl
    apt-get install -y php-zip
    apt-get install -y npm
    apt-get install -y unzip

    # install composer
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
    composer global require "fxp/composer-asset-plugin:^1.2.0"

    # install bower
    npm install -g bower

    # install dependencies with composer
    cd /var/www/anaconda
    composer install

    # fix weird naming issue
    #mv /var/www/anaconda/vendor/bower-asset/ /var/www/anaconda/vendor/bower
}

prepare_database() {
    echo "Preparing postgres database..."
    # configure postgres
    sed -i '$ a LANGUAGE="en_US.UTF-8"' /etc/default/locale
    sed -i '$ a LC_ALL="en_US.UTF-8"'  /etc/default/locale
    sed -i "$ a host    all all 10.0.2.2/24 md5" /etc/postgresql/9.5/main/pg_hba.conf
    sed -i "$ a listen_addresses = '*'" /etc/postgresql/9.5/main/postgresql.conf
    service postgresql restart

    # create database and load data
    su postgres -c $'psql -c "CREATE USER anaconda WITH PASSWORD \'anaconda\';"'
    su postgres -c 'psql -c "CREATE DATABASE anaconda;"'
    su postgres -c 'psql -d anaconda -c "ALTER DATABASE anaconda OWNER TO anaconda;"'
    su postgres -c 'psql -d anaconda -q -f /installation/schema_pg.sql'
    su postgres -c 'psql -d anaconda -q -f /installation/init.sql'
    su postgres -c 'psql -d anaconda -q -f /installation/data.sql'
    cd /installation
    unzip ts.sql.zip
    su postgres -c 'psql -d anaconda -q -f /installation/ts.sql'
    rm ts.sql
    su postgres -c 'psql -d anaconda -c "GRANT USAGE ON SCHEMA public TO anaconda;"'
    su postgres -c 'psql -d anaconda -c "GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO anaconda;"'
}

configure_app() {
    echo "Configuring app..."
    cp /installation/db_default.php /var/www/anaconda/config/db.php
    cp /var/www/anaconda/config/params.sample.php /var/www/anaconda/config/params.php
}

configure_apache() {
    echo "Configuring apache server"
    cp /installation/anaconda.conf /etc/apache2/sites-available/
    a2ensite anaconda.conf
    a2dissite 000-default.conf
    service apache2 reload

    # enable rewrite module
    a2enmod rewrite
    service apache2 restart
}

install_deps
prepare_database
configure_app
configure_apache


