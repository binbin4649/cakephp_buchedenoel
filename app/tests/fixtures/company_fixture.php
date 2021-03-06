<?php 
/* SVN FILE: $Id$ */
/* Company Fixture generated on: 2009-08-08 17:08:18 : 1249721598*/

class CompanyFixture extends CakeTestFixture {
	var $name = 'Company';
	var $table = 'companies';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 60),
		'username' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 10),
		'password' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 10),
		'destination_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'kana' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'user_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contact_section' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 60),
		'contact_post' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 60),
		'contact_name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 60),
		'post_code' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'district' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'address_one' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'address_two' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'tel' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'fax' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'mail' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'url' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'trade_type' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'basic_rate' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'rate_fraction' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'tax_method' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'tax_fraction' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'start_day' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'last_visit_day' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'stations' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'more' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'store_info' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'agreement' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 10),
		'remark' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
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
}
?>