<?php 
/* SVN FILE: $Id$ */
/* CreditsController Test cases generated on: 2009-08-08 19:08:26 : 1249727306*/
App::import('Controller', 'Credits');

class TestCredits extends CreditsController {
	var $autoRender = false;
}

class CreditsControllerTest extends CakeTestCase {
	var $Credits = null;

	function startTest() {
		$this->Credits = new TestCredits();
		$this->Credits->constructClasses();
	}

	function testCreditsControllerInstance() {
		$this->assertTrue(is_a($this->Credits, 'CreditsController'));
	}

	function endTest() {
		unset($this->Credits);
	}
}
?>