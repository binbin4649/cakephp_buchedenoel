<?php 
/* SVN FILE: $Id$ */
/* StockLogsController Test cases generated on: 2009-08-08 18:08:22 : 1249724302*/
App::import('Controller', 'StockLogs');

class TestStockLogs extends StockLogsController {
	var $autoRender = false;
}

class StockLogsControllerTest extends CakeTestCase {
	var $StockLogs = null;

	function startTest() {
		$this->StockLogs = new TestStockLogs();
		$this->StockLogs->constructClasses();
	}

	function testStockLogsControllerInstance() {
		$this->assertTrue(is_a($this->StockLogs, 'StockLogsController'));
	}

	function endTest() {
		unset($this->StockLogs);
	}
}
?>