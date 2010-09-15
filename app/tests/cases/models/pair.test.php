<?php 
/* SVN FILE: $Id$ */
/* Pair Test cases generated on: 2009-06-07 20:06:05 : 1244373605*/
App::import('Model', 'Pair');

class PairTestCase extends CakeTestCase {
	var $Pair = null;
	var $fixtures = array('app.pair');

	function startTest() {
		$this->Pair =& ClassRegistry::init('Pair');
	}

	function testPairInstance() {
		$this->assertTrue(is_a($this->Pair, 'Pair'));
	}

	function testPairFind() {
		$this->Pair->recursive = -1;
		$results = $this->Pair->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Pair' => array(
			'id'  => 1,
			'ladys_id'  => 1,
			'mens_id'  => 1,
			'created'  => '2009-06-07 20:20:05',
			'created_user'  => 1,
			'updated'  => '2009-06-07 20:20:05',
			'updated_user'  => 1,
			'deleted'  => 1,
			'deleted_date'  => '2009-06-07 20:20:05'
		));
		$this->assertEqual($results, $expected);
	}
}
?>