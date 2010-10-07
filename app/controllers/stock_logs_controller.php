<?php
class StockLogsController extends AppController {

	var $name = 'StockLogs';

	function index() {
		$modelName = 'StockLog';
		if (!empty($this->data)) {
			$conditions = array();
			if(!empty($this->data[$modelName]['subitem'])){
				$this->data[$modelName]['subitem'] = trim($this->data[$modelName]['subitem']);
				$conditions[] = array('and'=>array('Subitem.name LIKE'=>'%'.$this->data[$modelName]['subitem'].'%'));
			}
			if(!empty($this->data[$modelName]['depot'])){
				$this->data[$modelName]['depot'] = mb_convert_kana($this->data[$modelName]['depot'], 'a', 'UTF-8');
				$this->data[$modelName]['depot'] = ereg_replace("[^0-9]", "", $this->data[$modelName]['depot']);//半角数字以外削除
				$conditions[] = array('and'=>array('Depot.id'=>$this->data[$modelName]['depot']));
			}
			if(!empty($this->data[$modelName]['plus'])){
				$conditions[] = array('and'=>array('StockLog.plus'=>$this->data[$modelName]['plus']));
			}
			if(!empty($this->data[$modelName]['mimus'])){
				$conditions[] = array('and'=>array('StockLog.mimus'=>$this->data[$modelName]['mimus']));
			}
			if(!empty($this->data[$modelName]['jan'])){
				$this->data[$modelName]['jan'] = mb_convert_kana($this->data[$modelName]['jan'], 'a', 'UTF-8');
				$this->data[$modelName]['jan'] = ereg_replace("[^0-9]", "", $this->data[$modelName]['jan']);//半角数字以外削除
				$conditions[] = array('and'=>array('Subitem.jan'=>$this->data[$modelName]['jan']));
			}
			if(!empty($this->data[$modelName]['created_user'])){
				$this->data[$modelName]['created_user'] = mb_convert_kana($this->data[$modelName]['created_user'], 'a', 'UTF-8');
				$this->data[$modelName]['created_user'] = ereg_replace("[^0-9]", "", $this->data[$modelName]['created_user']);//半角数字以外削除
				$conditions[] = array('and'=>array('StockLog.created_user'=>$this->data[$modelName]['created_user']));
			}
			if(!empty($this->data[$modelName]['start_date']['year']) and !empty($this->data[$modelName]['start_date']['month']) and !empty($this->data[$modelName]['start_date']['day'])){
				$start_date = $this->data[$modelName]['start_date']['year'].'-'.$this->data[$modelName]['start_date']['month'].'-'.$this->data[$modelName]['start_date']['day'].' 00:00:00';
				$conditions[] = array('and'=>array('StockLog.created >='=>$start_date));
			}
			if(!empty($this->data[$modelName]['end_date']['year']) and !empty($this->data[$modelName]['end_date']['month']) and !empty($this->data[$modelName]['end_date']['day'])){
				$end_date = $this->data[$modelName]['end_date']['year'].'-'.$this->data[$modelName]['end_date']['month'].'-'.$this->data[$modelName]['end_date']['day'].' 23:59:59';
				$conditions[] = array('and'=>array('StockLog.created <='=>$end_date));
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
		$this->set('stockLogs', $this->paginate());
		$log_plus = log_plus();
		$log_mimus =log_mimus();
		$this->set(compact('log_plus', 'log_mimus'));
	}

}
?>