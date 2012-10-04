<?php
include 'config.php';
include 'github.php';

$repo = $_GET['r'];

$g = new Github( $d );
$info = $g->getRepoInfo( $repo );

echo "<h1>$repo</h1>\n";
echo "<p>Written in ", join( ', ', $info['langs'] ), "</p>";

echo "<h2>Branches</h2>\n";
echo "<ul>\n";
foreach ( $info['branches'] as $branch )
{
	echo "<li><a href='http://github.com/{$repo}/tree/{$branch}'>$branch</a></li>\n";
}
echo "</ul>\n";
?>
