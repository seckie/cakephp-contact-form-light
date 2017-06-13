# CakePHP3 contact form plugin

Specs:
- With confirmation screen
- Send e-mail to admninistrator
- Send auto-replay e-mail to user
- Save entry data to MySQL database
- No admin pages (If you need it, please use PHPMyAdmin etc.)

## Required

- [CakePHP 3.x](https://book.cakephp.org/3.0/en/installation.html#requirements)

---

## CakePHP Getting-started operations

Create project via composer.

```bash
$ composer create-project --prefer-dist cakephp/app YOUR_PROJECT_NAME
```

Setup database.

```bash
$ mysql -u root -p
mysql> CREATE USER your_user_name@'localhost' IDENTIFIED BY 'YOUR_PASSWORD-something1234';
mysql> CREATE DATABASE your_database_name;
mysql> GRANT ALL ON your_database_name.* TO your_user_name@'localhost';
mysql> exit;
$ vim config/app.php

<?php
return [
    ....
    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\MySQL',
            'persistent' => false,
            'host' => 'localhost',
            'username' => 'your_user_name',
            'password' => 'YOUR_PASSWORD-something1234',
            'database' => 'your_database_name',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false,
        ],
        ...
    ],
    ...
];
```

Create migration via `bake` command.
For example:

```bash
$ bin/cake bake migration CreateContacts subject:integer username:string email:string tel:string comment:text created modified
```

Create tables.

```bash
$ bin/cake migrations migrate
```

Scaffoldings.

```bash
$ bin/cake bake all contacts
```

### References

- https://book.cakephp.org/3.0/ja/quickstart.html
- https://book.cakephp.org/3.0/ja/plugins.html

---

## Install

### git clone

```bash
$ git clone https://github.com/seckie/cakephp-contact-form-light.git ./plugins/ContactFormLight
```

### Load

Load this plugin in your `config/bootstrap.php` as follows:

```php
Plugin::load('ContactFormLight', ['bootstrap' => true, 'routes' => true]);
```

Update `composer.json` for autoload:

```php
    "autoload": {
        "psr-4": {
            "App\\": "src",
            "ContactFormLight\\": "./plugins/ContactFormLight/src",
            "ContactFormLight\\Test\\": "./plugins/ContactFormLight/tests"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "App\\Test\\": "tests",
            "Cake\\Test\\": "./vendor/cakephp/cakephp/tests",
            "ContactFormLight\\Test\\": "./plugins/ContactFormLight/tests"
        }
    },
```

Finally, update composer autoload cache:

```bash
$ composer dump-autoload
```

## Configuration

You can override form options in `config/app.php` as follows:

```php
return [
    ...

    'ContactFormLight' => [
        // "Subject" field options
        'subjects' => [
            // key to save database => label to show
            1 => 'foo',
            2 => 'bar',
        ],
        // Validation error messages
        'validation' => [
            'messages' => [
                'notEmpty' => 'This field must have a value',
                'notSameEmail' => 'Email field is invalid',
            ]
        ]
    ]
];
```

Default options:

```php
return [
    'ContactFormLight' => [
        'default' => [
            'validation' => [
                'messages' => [
                    'notEmpty' => 'This field cannot be left empty',
                    'isRequired' => 'This field is required',
                    'tooLong' => 'The provided value is too long',
                    'invalidFormat' => 'The provided value is invalid',
                    'invalidTelFormat' => 'The provided value is invalid',
                    'invalidEmailFormat' => 'The provided value is invalid',
                    'notSameEmail' => 'This field must be same as "E-mail"',
                ]
            ],
            'subjects' => [
                1 => 'About us',
                2 => 'About our products',
                3 => 'Other',
            ]
        ]
    ],
];
```

If you want to use e-mail feature, you have to configure e-mail profile into `config/app.php`.

```php
return [
    ...
    'Email' => [
        ...
        'contact' => [
            'transport' => 'default',
            'from' => 'no-reply@example.com',
            'to' => ['admin@example.com'],
            'subject' => 'Default Contact Subject',
            'template' => 'contact',
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8',
        ],
        'debug_contact' => [
            'transport' => 'default',
            'from' => 'no-reply@example.com',
            'to' => ['admin@example.com'],
            'subject' => 'Default Contact Subject',
            'template' => 'contact',
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8',
        ]
    ],
    ...
];
```

