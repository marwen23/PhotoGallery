# Photo Gallery Application

A Symfony project for managing a photo gallery and keep information about different pictures and their licenses.
There are two type of users: 
Administraor, who's responsible of feeding the images DB, update and delete, also has the ability to manage users and change their roles.
Simple User, who can only visualize the list of stored images, search or sort the images list, and see their details.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine.

### Installing

A step by step series of examples that tells you have to get the project running.

After downloading the project and acceding to its directory, run this command to install all required files with composer.

```
composer update
```

After that, it will ask you to fill some information like database name, username, password...

Then, run thess commands to create database and tables.

```
php bin/console doctrine:database:create

php bin/console doctrine:schema:update --force
```

## Running the project

Just run this command 

```
php bin/console server:run
```

