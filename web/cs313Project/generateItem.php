<?php
require_once('class.item.php');

$newItem = new Item;

$newItem = generateItem();

/*
  // after generating the item we need to then INSERT
  // the item name and rarity to the item TABLE
  // and then pull the newly created item_id.
  //
  // now we will insert the attributes of the item to
  // the itemAttributes tables and link them to their
  // respective item using the item_id we pulled earlier.
*/

function generateItem()
{
  $itemQuality = getQuality(); // retrieve the quality of the item
  $tempItem = new Item;        // create a temp item to return

  // constant variables for easy edits
  $MINVAL = 1;
  $MAXVAL = 10;

  //variables to be used for the name
  $baseName;
  $prefix;
  $suffix;
  $fullName;

  //data array for item generation
  $baseNameArray = array("Sword", "Dagger", "Shield", "Wand", "Mace", "Bow", "Rock");
  $rarityArray = array("White", "Green", "Blue", "Yellow", "Orange", "Purple");

  // set rarity and generate a random index for a base name and set it
  $tempItem->setRarity($rarityArray[$itemQuality]);
  $randName = mt_rand(0, (count($baseNameArray) - 1));
  $baseName = $baseNameArray[$randName];

  // array for possible item attributes
  $attributes = array("Attack", "Defense", "Magic", "Luck", "Evasion", "MultiHit", "Crit", "Health");
  $attprefix  = array("Strong", "Tough", "Magical", "Lucky", "Slippery", "Repeating", "Sharp", "Healthy");
  $attsuffix  = array("of Strength", "of Turtle", "of Sorcery", "of RNG", "of Evasion", "of Speed", "with Crits", "of Life");

  // generate a random attribute and set it
  $randAttr = mt_rand(0, (count($attributes) - 1));
  $tempItem->setAttr1($attributes[$randAttr]);

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
    $fullName .= $prefix;
    $fullName .= " ";
  }
  $fullName .= $baseName;
  if($suffix) {
    $fullName .= " ";
    $fullName .= $suffix;
  }
  $tempItem->setItemName($fullName);

  return $tempItem;
}

// This function will determine the quality of the item
function getQuality() {
  $quality;
  $randNum = mt_rand(0, 100);

  if($randNum < 30) {         // 30%
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
