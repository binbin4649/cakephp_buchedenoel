<?php
class TransportsController extends AppController {

	var $name = 'Transports';
	var $uses = array('Transport', 'TransportDateil', 'Subitem', 'Depot', 'Stock', 'Section');
	var $components = array('Print', 'OutputCsv');

	function index() {
		$modelName = 'Transport';
		$statusName = 'transport_status';
		if (!empty($this->data[$modelName])) {
			$conditions = array();
			if(!empty($this->data[$modelName]['word'])){
				$this->data[$modelName]['word'] = mb_convert_kana($this->data[$modelName]['word'], 'a', 'UTF-8');
				$this->data[$modelName]['word'] = ereg_replace("[^0-9]", "", $this->data[$modelName]['word']);//半角数字以外削除
				$conditions[] = array('and'=>array('Transport.id'=>$this->data[$modelName]['word']));
			}
			if(!empty($this->data[$modelName]['status'])){
				$conditions[] = array('and'=>array('Transport.transport_status'=>$this->data[$modelName]['status']));
			}
			if(!empty($this->data[$modelName]['out_depot'])){
				$this->data[$modelName]['out_depot'] = mb_convert_kana($this->data[$modelName]['out_depot'], 'a', 'UTF-8');
				$this->data[$modelName]['out_depot'] = ereg_replace("[^0-9]", "", $this->data[$modelName]['out_depot']);//半角数字以外削除
				$conditions[] = array('and'=>array('Transport.out_depot'=>$this->data[$modelName]['out_depot']));
			}
			if(!empty($this->data[$modelName]['in_depot'])){
				$this->data[$modelName]['in_depot'] = mb_convert_kana($this->data[$modelName]['in_depot'], 'a', 'UTF-8');
				$this->data[$modelName]['in_depot'] = ereg_replace("[^0-9]", "", $this->data[$modelName]['in_depot']);//半角数字以外削除
				$conditions[] = array('and'=>array('Transport.in_depot'=>$this->data[$modelName]['in_depot']));
			}
			if(!empty($this->data[$modelName]['created_user_id'])){
				$this->data[$modelName]['created_user_id'] = mb_convert_kana($this->data[$modelName]['created_user_id'], 'a', 'UTF-8');
				$this->data[$modelName]['created_user_id'] = ereg_replace("[^0-9]", "", $this->data[$modelName]['created_user_id']);//半角数字以外削除
				$conditions[] = array('and'=>array('Transport.created_user'=>$this->data[$modelName]['created_user_id']));
			}
			if(!empty($this->data[$modelName]['start_date']['year']) and !empty($this->data[$modelName]['start_date']['month']) and !empty($this->data[$modelName]['start_date']['day'])){
				$start_date = $this->data[$modelName]['start_date']['year'].'-'.$this->data[$modelName]['start_date']['month'].'-'.$this->data[$modelName]['start_date']['day'].' 00:00:00';
				$conditions[] = array('and'=>array('Transport.created >='=>$start_date));
			}
			if(!empty($this->data[$modelName]['end_date']['year']) and !empty($this->data[$modelName]['end_date']['month']) and !empty($this->data[$modelName]['end_date']['day'])){
				$end_date = $this->data[$modelName]['end_date']['year'].'-'.$this->data[$modelName]['end_date']['month'].'-'.$this->data[$modelName]['end_date']['day'].' 23:59:59';
				$conditions[] = array('and'=>array('Transport.created <='=>$end_date));
			}
			if(!empty($this->data[$modelName]['layaway_only'])){
				$conditions[] = array('and'=>array('Transport.layaway_type <>'=>NULL));
			}
			if(empty($this->data[$modelName]['csv'])) $this->data[$modelName]['csv'] = 0;
			if($this->data[$modelName]['csv'] == 1){
				$params = array(
					'conditions'=>$conditions,
					'limit'=>5000,
					'order'=>array('Transport.id'=>'desc'),
					'recursive'=>1
				);
				$transports = $this->Transport->find('all' ,$params);
				$output_csv = $this->OutputCsv->Transport($transports);
				$file_name = 'Transport_csv'.date('Ymd-His').'.csv';
				$path = WWW_ROOT.'/files/user_csv/';
				$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
				file_put_contents($path.$file_name, $output_csv);
				$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
				$output['name'] = $file_name;
				$this->set('csv', $output);
				$this->data[$modelName]['csv'] = null;
			}
			//取り置きを一括出力
			if(empty($this->data[$modelName]['batch_print'])) $this->data[$modelName]['batch_print'] = 0;
			if($this->data[$modelName]['batch_print'] == 1){
				$params = array(
					'conditions'=>$conditions,
					'limit'=>500,
					'order'=>array('Transport.id'=>'desc'),
					'recursive'=>2
				);
				$transports = $this->Transport->find('all' ,$params);
				$file_name = 'TransportBatchPrint'.date('Ymd-His').'.php';
				$output_xml = $this->Print->TransportBatch($transports, $file_name);
				$path = WWW_ROOT.'/files/user_csv/';
				file_put_contents($path.$file_name, $output_xml);
				$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
				$output['name'] = $file_name;
				$this->set('batch_print', $output);
				$this->data[$modelName]['batch_print'] = null;
			}
			
			
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>60,
				'order'=>array('Transport.id'=>'desc'),
				'recursive'=>0
			);
		}else{
			$this->paginate = array(
				'conditions'=>array(),
				'limit'=>60,
				'order'=>array('Transport.id'=>'desc'),
				'recursive'=>0
			);
		}
		$index_views = $this->paginate();
		foreach($index_views as $key=>$index_view){
			$out_depot = $this->Depot->sectionMarge($index_view['Transport']['out_depot']);
			$index_views[$key]['Transport']['out_depot'] = $out_depot;
			$in_depot = $this->Depot->sectionMarge($index_view['Transport']['in_depot']);
			$index_views[$key]['Transport']['in_depot'] = $in_depot;
		}
		$this->set('transports', $index_views);
		$transport_status = get_transport_status();
		$this->set(compact('transport_status'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Transport.', true));
			$this->redirect(array('action'=>'index'));
		}
		$views = $this->Transport->read(null, $id);
		foreach($views['TransportDateil'] as $key=>$value){
			$params = array(
				'conditions'=>array('Subitem.id'=>$value['subitem_id']),
				'recursive'=>-1
			);
			$subitem = $this->Subitem->find('first' ,$params);
			$views['TransportDateil'][$key]['subitem_name'] = $subitem['Subitem']['name'];
			$views['TransportDateil'][$key]['subitem_jan'] = $subitem['Subitem']['jan'];
		}
		$out_depot = $this->Depot->sectionMarge($views['Transport']['out_depot']);
		$views['Transport']['out_depot_name'] = $out_depot['depot_name'];
		$views['Transport']['out_section_name'] = $out_depot['section_name'];
		$in_depot = $this->Depot->sectionMarge($views['Transport']['in_depot']);
		$views['Transport']['in_depot_name'] = $in_depot['depot_name'];
		$views['Transport']['in_section_name'] = $in_depot['section_name'];
		$views['Transport']['in_section_id'] = $in_depot['section_id'];
		$views['Transport']['layaway_user_name'] = $this->User->userName($views['Transport']['layaway_user']);
		$this->set('transport', $views);
		$transport_status = get_transport_status();
		$layaway_type = get_layaway_type();
		$this->set(compact('transport_status', 'layaway_type'));

		if(!empty($views['Transport']['print_file'])){
			$print_out['url'] = '/buchedenoel/files/transport/'.$views['Transport']['print_file'].'.php';
			$print_out['file'] = $views['Transport']['print_file'].'.pxd';
			$this->set('print', $print_out);
		}
	}

