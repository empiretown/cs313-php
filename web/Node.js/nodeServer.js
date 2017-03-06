
var http = require("http");

console.log("running class demo file");

function helloWorld(request, response) {
  console.log("hello world function was called");
  console.log("just gota request for: " + request.url);

  response.write("hello world!!!");
  response.end();
}

var server = http.createServer(helloWorld);
var port = 8080;

server.listen(port);
