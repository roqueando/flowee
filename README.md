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
The available types is 
`error` -> All errors that u have set (will become in red color)
`save` -> not required, but if u set true, will save in `src/log` folder
`message` -> the message which u will set to log
