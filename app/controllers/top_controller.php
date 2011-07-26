<?php
class TopController extends AppController {

  var $name = 'Top';
  var $uses = array('MemoData', 'MemoCategory', 'AmountSalesCode', 'AmountSection', 'AmountUser');
  //var $components = array('SalesCsv');

 	function index(){
 		//トップの掲示板表示
		$this->MemoData->recursive = 0;
		$conditions = array('MemoData.top_flag'=>'top');
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>15,
			'order'=>array('MemoData.updated'=>'desc')
		);
		$memo_datas = $this->paginate();
		$memo_datas_ext = array();
		foreach($memo_datas as $memo_data){
			$params = array(
				'conditions'=>array('User.id'=>$memo_data['MemoData']['created_user']),
				'recursive'=>0
			);
			$created_name = $this->User->find('first', $params);
			$memo_data['MemoData']['created_user'] = $created_name['User']['name'];
			$memo_data['MemoData']['created_user_section'] = $this->Section->cleaningName($created_name['User']['section_id']);
			$memo_datas_ext[] = $memo_data;
		}
		$this->set('memoDatas', $memo_datas_ext);
		$memo_categories = $this->MemoData->MemoCategory->find('list');
		$this->set(compact('memo_categories'));

		//トップの売上表示
		//$this->set('sales_code', $this->AmountSalesCode->today());
		//$this->set('sales_code', $this->AmountSalesCode->all_total());
		$section_id = $this->Auth->user('section_id');
		$user_id = $this->Auth->user('id');

		// CacheBehavior
		//モデルキャッシュをコントローラーから使う　cacheMethod('キャッシュ秒数','モデルのメソッド名', array(メソッドに渡すパラメーター))
		//$this->set('section_amount', $this->AmountSection->section_today($section_id)); 元はコレ
		//$amount_data = $this->AmountSection->cacheMethod('1800','section_today', array($section_id)); //30分
		//$this->set('section_amount', $amount_data);
		//$amount_data = $this->AmountUser->cacheMethod('600','user_today', array($user_id));
		//$this->set('user_amount', $amount_data);
		//$amount_data = $this->AmountSalesCode->cacheMethod('86400','all_total', array());//86400 = 24時間
		//$this->set('all_total', $amount_data);
		//$amount_data = $this->AmountSection->cacheMethod('600','ranking_today', array('1'));
		//$this->set('ranking_section', $amount_data);

		//本社専用の掲示板表示
		$this->MemoData->recursive = 0;
		$conditions = array('MemoData.top_flag'=>'only');
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>10,
			'order'=>array('MemoData.updated'=>'desc')
		);
		$memo_datas = $this->paginate();
		$memo_datas_ext = array();
		foreach($memo_datas as $memo_data){
			$params = array(
				'conditions'=>array('User.id'=>$memo_data['MemoData']['created_user']),
				'recursive'=>0
			);
			$created_name = $this->User->find('first', $params);
			$memo_data['MemoData']['created_user'] = $created_name['User']['name'];
			$memo_data['MemoData']['created_user_section'] = $this->Section->cleaningName($created_name['User']['section_id']);
			$memo_datas_ext[] = $memo_data;
		}
		$this->set('onlyDatas', $memo_datas_ext);
 	}



}
?>