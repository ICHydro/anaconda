# Installation guide Anaconda

## 1. Server setup

Anaconda is designed for a [LAMP](https://en.wikipedia.org/wiki/LAMP_%28software_bundle%29 "LAMP wikipedia") or [WAMP](https://en.wikipedia.org/wiki/LAMP_%28software_bundle%29#WAMP "WAMP wikipedia") setup. Installation depends on the particularities of your operating system, but some typical installation methods are described here.

### Requirements:

The Yii2 framework on which the project is built, needs PHP 5.4 or higher with the mbstring extension and PCRE-support.

### Redhat/Centos

```
sudo yum install httpd mysql-server php php-mbstring php-pdo php-mysqlnd
sudo service httpd start
```

To secure your mysql installation and set a root password run:

```
sudo mysql_secure_installation
```

### Debian/Ubuntu

TODO

### Windows

To install LAMP on Windows:

* Download the installation file from <http://www.wampserver.com/> and

* Open the installation file and follow the self-explanatory process to complete the download.


## 2. Installing Anaconda

Download anaconda and copy the contents of the www/ directory to the root of your web server, for instance:

```
curl -O https://codeload.github.com/ICHydro/anaconda/zip/master 
unzip master
cp anaconda-master/www/* /var/www/html/
```


## 3. Installing dependencies

Anaconda depends on several external php and javascript libraries. The easiest way to install and update them is by using a dependency manager. Anaconda uses composer for php dependencies and bower for javascript libraries. As composer fetches libraries from github, so git has to be installed and configured as well.

### Installing git

#### Windows

[Download](ttps://git-scm.com/download/win) and install the installer package.

Configure git with:

```
git config --global user.name "MyGitUsername"
git config --global user.email "me@example.com
```

#### Debian/ubuntu

```
sudo apt-get install git
git config --global user.name "MyGitUsername"
git config --global user.email "me@example.com
```

### Installing Composer

#### Windows

[Download](https://getcomposer.org/download) and install composer. The Composer directory (C:\ProgramData\ComposerSetup\bin) is also added to your system path, so you execute the composer command from every directory. More information can be found on https://getcomposer.org.

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
```

#### Mac:

Homebrew works best:

```
brew tap homebrew/dupes
brew tap homebrew/php
brew install php56
brew install composer
```

#### Test composer installation

Now you can use composer everywhere on your server on the command line via

```
composer
```

### Installing bower

## linux:

```
npm install -g bower
```

## Mac:

```
brew install bower
```


### Install dependencies with composer and bower

The file composer.json contains all the information on dependencies, so all that needs to be done is to execute the following command in the www/ directory:

```
cd /path/to/www/
composer install
bower install
```

The packages can be updated anytime with:

```
composer update
bower update
```

You can now check whether all php requirements for the installation are met, and sort out any issues:

```
http://anaconda-url/requirements.php
```

where you replace "anaconda-url" with the url of the anaconda installation.


## 4. Database

We use the standard LAMP setup, which includes MySQL as the database. MySQL should already be installed if you followed the instructions above.

### Loading the data in MySQL.

In Windows, your mysql.exe file is probably located in the C:\wamp\bin\mysql\mysqlX.X.X\bin\ folder (where X.X.X is the version of mysql that you have installed). Using Powershell in windows might give errors. Use the normal command prompt.

First create the new database:

```
mysql -u root -p -e "CREATE DATABASE anaconda COLLATE utf8_general_ci"
```

or

```
C:\wamp\bin\mysql\mysqlX.X.X\bin\mysql -uroot -p -e "CREATE DATABASE anaconda COLLATE utf8_general_ci"
```

Import the schema and load the initialization data:

```
mysql -u root -p anaconda < anaconda-master/installation/schema.sql
mysql -u root -p anaconda < anaconda-master/installation/init.sql

```

or


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

Setting up the database under linux (assuming you are user postgres):

```
createdb anaconda
createuser -P anaconda
psql -d anaconda -a -f anaconda_pg.sql
psql -d anaconda -c "REASSIGN OWNED BY postgres TO anaconda"
```

Note: ideally use UTF encoding. Set it explicitly with --lc-collate if you want to be sure.

### Configuring the database link

Change the access information in www/db.sample.php to match the credentials that you have chosen earlier and save the new file as db.php in the same directory. E.g. using linux:

```
cd www
cp db.sample.php db.php
nano db.php
```


### Maintaining the database.

To maintain the database, a graphical user interface such as PhPMyAdmin or [Mysql workbench](https://www.mysql.com/products/workbench) can be useful.

## 5. Permissions and security

To finalize the installation, there is one more thing to do for Linux users. This is not needed for the Windows installation. Yii needs some directories to be writable by the server. Change to your project home directory and change the permissions of the following directories:


```
sudo chmod -R 777 runtime
sudo chmod -R 777 web/assets
sudo chmod -R 777 uploads
sudo chmod -R 777 components
```

For the .htaccess files to work correctly, the AllowOverride option has to be set to All in the apache configuration file:

```
<Directory "/var/www/html">
[...]
    Options Indexes FollowSymLinks
    AllowOverride All
```
and apache has to be able to rewrite urls:

```
LoadModule rewrite_module libexec/apache2/mod_rewrite.so
```

Lastly, if you are ready to use the side for production purposes, make sure to comment the following two lines in web/index.php:

```
// defined('YII_DEBUG') or define('YII_DEBUG', true);
// defined('YII_ENV') or define('YII_ENV', 'dev');
``` 

That’s all. The website should work now when accessing the web url.

The default login and password are admin/admin, but it would of course be wise to change that!



