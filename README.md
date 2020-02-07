
              ▛▀▘▜              
              ▙▄ ▐ ▞▀▖▌  ▌▞▀▖▞▀▖
              ▌  ▐ ▌ ▌▐▐▐ ▛▀ ▛▀ 
              ▘   ▘▝▀  ▘▘ ▝▀▘▝▀▘ 

A simple logger that every service can communicate with him.

[![CodeFactor](https://www.codefactor.io/repository/github/roqueando/flowee/badge)](https://www.codefactor.io/repository/github/roqueando/flowee)

### install
`composer install`

### tests
these tests use phpunit 8 so, to run `./vendor/bin/phpunit src/tests`

### default structure
```json
{
  "type": "error",
	"save": true,
	"message": "lorem ipsum"
}
``````

### type
The available types is <br/> 
`error`  All errors that u have set (will become in red color) <br/>
`warning`  All warning that u have set (will become in yellow color) <br/>
`success`  All success that u have set (will become in green color) <br/>
`fail`  All fail that u have set (will become in magenta color) <br/>

### save
The `save` key is not required but, if set to true, will save in `src/log` folder, all logs

### message
The `message`key is required because will save in details all errors message, exceptions and etc.


### connecting
to connect to flowee you must connect via tcp using anyone language that u want. (check the src/tests which have an example in PHP) <br/>

in `tests/node` folder when u run `node test.js` will send a data to flowee (must be running), and save the log file. <br/>

I recommend to create your own flowee client using the tcp client of your choice, like in Node.js I used `net` module.
