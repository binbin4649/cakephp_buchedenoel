<?php
class TransportDateilsController extends AppController {

	var $name = 'TransportDateils';
	var $uses = array('TransportDateil', 'Subitem', 'Depot', 'Stock', 'Section', 'Transport');

	function index() {
		$this->TransportDateil->recursive = 0;
		$this->set('transportDateils', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TransportDateil.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('transportDateil', $this->TransportDateil->read(null, $id));
	}

	function add($ac = null , $id = null) {
		if($ac == 'indepot'){
			if($this->Session->check('TransportDateil')){
				$session_reader = $this->Session->read('TransportDateil');
				$outdepot = $this->Session->read('outdepot');
				//倉庫から在庫を抜く処理
				$Transport['Transport']['in_depot'] = $id;
				$Transport['Transport']['out_depot'] = $outdepot;
				$Transport['Transport']['transport_status'] = 2;
				$Transport['Transport']['created_user'] = $this->Auth->user('id');
				$this->Transport->save($Transport);
				$transport_id = $this->Transport->getInsertID();
				foreach($session_reader as $key=>$session_read){
					$result = $this->Stock->Mimus($key, $session_read['out_depot'], $session_read['quantity'], $this->Auth->user('id'), 2);
					if($result){
						$TransportDateil['TransportDateil']['transport_id'] = $transport_id;
						$TransportDateil['TransportDateil']['subitem_id'] = $key;
						$TransportDateil['TransportDateil']['out_qty'] = $session_read['quantity'];
						$TransportDateil['TransportDateil']['pairing_quantity'] = $session_read['quantity'];
						$TransportDateil['TransportDateil']['out_depot'] = $session_read['out_depot'];
						$TransportDateil['TransportDateil']['created_user'] = $this->Auth->user('id');
						$this->TransportDateil->save($TransportDateil);
						$this->TransportDateil->id = null;
					}else{
						$this->Transport->del($transport_id);
						$this->Session->setFlash('在庫が不足しています。誰かが先に出庫、売上などを行った可能性があります。');
						$this->Session->delete("TransportDateil");
						$this->Session->delete("outdepot");
						$this->redirect(array('action'=>'add'));
					}
				}
				$this->Session->delete("TransportDateil");
				$this->Session->delete("outdepot");
				$this->redirect(array('controller'=>'transports', 'action'=>'view/'.$transport_id));
			}else{
				$this->Session->setFlash('移動する商品を先に入力してください。');
			}
		}

		$session_reader = array();
		if($ac == 'reset'){
			$this->Session->delete("TransportDateil");
			$this->Session->delete("outdepot");
		}
		if($ac == 'del'){
			$this->Session->delete("TransportDateil.".$id);
		}

		if(!empty($this->params['data']['TransportDateil']['Qty'])){ //途中追加、数量変更
			$session_reader = $this->Session->read('TransportDateil');
			$outdepot = $this->Session->read('outdepot');
			foreach($this->params['data']['TransportDateil']['Qty'] as $qty_key=>$qty_value){
				$qty_value = mb_convert_kana($qty_value, 'a', 'UTF-8');
				$qty_value = ereg_replace("[^0-9]", "", $qty_value);//半角数字以外を削除
				$qty_check = false;
				if($qty_value >= 1){
					$qty_check = true;
					if(!$this->Stock->stockConfirm($qty_key, $outdepot, $qty_value)) $qty_check = false; //在庫が無いのか、0を入力したのか、分からないので、エラーなし
				}else{
					$this->Session->delete("TransportDateil.".$qty_key);
					unset($session_reader[$qty_key]);
				}
				if($qty_check) $session_reader[$qty_key]['quantity'] = $qty_value;
			}
			$this->Session->write("TransportDateil", $session_reader);
		}

		if(!empty($this->params['form']['input1'])){
			$params = array(
				'conditions'=>array('Subitem.jan'=>$this->params['form']['input1']),
				'recursive'=>0
			);
			$subitem = $this->Subitem->find('first' ,$params);
			if($subitem){
				$params = array(
					'conditions'=>array('and'=>array(
						'Stock.depot_id'=>$this->data['TransportDateil']['depot'],
						'Stock.subitem_id'=>$subitem['Subitem']['id']
					)),
					'recursive'=>0
				);
				$stock = $this->Stock->find('first' ,$params);
				if($this->Session->check('TransportDateil')){
					$session_reader = $this->Session->read('TransportDateil');
					if(!empty($session_reader[$subitem['Subitem']['id']])){
						$reder_quantity = $session_reader[$subitem['Subitem']['id']]['quantity'];
					}else{
						$reder_quantity = 0;
					}
				}else{
					$reder_quantity = 0;
				}
				if($stock['Stock']['quantity'] > 0 and $reder_quantity < $stock['Stock']['quantity']){
					$newitem_flag = true;
					foreach($session_reader as $key=>$session_read){
						if($key == $subitem['Subitem']['id']){
							$session_reader[$key]['quantity'] = $session_reader[$key]['quantity'] + 1;
							$newitem_flag = false;
							$this->Session->setFlash($session_reader[$key]['subitem_name'].'　合計：'.$session_reader[$key]['quantity'].'　になりました。');
						}
					}
					if($newitem_flag){
						$session_reader[$subitem['Subitem']['id']]['subitem_name'] = $subitem['Subitem']['name'];
						$session_reader[$subitem['Subitem']['id']]['view_quantity'] = $stock['Stock']['quantity'];
						$session_reader[$subitem['Subitem']['id']]['stock_id'] = $stock['Stock']['id'];
						$session_reader[$subitem['Subitem']['id']]['quantity'] = 1;
						$session_reader[$subitem['Subitem']['id']]['subitem_jan'] = $subitem['Subitem']['jan'];
						$session_reader[$subitem['Subitem']['id']]['item_price'] = $subitem['Item']['price'];
						$session_reader[$subitem['Subitem']['id']]['subitem_id'] = $subitem['Subitem']['id'];
						$session_reader[$subitem['Subitem']['id']]['out_depot'] = $this->data['TransportDateil']['depot'];
						$out_depot = $this->data['TransportDateil']['depot'];
						$this->Session->write("outdepot", $out_depot);
					}
					$this->Session->write("TransportDateil", $session_reader);
				}else{
					$this->Session->setFlash('入力された商品の在庫が無い、または倉庫が指定されていません。');
				}
			}
		}

		if(!empty($session_reader)){
			$this->set('TransportDateil',$session_reader);
		}elseif($this->Session->check('TransportDateil')){
			$session_reader = $this->Session->read('TransportDateil');
			$this->set('TransportDateil',$session_reader);
		}

		if(!empty($this->data['TransportDateil']['depot'])){
			$section['Section']['out_depot'] = $this->data['TransportDateil']['depot'];
		}else{
			if($this->Session->read('outdepot')){
				$section['Section']['out_depot'] = $this->Session->read('outdepot');
			}else{
				$params = array(
					'conditions'=>array('Section.id'=>$this->Auth->user('section_id')),
					'recursive'=>0
				);
				$section = $this->Section->find('first' ,$params);
			}
		}
		if($this->Auth->user('access_authority') != 2){
			$section_depots = $this->Depot->find('list');
		}else{
			$params = array(
				'conditions'=>array('Depot.section_id'=>$this->Auth->user('section_id')),
				'recursive'=>0
			);
			$section_depots = $this->Depot->find('list' ,$params);
		}
		$this->set(compact('section','section_depots'));

		if(!empty($this->data['Depot']['word'])){
			$seach_word = $this->data['Depot']['word'];
			$conditions['or'] = array(
				'Depot.name LIKE'=>'%'.$seach_word.'%',
				'Section.name LIKE'=>'%'.$seach_word.'%',
				'Depot.id'=>$seach_word
			);
			$conditions['and'] = array(
				'Depot.id <>'=>$this->data['TransportDateil']['depot']
			);
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>20
			);
			$this->Depot->recursive = 0;
			$this->set('depots', $this->paginate('Depot'));
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TransportDateil', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TransportDateil->save($this->data)) {
				$this->Session->setFlash(__('The TransportDateil has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TransportDateil could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TransportDateil->read(null, $id);
		}
		$transports = $this->TransportDateil->Transport->find('list');
		$subitems = $this->TransportDateil->Subitem->find('list');
		$this->set(compact('transports','subitems'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TransportDateil', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TransportDateil->del($id)) {
			$this->Session->setFlash(__('TransportDateil deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function reserve($ac = null , $id = null) {
		if($ac == 'indepot'){
			if($this->Session->check('TransportDateil')){
				$session_reader = $this->Session->read('TransportDateil');
				$outdepot = 910;
				//倉庫から在庫を抜く処理
				$Transport['Transport']['out_depot'] = $outdepot;
				$Transport['Transport']['transport_status'] = 2;
				$Transport['Transport']['layaway_type'] = 1;
				$Transport['Transport']['created_user'] = $this->Auth->user('id');
				$this->Transport->save($Transport);
				$transport_id = $this->Transport->getInsertID();
				foreach($session_reader as $key=>$session_read){
					$result = $this->Stock->Mimus($key, $outdepot, $session_read['quantity'], $this->Auth->user('id'), 4);
					if(EMERGENCY_LANDING) $result = true;
					if($result){
						$TransportDateil['TransportDateil']['transport_id'] = $transport_id;
						$TransportDateil['TransportDateil']['subitem_id'] = $key;
						$TransportDateil['TransportDateil']['out_qty'] = $session_read['quantity'];
						$TransportDateil['TransportDateil']['pairing_quantity'] = $session_read['quantity'];
						$TransportDateil['TransportDateil']['out_depot'] = $outdepot;
						$TransportDateil['TransportDateil']['created_user'] = $this->Auth->user('id');
						$this->TransportDateil->save($TransportDateil);
						$this->TransportDateil->id = null;
					}else{
						$this->Transport->del($transport_id);
						$this->Session->setFlash('在庫が不足しています。誰かが先に出庫、売上などを行った可能性があります。');
						$this->Session->delete("TransportDateil");
						$this->Session->delete("outdepot");
						$this->redirect(array('action'=>'add'));
					}
				}
				$this->Session->delete("TransportDateil");
				$this->Session->delete("outdepot");
				$this->Session->setFlash('【取置完了】取置番号：'.$transport_id.'<br><br>※取置番号を伝えたら、必ずResetボタンを押してください。');
			}else{
				$this->Session->setFlash('移動する商品を先に入力してください。');
			}
		}

		$session_reader = array();
		if($ac == 'reset'){
			$this->Session->delete("TransportDateil");
		}
		if($ac == 'del'){
			$this->Session->delete("TransportDateil.".$id);
		}
		if(!empty($this->params['form']['input1'])){
			$params = array(
				'conditions'=>array('Subitem.jan'=>$this->params['form']['input1']),
				'recursive'=>0
			);
			$subitem = $this->Subitem->find('first' ,$params);
			if($subitem){
				$params = array(
					'conditions'=>array('and'=>array(
						'Stock.depot_id'=>910,
						'Stock.subitem_id'=>$subitem['Subitem']['id']
					)),
					'recursive'=>0
				);
				$stock = $this->Stock->find('first' ,$params);
				if($this->Session->check('TransportDateil')){
					$session_reader = $this->Session->read('TransportDateil');
					if(!empty($session_reader[$subitem['Subitem']['id']])){
						$reder_quantity = $session_reader[$subitem['Subitem']['id']]['quantity'];
					}else{
						$reder_quantity = 0;
					}
				}else{
					$reder_quantity = 0;
				}
				if(EMERGENCY_LANDING) $stock['Stock']['quantity'] = 9999;
				if($stock['Stock']['quantity'] > 0 and $reder_quantity < $stock['Stock']['quantity']){
					$newitem_flag = true;
					foreach($session_reader as $key=>$session_read){
						if($key == $subitem['Subitem']['id']){
							$session_reader[$key]['quantity'] = $session_reader[$key]['quantity'] + 1;
							$newitem_flag = false;
						}
					}
					if($newitem_flag){
						$session_reader[$subitem['Subitem']['id']]['subitem_name'] = $subitem['Subitem']['name'];
						$session_reader[$subitem['Subitem']['id']]['view_quantity'] = $stock['Stock']['quantity'];
						$session_reader[$subitem['Subitem']['id']]['stock_id'] = $stock['Stock']['id'];
						$session_reader[$subitem['Subitem']['id']]['quantity'] = 1;
						$session_reader[$subitem['Subitem']['id']]['subitem_jan'] = $subitem['Subitem']['jan'];
					}
					$this->Session->write("TransportDateil", $session_reader);
				}else{
					$this->Session->setFlash('入力された商品の在庫が無いようです。');
				}
			}
		}

		if(!empty($session_reader)){
			$this->set('TransportDateil',$session_reader);
		}elseif($this->Session->check('TransportDateil')){
			$session_reader = $this->Session->read('TransportDateil');
			$this->set('TransportDateil',$session_reader);
		}

	}

}
?>