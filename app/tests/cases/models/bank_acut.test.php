<?php 
/* SVN FILE: $Id$ */
/* BankAcut Test cases generated on: 2009-08-08 19:08:26 : 1249727366*/
App::import('Model', 'BankAcut');

class BankAcutTestCase extends CakeTestCase {
	var $BankAcut = null;
	var $fixtures = array('app.bank_acut', 'app.credit');

	function startTest() {
		$this->BankAcut =& ClassRegistry::init('BankAcut');
	}

	function testBankAcutInstance() {
		$this->assertTrue(is_a($this->BankAcut, 'BankAcut'));
	}

	function testBankAcutFind() {
		$this->BankAcut->recursive = -1;
		$results = $this->BankAcut->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('BankAcut' => array(
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
		$this->assertEqual($results, $expected);
	}
}
?>