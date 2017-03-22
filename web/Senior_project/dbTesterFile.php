<DOCUTYPE! html>
<html>
  <head>
    <title>dbtester</title>
  </head>
<body>
<h1>Here is some stuff ya'll</h1>

<?php

             echo "<table>";
             echo "<tr> <th> account_id </th>";
             echo "<th> account_holder_name </th> </tr>";

             require_once('dbConnect.php');

             $statment = $db->prepare("SELECT id, name FROM account_holder");
             $statment->execute();

             while($row = $statment->fetch(PDO::FETCH_ASSOC))
             {
                          $id = $row['id'];
                          $name = $row['name'];
                          echo "<tr><td>" . $id . "</td>";
                          echo "<td>" . $name . "</td></tr>";
             }
             echo "</table>";

?>


</body>
</html>
