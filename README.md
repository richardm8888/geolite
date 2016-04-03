# GeoLite API

This application utilises the GeoLite Country database to return the country of a supplier IP address.

## Minimum Requirements

* php 5.5
* mysql 14.14
* composer

## Installation

In order to install the required libaries for this application, you will need to run composer.

If composer is installed globally, run the below in the application folder

	composer install

If composer is installed locally inside the application folder, run the below

	php composer.phar install

* Ensure 'logs/' is web writeable
* Run '/sql/install.sql' on your mysql database
* Update '/src/settings.php' with your database connection details
* There is a template apache vhost file in the vhost folder, copy this into your apache vhost configuration files.
* Run scripts/update.php
* Add the following to your system crontab '0 3 * * * php {APPLICATION_PATH}/scripts/update.php' to update your database on a daily basis.
