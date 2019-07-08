<p align="center" style="font-size:44px; font-weight: bold">
    <a href="https://gofunding.demo.afsyah.com/" target="_blank">
        Go Funding
    </a>
</p>
Open Source CrowdFunding Platform.

We using [midtrans](https://docs.midtrans.com/en/welcome/index.html) for payment gateway

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/)

# Installation

---

## Requirements

- The minimum required PHP version of Yii is PHP 5.4.
- It works best with PHP 7.
- Nginx 1.2 (Recomended) or Apache 2.4
- MySQL 5 or MariaDb
- [Follow the Definitive Guide](https://www.yiiframework.com/doc-2.0/guide-start-installation.html) in order to get step by step instructions.
- composer

## Setup

- composer install
- edit `web-local.php` file, and configure as you need.
- import the database [link database](https://github.com/gofunding/gofunding.sql.git)

```bash
Account Admin
- username : admin
- password : admindemo
```

# Contributing

---

## Directory Structure

```bash
├── app                            : core the app
│   ├── controllers
│   ├── models
│   ├── views
│   └── widgets
├── assets                         : cache files from assets
├── environtments                  : init config environment mode
├── public                         : contain css, js, images and upload files
└── tests                          : tests of the core framework code
```

## Mode Development or Production

In root folder, open index.php file and edit code below

```php
defined('YII_DEBUG') or define('YII_DEBUG', true); // false for no debug
defined('YII_ENV') or define('YII_ENV', 'dev'); // prod for production
```
