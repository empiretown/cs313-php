<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>TEAM ASSIGNMENT 2</title>
  <meta name="description" content="Hello World">
  <meta name="author" content="SitePoint">


  <link rel="stylesheet" type="text/css" href="homepage.css">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>

<body>

<br/><br/>

  <form action="ta2functions.php" method="post">
    <input type="text" name="firstname" value="" placeholder="WRITE YOUR NAME HERE"><br/>
    <input type="text" name="email" value="" placeholder="WRITE YOUR EMAIL HERE"><br/>

    <br/>

    <input type="radio" name="major" value="cs"> CS <br/>
    <input type="radio" name="major" value="cit"> CIT <br/>
    <input type="radio" name="major" value="wdd"> WDD <br/>
    <input type="radio" name="major" value="ce"> CE <br/>
    <input type="radio" name="major" value="bs"> Brad Studies <br/>

    <br/>

    <input type="textarea" name="comments" placeholder="WRITE YOUR COMMENTS HERE">

    <input type="hidden" name="action">

    <input type="submit" value="SUBMIT UR">

    <br/><br/>

  </form>
  <?php
  echo "<p>$error</p>";
  ?>
  <div id="hpimage"></div>


</body>
</html>
