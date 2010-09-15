<?php 
/* SVN FILE: $Id$ */
/* MemoDatasController Test cases generated on: 2009-07-24 11:07:32 : 1248404192*/
App::import('Controller', 'MemoDatas');

class TestMemoDatas extends MemoDatasController {
	var $autoRender = false;
}

class MemoDatasControllerTest extends CakeTestCase {
	var $MemoDatas = null;

	function startTest() {
		$this->MemoDatas = new TestMemoDatas();
		$this->MemoDatas->constructClasses();
	}

	function testMemoDatasControllerInstance() {
		$this->assertTrue(is_a($this->MemoDatas, 'MemoDatasController'));
	}

	function endTest() {
		unset($this->MemoDatas);
	}
}
?>