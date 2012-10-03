<?php
$file = __DIR__ . '/gitview.sqlite';

$d = new PDO("sqlite:$file");
$d->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
?>
