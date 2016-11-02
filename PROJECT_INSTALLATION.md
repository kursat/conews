######Document is in markdown (.md) format. Fyi.

Project Setup
============================

Initialization of Databases
-------------------

Project uses 2 databases: `conews.sql` for production, `conews_test.sql` for testing. Both located under `Source/db_dumps`.

 - For test database you should create a database named `conews_test` and execute queries inside `conews_test.sql` file.
 - For production you have 2 options.
	 - You can create a database named `conews` and execute queries inside `conews.sql` file.
	 - You can go to project directory and run following commands: `php yii migrate && php yii seed-database` and follow the instructions.,
 - To reset database run the following command: `php yii migrate/down 3 && php yii migrate && php yii seed-database`
 - Database imformation stored in `config/db.php` and `config/test_db.php` files.
 - Default database information for production:
```php
	return [
	    'class' => 'yii\db\Connection',
	    'dsn' => 'mysql:host=localhost;dbname=conews',
	    'username' => 'root',
	    'password' => '123456',
	    'charset' => 'utf8',
	];
```
 - Default database information for testing:
```php
	return [
	    'class' => 'yii\db\Connection',
	    'dsn' => 'mysql:host=localhost;dbname=conews_test',
	    'username' => 'root',
	    'password' => '123456',
	    'charset' => 'utf8',
	];
```

Preperation of Project
-------------------

 - To access project from your browser with url `conews.dev` run `echo '127.0.0.1 conews.dev' >> /etc/hosts`.
 - After directing domain name you should setup a virtual host. To create a virtual host run `cd /etc/apache2/sites-available/ && vim conews.conf` and save file with following content.

```
<VirtualHost conews.dev:80>
	# The ServerName directive sets the request scheme, hostname and port that
	# the server uses to identify itself. This is used when creating
	# redirection URLs. In the context of virtual hosts, the ServerName
	# specifies what hostname must appear in the request's Host: header to
	# match this virtual host. For the default virtual host (this file) this
	# value is not decisive as it is used as a last resort host regardless.
	# However, you must set it for any further virtual host explicitly.
	#ServerName www.example.com

	ServerAdmin webmaster@conews.dev

	ServerName conews.dev
	ServerAlias www.conews.dev

	# Set document root to be "basic/web"
	DocumentRoot "/var/www/html/conews/web"

	<Directory "/var/www/html/conews/web">
		# use mod_rewrite for pretty URL support
		RewriteEngine on
		# If a directory or a file exists, use the request directly
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteCond %{REQUEST_FILENAME} !-d
		# Otherwise forward the request to index.php
		RewriteRule . index.php

		# ...other settings...
	</Directory>

	# Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
	# error, crit, alert, emerg.
	# It is also possible to configure the loglevel for particular
	# modules, e.g.
	#LogLevel info ssl:warn

	ErrorLog ${APACHE_LOG_DIR}/conews-error.log
	CustomLog ${APACHE_LOG_DIR}/conews-access.log combined

	# For most configuration files from conf-available/, which are
	# enabled or disabled at a global level, it is possible to
	# include a line for only one particular virtual host. For example the
	# following line enables the CGI configuration for this host only
	# after it has been globally disabled with "a2disconf".
	#Include conf-available/serve-cgi-bin.conf
</VirtualHost>

# vim: syntax=apache ts=4 sw=4 sts=4 sr noet
```

 - Extract project source code under `/var/www/html/conews` directory.
 - After setting up virtual host you should enable site with `a2ensite conews.conf` command.
 - You should run `composer global require "fxp/composer-asset-plugin:^1.2.0"` command to install composer assets.
 - To install required packages and set up the project you should run `cd /var/www/html/conews && composer install` command.
 - If you have trouble with file permissions run following commands in project directory.
```
	sudo mkdir web/user_images
	sudo chmod 777 web/user_images
	sudo chmod 777 runtime
	sudo chmod 777 web/assets
	sudo chmod 755 yii
```
- To run tests:
```
   # run all available tests
   composer exec codecept run

   # run only unit tests
   composer exec codecept run unit
```

Assumptions / Requirements
-------------------

 - Project runs on LAMP server.
 - Apache2 should have enabled `alias, rewrite, vhost_alias` modules.
 - PHP should have enabled `gd, mbstring, pdo_mysql, mysqli` modules.
 - Server should have composer installed.

Possible Improvements
-------------------

 - News can be categorized.
 - Newssttand can show more news with infinite scroll.
 - Users should interact with each other. eg. messaging, following or following same interests/categories. 
 - Users can have their custom feeds consisting of news of followed users.
