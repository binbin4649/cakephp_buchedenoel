<?php 
/* SVN FILE: $Id$ */
/* Material Test cases generated on: 2009-06-07 20:06:20 : 1244373380*/
App::import('Model', 'Material');

class MaterialTestCase extends CakeTestCase {
	var $Material = null;
	var $fixtures = array('app.material');

	function startTest() {
		$this->Material =& ClassRegistry::init('Material');
	}

	function testMaterialInstance() {
		$this->assertTrue(is_a($this->Material, 'Material'));
	}

	function testMaterialFind() {
		$this->Material->recursive = -1;
		$results = $this->Material->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Material' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'cleaning_plan'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'notes'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-06-07 20:16:20',
			'created_user'  => 1,
			'updated'  => '2009-06-07 20:16:20',
			'updated_user'  => 1,
			'deleted'  => 1,
			'deleted_date'  => '2009-06-07 20:16:20'
		));
		$this->assertEqual($results, $expected);
	}
}
?>