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

app.get('/dothemath', function(request, response) {

  var requestUrl = url.parse(request.url, true);

  console.log("Query parameters: " + JSON.stringify(requestUrl.query));

  var operator = requestUrl.query.operator;         // $_GET["operator"]
  var firstN   = Number(requestUrl.query.firstN);   // $_GET["firstN"]
  var secondN  = Number(requestUrl.query.secondN);  // $_GET["secondN"]

  //console.log(operator + " - " + firstN + " - " + secondN);

  var result;

  if(operator == "addition") {
    result = firstN + secondN;
  }
  else if (operator == "subtraction") {
    result = firstN - secondN;
  }
  else if (operator == "multiplication") {
    result = firstN * secondN;
  }
  else if (operator == "division") {
    result = firstN / secondN;
  }

  // Set up a JSON object of the values we want to pass along to the EJS result page
  var params = {operator: operator, firstN: firstN, secondN: secondN, result: result};

  response.render('pages/dothemath', params);
}
);

app.listen(app.get('port'), function() {
  console.log('Node app is running on port', app.get('port'));
});
