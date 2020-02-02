# Flowee
A simple logger that every service can communicate with him.

### install
`composer install`

### default structure
```json
{
  "type": "error",
	"save": true,
	"message": "lorem ipsum"
}
``````

### Type
The available types is <br/> 
`error` -> All errors that u have set (will become in red color) <br/>
`warning` -> All warning that u have set (will become in yellow color) <br/>
`success` -> All success that u have set (will become in green color) <br/>
`fail` -> All fail that u have set (will become in magenta color) <br/>

### Save
The `save` key is not required but, if set to true, will save in `src/log` folder, all logs

### Message
The `message`key is required because will save in details all errors message, exceptions and etc.
