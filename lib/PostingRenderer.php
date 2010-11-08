<?php

class PostingRenderer {
  protected
    $posting;

  public function __construct($posting = null) {
    $this->posting = $posting;
  }

  public function render() {
    if (!$this->posting) {
      return "No posting";
    }
    require_once( '../lib/head_control.php');
    include_css("renderer.css");
    $out = "";

    $out .= "<div class=\"posting_page\">";

    $out .= "<h1 class=\"posting_header\">"
      . htmlspecialchars($this->posting->getTitle()) . "</h1>";

    $static_map_url = $this->posting->getStaticMapUrl();
    if ($static_map_url) {
      $alt = htmlspecialchars($this->posting->getFullAddress());
      $out .= "<a href=\"#map\" rel=\"facebox\"> <img class=\"posting_map\" alt=\"" . $alt . "\" title=\""
        . $alt . "\" src=\"" . $static_map_url . "\"/></a>";
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
