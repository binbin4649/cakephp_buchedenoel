<?php
class SectionsController extends AppController {

	var $name = 'Sections';
	var $uses = array('Section', 'User', 'Post', 'Employment', 'Depot', 'Sale');
	var $components = array('OutputCsv');

	function index($id = null) {
		$conditions = array();
		if($id != null) $conditions[] = array('and'=>array('Section.sales_code'=> $id));
		$this->Section->recursive = 0;
		$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>100,
				'order'=>array('Section.updated'=>'desc')
			);
		$this->set('sections', $this->paginate());

		if($this->Session->check('Section.ehStore')){
			$this->set('ehStore', $this->Session->read('Section.ehStore'));
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Section', true), array('action'=>'index'));
		}
		/*
		$conditions[] = array('and'=>array('Section.id'=> $id));
		$params = array(
			'conditions'=>$conditions,
		);
		$section = $this->Section->find('first', $params);
		*/
		$section = $this->Section->viewFind($id);
		if(!empty($section['Section']['contact_user'])){
			$params = array('conditions'=>array('User.id'=>$section['Section']['contact_user']));
			$this->set('contact_user', $this->User->find('first', $params));
		}
		$this->set('section', $section);
		$this->set('post', $this->Post->find('list'));
		$this->set('employment', $this->Employment->find('list'));
		$this->set('duty_code', get_duty_code());
		$this->set('sales_code', get_sales_code());
		$this->set('district', get_district());

		$amount_year = array();
		$amount_year[] = MINYEAR;
		$year = MINYEAR;
		while($year < MAXYEAR){
			$year++;
			$amount_year[] = $year;
		}
		$this->set('amount_year', $amount_year);

		//今日の売上金額、前受金額
		//$date = date('Y-m-d');
		//$this->set('today_total', $this->Sale->AggreSaleDaySection($date, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Section->create();
			if ($this->Section->save($this->data)) {
				$id = $this->Section->getInsertID();
				$this->redirect('/sections/view/'.$id);
			} else {
			}
		}
		$sales_code = get_sales_code();
		$tax_method = get_tax_method();
		$tax_fraction = get_tax_fraction();
		$district = get_district();
		$this->set(compact('sales_code', 'tax_method', 'tax_fraction', 'district'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Section', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Section->save($this->data)) {
				$this->redirect('/sections/view/'.$id);
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Section->read(null, $id);
			//pr($this->data['Section']['contact_user']);
			$params = array(
				'conditions'=>array('User.id'=>$this->data['Section']['contact_user']),
			);
			$this->set('contact_user', $this->User->find('first', $params));
		}
		$sales_code = get_sales_code();
		$tax_method = get_tax_method();
		$tax_fraction = get_tax_fraction();
		$district = get_district();
		$this->set(compact('sales_code', 'tax_method', 'tax_fraction', 'district'));
	}


	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Section', true), array('action'=>'index'));
		}
		if ($this->Section->del($id) == false) {
			$this->flash(__('Section deleted', true), array('action'=>'index'));
		}
	}

	//区分けが営業部門（店舗）の佐川e秘伝用のＣＳＶを一括出力
	function eh_store(){
		$params = array(
			'conditions'=>array('Section.sales_code'=>1),
			'recursive'=>0,
		);
		$sections = $this->Section->find('all' ,$params);

		$output_csv = $this->OutputCsv->ehStore($sections);

		$file_name = 'eh_store-'.date('Ymd-His').'.csv';
		$path = WWW_ROOT.'/files/eh_store/';
		$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
		file_put_contents($path.$file_name, $output_csv);
		$output['url'] = '/'.SITE_DIR.'/files/eh_store/'.$file_name;
		$output['name'] = $file_name;
		$this->Session->write("Section.ehStore", $output);
		$this->redirect(array('action'=>'index'));
	}

}
?>