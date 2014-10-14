<?php
class PaysController extends AppController {

	var $name = 'Pays';
	var $uses = array('Pay', 'Purchase', 'PurchaseDetail');
	var $components = array('PayClose', 'DateilSeach', 'OutputCsv');

	function index($ac = null, $id = null) {
		//随時締めは、随時締められなければいけないわけだが、そこは手動じゃないと気持ち悪いだとうと思って
		if($ac == 'doing' OR $ac == 'close'){
			$this->PayClose->paysClose($ac, $id);
		}
		$modelName = 'Pay';
		$statusName = 'pay_status';
		if (!empty($this->data[$modelName])) {
			$conditions = array();
			if(!empty($this->data[$modelName]['total_day_start']['year'])){
				$date = $this->DateilSeach->dateSqlArray($this->data[$modelName]['total_day_start']);
				$conditions[] = array('and'=>array($modelName.'.total_day >='=>$date));
			}
			if(!empty($this->data[$modelName]['total_day_end']['year'])){
				$date = $this->DateilSeach->dateSqlArray($this->data[$modelName]['total_day_end']);
				$conditions[] = array('and'=>array($modelName.'.total_day <='=>$date));
			}
			if(!empty($this->data[$modelName]['payment_day_start']['year'])){
				$date = $this->DateilSeach->dateSqlArray($this->data[$modelName]['payment_day_start']);
				$conditions[] = array('and'=>array($modelName.'.payment_day >='=>$date));
			}
			if(!empty($this->data[$modelName]['payment_day_end']['year'])){
				$date = $this->DateilSeach->dateSqlArray($this->data[$modelName]['payment_day_end']);
				$conditions[] = array('and'=>array($modelName.'.payment_day <='=>$date));
			}
			if(!empty($this->data[$modelName]['id']))$conditions[] = array('and'=>array($modelName.'.id'=>$this->data[$modelName]['id']));
			if(!empty($this->data[$modelName]['status']))$conditions[] = array('and'=>array($modelName.'.'.$statusName=>$this->data[$modelName]['status']));

			if($this->data[$modelName]['csv'] == 1){
				$params = array(
					'conditions'=>$conditions,
				);
				$pays = $this->Pay->find('all' ,$params);
				$output_csv = $this->OutputCsv->pays($pays);
				$file_name = 'pay_csv'.date('Ymd-His').'.csv';
				$path = WWW_ROOT.'/files/user_csv/';
				$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
				file_put_contents($path.$file_name, $output_csv);
				$output['url'] = '/'.SITE_DIR.'/files/user_csv/'.$file_name;
				$output['name'] = $file_name;
				$this->set('csv', $output);
				$this->data[$modelName]['csv'] = null;
			}
			$this->Session->write($modelName.".conditions", $conditions);
			$this->Session->write($modelName.".search", $this->data);
		}else{
			$conditions = array();
			if(empty($this->params['named']['page'])) $this->Session->delete($modelName);
		}
		if($this->Session->check($modelName)){
			$conditions = $this->Session->read($modelName.'.conditions');
			$this->data = $this->Session->read($modelName.'.search');
		}
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>60,
			'order'=>array($modelName.'.updated'=>'desc')
		);
		$this->Pay->recursive = 0;
		$index_view = $this->paginate();
		$pay_status = get_pay_status();
		$this->set(compact('pay_status'));
		$index_out = array();
		$i = 0;
		foreach($index_view as $index){
			if(!empty($index['Pay']['adjustment'])){
				$index['Pay']['view_total'] = $index['Pay']['total'] + $index['Pay']['adjustment'];
			}else{
				$index['Pay']['view_total'] = $index['Pay']['total'];
			}
			$index_out[$i] = $index;
			$i++;
		}
		$this->set('pays', $index_out);
		$this->set(compact('pay_status'));
		$this->set('blance_total', $this->Pay->paysBlance());
	}

	function view($id = null, $ac = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Pay.', true));
			$this->redirect(array('action'=>'index'));
		}
		$view_data = $this->Pay->read(null, $id);
		$this->set('pay', $view_data);
		$pay_status = get_pay_status();
		$pay_way_type = get_pay_way_type();
		$this->set(compact('pay_status', 'pay_way_type'));
		if(!empty($view_data['Pay']['adjustment'])){
			$view_total = $view_data['Pay']['total'] + $view_data['Pay']['adjustment'];
			$this->set('view_total', $view_total);
		}
		if($ac == 'csv'){
			$output_csv = $this->OutputCsv->paysView($view_data);
			$file_name = 'pays_'.date('Ymd-His').'.csv';
			$path = WWW_ROOT.'/files/user_csv/';
			$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
			file_put_contents($path.$file_name, $output_csv);
			$output['url'] = '/'.SITE_DIR.'/files/user_csv/'.$file_name;
			$output['name'] = $file_name;
			$this->set('csv', $output);
		}
	}

	function add() {
		if (!empty($this->data)) {
			$this->Pay->create();
			if ($this->Pay->save($this->data)) {
				$this->Session->setFlash(__('The Pay has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Pay could not be saved. Please, try again.', true));
			}
		}
		$factories = $this->Pay->Factory->find('list');
		$this->set(compact('factories'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Pay', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Pay->save($this->data)) {
				$this->Session->setFlash(__('The Pay has been saved', true));
				$this->redirect(array('action'=>'view/'.$this->data['Pay']['id']));
			} else {
				$this->Session->setFlash(__('The Pay could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Pay->read(null, $id);
		}
		$pay_status = get_pay_status();
		$pay_way_type = get_pay_way_type();
		$this->set(compact('pay_status', 'pay_way_type'));
		//$factories = $this->Pay->Factory->find('list');
		//$this->set(compact('factories'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Pay', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Pay->del($id)) {
			$this->Session->setFlash(__('Pay deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>