# Flowee
A simple logger that every service can communicate with him.

### install
`composer install`

### default structure
```json
{
  "type": 'error', //available types ['error', 'warning', 'success', 'failed'],
	"save": true, // save is not required, but if true, will save on src/log folder,
	"message": "lorem ipsum" // all message which u will set
}
``````
