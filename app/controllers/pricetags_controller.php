<?php
class PricetagsController extends AppController {

	var $name = 'Pricetags';
	//var $helpers = array('AddForm');
	var $uses = array('Pricetag', 'Item', 'PricetagDetail', 'Subitem', 'Factory');
	var $components = array('OutputCsv');

	function index() {
		if (!empty($this->data['Pricetag']['word']) or !empty($this->data['Pricetag']['status'])) {
			$seach_word = $this->data['Pricetag']['word'];
			$seach_status = $this->data['Pricetag']['status'];
			$conditions['or'] = array('Pricetag.id'=>$seach_word, 'Pricetag.pricetag_status'=>$seach_status);
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>60,
				'order'=>array('Pricetag.created'=>'desc')
			);
		}else{
			$this->paginate = array(
				'limit'=>60,
				'order'=>array('Pricetag.created'=>'desc')
			);
		}
		$this->Pricetag->recursive = 0;
		$this->set('pricetags', $this->paginate());
		$pricetag_status = get_pricetag_status();
		$this->set('status', $pricetag_status);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Pricetag.', true));
			$this->redirect(array('action'=>'view/'.$id));
		}
		$status = get_pricetag_status();
		$this->set('status', $status);
		$params = array(
			'conditions'=>array('Pricetag.id'=>$id),
			'recursive'=>2,
		);
		$Pricetag = $this->Pricetag->find('first' ,$params);
		$this->set('pricetag', $Pricetag);
		if(!empty($Pricetag['Pricetag']['csv_data'])){
			$file_names = explode(',', $Pricetag['Pricetag']['csv_data']);
			//$print_out['url'] = '/buchedenoel/files/pricetag/'.$Pricetag['Pricetag']['csv_data'];
			//$print_out['file'] = $Pricetag['Pricetag']['csv_data'];
			$this->set('prints', $file_names);
		}
	}

	function del($id = null) {
		$params = array(
			'conditions'=>array('PricetagDetail.id'=>$id),
			'recursive'=>0,
		);
		$PricetagDetail = $this->PricetagDetail->find('first' ,$params);
		if ($this->PricetagDetail->del($id)) {
			$this->Session->setFlash(__('PricetagDetail deleted', true));
			$this->redirect(array('action'=>'view/'.$PricetagDetail['PricetagDetail']['pricetag_id']));
		}
	}

	function cancel($id = null){
		$Pricetag['Pricetag']['id'] = $id;
		$Pricetag['Pricetag']['pricetag_status'] = 4;
		$Pricetag['Pricetag']['updated_user'] = $this->Auth->user('id');
		$this->Pricetag->save($Pricetag);
		$this->redirect(array('action'=>'view', $id));
	}

	function comp($id = null){
		$Pricetag['Pricetag']['id'] = $id;
		$Pricetag['Pricetag']['pricetag_status'] = 3;
		$Pricetag['Pricetag']['updated_user'] = $this->Auth->user('id');
		$this->Pricetag->save($Pricetag);
		$this->redirect(array('action'=>'view', $id));
	}

	function csv($id = null){
		$params = array(
			'conditions'=>array('Pricetag.id'=>$id),
			'recursive'=>2,
		);
		$total_qty = 0;
		$brands = array();
		$this->Pricetag->contain('PricetagDetail.Subitem');
		$Pricetag = $this->Pricetag->find('first' ,$params);
		foreach($Pricetag['PricetagDetail'] as $detail){
			$total_qty = $total_qty + $detail['quantity'];
		}
		$output_csv = $this->OutputCsv->priceTag($Pricetag);
		$file_names = array();
		foreach($output_csv as $brand_id=>$output){
			$file_name = $brand_id.'-'.$Pricetag['Pricetag']['section_id'].'-'.$id.'-'.date('YmdHis').'.csv';
			$path = WWW_ROOT.'/files/pricetagcsv/';
			$output = mb_convert_encoding($output, 'SJIS', 'UTF-8');
			file_put_contents($path.$file_name, $output);
			$file_names[] = $file_name;
		}
		$save_name = implode(',', $file_names);
		/*
		$file_name = 'tag-'.$Pricetag['Pricetag']['section_id'].'-'.$id.'-'.date('Ymd-His').'.csv';
		$path = WWW_ROOT.'/files/pricetag/';
		$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
		file_put_contents($path.$file_name, $output_csv);
		*/
		
		$Pricetag['Pricetag']['id'] = $id;
		$Pricetag['Pricetag']['pricetag_status'] = 2;
		$Pricetag['Pricetag']['total_quantity'] = $total_qty;
		$Pricetag['Pricetag']['updated_user'] = $this->Auth->user('id');
		$Pricetag['Pricetag']['csv_data'] = $save_name;
		$this->Pricetag->save($Pricetag);
		$this->redirect(array('action'=>'view', $id));
	}

}
?>