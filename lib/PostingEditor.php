<?php

class PostingEditor {
  protected
    $posting,
    $action;

  public function render() {
    $out = "";
    $out .= "<form method=\"post\" action=\"" . $this->action . "\">";

    $out .= "<input type=\"hidden\" name=\"posting_id\" value=\""
       . htmlspecialchars($this->posting->getId()) . "\" />";

    $out .= "<div class=\"edit\">";
    $out .= "<div class=\"left_edit\">Title:</div>";
    $out .= "<div class=\"right_edit\">"
      . "<input type=\"text\" name=\"posting_title\""
      . " value=\"" . htmlspecialchars($this->posting->getTitle()) . "\" />"
      . "</div>";
    $out .= "</div>";

    $out .= "<div class=\"edit\">";
    $out .= "<div class=\"left_edit\">Address:</div>";
    $out .= "<div class=\"right_edit\">"
      . "<input type=\"text\" name=\"posting_address\""
      . " value=\"" . htmlspecialchars($this->posting->getAddress()) . "\" />"
      . "</div>";
    $out .= "</div>";

    $out .= "<div class=\"edit\">";
    $out .= "<div class=\"left_edit\">Cost ($/per month):</div>";
    $out .= "<div class=\"right_edit\">"
      . "<input type=\"text\" name=\"posting_cost\""
      . " value=\"" . htmlspecialchars($this->posting->getCost()) . "\" />"
      . "</div>";
    $out .= "</div>";

    $out .= "<div class=\"edit\">";
    $out .= "<div class=\"left_edit\">Info:</div>";
    $out .= "<div class=\"right_edit\">"
      . "<textarea type=\"text\" name=\"posting_info\" rows=\"10\""
      . ">" . htmlspecialchars($this->posting->getInfo()) . "</textarea>"
      . "</div>";
    $out .= "</div>";

    $out .= "<div class=\"edit\">";
    $out .= "<div class=\"center_edit\">"
      . "<input type=\"submit\" name=\"Create\""
      . " value=\"Create new posting\" />"
      . "</div>";
    $out .= "</div>";

    $out .= "<input type=\"hidden\" name=\"posting_submitted\""
       . " value=\"1\" />";

    $out .= "</form>";
    return $out;
  }

  public function setAction($new_action) {
    $this->action = $new_action;
    return $this;
  }

  public function getAction() {
    return $this->action;
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