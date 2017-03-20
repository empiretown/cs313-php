var express = require('express');
var app = express();
var url = require('url');

const pg = require('pg');
const connectionString = process.env.DATABASE_URL ||
'postgres://brother_burton:bradismyfavoritestudent@localhost:5432/ta10';

app.set('port', (process.env.PORT || 5000));

app.use(express.static(__dirname + '/public'));

// views is directory for all template files
app.set('views', __dirname + '/views');
app.set('view engine', 'ejs');

app.get('/', function(request, response) {
  response.render('pages/index');
});

app.get('/getPerson', function(request, response) {

  var requestUrl = url.parse(request.url, true);

  console.log("Query parameters: " + JSON.stringify(requestUrl.query));

  var getId = requestUrl.query.id;         // $_GET["id"]



  const client = new pg.Client(connectionString);
  client.connect();

  const results = [];  //creates empty array

  const query = client.query(  //:title", { title: "Hello MySQL" });
    'SELECT * FROM person WHERE id = ($1)', [getId]//selects data
  );
  query.on('row', (row) => { //puts data into rows in results
      results.push(row);
  });
  query.on('end', () => {
    //done();
    response.json(results);
    //console.log(results);
  });


///sql statement goes here

  // Set up a JSON object of the values we want to pass along to the EJS result page
//  var params = {operator: operator, firstN: firstN, secondN: secondN, result: result};

//  response.render('pages/dothemath', params);
}
);

app.listen(app.get('port'), function() {
  console.log('Node app is running on port', app.get('port'));
});
