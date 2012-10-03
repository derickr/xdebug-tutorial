<?php
include 'config.php';

function fetch($call)
{
	$base = "https://api.github.com/";
	return json_decode(file_get_contents("$base$call"));
}

foreach ($d->query("SELECT name FROM user") as $row)
{
	$name = $row['name'];
	echo "Fetching for {$name}\n";

	foreach (fetch("users/{$name}/repos") as $r) 
	{
		if ($r->fork) {
			continue;
		}
		echo $r->name, ': ', $r->description, "\n";

		echo "- Branches:\n";
		foreach (fetch("repos/{$name}/{$r->name}/branches") as $b) {
			echo "  - ". $b->name, "\n";
		}

		echo "- Languages:\n";
		foreach (fetch("repos/{name}/{$r->name}/languages") as $l => $count) {
			echo "  - $l; bytes: $count\n";
		}
		echo "\n";
	}
}
