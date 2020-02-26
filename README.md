# Flowee
A simple logger made in PHP that every service can communicate with him.

[![CodeFactor](https://www.codefactor.io/repository/github/roqueando/flowee/badge)](https://www.codefactor.io/repository/github/roqueando/flowee)

## Getting started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. 

### Prerequisites
- PHP 7
- Composer

### Installing
Install all dependencies
`composer install` then run flowee `php flowee.php` and you will see a Flowee logo

## Running tests
`php vendor/bin/phpunit`

## Basic Structure
```json
{
  "type": "error",
  "save": true,
  "message": "something"
}

```
### type
The `type` key is what kind of error will set in log, and save to the respectively log folder. Having in the first version only 4 types. `error`, `fail`, `success` and `warning`

### save
The `save` key is not required but, if set to true, will save in `src/log` folder, all logs

### message
The `message`key is required because will save in details all errors message, exceptions and etc.

## Built with
* [ReactPHP](https://github.com/reactphp/socket) - EventLoop TCP Server
* [Composer](https://getcomposer.org/) - Package manager

## Authors
* **Vitor Roque** - **owner** - [roqueando](https://github.com/roqueando)
