<?php
include 'config.php';
include 'github.php';

$g = new Github( $d );

echo "<ul>\n";
foreach ( $g->getRepos() as $r )
{
	echo "<li><a href='view-repo.php?r=$r'>$r</a></li>\n";
}
echo "</ul>\n";
?>
