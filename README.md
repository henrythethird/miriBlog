# Kchenkrümel und Rosmarin

This is a quite simple blog application I develop for my girlfriend. The
productive version can be found (here)[http://kuchenkruemel.ch].

## Requirements
This is a symfony 3 project, so you can run the following command to
make sure everything is in place:

```sh
./bin/symfony_requirements
```

## Installation

Simply checkout the repository

```sh
git clone https://github.com/henrythethird/miriBlog/
```

Install the necessary packages via composer (if you don't have one 
locally installed, there's a phar in the `bin/` directory.

```sh
./bin/composer.phar install
```

This will prompt you for some configuration parameters. Create the 
database and the schema:

```sh
./bin/console doctrine:database:create
./bin/console doctrine:schema:create
```

To get started publishing blog posts, you first have to create a admin
 user (replace the terms in the brackets with your information):
 
```sh
./bin/console fos:user:create [username] [email] [password] --super-user
```

Now you can start your local server

```sh
./bin/console server:start
```

And navigate to http://127.0.0.1:8000

In order to access the admin part, visit http://127.0.0.1:8000/admin
