# Flowee
A simple logger made in PHP that every service can communicate with him.

[![CodeFactor](https://www.codefactor.io/repository/github/roqueando/flowee/badge)](https://www.codefactor.io/repository/github/roqueando/flowee)

## getting started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. 

### prerequisites
`
- PHP 7
- Composer
`
### installing
Install all dependencies
`composer install`
Then run flowee
`php flowee.php`
You will see a Flowee logo

## running tests
`./vendor/bin/phpunit src/tests`

### step-by-step
#### should init server
will test if the TCP server has been started correctly

#### should receive data
will test if the server received the socket data correctly

#### should check data correctly
test if data has in correct structure

#### should not save logs in root
test if logs will be saved in `src/log`

#### should save logs in respectively folders
test if all logs will be saved on correctly folders by error type

## structure
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

## built with
* [ReactPHP](https://github.com/reactphp/socket) - EventLoop TCP Server
* [Composer](https://getcomposer.org/) - Package manager

## authors
* **Vitor Roque** - **owner** - [roqueando](https://github.com/roqueando)
