<?php
class Github
{
	static $base = "https://api.github.com/";
	private $d;

	function __construct( $dbh )
	{
		$this->d = $dbh;
	}

	function call( $method )
	{
		return json_decode(file_get_contents(self::$base . $method));
	}

	function getBranches( $repo )
	{
		$branches = array();
		foreach ( $this->d->query("SELECT * FROM branch WHERE repo='$repo'") as $row )
		{
			$branches[] = $row['branch'];
		}
		return $branches;
	}

	private function storeRepository( $name, $reponame, $branches, $languages )
	{
		$canonicalName = "$name/{$reponame}";

		/* First we store the repository name */
		$this->d->query( "INSERT INTO repo VALUES('$canonicalName', 0)" );

		/* Then languages and branches */
		foreach ( $branches as $branch )
		{
			$this->d->query( "INSERT INTO branch VALUES('$canonicalName', '$branch');" );
		}
		foreach ( $languages as $lang )
		{
			$this->d->query( "INSERT INTO lang VALUES('$canonicalName', '$lang');" );
		}

	}

	private function processUser( $name )
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

			$this->storeRepository( $name, $r->name, $branches, $languages );
		}
	}

	function processUsers()
	{
		foreach ( $this->d->query("SELECT name FROM user") as $row )
		{
			$name = $row['name'];
			$this->processUser( $name );
		}
	}
}
?>
