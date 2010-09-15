<?php 
/* SVN FILE: $Id$ */
/* StockRevisionsController Test cases generated on: 2009-08-08 18:08:35 : 1249724375*/
App::import('Controller', 'StockRevisions');

class TestStockRevisions extends StockRevisionsController {
	var $autoRender = false;
}

class StockRevisionsControllerTest extends CakeTestCase {
	var $StockRevisions = null;

	function startTest() {
		$this->StockRevisions = new TestStockRevisions();
		$this->StockRevisions->constructClasses();
	}

	function testStockRevisionsControllerInstance() {
		$this->assertTrue(is_a($this->StockRevisions, 'StockRevisionsController'));
	}

	function endTest() {
		unset($this->StockRevisions);
	}
}
?>