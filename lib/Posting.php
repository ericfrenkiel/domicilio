<?php

class Posting {
  protected
    $id,
    $title,
    $address,
    $info,
    $cost,
    $photos;

  public static function fromPOST() {
    return id(new Posting())
             ->setId(edx($_POST, 'posting_id', 'No data'))
             ->setTitle(edx($_POST, 'posting_title', 'No data'))
             ->setInfo(edx($_POST, 'posting_info', 'No data'))
             ->setAddress(edx($_POST, 'posting_address', 'No data'))
             ->setCost(edx($_POST, 'posting_cost', 'No data'));
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
}
?>