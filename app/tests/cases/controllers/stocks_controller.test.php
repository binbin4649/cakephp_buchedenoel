<?php 
/* SVN FILE: $Id$ */
/* StocksController Test cases generated on: 2009-08-11 21:08:39 : 1249994859*/
App::import('Controller', 'Stocks');

class TestStocks extends StocksController {
	var $autoRender = false;
}

class StocksControllerTest extends CakeTestCase {
	var $Stocks = null;

	function startTest() {
		$this->Stocks = new TestStocks();
		$this->Stocks->constructClasses();
	}

	function testStocksControllerInstance() {
		$this->assertTrue(is_a($this->Stocks, 'StocksController'));
	}

	function endTest() {
		unset($this->Stocks);
	}
}
?>