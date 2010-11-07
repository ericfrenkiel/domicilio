<?php
  class PostingEditor {    protected
      $id,
      $title,
      $address,
      $info,
      $cost,
      $photos,
      $action;

    function render() {      echo "<form action=\"{$this->action}\">";
      echo "
      echo "</form>";
    }
  }
?>