<?php 
/* SVN FILE: $Id$ */
/* DestinationsController Test cases generated on: 2009-08-08 18:08:56 : 1249723076*/
App::import('Controller', 'Destinations');

class TestDestinations extends DestinationsController {
	var $autoRender = false;
}

class DestinationsControllerTest extends CakeTestCase {
	var $Destinations = null;

	function startTest() {
		$this->Destinations = new TestDestinations();
		$this->Destinations->constructClasses();
	}

	function testDestinationsControllerInstance() {
		$this->assertTrue(is_a($this->Destinations, 'DestinationsController'));
	}

	function endTest() {
		unset($this->Destinations);
	}
}
?>