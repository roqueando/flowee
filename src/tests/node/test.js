const net = require('net');

const socket = net.createConnection({
  host: '127.0.0.1',
  port: 8000
});
const obj = {
  type: "error",
	save: true,
  message: "On line 43, a simple line of code was broken"
};
socket.write(JSON.stringify(obj), 'utf8', function() {
  console.log('data sended');
})
