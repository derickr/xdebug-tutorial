<?php
include 'config.php';
include 'github.php';

$g = new Github( $d );
$g->processUsers();
echo "Done!\n";
?>
