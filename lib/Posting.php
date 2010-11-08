<?php

class Posting {
  protected
    $id,
    $title,
    $address,
    $state,
    $city,
    $info,
    $cost,
    $photos;

  public static function fromPOST() {
    return id(new Posting())
             ->setId(edx($_POST, 'posting_id', 'No data'))
             ->setTitle(edx($_POST, 'posting_title', 'No data'))
             ->setInfo(edx($_POST, 'posting_info', 'No data'))
             ->setCity(edx($_POST, 'posting_city', 'No data'))
             ->setState(edx($_POST, 'posting_state', 'No data'))
             ->setAddress(edx($_POST, 'posting_address', 'No data'))
             ->setCost(edx($_POST, 'posting_cost', 'No data'));
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
    $this->state = $new_state;
    return $this;
  }

  public function getState() {
    return $this->state;
  }
}
?>