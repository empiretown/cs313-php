<?php
class Item {
    // item variables
    public $itemName;
    public $rarity;
    public $attr1;
    public $attr2;
    public $attr3;
    public $val1;
    public $val2;
    public $val3;

    // functions setups
    public $setRarity = 'setRarity'; //
    public $setItemName = 'setItemName'; //
    public $setAttr1 = 'setAttr1'; //
    public $setAttr2 = 'setAttr2'; //
    public $setAttr3 = 'setAttr3'; //
    public $setVal1 = 'setVal1'; //
    public $setVal2 = 'setVal2'; //
    public $setVal3 = 'setVal3'; //

    // value setters
    function setRarity($rarity) {
        $this->rarity = $rarity;
    }
    function setItemName($itemName) {
        $this->itemName = $itemName;
    }
    function setAttr1($attr1) {
        $this->attr1 = $attr1;
    }
    function setAttr2($attr2) {
        $this->attr2 = $attr2;
    }
    function setAttr3($attr3) {
        $this->attr3 = $attr3;
    }
    function setVal1($val1) {
        $this->val1 = $val1;
    }
    function setVal2($val2) {
        $this->val2 = $val2;
    }
    function setVal3($val3) {
        $this->val3 = $val3;
    }
}

?>
