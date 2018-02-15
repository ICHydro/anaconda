# Installation guide Anaconda

## Linux (Ubuntu 16.04)
If you have fresh install of Ubuntu you can simply run [deploy script](deploy_on_clean_vm.sh) 
to set up everything automatically. Otherwise you need to satisfy following requirements:

### 1. HTTP Server

Install and configure HTTP server (nginx, apache). For apache do following (as sudo):
```
apt-get install apache2
apt-get install libapache2-mod-php
cp /installation/anaconda.conf /etc/apache2/sites-available/
a2ensite anaconda.conf
a2dissite 000-default.conf
service apache2 reload
a2enmod rewrite
service apache2 restart
```

### 2. Database (PostgreSQL)

Install and configure Postgres, run (as sudo):
```
apt-get install postgresql-contrib-9.5
apt-get install postgresql-9.5-postgis-2.2
apt-get install postgresql-client-9.5
sed -i '$ a LANGUAGE="en_US.UTF-8"' /etc/default/locale
sed -i '$ a LC_ALL="en_US.UTF-8"'  /etc/default/locale
```
Create database and load data (as sudo):
```
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
```

### 3. php

Install php, run (as sudo):
```
apt-get install php php-pgsql php-mbstring php-gettext phpunit php-xml php-curl php-zip
```
Install composer
```    
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer global require "fxp/composer-asset-plugin:^1.4.1"
```

### 4. bower
Install bower via npm (as sudo):
```
apt-get install npm
npm install -g bower
```

### 5. anaconda
Finally, set up anaconda yii2 project. Download anaconda and copy the contents of the www/ directory to the root 
of your http server (e.g. in `/var/www/`):
```
sudo cp -r www /var/www/anaconda
sudo cp installation/db_default.php /var/www/anaconda/config/db.php
sudo cp /var/www/anaconda/config/params.sample.php /var/www/anaconda/config/params.php
```
You may want to change credentials (depending on what you set for postgres db) or add google api key. 

Then install dependencies via composer:
```
cd /var/www/anaconda
sudo composer install
```
and fix permissions:
```
sudo chmod -R 777 runtime
sudo chmod -R 777 web/assets
sudo chmod -R 777 uploads
sudo chmod -R 777 components
```

Now you are ready to test anaconda in your [browser](http://localhost/). 
The default login and password are admin/neo, 
but it would of course be wise to change that!

To maintain the database, a graphical user interface such as 
[pgAdmin](https://www.pgadmin.org/) can be useful.

Lastly, if you are ready to use the site for production purposes, 
make sure to comment the following two lines in web/index.php:
```
// defined('YII_DEBUG') or define('YII_DEBUG', true);
// defined('YII_ENV') or define('YII_ENV', 'dev');
``` 

## Windows
TODO

* Download the installation file from <http://www.wampserver.com/> and

* Open the installation file and follow the self-explanatory process to complete the download.

[Download](https://getcomposer.org/download) and install composer. The Composer directory (C:\ProgramData\ComposerSetup\bin) is also added to your system path, so you execute the composer command from every directory. More information can be found on [the composer site] (https://getcomposer.org). Don't forget to install the fxp plugin to make sure that composer and bower interact nicely.


## Mac
TODO

```
curl -O https://codeload.github.com/ICHydro/anaconda/zip/master 
unzip master
cp anaconda-master/www/* /var/www/html/
cp anaconda-master/www/.htaccess /var/www/html/
cp anaconda-master/www/.bowerrc /var/www/html/
```

Homebrew works best:

```
brew tap homebrew/dupes
brew tap homebrew/php
brew install php56
brew install composer
composer global require "fxp/composer-asset-plugin:^1.2.0"
```

```
brew install bower
```
