<?php
class StockLogsController extends AppController {

	var $name = 'StockLogs';

	function index() {
		$modelName = 'StockLog';
		if (!empty($this->data)) {
			$conditions = array();
			if(!empty($this->data[$modelName]['subitem'])){
				$conditions[] = array('and'=>array('Subitem.name LIKE'=>'%'.$this->data[$modelName]['subitem'].'%'));
			}
			if(!empty($this->data[$modelName]['depot'])){
				$conditions[] = array('and'=>array('Depot.id'=>$this->data[$modelName]['depot']));
			}
			if(!empty($this->data[$modelName]['plus'])){
				$conditions[] = array('and'=>array('StockLog.plus'=>$this->data[$modelName]['plus']));
			}
			if(!empty($this->data[$modelName]['mimus'])){
				$conditions[] = array('and'=>array('StockLog.mimus'=>$this->data[$modelName]['mimus']));
			}
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>60,
				'order'=>array('StockLog.created'=>'desc')
			);
		}else{
			$this->paginate = array(
				'conditions'=>array(),
				'limit'=>60,
				'order'=>array('StockLog.created'=>'desc')
			);
		}

		$this->StockLog->recursive = 0;
		$this->set('stockLogs', $this->paginate());
		$log_plus = log_plus();
		$log_mimus =log_mimus();
		$this->set(compact('log_plus', 'log_mimus'));
	}

}
?>