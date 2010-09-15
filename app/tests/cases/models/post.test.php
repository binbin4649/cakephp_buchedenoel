<?php 
/* SVN FILE: $Id$ */
/* Post Test cases generated on: 2009-06-04 17:06:40 : 1244103040*/
App::import('Model', 'Post');

class PostTestCase extends CakeTestCase {
	var $Post = null;
	var $fixtures = array('app.post');

	function startTest() {
		$this->Post =& ClassRegistry::init('Post');
	}

	function testPostInstance() {
		$this->assertTrue(is_a($this->Post, 'Post'));
	}

	function testPostFind() {
		$this->Post->recursive = -1;
		$results = $this->Post->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Post' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'delete_flag'  => 1,
			'kyuuyo_bugyo_code'  => 1,
			'name_english'  => 'Lorem ipsum dolor sit amet',
			'list_order'  => 1,
			'created_user'  => 1,
			'updated_user'  => 1,
			'created'  => '2009-06-04 17:10:40',
			'updated'  => '2009-06-04 17:10:40'
		));
		$this->assertEqual($results, $expected);
	}
}
?>