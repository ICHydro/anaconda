# Installation guide Anaconda

## 1. Setting up the server

To host the application, you need to set up the server. The application should be hosted on a LAMP or WAMP server.

### LAMP (Linux, Apache, MySQL, PHP)

LAMP is an open source Web development platform. It uses Linux as the operating system, Apache as the Web server, MySQL as the relational database management system and PHP as the object-oriented scripting language. 

The reason they call it a stack is because each level derives off its base layer. Your Operating system, Linux, is the base layer. Then Apache, your web daemon sits on top of your OS. Then your database stores all the information served by your web daemon. Finally, PHP is used to drive and display all the data, and allow for user interaction.

The installation of LAMP depends on the Linux distribution. Please refer to the specific documentation for the installation of the LAMP setup.

### WAMP (Window, Apache, MySQL, PHP)

If you use LAMP on a Windows operating system, it can also be referred to as WAMP. WAMP means the usage of LAMP open source web development on a windows operating system.

In order to install LAMP on Windows, follow the steps in the chronological order as shown below:

* Go to http://www.wampserver.com/

* Click on Download or Scroll down to find the list of versions

* Now click on the version that you want to download

* Click on “Direct Download” in order to download the installation file

* After downloading the installation file, click on the installation file and follow the self-explanatory process to complete the download.

### Requirements:

Yii2, the framework on which the project is build, needs minimum PHP 5.4 with the mbstring extension and PCRE-support.


## 2. Version control system

When working on code for a website or piece of software it’s always important to track the changes. This is especially critical when collaborating on projects where multiple people will be updating the same code. It’s crucial to keep thorough records of the work being done.

This is where a Version Control System comes in handy. A version control system acts as a growth chart for a project, allowing contributors to stay up to date with each other’s changes when adding new improvements and features.

For this project, we are using GIT as version control system, and the code is stored on GITHub

### Git

Git is a widely used source code management system for software development. It is a distributed revision control system with an emphasis on speed, data integrity, and support for distributed, non-linear workflows. Git was initially designed and developed in 2005 by Linux kernel developers.

#### Installing GIT on windows

* Download the Git for Windows installer package on https://git-scm.com/download/win

* When you've successfully started the installer, you should see the Git Setup wizard screen. Follow the Next and Finish prompts to complete the installation.

* Configure your username using the following command, replacing the name with your own.

git config --global user.name "Wouter"

* Configure your email address using the following command, replacing the email address with your own.

git config --global user.email wouter@gmail.com

#### Installing GIT on Linux

Follow the following steps to install GIT on Linux:

1. Enter the following command to install Git:

sudo apt-get install git

2. Verify the installation was successful by typing which git at the command line.

which git
>> /opt/local/bin/git

3. Configure your username using the following command.

git config --global user.name "Wouter"

4. Configure your email address using the following command.

git config --global user.email wouter@gmail.com

### Downloading a Repository with GIT

You can get a Git project using two main approaches. The first takes an existing project or directory and imports it into Git. The second clones an existing Git repository from another server. As the project is already hosted on the GitHub server, we need to clone it.

#### Cloning an Existing Repository

If you want to get a copy of an existing Git repository, the command you need is git clone. If you’re familiar with other VCS systems such as Subversion, you’ll notice that the command is clone and not checkout. This is an important distinction — Git receives a copy of nearly all data that the server has. Every version of every file for the history of the project is pulled down when you run git clone. In fact, if your server disk gets corrupted, you can use any of the clones on any client to set the server back to the state it was in when it was cloned.

You clone a repository with git clone [url]. To clone the project, you can do so like this:

cd myWorkingDirectory
git clone git@github.com:ICHydro/anaconda.git

That creates a directory named " mountain-evo ", initializes a .git directory inside it, pulls down all the data for that repository, and checks out a working copy of the latest version. If you go into the new mountain-evo directory, you’ll see the project files in there, ready to be worked on or used.

Git has a number of different transfer protocols you can use. The previous example uses the git:// protocol, but you may also see http(s):// or user@server:/path.git, which uses the SSH transfer protocol.

#### Git Interface Tools

There are also some tools that offer a visual interface for handling the GIT commands and are easier than executing the commands on the command line.

##### TortoiseGit

You can download TortoiseGit on https://tortoisegit.org

TortoiseGit is a Windows Shell Interface to Git and based on TortoiseSVN. It's open source and can fully be build with freely available software.

##### SourceTree

You can download SourceTree on https://www.atlassian.com/software/sourcetree

SourceTree simplifies how you interact with your Git and Mercurial repositories so you can focus on coding. Visualize and manage your repositories through SourceTree's simple interface.

cd myWorkingDirectory
git clone git@github.com:Webvillage/mountain-evo.git

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

composer

Type the above command to make sure Composer is installed correctly.

Please note: A lot of tutorials show composer commands like this: php composer.phar. That’s not necessary anymore as we have “installed” Composer. A single composer command followed by the arguments is all you need.

### Running Composer

To start using Composer in your project, all you need is a composer.json file. This file describes the dependencies of your project and may contain other metadata as well. The composer.json file is located in the main directory of our project.

#### Installing project dependencies

Before starting with development, all dependencies need to be downloaded and installed. This can be done with the following command:

composer install

The dependencies are installed in the vendor directory.

To install one project dependency, use the name of the package:

composer install package-name

To remove a package, you can use

composer remove package-name

Update project dependencies

During the project, you can also update the project dependencies. This checks online for new versions of the libraries and installs the newer versions if found.

composer update

## 4. Database

The project is using MySQL as database. MySQL is an open-source relational database management system (RDBMS). MySQL is a popular choice of database for use in web applications, and is a central component of the widely used LAMP open-source web application software stack.

### Loading data in MySQL.

In Windows, you mysql.exe file is probably located in the C:\wamp\bin\mysql\mysql5.7.9\bin\ folder. Using Powershell in windows might give errors. Use the normal command prompt.

First create the new mountain-evo database:

mysql -uroot -e "CREATE DATABASE envisim COLLATE utf8_general_ci"

or

C:\wamp\bin\mysql\mysql5.7.9\bin\mysql -uroot -e "CREATE DATABASE envisim
COLLATE utf8_general_ci"

Change to the root folder of the project and import the mountain-evo.sql file:

mysql -u root envisim < mountain-evo.sql

or

C:\wamp\bin\mysql\mysql5.7.9\bin\mysql -uroot -e "CREATE DATABASE envisim COLLATE utf8_general_ci"

To create a specific user for the project, you can execute the following commando:

mysql -uroot -e "grant all privileges on envisim.* to 'envisim'@'localhost' identified by 'zM8pdEaeFxYY2XnE'"

or

C:\wamp\bin\mysql\mysql5.7.9\bin\ mysql -uroot -e "grant all privileges on envisim.* to 'envisim'@'localhost' identified by 'zM8pdEaeFxYY2XnE'"

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

![MySQL workbench](/images/mysqlworkbench.png)

## 5. Directories

To finalize the installation, there is one more thing to do for Linux users. This is not needed for the Windows installation.

Yii needs some directories to be writable by the server. These directories are runtime, assets and upload for the file uploads.

Change to your project home folder and give the permissions: Runtime directory

sudo chmod -R 777 runtime

Assets directory:

sudo chmod -R 777 web/assets

Upload directory:

sudo chmod -R 777 uploads

That’s all. Well done installing!!

The website should work now when accessing the web url.

You can login with admin/admin.



