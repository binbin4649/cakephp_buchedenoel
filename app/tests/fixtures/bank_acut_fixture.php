<?php 
/* SVN FILE: $Id$ */
/* BankAcut Fixture generated on: 2009-08-08 19:08:26 : 1249727366*/

class BankAcutFixture extends CakeTestFixture {
	var $name = 'BankAcut';
	var $table = 'bank_acuts';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'account_number' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'account_type' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'bank_code' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'branch_code' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'remark' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'account_number'  => 'Lorem ipsum dolor ',
		'account_type'  => 1,
		'bank_code'  => 'Lorem ipsum dolor ',
		'branch_code'  => 'Lorem ipsum dolor ',
		'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created'  => 1,
		'created_user'  => 1,
		'updated'  => 1,
		'updated_user'  => 1
	));
}
?>