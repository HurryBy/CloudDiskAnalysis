<?php
$link = isset($_GET['link']) ? $_GET['link'] : NULL;
$length = strlen($link)-strrpos($link,"/")+1;
$lanzou_id = substr($link,strrpos($link,"/")+1,$length);
echo $lanzou_id;
?>