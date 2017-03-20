var express = require('express');
var app = express();
var url = require('url');

app.set('port', (process.env.PORT || 5000));

app.use(express.static(__dirname + '/public'));

// views is directory for all template files
app.set('views', __dirname + '/views');
app.set('view engine', 'ejs');

app.get('/', function(request, response) {
  response.render('pages/index');
});

app.get('/scriptures', function(request, response) {

  var requestUrl = url.parse(request.url, true);

  console.log("Query parameters: " + JSON.stringify(requestUrl.query));

  const client = new pg.Client(connectionString);
  client.connect();

  const results = []; // creates empty array

  if(isset(requestUrl.query.book)){
    var book = requestUrl.query.book;      // $_GET["book"]

    const query = client.query(
      'SELECT content FROM scripture WHERE book = ($1)', [book]
    );
     query.on('row', (row) => { // puts data into rows in results
       results.push(row);
     });
     query.on('end', () => {
       response.json(results);
     });
  }
  else {
    const query = client.query(
      'SELECT content FROM scripture;'
    );
    query.on('row', (row) => { // puts data into rows in results
      results.push(row);
    });
    query.on('end', () => {
      response.json(results);
    });
    var book = -1;
  }

  // Set up a JSON object of the values we want to pass along to the EJS result page
//  var params = {book: book};

//  response.render('pages/postageDisplay', params);
}
);

app.listen(app.get('port'), function() {
  console.log('Node app is running on port', app.get('port'));
});
