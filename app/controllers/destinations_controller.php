<?php
class DestinationsController extends AppController {

	var $name = 'Destinations';
	var $uses = array('Destination', 'Company');

	function index() {
		$this->Destination->recursive = 0;
		if (!empty($this->data['Destination']['word'])) {
			$seach_word = $this->data['Destination']['word'];
			$conditions['or'] = array(
				'Destination.name LIKE'=>'%'.$seach_word.'%',
				'Destination.address_one LIKE'=>'%'.$seach_word.'%',
				'Destination.tel LIKE'=>'%'.$seach_word.'%'
			);
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>20,
				'order'=>array('Destination.updated'=>'desc')
			);
		}else{
			if($this->data['Destination']['trade_type'] == '1'){
				$conditions = array();
			}else{
				$conditions['or'] = array(
					'Destination.trade_type <>'=>'3',
					'Destination.trade_type'=>NULL,
				);
			}
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>20,
				'order'=>array('Destination.updated'=>'desc')
			);
		}
		$companies = $this->Destination->Company->find('list');
		$index_view = $this->paginate();
		$index_out = array();
		foreach($index_view as $index){
			if(!empty($index['Destination']['company_id'])){
				$index['Destination']['company_name'] = mb_substr($companies[$index['Destination']['company_id']], 0, 10);
			}
			$index_out[] = $index;
		}
		$this->set('destinations', $index_out);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Destination.', true));
			$this->redirect(array('action'=>'index'));
		}
		$trade_type = get_trade_type();
		$district = get_district();
		$shipping_flag = get_shipping_flag();
		$view = $this->Destination->read(null, $id);
		if(!empty($view['Destination']['trade_type']))$view['Destination']['trade_type'] = $trade_type[$view['Destination']['trade_type']];
		if(!empty($view['Destination']['district']))$view['Destination']['district'] = $district[$view['Destination']['district']];
		if(!empty($view['Destination']['shipping_flag']))$view['Destination']['shipping_flag'] = $shipping_flag[$view['Destination']['shipping_flag']];
		$this->set('destination', $view);
	}

	function add($company_id = null) {
		if (!empty($this->data)) {
			$this->Destination->create();
			if ($this->Destination->save($this->data)) {
				$this->Session->setFlash(__('The Destination has been saved', true));
				$id = $this->Destination->getInsertID();
				$this->redirect(array('action'=>'view/'.$id));
			} else {
				$this->Session->setFlash(__('The Destination could not be saved. Please, try again.', true));
			}
		}
		if(!empty($company_id)){
			$params = array(
				'conditions'=>array('Company.id'=>$company_id),
				'recursive'=>0
			);
			$company = $this->Company->find('first' ,$params);
			$this->set('company', $company);
		}else{
			$this->set('company', false);
		}
		$trade_type = get_trade_type();
		$district = get_district();
		$shipping_flag = get_shipping_flag();
		$this->set(compact('district', 'shipping_flag', 'trade_type'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Destination', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Destination->save($this->data)) {
				$this->Session->setFlash(__('The Destination has been saved', true));
				$this->redirect(array('action'=>'view/'.$id));
			} else {
				$this->Session->setFlash(__('The Destination could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Destination->read(null, $id);
		}
		$trade_type = get_trade_type();
		$district = get_district();
		$shipping_flag = get_shipping_flag();
		$this->set(compact('district', 'shipping_flag', 'trade_type'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Destination', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Destination->del($id)) {
			$this->Session->setFlash(__('Destination deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	//thickbox用
	function selectid(){
		$this->layout = 'senddata';
		$this->index();
	}
	

}
?>