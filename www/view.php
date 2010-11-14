<?php

require_once('../lib/header.php');
require_once('../lib/Posting.php');

$id = idx($_GET, 'id', 0);
$posting = Posting::fromDB($id);
require_once('../lib/PostingRenderer.php');
$renderer = new PostingRenderer($posting);
echo $renderer->render();

require_once('../lib/footer.php');

?>
