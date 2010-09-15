<?php
class CompaniesController extends AppController {

	var $name = 'Companies';
	var $uses = array('Company', 'Brand', 'Billing', 'Destination');

	function index() {
		$this->Company->recursive = 0;

	if (!empty($this->data['Company']['word'])) {
			$seach_word = $this->data['Company']['word'];
			$conditions['or'] = array(
				'Company.name LIKE'=>'%'.$seach_word.'%',
				'Company.address_one LIKE'=>'%'.$seach_word.'%',
				'Company.tel LIKE'=>'%'.$seach_word.'%'
			);
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>20,
				'order'=>array('Company.updated'=>'desc')
			);
		}else{
			if($this->data['Company']['trade_type'] == '1'){
				$conditions = array();
			}else{
				$conditions['or'] = array(
					'Company.trade_type <>'=>'3',
					'Company.trade_type'=>NULL,
				);
			}
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>20,
				'order'=>array('Company.updated'=>'desc')
			);
		}
		$index_view = $this->paginate();
		$trade_type = get_trade_type();
		$index_out = array();
		foreach($index_view as $index){
			if(!empty($index['Company']['trade_type'])){
				$index['Company']['trade_type'] = $trade_type[$index['Company']['trade_type']];
			}
			$index_out[] = $index;
		}
		$this->set('companies', $index_out);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Company.', true));
			$this->redirect(array('action'=>'index'));
		}
		$view = $this->Company->read(null, $id);
		$district = get_district();
		$trade_type = get_trade_type();
		$rate_fraction = get_tax_fraction();
		$tax_method = get_tax_method();
		$tax_fraction = get_tax_fraction();
		if(!empty($view['Company']['trade_type']))$view['Company']['trade_type'] = $trade_type[$view['Company']['trade_type']];
		if(!empty($view['Company']['tax_fraction']))$view['Company']['tax_fraction'] = $tax_fraction[$view['Company']['tax_fraction']];
		if(!empty($view['Company']['rate_fraction']))$view['Company']['rate_fraction'] = $rate_fraction[$view['Company']['rate_fraction']];
		if(!empty($view['Company']['tax_method']))$view['Company']['tax_method'] = $tax_method[$view['Company']['tax_method']];
		if(!empty($view['Company']['district']))$view['Company']['district'] = $district[$view['Company']['district']];
		$this->set('company', $view);
		$this->set('brand', $this->Brand->find('list'));
		$cancel_flag = get_cancel_flag();
		$this->set(compact('cancel_flag'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Company->create();
			if ($this->Company->save($this->data)) {
				$this->Session->setFlash(__('The Company has been saved', true));
				$id = $this->Company->getInsertID();
				$this->redirect(array('action'=>'view/'.$id));
			} else {
				$this->Session->setFlash(__('The Company could not be saved. Please, try again.', true));
			}
		}
		$district = get_district();
		$trade_type = get_trade_type();
		$rate_fraction = get_tax_fraction();
		$tax_method = get_tax_method();
		$tax_fraction = get_tax_fraction();

		$groupings = $this->Company->Grouping->find('list');
		//$users = $this->Company->User->find('list');
		$this->set(compact('groupings', 'users', 'district', 'trade_type', 'rate_fraction', 'tax_method', 'tax_fraction'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Company', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Company->save($this->data)) {
				$this->Session->setFlash(__('The Company has been saved', true));
				$this->redirect(array('action'=>'view/'.$id));
			} else {
				$this->Session->setFlash(__('The Company could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Company->read(null, $id);
		}
		$district = get_district();
		$trade_type = get_trade_type();
		$rate_fraction = get_tax_fraction();
		$tax_method = get_tax_method();
		$tax_fraction = get_tax_fraction();
		$groupings = $this->Company->Grouping->find('list');
		//$users = $this->Company->User->find('list');
		$this->set(compact('groupings', 'users', 'district', 'trade_type', 'rate_fraction', 'tax_method', 'tax_fraction'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Company', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Company->del($id)) {
			$this->Session->setFlash(__('Company deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function csv_update(){
		if (!empty($this->data)) {
			$file_name = date('Ymd-His').'company.csv';
			rename($this->data['Company']['upload_file']['tmp_name'], WWW_ROOT.DS.'files/temp/'.$file_name);
			//$file_stream = file_get_contents(WWW_ROOT.DS.'files/temp/'.$file_name);
			//$file_stream = mb_convert_encoding($file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
			//$rename_opne = fopen(WWW_ROOT.DS.'files/temp/en'.$file_name, 'w');
			//$result = fwrite($rename_opne, $file_stream);
			//fclose($rename_opne);
			$file_open = fopen(WWW_ROOT.DS.'files/temp/'.$file_name, 'r');
			$csv_header = fgetcsv($file_open);

			$temp_tokcd = '';
			while($row = fgetcsv($file_open)){
				$name = mb_convert_kana($row[2], 'K', 'UTF-8');
				$address_one = mb_convert_kana($row[7], 'K', 'UTF-8');
				$address_two = mb_convert_kana($row[8], 'K', 'UTF-8');
				$post_code = trim($row[6]);
				if($temp_tokcd == $row[0]){//TOKCDが同じだったとき、子とみなして出荷先に登録

					$save_destination = array('Destination'=>array(
						'name'=>$name,
						'post_code'=>$post_code,
						'address_one'=>$address_one,
						'address_two'=>$address_two,
						'tel'=>$row[9],
						'fax'=>$row[10],
						'company_id'=>$company_id,
						'old_system_no'=>$row[0].'-'.$row[1],
					));
					$this->Destination->save($save_destination);
					$destination_id = $this->Destination->getInsertID();
					$this->Destination->id = null;

				}else{//TOKCD違うとき、請求先、取引先、出荷先、全て登録
					$temp_tokcd = $row[0];

					$save_billing = array('Billing'=>array(
						'name'=>$name,
						'post_code'=>$post_code,
						'address_one'=>$address_one,
						'address_two'=>$address_two,
						'tel'=>$row[9],
						'fax'=>$row[10],
					));
					$this->Billing->save($save_billing);
					$billing_id = $this->Billing->getInsertID();
					$this->Billing->id = null;

					$save_company = array('Company'=>array(
						'name'=>$name,
						'post_code'=>$post_code,
						'address_one'=>$address_one,
						'address_two'=>$address_two,
						'tel'=>$row[9],
						'fax'=>$row[10],
						'billing_id'=>$billing_id,
					));
					$this->Company->save($save_company);
					$company_id = $this->Company->getInsertID();
					$this->Company->id = null;

					$save_destination = array('Destination'=>array(
						'name'=>$name,
						'post_code'=>$post_code,
						'address_one'=>$address_one,
						'address_two'=>$address_two,
						'tel'=>$row[9],
						'fax'=>$row[10],
						'company_id'=>$company_id,
						'old_system_no'=>$row[0].'-'.$row[1],
					));
					$this->Destination->save($save_destination);
					$destination_id = $this->Destination->getInsertID();
					$this->Destination->id = null;

				}
			}
			$this->Session->setFlash(__('CSV UPDATEが終了しました。', true));
		}
	}

}
?>