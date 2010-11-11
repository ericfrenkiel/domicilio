<?php

class PostingEditor extends Posting {
  protected
    $posting,
    $action;

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
