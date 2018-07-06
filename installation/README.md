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

Since anaconda relies on [Apache] (https://httpd.apache.org/download.cgi) web server ,
[PostgreSQL](https://www.postgresql.org/download/windows/) and [php](http://windows.php.net/download/), 
you need either install them separately or simply use Bitnami stack ['WAPP'](https://bitnami.com/stack/wapp/installer ).
Here we use the latter approach. 

### 1. WAPP 

Download and install WAPP stack. Set up apache port and postgres root password. 
In all configuration below we use installation directory 'C:/Bitnami/wappstack-7.1.14-0'. 
Replace it with one of yours. 

### 2. php composer
 
Follow CLI option for composer [installation](https://getcomposer.org/download/).

Install asset plugin. For using composer you need to open Bitnami console ("Start -> Bitnami APPNAME Stack -> Application console").
Run `php composer.phar global require "fxp/composer-asset-plugin:^1.4.1"`.

### 3. install bower

First you need to install [node.js](https://nodejs.org/en/). Then simply run:
```npm install -g bower```.

### 4. install anaconda

Create application directory in Bitnami stack `/apps` directory (e.g. C:/Bitnami/wappstack-7.1.14-0/apps/anaconda).

- copy www to C:/Bitnami/wappstack-7.1.14-0/apps/anaconda/www
- copy installation to C:/Bitnami/wappstack-7.1.14-0/apps/anaconda/installation
- copy installation/db_default.php to C:/Bitnami/wappstack-7.1.14-0/apps/anaconda/www/config/db.php
- copy C:/Bitnami/wappstack-7.1.14-0/apps/anaconda/www/config/params.sample.php to C:/Bitnami/wappstack-7.1.14-0/anaconda/config/params.php
- install dependencies:
    ```
    cd C:/Bitnami/wappstack-7.1.14-0/apps/anaconda/www
    php C:\Bitnami\wappstack-7.1.14-0\composer.phar install
    ```

### 5. set up PostgreSQL 

Unzip ts.zip in C:/Bitnami/wappstack-7.1.14-0/apps/anaconda/installation. 
Then run following commands from Bitnami console:
```
cd C:/Bitnami/wappstack-7.1.14-0/apps/anaconda/installation
psql -U postgres -c "CREATE USER anaconda WITH PASSWORD \'anaconda\';"
psql -U postgres -c "CREATE DATABASE anaconda;"
psql -U postgres -d anaconda -c "ALTER DATABASE anaconda OWNER TO anaconda;
psql -U postgres -c "SET CLIENT_ENCODING TO 'utf8';
psql -U postgres -d anaconda -q -f schema_pg.sql
psql -U postgres -d anaconda -q -f init.sql
psql -U postgres -d anaconda -q -f data.sql
psql -U postgres -d anaconda -q -f ts.sql
psql -d anaconda -U postgres -c "GRANT USAGE ON SCHEMA public TO anaconda;"
```

Notes: If you encounter some troubles with data.sql or ts.sql you may need to connect to database and run queries manually.
For ts.sql it may be needed to change encoding appropriate for windows. 

### 6. configure Apache

The last step is to configure web server properly:
- create configuration directory (e.g. C:/Bitnami/wappstack-7.1.14-0/apps/anaconda/conf/)
- copy installation/anaconda_bitnami.conf to C:/Bitnami/wappstack-7.1.14-0/apps/anaconda/conf/anaconda.conf
- add line to C:\Bitnami\wappstack-7.1.14-0\apache2\conf\bitnami\bitnami-apps-prefix.conf: 
    `Include "C:/Bitnami/wappstack-7.1.14-0/apps/anaconda/conf/httpd-prefix.conf"`
- restart apache (e.g. from Bitnami stack manager)
- test installation accessing `localhost/anaconda`

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
