# Installation guide Anaconda

## 1. Server setup

Anaconda is designed for a [LAMP](https://en.wikipedia.org/wiki/LAMP_%28software_bundle%29 "LAMP wikipedia") or [WAMP](https://en.wikipedia.org/wiki/LAMP_%28software_bundle%29#WAMP "WAMP wikipedia") setup. Installation depends on the particularities of your operating system, but some typical installation methods are described here. You can also use PostgreSQL instead of MySQL.

### Requirements:

The Yii2 framework on which the project is built, needs PHP 5.4 or higher with the mbstring extension and PCRE-support.

### Redhat/Centos

* Using MySQL:

```
sudo yum install httpd mysql-server php php-mbstring php-pdo php-mysqlnd
sudo service httpd start
```

To secure your mysql installation and set a root password run:

```
sudo mysql_secure_installation
```

* Using PostgreSQL:

TODO

### Debian/Ubuntu

TODO

### Windows

* Download the installation file from <http://www.wampserver.com/> and

* Open the installation file and follow the self-explanatory process to complete the download.


## 2. Installing Anaconda

Download anaconda and copy the contents of the www/ directory to the root of your web server, for instance:

### Mac/Linux

```
curl -O https://codeload.github.com/ICHydro/anaconda/zip/master 
unzip master
cp anaconda-master/www/* /var/www/html/
cp anaconda-master/www/.htaccess /var/www/html/
cp anaconda-master/www/.bowerrc /var/www/html/

```


## 3. Installing dependencies

Anaconda depends on several external php and javascript libraries. The easiest way to install and update them is by using a dependency manager. Anaconda uses composer for php dependencies, which in its turn uses bower for javascript libraries. As composer fetches libraries from github, git has to be installed and configured as well.

Note: if you prefer not too install the additional software on your production server, you can install the dependencies using another system, and move it onto the server afterwards. Of course 

### Installing git

#### Windows

[Download](ttps://git-scm.com/download/win) and install the installer package.

Configure git with:

```
git config --global user.name "MyGitUsername"
git config --global user.email "me@example.com"
```

#### Debian/ubuntu

```
sudo apt-get install git
git config --global user.name "MyGitUsername"
git config --global user.email "me@example.com"
```

### Installing Composer

#### Windows

[Download](https://getcomposer.org/download) and install composer. The Composer directory (C:\ProgramData\ComposerSetup\bin) is also added to your system path, so you execute the composer command from every directory. More information can be found on [the composer site] (https://getcomposer.org). Don't forget to install the fxp plugin to ensure that composer and bower interact nicely.

#### Debian/Ubuntu:

```
# install dependencies:
sudo apt-get update
sudo apt-get install curl
sudo apt-get install php5-curl
sudo apt-get install openssl
# restart the server:
sudo service apache2 restart
# install composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer global require "fxp/composer-asset-plugin:^1.2.0"
```

#### Mac:

Homebrew works best:

```
brew tap homebrew/dupes
brew tap homebrew/php
brew install php56
brew install composer
composer global require "fxp/composer-asset-plugin:^1.2.0"
```

#### Test composer installation

Now you can use composer everywhere on your server on the command line via:

```
composer
```

### Installing bower

## Debian/Ubuntu::

```
apt-get install npm
npm install -g bower
```

## Mac:

```
brew install bower
```


### Install dependencies with composer

Now it's time to install the dependencies:

```
cd /path/to/www/
composer install
```

The packages can be updated anytime with:

```
composer update
```

You can now check whether all php requirements for the installation are met, and sort out any issues:

```
http://anaconda-url/requirements.php
```

where you replace "anaconda-url" with the url of the anaconda installation.


## 4. Database

We use the standard LAMP setup, which includes MySQL as the database. MySQL should already be installed if you followed the instructions above.

The file init.sql installs a default admin user, which is needed to login. You can change the details of the file before running it.

Optionally you can run data.sql, which gives you some dummy data to play with. You can also change this file at your leasure before uploading.


### Preparing MySQL

First create the database:

Linux/Mac:

```
mysql -u root -p -e "CREATE DATABASE anaconda COLLATE utf8_general_ci"
```

Windows (adjust the path according to your mysql installation if needed):

```
C:\wamp\bin\mysql\mysqlX.X.X\bin\mysql -uroot -p -e "CREATE DATABASE anaconda COLLATE utf8_general_ci"
```

Import the schema and load the initialization data:

Linux/mac:

```
mysql -u root -p anaconda < anaconda-master/installation/schema.sql
mysql -u root -p anaconda < anaconda-master/installation/init.sql

```

Windows:


```
C:\wamp\bin\mysql\mysqlX.X.X\bin\mysql -u root -p anaconda < anaconda-master\installation\schema.sql
C:\wamp\bin\mysql\mysqlX.X.X\bin\mysql -u root -p anaconda < anaconda-master\installation\init.sql
```

To create a specific user for the project, you can execute the following command:

```
mysql -uroot -p -e "grant all privileges on anaconda.* to 'myuser'@'localhost' identified by 'mypassword'"
```

or

```
C:\wamp\bin\mysql\mysql5.7.9\bin\ mysql -uroot -e "grant all privileges on anaconda.* to 'myuser'@'localhost' identified by 'mypassword'"
```

where obviously you change 'myuser' and 'mypassword' with appropriate credentials.

### Using PostgreSQL:

The use of PostgreSQL is a bit more experimental but possible. The main advantage of PostgreSQL is the good integration with open source spatial databases (PostGIS), which is useful when storing data with a spatial dimension.

Setting up the database under linux:

```
createdb anaconda
createuser -P anaconda
psql -d anaconda -c "ALTER DATABASE anaconda OWNER TO anaconda"
psql -d anaconda -U anaconda -a -f schema_pg.sql
psql -d anaconda -U anaconda -a -f init.sql
```

Note: ideally use UTF encoding. Set it explicitly with --lc-collate if you want to be sure.

### Configuration

The site has two parameter files, located in www/config. The database connection is configured in db.php; some other parameters are set in params.php. Example files are included, but need to be copied and modified. E.g. using linux:

```
cd www/config
cp db.sample.php db.php
nano db.php
cp params.sample.php params.php
nano params.php
```


### Maintaining the database and uploading data.

To maintain the database, a graphical user interface such as PhPMyAdmin or [Mysql workbench](https://www.mysql.com/products/workbench) can be useful. You can also edit and run data.sql to add new data.


## 5. Permissions and security

To finalize the installation, there is one more thing to do for Linux users. This is not needed for the Windows installation. Yii needs some directories to be writable by the server. Change to your project home directory and change the permissions of the following directories:


```
chmod -R 777 runtime
chmod -R 777 web/assets
chmod -R 777 uploads
chmod -R 777 components
```

For the .htaccess files to work correctly, the AllowOverride option has to be set to All in the apache configuration file. You can also change the root of the site to the web/ directory here.

```
<Directory "/var/www/html/web">
[...]
    Options Indexes FollowSymLinks
    AllowOverride All
```

Apache also has to be able to rewrite urls:

```
LoadModule rewrite_module modules/mod_rewrite.so
```

(the path may be slightly different depending on your OS)

Lastly, if you are ready to use the site for production purposes, make sure to comment the following two lines in web/index.php:

```
// defined('YII_DEBUG') or define('YII_DEBUG', true);
// defined('YII_ENV') or define('YII_ENV', 'dev');
``` 

That’s all. The website should work now when accessing the web url.

The default login and password are admin/neo, but it would of course be wise to change that!



