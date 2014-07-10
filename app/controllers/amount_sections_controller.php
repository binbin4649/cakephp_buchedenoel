<?php
class AmountSectionsController extends AppController {

	var $name = 'AmountSections';
	var $helpers = array('Html', 'Form', 'Javascript', 'Cache');
	var $uses = array('AmountSection', 'Section');
	var $cacheAction = array('ranking'=>'7200');//キャッシュ2時間
	var $components = array('Cleaning', 'DateCal');

	function index() {
		$modelName = 'AmountSection';
		$subModel = 'Section';
		$sub_id = 'section_id';
		if (!empty($this->data)) {
			$conditions = array();
			if(!empty($this->data[$modelName][$sub_id])){
				$conditions[] = array('and'=>array($modelName.'.'.$sub_id=>$this->data[$modelName][$sub_id]));
			}
			if(!empty($this->data[$modelName]['amount_type'])){
				$conditions[] = array('and'=>array($modelName.'.amount_type'=>$this->data[$modelName]['amount_type']));
			}
			if(!empty($this->data[$modelName]['start_day']['year']) and !empty($this->data[$modelName]['start_day']['month']) and !empty($this->data[$modelName]['start_day']['day'])){
				$start_date = $this->data[$modelName]['start_day']['year'].'-'.$this->data[$modelName]['start_day']['month'].'-'.$this->data[$modelName]['start_day']['day'];
				$conditions[] = array('and'=>array($modelName.'.start_day'=>$start_date));
			}
			if(!empty($this->data[$modelName]['end_day']['year']) and !empty($this->data[$modelName]['end_day']['month']) and !empty($this->data[$modelName]['end_day']['day'])){
				$end_date = $this->data[$modelName]['end_day']['year'].'-'.$this->data[$modelName]['end_day']['month'].'-'.$this->data[$modelName]['end_day']['day'];
				$conditions[] = array('and'=>array($modelName.'.end_day'=>$end_date));
			}
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>100,
				'order'=>array($modelName.'.created'=>'desc')
			);
		}else{
			$this->paginate = array(
				'conditions'=>array(),
				'limit'=>100,
				'order'=>array($modelName.'.created'=>'desc')
			);
		}
		$this->AmountSection->recursive = 0;
		$this->set('amountSections', $this->paginate());
		$sections = $this->AmountSection->Section->find('list');
		$this->set(compact('sections'));
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AmountSection.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('amountSection', $this->AmountSection->read(null, $id));
	}

	function add() {
		$sections = $this->AmountSection->Section->find('list');
		$this->set(compact('sections'));
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!empty($this->data)) {
			$this->AmountSection->create();
			$modelName = 'AmountSection';
			$subModel = 'Section';
			$sub_id = 'section_id';
			$value_name = mb_substr($sections[$this->data[$modelName][$sub_id]], 0, 10).':'.$this->data[$modelName][$sub_id];
			$name = $value_name.'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountSection->save($this->data)) {
				$this->Session->setFlash(__('The AmountSection has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountSection could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$sections = $this->AmountSection->Section->find('list');
		$this->set(compact('sections'));
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid AmountSection', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$modelName = 'AmountSection';
			$subModel = 'Section';
			$sub_id = 'section_id';
			$value_name = mb_substr($sections[$this->data[$modelName][$sub_id]], 0, 10).':'.$this->data[$modelName][$sub_id];
			$name = $value_name.'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountSection->save($this->data)) {
				$this->Session->setFlash(__('The AmountSection has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountSection could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AmountSection->read(null, $id);
		}
	}

	//目標、予算を入力管理する
	//1、ショップスタッフで、かつ、その月のデータがあればもってくる
	//2、未完
	function edit_mark($section_id = null, $month = null){
	$login_user = $this->Auth->user();
		if (empty($this->data)) {
			$sections = $this->AmountSection->Section->find('list');
			foreach($sections as $section_id=>$section_name){
				$sections[$section_id] = $this->Cleaning->sectionName($section_name);
			}
			$this->set(compact('sections'));
		}
	}
	
	function mark_edit($id = null){
		$this->mark($id);
	}
	
	//部門一覧を出す　→　年月選択画面　→　日付ごとの一覧虫食い画面
	// sections/index  →  amount_sections/index_mark  →  amount_sections/days_mark	
	//目標一覧画面
	function mark($id = null, $year = null, $month = null){
		if($id == null){
			$this->redirect(array('controller'=>'sections', 'action'=>'index'));
		}
		$params = array(
			'conditions'=>array('Section.id'=>$id),
			'recursive'=>0,
			'fields'=>'Section.name'
		);
		$section = $this->Section->find('first', $params);
		
		if(!empty($this->data['AmountSections']['mark'])){
			foreach($this->data['AmountSections']['mark'] as $value){
				$this->AmountSection->saveMark($value);
			}
			$this->redirect(array('controller'=>'amount_sections', 'action'=>'mark/'.$id.'/'.$value['year'].'/'.$value['month']));
		}
		if(!empty($year) and !empty($month)){
			$this->data['AmountSections']['year'] = $year;
			$this->data['AmountSections']['month'] = $month;
		}
		if(!empty($this->data['AmountSections']['year'])){
			$year = $this->data['AmountSections']['year'];
			$month = $this->data['AmountSections']['month'];
		}else{
			$this->data['AmountSections']['year']  = date('Y');
			$this->data['AmountSections']['month']  = date('m');
			$year = date('Y');
			$month = date('m');
		}
		$total = $this->AmountSection->markIndex($id, $year, $month);
		$days = $total['days'];
		$yearList = get_year_list();
		$monthList = get_month_list();
		$this->set(compact('days', 'total', 'yearList', 'monthList', 'section'));
	}

	function outputdata(){
		$path = WWW_ROOT.'/files/store_sales/';
		$old_file = array();
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			if($file != '.' and $file != '..'){
				$old_file[] = $file;
			}
		}
		closedir($handle);
		rsort($old_file);
		$pop_count = 0;//後ろから省く数
		$pop_count = floor(count($old_file) / 2);//総数の半分を省く
		for($i = 0; $i < $pop_count; $i++){
			$stash = array_pop($old_file);
		}
		$this->set('old_file', $old_file);
	}

	function pentaho(){
		$path = WWW_ROOT.'/files/pentaho/';
		$old_file = array();
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			if($file != '.' and $file != '..'){
				$old_file[] = $file;
			}
		}
		closedir($handle);
		rsort($old_file);
		$this->set('old_file', $old_file);
	}
	
	//ランキング
	function ranking($id = 1, $key = 3){
		$this->set('ranking_store', $this->AmountSection->ranking_today($id, $key));
	}
	
	//今日の速報
	function todayindex(){
		$this->set('today', $this->AmountSection->today_index());
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AmountSection', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AmountSection->del($id)) {
			$this->Session->setFlash(__('AmountSection deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>