	function file_print($id = null){
		$params = array(
			'conditions'=>array('Transport.id'=>$id),
			'recursive'=>2
		);
		$Transport = $this->Transport->find('first' ,$params);
		$file_name = 'transport'.$id.'-'.date('Ymd-His');
		$path = WWW_ROOT.'/files/transport/';
		$print_xml = $this->Print->transport($Transport, $file_name);
		file_put_contents($path.$file_name.'.php', $print_xml);
		$Transport['Transport']['id'] = $id;
		$Transport['Transport']['updated_user'] = $this->Auth->user('id');
		$Transport['Transport']['print_file'] = $file_name;
		$this->Transport->save($Transport);
		$this->redirect(array('action'=>'view', $id));
	}
	
	function add_edit($id = null){
		$this->add($id);
	}

	function add($id = null) {//実質編集
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Transport', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Transport->save($this->data)) {
				foreach($this->data['TransportDateil'] as $key=>$value){
					//pr($this->data['TransportDateil']);
					$TransportDateil = array();
					$TransportDateil['TransportDateil']['id'] = $key;
					$TransportDateil['TransportDateil']['order_id'] = $value['order_id'];
					$this->TransportDateil->save($TransportDateil);
					$this->TransportDateil->id = null;
				}
				$this->Session->setFlash(__('The Transport has been saved', true));
				$this->redirect(array('action'=>'view/'.$id));
			} else {
				$this->Session->setFlash(__('The Transport could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Transport->read(null, $id);
		}
		foreach($this->data['TransportDateil'] as $key=>$value){
			$params = array(
				'conditions'=>array('Subitem.id'=>$value['subitem_id']),
				'recursive'=>0
			);
			$subitem = $this->Subitem->find('first' ,$params);
			$this->data['TransportDateil'][$key]['subitem_name'] = $subitem['Subitem']['name'];
		}
		$out_depot = $this->Depot->sectionMarge($this->data['Transport']['out_depot']);
		$this->data['Transport']['out_depot'] = $out_depot;
		$in_depot = $this->Depot->sectionMarge($this->data['Transport']['in_depot']);
		$this->data['Transport']['in_depot'] = $in_depot;
		$transport_status = get_transport_status();
		$layaway_type = get_layaway_type();
		$this->set(compact('transport_status', 'layaway_type'));
	}

	function edit($id = null) {//実質入庫
		if (!empty($this->data)) {
			if(!empty($this->data['Transport']['in_depot'])){
				foreach($this->data['TransportDateil'] as $key=>$value){
					if(!empty($value['in_qty'])){
						$params = array(
							'conditions'=>array('TransportDateil.id'=>$key),
							'recursive'=>0
						);
						$TransportDateil = $this->TransportDateil->find('first' ,$params);
						$compari = $TransportDateil['TransportDateil']['pairing_quantity'] - $TransportDateil['TransportDateil']['in_qty'];
						if($value['in_qty'] <= $compari){
							$TransportDateil['TransportDateil']['in_qty'] = $value['in_qty'] + $TransportDateil['TransportDateil']['in_qty'];
							$this->TransportDateil->save($TransportDateil);
							$this->TransportDateil->id = null;
							$this->Stock->Plus($value['subitem_id'], $value['in_depot'], $value['in_qty'], $this->Auth->user('id'), 2);
						}else{
							$this->Session->setFlash(__('入庫数が出庫数を超えている可能性があるので、処理を途中で中断しました。', true));
							$this->redirect(array('action'=>'edit/'.$this->data['Transport']['id']));
						}
					}
				}
			}else{
				$this->Session->setFlash(__('入庫倉庫が入力されていないと思います。', true));
			}
			$transport_jugement = $this->TransportDateil->Finish($this->data['Transport']['id']);
			if($transport_jugement){
				$Transport['Transport'] = $this->data['Transport'];
				$Transport['Transport']['transport_status'] = 3;
				$this->Transport->save($Transport);
				$this->Session->setFlash(__('全ての入庫を確認しましたので状態を「入庫済」に変更しました。', true));
			}
			$this->redirect(array('action'=>'view/'.$this->data['Transport']['id']));

		}
		$this->data = $this->Transport->read(null, $id);
		foreach($this->data['TransportDateil'] as $key=>$value){
			$params = array(
				'conditions'=>array('Subitem.id'=>$value['subitem_id']),
				'recursive'=>0
			);
			$subitem = $this->Subitem->find('first' ,$params);
			$this->data['TransportDateil'][$key]['subitem_name'] = $subitem['Subitem']['name'];
		}
		$out_depot = $this->Depot->sectionMarge($this->data['Transport']['out_depot']);
		$this->data['Transport']['out_depot'] = $out_depot;
		$in_depot = $this->Depot->sectionMarge($this->data['Transport']['in_depot']);
		$this->data['Transport']['in_depot'] = $in_depot;
		$transport_status = get_transport_status();
		$layaway_type = get_layaway_type();
		$this->set(compact('transport_status', 'layaway_type'));
	}

	function cancell($id = null){
		$params = array(
			'conditions'=>array('TransportDateil.transport_id'=>$id),
			'recursive'=>0
		);
		$TransportDateil = $this->TransportDateil->find('all' ,$params);
		foreach($TransportDateil as $Dateil){
			$compari = $Dateil['TransportDateil']['pairing_quantity'] - $Dateil['TransportDateil']['in_qty'];
			if($compari >= 1){
				$subitem_id = $Dateil['TransportDateil']['subitem_id'];
				$depot_id = $Dateil['TransportDateil']['out_depot'];
				$this->Stock->Plus($subitem_id, $depot_id, $compari, $this->Auth->user('id'), 4);
				$transport_dateil['TransportDateil'] = $Dateil['TransportDateil'];
				$transport_dateil['TransportDateil']['out_qty'] = $transport_dateil['TransportDateil']['out_qty'] - $compari;
				$transport_dateil['TransportDateil']['pairing_quantity'] = $transport_dateil['TransportDateil']['pairing_quantity'] - $compari;
				$transport_dateil['TransportDateil']['updated_user'] = $this->Auth->user('id');
				$this->TransportDateil->save($transport_dateil);
				$this->TransportDateil->id = null;
			}
		}
		$Transport['Transport']['id'] = $id;
		$Transport['Transport']['transport_status'] = 4;
		$Transport['Transport']['updated_user'] = $this->Auth->user('id');
		$this->Transport->save($Transport);
		$this->Session->setFlash(__('状態を「取消」に変更しました。', true));
		$this->redirect(array('action'=>'view/'.$id));
	}

	function input_reserve($id = null) {
		if (!empty($this->data)) {
			$params = array(
				'conditions'=>array('Depot.id'=>$this->data['Transport']['in_depot']),
				'recursive'=>0
			);
			if($this->Depot->find('first' ,$params)){
				$Transport['Transport'] = $this->data['Transport'];
				$Transport['Transport']['layaway_type'] = 2;
				$Transport['Transport']['layaway_user'] = $this->Auth->user('id');
				$this->Transport->save($Transport);
				$this->redirect(array('action'=>'view/'.$this->data['Transport']['id']));
			}else{
				$this->Session->setFlash(__('そんな倉庫は無いと思います。', true));
			}
		}
		$this->data = $this->Transport->read(null, $id);
		foreach($this->data['TransportDateil'] as $key=>$value){
			$params = array(
				'conditions'=>array('Subitem.id'=>$value['subitem_id']),
				'recursive'=>0
			);
			$subitem = $this->Subitem->find('first' ,$params);
			$this->data['TransportDateil'][$key]['subitem_name'] = $subitem['Subitem']['name'];
		}

		$out_depot = $this->Depot->sectionMarge($this->data['Transport']['out_depot']);
		$this->data['Transport']['out_depot'] = $out_depot;
		$in_depot = $this->Depot->sectionMarge($this->data['Transport']['in_depot']);
		$this->data['Transport']['in_depot'] = $in_depot;
		$transport_status = get_transport_status();
		$layaway_type = get_layaway_type();
		$this->set(compact('transport_status', 'layaway_type'));
	}


	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Transport', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Transport->del($id)) {
			$this->Session->setFlash(__('Transport deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>