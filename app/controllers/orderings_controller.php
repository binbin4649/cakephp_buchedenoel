<?php
class OrderingsController extends AppController {

	var $name = 'Orderings';
	var $helpers = array('AddForm');
	var $uses = array('Ordering', 'Item', 'OrderingsDetail', 'Subitem', 'User', 'Depot', 'Factory');
	var $components = array('Total', 'Print');

	function index() {
		$conditions = array();
		if (!empty($this->data['Ordering'])) {
			if(!empty($this->data['Ordering']['word'])) $conditions[] = array('Ordering.id'=>$this->data['Ordering']['word']);
			if(!empty($this->data['Ordering']['status'])) $conditions[] = array('Ordering.ordering_status'=>$this->data['Ordering']['status']);
			if(!empty($this->data['Ordering']['orderings_type'])) $conditions[] = array('Ordering.orderings_type'=>$this->data['Ordering']['orderings_type']);
		}else{
			$conditions = array('Ordering.ordering_status <>'=>'6');
		}
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>50,
			'recursive'=>0,
			'order'=>array('Ordering.updated'=>'desc')
		);
		$index_view = $this->paginate();
		$ordering_status = get_ordering_status();
		$factories = $this->Ordering->Factory->find('list');
		$index_out = array();
		foreach($index_view as $index){
			if(!empty($index['Ordering']['ordering_status']))$index['Ordering']['ordering_status'] = $ordering_status[$index['Ordering']['ordering_status']];
			if(!empty($index['Ordering']['factory_id']))$index['Ordering']['factory_id'] = $factories[$index['Ordering']['factory_id']];
			$index_out[] = $index;
		}
		$this->set('orderings', $index_out);
		$ordering_status = get_ordering_status();
		$this->set('status', $ordering_status);
		$orderings_type = get_orderings_type();
		$this->set('type', $orderings_type);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Ordering.', true));
			$this->redirect(array('action'=>'index'));
		}
		$factories = $this->Ordering->Factory->find('list');
		$ordering_status = get_ordering_status();
		$view = $this->Ordering->read(null, $id);
		if(!empty($view['Ordering']['ordering_status'])){
			$view['Ordering']['status'] = $view['Ordering']['ordering_status'];
			$view['Ordering']['ordering_status'] = $ordering_status[$view['Ordering']['ordering_status']];
		}
		if(!empty($view['Ordering']['factory_id']))$view['Ordering']['factory_id'] = $factories[$view['Ordering']['factory_id']];
		$i = 0;
		foreach($view['OrderingsDetail'] as $OrderingsDetail){
			$params = array(
				'conditions'=>array('Subitem.id'=>$OrderingsDetail['subitem_id']),
				'recursive'=>0,
				'fields'=>array('Subitem.name')
			);
			$subitem = $this->Subitem->find('first' ,$params);
			$view['OrderingsDetail'][$i]['subitem_name'] = $subitem['Subitem']['name'];
			$params = array(
				'conditions'=>array('Depot.id'=>$OrderingsDetail['depot']),
				'recursive'=>0,
				'fields'=>array('Depot.name')
			);
			$depot = $this->Depot->find('first' ,$params);
			$view['OrderingsDetail'][$i]['depot_name'] = $depot['Depot']['name'];
			$params = array(
				'conditions'=>array('User.id'=>$OrderingsDetail['created_user']),
				'recursive'=>0,
				'fields'=>array('User.name')
			);
			$user = $this->User->find('first' ,$params);
			$view['OrderingsDetail'][$i]['created_user'] = $user['User']['name'];
			$i++;
		}
		$this->set('ordering', $view);
		if(!empty($view['Ordering']['print_file'])){
			$print_out['url'] = '/buchedenoel/files/ordering/'.$view['Ordering']['print_file'].'.php';
			$print_out['file'] = $view['Ordering']['print_file'].'.pxd';
			$this->set('print', $print_out);
		}
		$orderings_type = get_orderings_type();
		$this->set('type', $orderings_type);
	}

	function add($ac = null, $id = null) {
		//確定処理
		if($ac == 'decision'){
			$params = array(
				'conditions'=>array('Ordering.id'=>$id),
				'recursive'=>0,
			);
			$ordering = $this->Ordering->find('first' ,$params);
			$params = array(
				'conditions'=>array('OrderingsDetail.ordering_id'=>$id),
				'recursive'=>0,
			);
			$details = $this->OrderingsDetail->find('all' ,$params);
			$ordering_total = 0;
			$detail_total = 0;
			$detail_quantity = 0;
			$sub_total = array();
			$i = 0;
			foreach($details as $dateil){
				$sub_total[$i]['money'] = $dateil['OrderingsDetail']['bid'];
				$sub_total[$i]['quantity'] = $dateil['OrderingsDetail']['ordering_quantity'];
				$i++;
			}
			$slip_total = $this->Total->slipTotal($sub_total, $ordering['Factory']['tax_method'], $ordering['Factory']['tax_fraction']);
			$Ordering['Ordering']['id'] = $id;
			$Ordering['Ordering']['ordering_status'] = 2;
			$Ordering['Ordering']['updated_user'] = $this->Auth->user('id');
			$Ordering['Ordering']['total'] = $slip_total['total'] + $ordering['Ordering']['adjustment'];
			$Ordering['Ordering']['total_tax'] = $slip_total['tax'];
			$Ordering['Ordering']['dateil_total'] = $slip_total['detail_total'];
			if(empty($ordering['Ordering']['date'])){
				$Ordering['Ordering']['date'] = date('Y-m-d');
			}
			$this->Ordering->save($Ordering);
			$this->redirect(array('action'=>'view', $id));
		}
		if($ac == 'print'){
			$params = array(
				'conditions'=>array('Ordering.id'=>$id),
				'recursive'=>0,
			);
			$ordering = $this->Ordering->find('first' ,$params);
			$params = array(
				'conditions'=>array('OrderingsDetail.ordering_id'=>$id),
				'recursive'=>0,
			);
			$details = $this->OrderingsDetail->find('all' ,$params);

			$file_name = 'ordering'.$id.'-'.date('Ymd-His');
			$path = WWW_ROOT.'/files/ordering/';
			$print_xml = $this->Print->ordering($ordering, $details, $file_name);
			file_put_contents($path.$file_name.'.php', $print_xml);
			$Ordering['Ordering']['id'] = $id;
			$Ordering['Ordering']['ordering_status'] = 3;
			$Ordering['Ordering']['updated_user'] = $this->Auth->user('id');
			$Ordering['Ordering']['print_file'] = $file_name;
			$this->Ordering->save($Ordering);
			$this->redirect(array('action'=>'view', $id));
		}
		if($ac == 'fax'){
			$Ordering['Ordering']['id'] = $id;
			$Ordering['Ordering']['ordering_status'] = 4;
			$Ordering['Ordering']['updated_user'] = $this->Auth->user('id');
			$this->Ordering->save($Ordering);
			$this->redirect(array('action'=>'view', $id));
		}
		if($ac == 'alteration'){
			$Ordering['Ordering']['id'] = $id;
			$Ordering['Ordering']['ordering_status'] = 1;
			$Ordering['Ordering']['updated_user'] = $this->Auth->user('id');
			$this->Ordering->save($Ordering);
			$this->redirect(array('action'=>'view', $id));
		}
	if($ac == 'cancell'){
			$Ordering['Ordering']['id'] = $id;
			$Ordering['Ordering']['ordering_status'] = 6;
			$Ordering['Ordering']['updated_user'] = $this->Auth->user('id');
			$this->Ordering->save($Ordering);
			$this->redirect(array('action'=>'view', $id));
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Ordering', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data['Ordering']['id'])) {
			$this->data['Ordering']['total'] = ($this->data['Ordering']['dateil_total'] + $this->data['Ordering']['total_tax']) + $this->data['Ordering']['adjustment'];
			if ($this->Ordering->save($this->data)) {
				$this->Session->setFlash(__('The Ordering has been saved', true));
				$this->redirect(array('action'=>'view', $id));
			} else {
				$this->Session->setFlash(__('The Ordering could not be saved. Please, try again.', true));
			}
		}

		$this->data = $this->Ordering->read(null, $id);

		$ordering_status = get_ordering_status();
		$factories = $this->Ordering->Factory->find('list');
		$this->set(compact('factories', 'ordering_status'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Ordering', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Ordering->del($id)) {
			$this->Session->setFlash(__('Ordering deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>