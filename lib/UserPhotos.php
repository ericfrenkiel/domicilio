<?php
require_once("../lib/core.php");
require_once("../lib/db.php");

class Posting {
  protected
    $id,
    $title,
    $address,
    $state,
    $city,
    $info,
    $cost,
    $ownerId,
    $photos;

  public static function fromPOST() {
    return id(new Posting())
             ->setId(edx($_POST, 'posting_id', false))
             ->setTitle(edx($_POST, 'posting_title', 'New posting'))
             ->setInfo(edx($_POST, 'posting_info', 'No info'))
             ->setCity(edx($_POST, 'posting_city', ''))
             ->setState(edx($_POST, 'posting_state'))
             ->setAddress(edx($_POST, 'posting_address', ''))
             ->setCost(edx($_POST, 'posting_cost', 0));
  }

  public static function fromDB($id) {
    $res = db_query("select id, title, cost, address, city, state,"
      . " info, owner_id from postings where id='" . db_escape($id) . "'");
    if ($arr = db_fetch($res)) {
      return id(new Posting())
               ->setId(edx($arr, 0, false))
               ->setTitle(edx($arr, 1, 'New posting'))
               ->setCost(edx($arr, 2, 0))
               ->setAddress(edx($arr, 3, ''))
               ->setCity(edx($arr, 4, ''))
               ->setState(edx($arr, 5))
               ->setInfo(edx($arr, 6, 'No info'))
               ->setOwnerId(edx($arr, 7, 0));
    } else {
      return false;
    }
  }

  public function addToDB() {
    $res = db_query("insert into postings (title, cost, address, city, state,"
      . " info, owner_id) values ("
      . "'" . db_escape($this->title) . "', "
      . "'" . db_escape($this->cost) . "', "
      . "'" . db_escape($this->address) . "', "
      . "'" . db_escape($this->city) . "', "
      . "'" . db_escape($this->state) . "', "
      . "'" . db_escape($this->info) . "', "
      . "'" . db_escape($this->ownerId) . "'"
      . ");"
    );
    $this->id = mysql_insert_id();
    return $this;
  }

  public function updateToDB() {
    if ($this->id) {
      $res = db_query("update postings set"
        . "title='" . db_escape($this->title) . "', "
        . "cost='" . db_escape($this->cost) . "', "
        . "address='" . db_escape($this->address) . "', "
        . "city='" . db_escape($this->city) . "', "
        . "state='" . db_escape($this->state) . "', "
        . "info='" . db_escape($this->info) . "', "
        . "owner_id='" . db_escape($this->ownerId) . "' "
        . "where id='" . db_escape($this->id) . "';"
      );
    }
    return $this;
  }

  public function getFullAddress() {
    return $this->getAddress() . ", " . $this->getCity() . ", "
      . $this->getState();
  }

  public function getStaticMapUrl() {
    $location = urlencode($this->getAddress()) . ","
      . urlencode($this->getCity()) . ","
      . urlencode($this->getState());
    return "http://maps.google.com/maps/api/staticmap?center=" . $location
      . "&zoom=14&size=256x256&markers=color:blue|label:H|"
      . $location . "&sensor=false";
  }

  public function setId($new_id) {
    $this->id = $new_id;
    return $this;
  }

  public function getId() {
    return $this->id;
  }

  public function setTitle($new_title) {
    $this->title = $new_title;
    return $this;
  }

  public function getTitle() {
    return $this->title;
  }

  public function setInfo($new_info) {
    $this->info = $new_info;
    return $this;
  }

  public function getInfo() {
    return $this->info;
  }

  public function setAddress($new_address) {
    $this->address = $new_address;
    return $this;
  }

  public function getAddress() {
    return $this->address;
  }

  public function setCost($new_cost) {
    $this->cost = $new_cost;
    return $this;
  }

  public function getCost() {
    return $this->cost;
  }

  public function setCity($new_city) {
    $this->city = $new_city;
    return $this;
  }

  public function getCity() {
    return $this->city;
  }

  public function setState($new_state) {
    require_once('../lib/constants/states.php');
    global $state_list;
    if (!isset($state_list[$new_state])) {
      $new_state = null;
    }
    $this->state = $new_state;
    return $this;
  }

  public function getState() {
    return $this->state;
  }

  public function setOwnerId($new_owner_id) {
    $this->ownerId = $new_owner_id;
    return $this;
  }

  public function getOwnerId() {
    return $this->ownerId;
  }
}
?>