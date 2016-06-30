# Installation guide Anaconda

## 1. Server setup

Anaconda is designed for a [LAMP](https://en.wikipedia.org/wiki/LAMP_%28software_bundle%29 "LAMP wikipedia") or [WAMP](https://en.wikipedia.org/wiki/LAMP_%28software_bundle%29#WAMP "WAMP wikipedia") setup. Installation depends on the particularities of your operating system, but some typical installation methods can be found below.

### Requirements:

The Yii2 framework on which the project is built, needs PHP 5.4 or higher with the mbstring extension and PCRE-support.

### CENTOS

```
sudo yum install httpd mysql-server php php-mbstring php-pdo
sudo service httpd start
```

To secure your mysql installation and set a root password run:

```
sudo mysql_secure_installation
```

### Windows

To install LAMP on Windows:

* Download the installation file from <http://www.wampserver.com/> and

* Open the installation file and follow the self-explanatory process to complete the download.

## 2. Installing Anaconda

Download anaconda and copy the contents of the www/ directory to the root of your web server, for instance:

```
curl -O https://github.com/ICHydro/anaconda/archive/master.zip
unzip master.zip
cp www/* /var/www/html/
```

You can check whether all php requirements are met by pointing your browser to:

```
http://anaconda-url/requirements.php
```

where you replace "anaconda-url" with the url of the anaconda installation.

## 3. Composer

Composer is a Dependency Manager for PHP. Composer will manage the dependencies you require on a project by project basis. This means that Composer will pull in all the required libraries, dependencies and manage them all in one place.

Composer is not a package manager in the same sense as Yum or Apt are. Yes, it deals with "packages" or libraries, but it manages them on a per-project basis, installing them in a directory (e.g. vendor) inside your project. By default it does not install anything globally. Thus, it is a dependency manager.

Suppose:

* You have a project that depends on a number of libraries.

* Some of those libraries depend on other libraries.

Composer:

* Enables you to declare the libraries you depend on.

* Finds out which versions of which packages can and need to be installed, and installs them (meaning it downloads them into your project).

### Installing Composer

#### Installing Composer on Windows

In order to install Composer on Windows go to https://getcomposer.org/download and download the Composer-Setup.exe file and open the self-explanatory installation process after downloading the .exe file.

The Composer directory (C:\ProgramData\ComposerSetup\bin) is also added to your system path, so you execute the composer command from every directory.

More information can be found on https://getcomposer.org.

#### Installing Composer on Linux

Most tutorials say that you should download the composer.phar file into your project, you’ve probably seen this before. But, this is outdated and not recommend! The better way to go is to “install” Composer. It’s also not possible to use Composer out-of-the-box, as this tool uses some things that need to be installed first: Composer is basically a PHP tool (which runs PHP on a webserver) that fetches remote files via git and curl over https (=openssl).

Installing Composer on linux needs a little bit of work first:

Do an update:

sudo apt-get update

First, make sure you have curl installed, so simply try to install it (if already installed, nothing will happen). Curl is a basic unix tool for file transfering (wikipedia). Install curl and the php5-curl extension:

sudo apt-get install curl
sudo apt-get install php5-curl

Then, make sure you have OpenSSL installed, a library that allows unix to handle HTTPS. Same procedure as with curl:

sudo apt-get install openssl

Composer uses git, but we already installed it on the system.

Then restart your server:

sudo service apache2 restart

Okay, now let’s install Composer:

curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

This downloads composer.phar (which is a packed php archive by the way, see http://php.net/phar for more info) moved the file to a special folder, making it available systemwide.

### Test composer installation

Now you can use composer everywhere on your server on the command line via

```
composer
```

Type the above command to make sure Composer is installed correctly.

Please note: A lot of tutorials show composer commands like this: php composer.phar. That’s not necessary anymore as we have “installed” Composer. A single composer command followed by the arguments is all you need.

### Running Composer

To start using Composer in your project, all you need is a composer.json file. This file describes the dependencies of your project and may contain other metadata as well. The composer.json file is located in the main directory of our project.

#### Installing project dependencies

Before starting with development, all dependencies need to be downloaded and installed. This can be done with the following command:

```
composer install
```

The dependencies are installed in the vendor directory.

To install one project dependency, use the name of the package:

```
composer install package-name
```

To remove a package, you can use

```
composer remove package-name
```

Update project dependencies

During the project, you can also update the project dependencies. This checks online for new versions of the libraries and installs the newer versions if found.

```
composer update
```

## 4. Database

We use the standard LAMP setup, which includes MySQL as the database. MySQL should already be installed if you followed the instructions above.

### Loading data in MySQL.

In Windows, you mysql.exe file is probably located in the C:\wamp\bin\mysql\mysql5.7.9\bin\ folder. Using Powershell in windows might give errors. Use the normal command prompt.

First create the new database:

```
mysql -u root -p -e "CREATE DATABASE envisim COLLATE utf8_general_ci"
```

or

```
C:\wamp\bin\mysql\mysql5.7.9\bin\mysql -uroot -p -e "CREATE DATABASE envisim COLLATE utf8_general_ci"
```

Import the mountain-evo.sql file:

```
mysql -u root -p envisim < anaconda-master/installation/anaconda.sql
```

or

```
C:\wamp\bin\mysql\mysql5.7.9\bin\mysql -u root -p envisim < anaconda-master\installation\anaconda.sql
```

To create a specific user for the project, you can execute the following command:

```
mysql -uroot -p -e "grant all privileges on envisim.* to 'envisim'@'localhost' identified by 'zM8pdEaeFxYY2XnE'"
```

or

```
C:\wamp\bin\mysql\mysql5.7.9\bin\ mysql -uroot -e "grant all privileges on envisim.* to 'envisim'@'localhost' identified by 'zM8pdEaeFxYY2XnE'"
```

### PHPMyAdmin

PhpMyAdmin is a free and open source tool written in PHP intended to handle the administration of MySQL with the use of a web browser. It can perform various tasks such as creating, modifying or deleting databases, tables, fields or rows; executing SQL statements; or managing users and permissions.

PhpMyAdmin makes it very easy to inspect the data. To have a look at the data model, Mysql Workbench comes is more useful.

#### Mysql Workbench

MySQL Workbench is a unified visual tool for database architects, developers, and DBAs. MySQL Workbench provides data modeling, SQL development, and comprehensive administration tools for server configuration, user administration, backup, and much more. MySQL Workbench is available on Windows, Linux and Mac OS X.

##### Installing MySQL Workbench on Windows

MySQL Workbench may be installed using the installer file or it may be installed manually from a ZIP file. Installing MySQL Workbench using the installer requires either Administrator or Power User privileges. If you are using the ZIP file without an installer, you do not need Administrator or Power User privileges.

You can download the files from: https://www.mysql.com/products/workbench.

##### Working with MySQL Workbench

MySQL Workbench can import the scheme from your database and visualize it:

* Create the database connection with your server

* Add a new model

* Synchronize the database using the database menu > synchronize model.

* After importing the database in the model, all tables are visualized in a conceptual model.

You can change the model, and synchronize it again with the database to update the database with the changes you made.

![MySQL workbench](/images/mysqlworkbench.jpg)

## 5. Permissions

To finalize the installation, there is one more thing to do for Linux users. This is not needed for the Windows installation. Yii needs some directories to be writable by the server. Change to your project home directory and change the permissions of the following directories:


```
sudo chmod -R 777 runtime
sudo chmod -R 777 web/assets
sudo chmod -R 777 uploads
```

That’s all. The website should work now when accessing the web url.

The default login and password are admin/admin.



