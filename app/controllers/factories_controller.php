<?php
class FactoriesController extends AppController {

	var $name = 'Factories';
	var $uses = array('Factory', 'User');

	function index() {
		$modelName = 'Factory';
		if (!empty($this->data[$modelName]['word'])) {
			$seach_word = $this->data[$modelName]['word'];
			$conditions['or'] = array($modelName.'.id'=>$seach_word, $modelName.'.name LIKE'=>'%'.$seach_word.'%');
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>30,
				'order'=>array($modelName.'.created'=>'desc')
			);
		}else{
			if($this->data[$modelName]['trading_flag'] == '1'){
				$conditions = array();
			}else{
				$conditions['or'] = array(
					$modelName.'.trading_flag <>'=>'3',
					$modelName.'.trading_flag'=>NULL
				);
			}
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>30,
				'order'=>array($modelName.'.created'=>'desc')
			);
		}
		$this->Factory->recursive = 0;
		$this->set('factories', $this->paginate());
		$this->set('trading_flag', get_trading_flag());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Factory', true), array('action'=>'index'));
		}
		$params = array(
			'conditions'=>array('Factory.id'=>$id),
			'recursive'=>0
		);
		$view_data = $this->Factory->find('first', $params);
		$tax_method = get_tax_method();
		$tax_fraction = get_tax_fraction();
		$total_day = get_total_day();
		$payment_day = get_payment_day();
		$payment_code = get_payment_code();
		$trading_flag = get_trading_flag();
		$district = get_district();
		if(!empty($view_data['Factory']['tax_method']))$view_data['Factory']['tax_method'] = $tax_method[$view_data['Factory']['tax_method']];
		if(!empty($view_data['Factory']['tax_fraction']))$view_data['Factory']['tax_fraction'] = $tax_fraction[$view_data['Factory']['tax_fraction']];
		if(!empty($view_data['Factory']['total_day']))$view_data['Factory']['total_day'] = $total_day[$view_data['Factory']['total_day']];
		if(!empty($view_data['Factory']['payment_day']))$view_data['Factory']['payment_day'] = $payment_day[$view_data['Factory']['payment_day']];
		if(!empty($view_data['Factory']['payment_code']))$view_data['Factory']['payment_code'] = $payment_code[$view_data['Factory']['payment_code']];
		if(!empty($view_data['Factory']['trading_flag']))$view_data['Factory']['trading_flag'] = $trading_flag[$view_data['Factory']['trading_flag']];
		if(!empty($view_data['Factory']['district']))$view_data['Factory']['district'] = $district[$view_data['Factory']['district']];
		$this->set('factory', $view_data);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Factory->create();
			if ($this->Factory->save($this->data)) {
				$id = $this->Factory->getInsertID();
				$this->redirect('/factories/view/'.$id);
			} else {
			}
		}
		$tax_method = get_tax_method();
		$tax_fraction = get_tax_fraction();
		$total_day = get_total_day();
		$payment_day = get_payment_day();
		$payment_code = get_payment_code();
		$trading_flag = get_trading_flag();
		$district = get_district();

		$this->set(compact('tax_method', 'tax_fraction', 'total_day', 'payment_day', 'payment_code', 'trading_flag', 'district'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Factory', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Factory->save($this->data)) {
				$this->redirect('/factories/view/'.$id);
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Factory->read(null, $id);
		}
		$tax_method = get_tax_method();
		$tax_fraction = get_tax_fraction();
		$total_day = get_total_day();
		$payment_day = get_payment_day();
		$payment_code = get_payment_code();
		$trading_flag = get_trading_flag();
		$district = get_district();

		$this->set(compact('tax_method', 'tax_fraction', 'total_day', 'payment_day', 'payment_code', 'trading_flag', 'district'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Factory', true), array('action'=>'index'));
		}
		if ($this->Factory->del($id) == false) {
			$this->redirect('/factories/');
		}
	}


}
?>