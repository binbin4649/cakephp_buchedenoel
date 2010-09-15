<?php 
/* SVN FILE: $Id$ */
/* ItemImage Test cases generated on: 2009-06-07 20:06:53 : 1244373233*/
App::import('Model', 'ItemImage');

class ItemImageTestCase extends CakeTestCase {
	var $ItemImage = null;
	var $fixtures = array('app.item_image');

	function startTest() {
		$this->ItemImage =& ClassRegistry::init('ItemImage');
	}

	function testItemImageInstance() {
		$this->assertTrue(is_a($this->ItemImage, 'ItemImage'));
	}

	function testItemImageFind() {
		$this->ItemImage->recursive = -1;
		$results = $this->ItemImage->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ItemImage' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'item_id'  => 1,
			'created'  => '2009-06-07 20:13:53',
			'created_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>