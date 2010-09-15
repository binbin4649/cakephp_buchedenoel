<?php 
/* SVN FILE: $Id$ */
/* TimeCardsController Test cases generated on: 2009-06-15 15:06:41 : 1245047801*/
App::import('Controller', 'TimeCards');

class TestTimeCards extends TimeCardsController {
	var $autoRender = false;
}

class TimeCardsControllerTest extends CakeTestCase {
	var $TimeCards = null;

	function startTest() {
		$this->TimeCards = new TestTimeCards();
		$this->TimeCards->constructClasses();
	}

	function testTimeCardsControllerInstance() {
		$this->assertTrue(is_a($this->TimeCards, 'TimeCardsController'));
	}

	function endTest() {
		unset($this->TimeCards);
	}
}
?>