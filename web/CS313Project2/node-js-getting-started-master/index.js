
var express = require('express');
var app = express();
var url = require('url');
var qs = require('querystring');

const pg = require('pg');
const connectionString = process.env.DATABASE_URL ||
'postgres://brother_burton:bradismyfavoritestudent@localhost:5432/node';

app.set('port', (process.env.PORT || 5000));

app.use(express.static(__dirname + '/public'));

// views is directory for all template files
app.set('views', __dirname + '/views');
app.set('view engine', 'ejs');

app.get('/', function(request, response) {
  response.render('pages/index');
});

app.post('/authenticate', function(request, response) {

  var params = [];
  var isAdmin = false;

  if (request.method == 'POST') {
      var body = '';
      request.on('data', function (data) {
          body += data;
          // 1e6 === 1 * Math.pow(10, 6) === 1 * 1000000 ~~~ 1MB
          if (body.length > 1e6) {
              // FLOOD ATTACK OR FAULTY CLIENT, NUKE REQUEST
              request.connection.destroy();
          }
      });
      request.on('end', function() {

          var POST = qs.parse(body);
          // use POST
          // when the name of the input text field is "user",
          // POST.user will show the data of that field.
          console.log("Query parameters: " + JSON.stringify(POST));

          const client = new pg.Client(connectionString);
          client.connect();

          const results = []; // creates empty array
          var username = POST.username; // $_POST["username"]
          var password = POST.password; // $_POST["password"]

          const query = client.query(
            'SELECT id, userName, password, firstName, lastName, isAdmin FROM classUser WHERE userName = \'' + username + '\''
          );
          query.on('row', (row) => { // puts data into rows in results
             results.push(row);
          });
          query.on('end', () => {
             //response.json(results);
          console.log("finished the query");
          console.log("Query parameters: " + JSON.stringify(results));
          // no clue how to pull data out of the results tbh
          // guessing its something like this:
          var dbpassword = results.password;
          isAdmin        = results.isAdmin;
          var id         = results.id;
          var dbuserName = results.userName;
          var firstName  = results.firstName;
          var lastName   = results.lastName;


          if(dbpassword != password){
            response.render('pages/login');
          }

          params = {id: id, userName: dbuserName, firstName: firstName, lastName: lastName};
          });
      });
  }

  if(isAdmin) {
    response.render('pages/adminInterface', params);
  }
  else {
    response.render('pages/studentInterface', params);
  }
}
);

app.post('/createUser', function(request, response) {

  if (request.method == 'POST') {
      var body = '';
      request.on('data', function (data) {
          body += data;
          // 1e6 === 1 * Math.pow(10, 6) === 1 * 1000000 ~~~ 1MB
          if (body.length > 1e6) {
              // FLOOD ATTACK OR FAULTY CLIENT, NUKE REQUEST
              request.connection.destroy();
          }
      });
      request.on('end', function() {

          var POST = qs.parse(body);
          // use POST
          // when the name of the input text field is "user",
          // POST.user will show the data of that field.
          console.log("Query parameters: " + JSON.stringify(POST));

          const client = new pg.Client(connectionString);
          client.connect();

          const results = []; // creates empty array
          var username  = POST.usernameC;  // $_POST["username"]
          var password  = POST.passwordC;  // $_POST["password"]
          var password2 = POST.passwordC2; // $_POST["password"]
          var firstName = POST.firstName;  // $_POST["firstName"]
          var lastName  = POST.lastName;   // $_POST["lastName"]
          var iNumber   = POST.iNumber;    // $_POST["iNumber"]
          var isAdmin   = false;

          if(password === password2)
          {
            console.log("about to query");
            const query = client.query(
              'INSERT INTO classUser (userName, password, firstName, lastName, iNumber, isAdmin) VALUES ($1, $2, $3, $4, $5, $6)',
              [username, password, firstName, lastName, iNumber, isAdmin]
            );

          query.on('end', () => {

            response.render('pages/login');
          })
        }})
      }});

      app.listen(app.get('port'), function() {
        console.log('Node app is running on port', app.get('port'));
      });
