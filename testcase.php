<?php
require_once 'github.php';
include 'config.php';

class PullTest extends PHPUnit_Framework_TestCase
{
	function testHasMasterBranch1()
	{
		$g = new Github( $GLOBALS['d'] );
		$branches =  $g->getBranches( 'derickr/xdebug.org' );
		$this->assertContains( 'master', $branches );
	}
		
	function testHasMasterBranch2()
	{
		$g = new Github( $GLOBALS['d'] );
		$branches =  $g->getBranches( 'derickr/xdebug-tutorial' );
		$this->assertContains( 'master', $branches );
	}
}
