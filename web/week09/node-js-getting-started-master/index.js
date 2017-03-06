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

app.get('/postageDisplay', function(request, response) {

  var requestUrl = url.parse(request.url, true);

  console.log("Query parameters: " + JSON.stringify(requestUrl.query));

  var postageType = requestUrl.query.postageType;         // $_GET["postageType"]
  var weight      = Number(requestUrl.query.weight);   // $_GET["weight"]

  //console.log(postageType + " - " + weight + " - ");

  var result;

  if(postageType == "lettersS") {
    result = lettersSCalc(weight);
  }
  else if (postageType == "lettersM") {
    result = lettersMCalc(weight);
  }
  else if (postageType == "envelopes") {
    result = envelopesCalc(weight);
  }
  else if (postageType == "parcels") {
    result = parcelsCalc(weight);
  }

  // Set up a JSON object of the values we want to pass along to the EJS result page
  var params = {postageType: postageType, weight: weight, result: result};

  response.render('pages/postageDisplay', params);
}
);

app.listen(app.get('port'), function() {
  console.log('Node app is running on port', app.get('port'));
});
