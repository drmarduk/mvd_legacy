<?php

$id = $_GET['id'];

$delete = new delete();
$delete->delete($id);
?>
