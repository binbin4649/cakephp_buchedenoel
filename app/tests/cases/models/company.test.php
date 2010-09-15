<?php 
/* SVN FILE: $Id$ */
/* Company Test cases generated on: 2009-08-08 17:08:18 : 1249721598*/
App::import('Model', 'Company');

class CompanyTestCase extends CakeTestCase {
	var $Company = null;
	var $fixtures = array('app.company', 'app.user', 'app.y', 'app.brand_rate', 'app.destination');

	function startTest() {
		$this->Company =& ClassRegistry::init('Company');
	}

	function testCompanyInstance() {
		$this->assertTrue(is_a($this->Company, 'Company'));
	}

	function testCompanyFind() {
		$this->Company->recursive = -1;
		$results = $this->Company->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Company' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'username'  => 'Lorem ip',
			'password'  => 'Lorem ip',
			'destination_id'  => 1,
			'kana'  => 'Lorem ipsum dolor sit amet',
			'user_id'  => 1,
			'contact_section'  => 'Lorem ipsum dolor sit amet',
			'contact_post'  => 'Lorem ipsum dolor sit amet',
			'contact_name'  => 'Lorem ipsum dolor sit amet',
			'post_code'  => 'Lorem ipsum dolor ',
			'district'  => 1,
			'address_one'  => 'Lorem ipsum dolor sit amet',
			'address_two'  => 'Lorem ipsum dolor sit amet',
			'tel'  => 'Lorem ipsum dolor sit amet',
			'fax'  => 'Lorem ipsum dolor sit amet',
			'mail'  => 'Lorem ipsum dolor sit amet',
			'url'  => 'Lorem ipsum dolor sit amet',
			'trade_type'  => 1,
			'basic_rate'  => 1,
			'rate_fraction'  => 1,
			'tax_method'  => 1,
			'tax_fraction'  => 1,
			'start_day'  => '2009-08-08',
			'last_visit_day'  => '2009-08-08',
			'stations'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'more'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'store_info'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'agreement'  => 'Lorem ip',
			'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-08-08 17:53:18',
			'created_user'  => 1,
			'updated'  => '2009-08-08 17:53:18',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>