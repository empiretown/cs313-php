<?php
session_start();
require_once('class.item.php');

$newItem = new Item;
$newItem = generateItem();

echo "New Item Name: " . $newItem->itemName . "<br/>";
echo "Attribute 1: " . $newItem->attr1 . " - " . $newItem->val1 . "<br/>";
echo "Attribute 2: " . $newItem->attr2 . " - " . $newItem->val2 . "<br/>";
echo "Attribute 3: " . $newItem->attr3 . " - " . $newItem->val3 . "<br/>";
echo "Rarity: " . $newItem->rarity . "<br/>";
/************************************************************
   after generating the item we need to then INSERT
   the item name and rarity to the item TABLE
   and then pull the newly created item_id.
************************************************************/
require_once('dbConnect.php');

// Insert the item in the item table
$statement = $db->prepare("INSERT INTO item (itemname, rarity)
                           VALUES (:itemname, :rarity)");
$statement->bindValue(":itemname", $newItem->itemName, PDO::PARAM_STR);
$statement->bindValue(":rarity", $newItem->rarity, PDO::PARAM_STR);
$statement->execute();

// get the last inserted id
$lastItemId = $db->lastInsertId();
echo "last item id: " . $lastItemId . "<br/>";
/************************************************************
   now we will insert the attributes of the item to
   the itemAttributes tables and link them to their
   respective item using the item_id we pulled earlier.
************************************************************/

$statement = $db->prepare("INSERT INTO itemAttributes (attribute, value, item_id)
                           VALUES (:attribute, :value, :lastId)");
$statement->bindValue(":attribute", $newItem->attr1, PDO::PARAM_STR);
$statement->bindValue(":value", $newItem->val1, PDO::PARAM_INT);
$statement->bindValue(":lastId", $lastItemId, PDO::PARAM_INT);
$statement->execute();

// check for attribute 2
if(isset($newItem->attr2)){
  $statement = $db->prepare("INSERT INTO itemAttributes (attribute, value, item_id)
                             VALUES (:attribute, :value, :lastId)");
  $statement->bindValue(":attribute", $newItem->attr2, PDO::PARAM_STR);
  $statement->bindValue(":value", $newItem->val2, PDO::PARAM_INT);
  $statement->bindValue(":lastId", $lastItemId, PDO::PARAM_INT);
  $statement->execute();
}

//check for attribute 3
if(isset($newItem->attr3)){
  $statement = $db->prepare("INSERT INTO itemAttributes (attribute, value, item_id)
                             VALUES (:attribute, :value, :lastId)");
  $statement->bindValue(":attribute", $newItem->attr3, PDO::PARAM_STR);
  $statement->bindValue(":value", $newItem->val3, PDO::PARAM_INT);
  $statement->bindValue(":lastId", $lastItemId, PDO::PARAM_INT);
  $statement->execute();
}
/************************************************************
   Finally, link the item to the user
************************************************************/
$playerId = $_SESSION["playerId"];

$statement = $db->prepare("INSERT INTO usertoitems (player_id, item_id)
                           VALUES (:player_id, :item_id)");
$statement->bindValue(":player_id", $playerId, PDO::PARAM_INT);
$statement->bindValue(":item_id", $lastItemId, PDO::PARAM_INT);
$statement->execute();

header("Location: userInterface.php");


function generateItem()
{
  $itemQuality = getQuality(); // retrieve the quality of the item
  $tempItem = new Item;        // create a temp item to return

  // constant variables for easy edits
  $MINVAL = 1;
  $MAXVAL = 10;

  //variables to be used for the name
  $baseName;
  $prefix = NULL;
  $suffix = NULL;
  $fullName;

  //data array for item generation
  $baseNameArray = array(
    "Sword", "Shield", "Wand", "Amulet", "Dagger", "Bow", "Mace", "Rock");
  $rarityArray = array("White", "Green", "Blue", "Yellow", "Orange", "Purple");

  // array for possible item attributes
  $attributes = array(
    "Attack", "Defense", "Magic", "Luck", "Evasion", "MultiHit", "Crit", "Health");
  $attprefix  = array(
    "Strong", "Tough", "Magical", "Lucky", "Slippery", "Repeating", "Sharp", "Healthy");
  $attsuffix  = array(
    "of Strength", "of Turtle", "of Sorcery", "of RNG", "of Evasion", "of Speed", "with Crits", "of Life");

  // set rarity and generate a random index for a base name and set it
  $tempItem->setRarity($rarityArray[$itemQuality]);
  $randNum = mt_rand(0, (count($baseNameArray) - 1));

  // set the base name and attribute
  $baseName = $baseNameArray[$randNum];
  $tempItem->setAttr1($attributes[$randNum]);

  // generate a random value and adjust it based on item quality and set it
  $randVal = mt_rand(($MINVAL + $itemQuality), $MAXVAL);
  $tempItem->setVal1($randVal * ($itemQuality + 1));

  switch ($itemQuality) {
    case '0':
      break;
    case '1':
      break;
    case '2':
      // get second attribute, set it, and set the name prefix
      $randAttr = mt_rand(0, (count($attributes) - 1));
      $tempItem->setAttr2($attributes[$randAttr]);
      $prefix = $attprefix[$randAttr];
      // generate and set the values of the new attributes
      $randVal = mt_rand(($MINVAL + $itemQuality), $MAXVAL);
      $tempItem->setVal2($randVal * ($itemQuality + 1));
      break;
    case '3':
      // get second attribute, set it, and set the name prefix
      $randAttr = mt_rand(0, (count($attributes) - 1));
      $tempItem->setAttr2($attributes[$randAttr]);
      $prefix = $attprefix[$randAttr];
      // generate and set the values of the new attributes
      $randVal = mt_rand(($MINVAL + $itemQuality), $MAXVAL);
      $tempItem->setVal2($randVal * ($itemQuality + 1));
      break;
    case '4':
      // get second attribute, set it, and set the name prefix
      $randAttr = mt_rand(0, (count($attributes) - 1));
      $tempItem->setAttr2($attributes[$randAttr]);
      $prefix = $attprefix[$randAttr];
      // get third attribute, set it, and set the name suffix
      $randAttr = mt_rand(0, (count($attributes) - 1));
      $tempItem->setAttr3($attributes[$randAttr]);
      $suffix = $attsuffix[$randAttr];
      // generate and set the values of the new attributes
      $randVal = mt_rand(($MINVAL + $itemQuality), $MAXVAL);
      $tempItem->setVal2($randVal * ($itemQuality + 1));
      $randVal = mt_rand(($MINVAL + $itemQuality), $MAXVAL);
      $tempItem->setVal3($randVal * ($itemQuality + 1));
      break;
    case '5':
      // get second attribute, set it, and set the name prefix
      $randAttr = mt_rand(0, (count($attributes) - 1));
      $tempItem->setAttr2($attributes[$randAttr]);
      $prefix = $attprefix[$randAttr];
      // get third attribute, set it, and set the name suffix
      $randAttr = mt_rand(0, (count($attributes) - 1));
      $tempItem->setAttr3($attributes[$randAttr]);
      $suffix = $attsuffix[$randAttr];
      // generate and set the values of the new attributes
      $randVal = mt_rand(($MINVAL + $itemQuality), $MAXVAL);
      $tempItem->setVal2($randVal * ($itemQuality + 1));
      $randVal = mt_rand(($MINVAL + $itemQuality), $MAXVAL);
      $tempItem->setVal3($randVal * ($itemQuality + 1));
      break;

    default:
      echo "I should never be in here";
      break;
  }

  // set the full item name, check for NULL prefix or suffix before adding
  if($prefix) {
    $fullName = $prefix;
    $fullName .= " ";
    $fullName .= $baseName;
  }
  else {
    $fullName = $baseName;
  }

  if($suffix) {
    $fullName .= " ";
    $fullName .= $suffix;
  }
  $tempItem->setItemName($fullName);

echo "Temp Item Name: " . $tempItem->itemName . "<br/>";

  return $tempItem;
}

// This function will determine the quality of the item
function getQuality() {
  $quality = 0;
  $randNum = mt_rand(0, 100);

  if ($randNum < 30) {         // 30%
    $quality = 0;
  }
  else if ($randNum < 55) {   // 25%
    $quality = 1;
  }
  else if ($randNum < 75) {   // 20%
    $quality = 2;
  }
  else if ($randNum < 90) {   // 15%
    $quality = 3;
  }
  else if ($randNum < 97) {   // 7%
    $quality = 4;
  }
  else if ($randNum <= 100) { // 3%
    $quality = 5;
  }

  return $quality;
}
?>
