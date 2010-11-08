<?php

class PostingEditor {
  protected
    $posting,
    $action;

  public function render() {
    $out = "";
    $out .= "<form id=\"posting_form\" method=\"post\" "
      . "action=\"" . $this->action . "\">";

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
    $out .= "<div class=\"left_edit\">City:</div>";
    $out .= "<div class=\"right_edit\">"
      . "<input type=\"text\" name=\"posting_city\""
      . " value=\"" . htmlspecialchars($this->posting->getCity()) . "\" />"
      . "</div>";
    $out .= "</div>";

    $out .= "<div class=\"edit\">";
    $out .= "<div class=\"left_edit\">State:</div>";
    $out .= "<div class=\"right_edit\">"
      . "<select name=\"posting_state\" size=\"1\">";
    require_once('../lib/constants/states.php');
    global $state_list;
    $cur_state = $this->posting->getState();
    foreach ($state_list as $short => $long) {
      $out .= "<option value=\"" . $short . "\"";
      if ($short === $cur_state) {
        $out .= " selected=\"selected\"";
      }
      $out .= ">" . $long . "</option>";
    }
    $out .= "</select></div>";
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
    $out .= "<div class=\"center_edit\">";
    $out .= "<input type=\"submit\" name=\"Create\""
      . " value=\"Create new posting\" />";
    $out .= "<input type=\"submit\" name=\"Create\""
      . " value=\"Preview\" onclick=\"preview();return false;\" />";
    $out .= "</div>";
    $out .= "</div>";

    $out .= "<input type=\"hidden\" name=\"posting_submitted\""
       . " value=\"1\" />";

    $out .= "</form>";
    $out .= "<div id=\"preview\"></div>";
    $out .= "<script>"
      . "function preview() {"
      . "  $.post(\"preview.php\", $(\"#posting_form\").serialize(),"
      . " function(data){ $(\"#preview\").html(data);}"
      . ");"
      . "}";
    $out .= "</script>";
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