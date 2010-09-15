<?php
class BrandRatesController extends AppController {

	var $name = 'BrandRates';
	var $uses = array('BrandRate', 'Company');

	function index() {
		$this->BrandRate->recursive = 0;
		$index_out = array();
		$brands = $this->BrandRate->Brand->find('list');
		$companies = $this->BrandRate->Company->find('list');
		$cancel_flag = get_cancel_flag();
		$index_view = $this->paginate();
		foreach($index_view as $index){
			if(!empty($index['BrandRate']['company_id'])){
				$index['BrandRate']['company_name'] = $companies[$index['BrandRate']['company_id']];
			}
			if(!empty($index['BrandRate']['brand_id'])){
				$index['BrandRate']['brand_name'] = $brands[$index['BrandRate']['brand_id']];
			}
			if(!empty($index['BrandRate']['cancel_flag'])){
				$index['BrandRate']['cancel_flag'] = $cancel_flag[$index['BrandRate']['cancel_flag']];
			}
			$index_out[] = $index;
		}
		$this->set('brandRates', $index_out);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid BrandRate.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('brandRate', $this->BrandRate->read(null, $id));
	}

	function add($company_id = null) {
		if (!empty($this->data)) {
			$this->BrandRate->create();
			if ($this->BrandRate->save($this->data)) {
				$this->Session->setFlash(__('The BrandRate has been saved', true));
				//$id = $this->BrandRate->getInsertID();
				$this->redirect(array('controller'=>'companies', 'action'=>'view/'.$this->data['BrandRate']['company_id']));
			} else {
				$this->Session->setFlash(__('The BrandRate could not be saved. Please, try again.', true));
			}
		}
		if(!empty($company_id)){
			$params = array(
				'conditions'=>array('Company.id'=>$company_id),
				'recursive'=>0,
				'fields'=>array('Company.name')
			);
			$company = $this->Company->find('first' ,$params);
			$this->set('company', $company);
		}

		$cancel_flag = get_cancel_flag();
		$brands = $this->BrandRate->Brand->find('list');
		$this->set(compact('brands', 'cancel_flag'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid BrandRate', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->BrandRate->save($this->data)) {
				$this->Session->setFlash(__('The BrandRate has been saved', true));
				$this->redirect(array('controller'=>'companies', 'action'=>'view/'.$this->data['BrandRate']['company_id']));
			} else {
				$this->Session->setFlash(__('The BrandRate could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->BrandRate->read(null, $id);
		}
		$cancel_flag = get_cancel_flag();
		$brands = $this->BrandRate->Brand->find('list');
		$this->set(compact('brands', 'cancel_flag'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for BrandRate', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BrandRate->del($id)) {
			$this->Session->setFlash(__('BrandRate deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>