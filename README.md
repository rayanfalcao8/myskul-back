<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## Boilerplate Api MIREV

# Table of Contents

1. [Requirements](#requirements)
2. [Modules](#modules)
3. [Installation](#installation)
4. [Usage](#usage)
5. [Testing](#testing)
6. [Code of conduct](#code-of-conduct)
7. [Security](#security-vulnerabilities)

## Requirements
Make sure your server meets the following requirements.

-   Apache 2.2+ or nginx
-   MySQL Server 5.7.8+
-   PHP Version 8.0+
-   Laravel 9.0+
-   Node v16.14.1+ & yarn v1.22.0+ || npm v8.6.0+
-   Laravel valet (for Mac & Linux) or Laragon (for Windows) would be a plus for setting up local subdomains for Laravel

## Modules
The modules available for the project are:
- **Core** (Based Core Module for boostrap all the application). This module allows you to manage countries, currencies and other configurations
- **Authentication** This module manages everything related to user authentication (login, registration, reset password, etc)
- **Authorization** It is the authorization module that manages the roles and permissions for access to the API
- **User** This module gathers all the actions associated to the user (profile, update modification, etc)

## Installation
1. Firstly, clone this repository using git command
``` bash  
 git clone git@gitlab.com:i2658/laravel-api-boilerplate.git boilerplate-api
```
2. Run this command to install composer php dependencies
```bash
 composer install
```
3. Set up a local database called `api`
4. Run `composer setup` to setup the application. This command will migrate all tables and seeders and at the end create and admin user
5. Set up a working e-mail driver like [Mailtrap](https://mailtrap.io/) or [Maildev](https://maildev.github.io/maildev/)

## Usage
Run laravel server `php artisan serve` if you don't have laravel valet or directly access url `http://boilerplate-api.test`

To be able to see all the api available in the project, you must have [Postman](https://www.postman.com/) or [Insomnia](https://insomnia.rest/) and download the json collection files available.
- [Postman collection](/.collections/postman.json)
- [Insomnia collection](/.collections/insomnia.json)

## Testing
```bash
 composer test
```

## Code of Conduct

In order to ensure that the ISDG Company is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Manfouo Thierno via [thierno@isdg-sarl.com](mailto:thierno@isdg-sarl.com) or Arthur Monney via [monney.arthur@isdg-sarl.com](mailto:monney.arthur@isdg-sarl.com). All security vulnerabilities will be promptly addressed.
