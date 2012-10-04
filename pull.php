<?php
include 'config.php';

class Github
{
	static $base = "https://api.github.com/";

	function call( $method )
	{
		return json_decode(file_get_contents(self::$base . $method));
	}

	private function storeRepository( $d, $name, $reponame, $branches, $languages )
	{
		$canonicalName = "$name/{$reponame}";

		/* First we store the repository name */
		$d->query( "INSERT INTO repo VALUES('$canonicalName', 0)" );

		/* Then languages and branches */
		foreach ( $branches as $branch )
		{
			$d->query( "INSERT INTO branch VALUES('$canonicalName', '$branch');" );
		}
		foreach ( $languages as $lang )
		{
			$d->query( "INSERT INTO lang VALUES('$canonicalName', '$lang');" );
		}

	}

	private function processUser( $d, $name )
	{
		foreach ( $this->call("users/{$name}/repos") as $r )
		{
			if ( $r->fork ) {
				continue;
			}

			$branches = $languages = array();

			foreach ( $this->call( "repos/{$name}/{$r->name}/branches" ) as $b )
			{
				$branches[] = $b->name;
			}

			foreach ( $this->call( "repos/{$name}/{$r->name}/languages" ) as $l => $count )
			{
				$languages[] = $l;
			}

			$this->storeRepository( $d, $name, $r->name, $branches, $languages );
		}
	}

	function processUsers( $d )
	{
		foreach ( $d->query("SELECT name FROM user") as $row )
		{
			$name = $row['name'];
			$this->processUser( $d, $name );
		}
	}
}

$g = new Github;
$g->processUsers( $d );
echo "Done!\n";
?>
