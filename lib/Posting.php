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
    $location = array('lat' => 0, 'lng' => 0),
    $photos = array();

  public static function fromPOST() {
    $posting = id(new Posting())
                 ->setId(edx($_POST, 'posting_id', false))
                 ->setTitle(edx($_POST, 'posting_title', 'New posting'))
                 ->setInfo(edx($_POST, 'posting_info', 'No info'))
                 ->setCity(edx($_POST, 'posting_city', ''))
                 ->setState(edx($_POST, 'posting_state'))
                 ->setAddress(edx($_POST, 'posting_address', ''))
                 ->setCost(edx($_POST, 'posting_cost', 0));
    $img_id_str = 'img_input_id_';
    foreach($_POST as $key => $val) {
      if (substr($key, 0, strlen($img_id_str)) !== $img_id_str) {
        continue;
      }
      $photo_id = $val;
      $photo_src = unsafe_post('img_input_src_' . $photo_id);
      $photo_preview = unsafe_post('img_input_preview_' . $photo_id);
      $posting->addPhoto($photo_id, $photo_preview, $photo_src);
    }
    $posting->generateLocation();
    return $posting;
  }

  protected function generateLocation() {
    $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" .
      $this->getEncodedAddress() . "&sensor=false";
    $res = easy_curl($url);
    if ($res) {
      $obj = json_decode($res);
      if ($obj->status == "OK" && count($obj->results)) {
        $loc = $obj->results[0]->geometry->location;
        $this->setLocation($loc->lat, $loc->lng);
      }
    }
  }

  public static function fromDB($id) {
    $res = db_query("select id, title, cost, address, city, state,"
      . " info, owner_id, lat, lng from postings where id='" . db_escape($id) . "';");
    if ($arr = db_fetch($res)) {
      $id = $arr[0];
      $posting = id(new Posting())
                   ->setId($id)
                   ->setTitle(edx($arr, 1, 'New posting'))
                   ->setCost(edx($arr, 2, 0))
                   ->setAddress(edx($arr, 3, ''))
                   ->setCity(edx($arr, 4, ''))
                   ->setState(edx($arr, 5))
                   ->setInfo(edx($arr, 6, 'No info'))
                   ->setOwnerId(edx($arr, 7, 0))
                   ->setLocation(edx($arr, 8, 0), edx($arr, 9, 0));
      $res = db_query("select photo_id, photo_url,"
          . " photo_url_thumbnail from posting_photos where posting_id = '"
          . db_escape($id) . "';");
      while($arr = db_fetch($res)) {
        $posting->addPhoto($arr[0], $arr[2], $arr[1]);
      }
      return $posting;
    } else {
      return false;
    }
  }

  protected function insertPhotosToDB() {
    foreach($this->photos as $photo) {
      $res = db_query("insert into posting_photos (posting_id, photo_id,"
        . " photo_url, photo_url_thumbnail) VALUES ("
        . "'" . db_escape($this->id) . "', "
        . "'" . db_escape($photo['id']) . "', "
        . "'" . db_escape($photo['src']) . "', "
        . "'" . db_escape($photo['preview']) . "'"
        . ");"
      );
    }
  }

  public function addToDB() {
    $res = db_query("insert into postings (title, cost, address, city, state,"
      . " info, owner_id, lat, lng) values ("
      . "'" . db_escape($this->title) . "', "
      . "'" . db_escape($this->cost) . "', "
      . "'" . db_escape($this->address) . "', "
      . "'" . db_escape($this->city) . "', "
      . "'" . db_escape($this->state) . "', "
      . "'" . db_escape($this->info) . "', "
      . "'" . db_escape($this->ownerId) . "', "
      . "'" . db_escape($this->location['lat']) . "', "
      . "'" . db_escape($this->location['lng']) . "'"
      . ");"
    );
    $this->id = mysql_insert_id();
    if ($this->id) {
      $this->insertPhotosToDB();
    }
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
        . "lat='" . db_escape($this->location['lat']) . "' "
        . "lng='" . db_escape($this->location['lng']) . "' "
        . "where id='" . db_escape($this->id) . "';"
      );
      $res = db_query("delete from posting_photos where posting_id = '"
          . db_escape($this->id) . "';");
      $this->insertPhotosToDB();
    }
    return $this;
  }

  public function setLocation($new_lat, $new_lng) {
    $this->location = array('lat' => $new_lat, 'lng' => $new_lng);
    return $this;
  }

  public function getLocation() {
    return $this->location;
  }

  public function getFullAddress() {
    return $this->getAddress() . ", " . $this->getCity() . ", "
      . $this->getState();
  }

  protected function getEncodedAddress() {
    return urlencode($this->getAddress()) . ","
      . urlencode($this->getCity()) . ","
      . urlencode($this->getState());
  }

  public function getStaticMapUrl() {
    $location = $this->getEncodedAddress();
    return "http://maps.google.com/maps/api/staticmap?center=" . $location
      . "&zoom=14&size=256x256&markers=color:blue|label:H|"
      . $location . "&sensor=false";
  }

  public function addPhoto($photo_id, $photo_preview, $photo_src) {
    $this->photos[] = array(
      'id' => $photo_id,
      'preview' => $photo_preview,
      'src' => $photo_src,
    );
    return $this;
  }

  public function getPhotos() {
    return $this->photos;
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