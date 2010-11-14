<?php

class PostingRenderer {
  protected
    $posting;

  public function __construct($posting = null) {
    $this->posting = $posting;
  }

  public function render($craig = false) {
    if (!$this->posting) {
      return "No posting";
    }
    $out = "";
    if ($craig) {
      $out .= "<style>";
      $out .= file_get_contents('css/renderer.css');
      $out .= "</style>";
    } else {
      require_once( '../lib/head_control.php');
      include_css("renderer.css?" . mt_rand());
    }

    $out .= "<div class=\"posting_page\">";

    $out .= "<h1 class=\"posting_header\">"
      . htmlspecialchars($this->posting->getTitle()) . "</h1><br />";

    $static_map_url = $this->posting->getStaticMapUrl();
    if ($static_map_url) {
      $alt = htmlspecialchars($this->posting->getFullAddress());
      $out .= "<div class=\"posting_map\">";
      $out .= "<a href=\"#map\">"
        . "<img class=\"posting_map_img\" alt=\"" . $alt . "\" title=\""
        . $alt . "\" src=\"" . $static_map_url . "\"/></a>";
      $out .= "</div>";
    }

    $out .= "<div class=\"right_info\">";

    $out .= "<div class=\"right_elem\">";
    $out .= "<div class=\"right_elem_name\">Address:</div>";
    $out .= "<div class=\"right_elem_value\">"
      . htmlspecialchars($this->posting->getAddress()) . "</div>";
    $out .= "</div>";

    $out .= "<div class=\"right_elem\">";
    $out .= "<div class=\"right_elem_name\">Cost ($/per month):</div>";
    $out .= "<div class=\"right_elem_value\">"
      . htmlspecialchars($this->posting->getCost()) . "</div>";
    $out .= "</div>";

    $out .= "</div>";

    $out .= "<div class=\"desription\">";
    $out .= htmlspecialchars($this->posting->getInfo());
    $out .= "</div>";

    foreach ($this->posting->getPhotos() as $photo) {
      $out .= "<img src=\"" . htmlspecialchars($photo['preview']) . "\" />";
    }

    $out .= "</div>";
    return $out;
  }

  public function setPosting($new_posting) {
    $this->posting = $new_posting;
    return $this;
  }

  public function getPosting() {
    return $this->posting;
  }
}
?>
