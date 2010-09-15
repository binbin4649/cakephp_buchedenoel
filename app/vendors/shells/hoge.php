<?php
class HogeShell extends Shell {

	//var $uses = array('Sale', 'SalesDateil', 'Subitem', 'OrdersSale', 'Order', 'OrderDateil', 'Stock', 'Depot', 'Item', 'Destination');
	//var $components = array('Selector', 'Print', 'Total',  'StratCsv');

	function startup(){
		

	}
	
	//部門のリストから、一人ずつ、フリーユーザーを作る 9/2まーだまーだ
	//post_id が　15　の奴はフリーユーザー
	function crateFreeUser(){
		App::import('Model', 'Section');
    	$SectionModel = new Section();
    	App::import('Model', 'User');
    	$UserModel = new User();
   		$section_list = $SectionModel->cleaningList();
		foreach($section_list as $section_id=>$section_name){
			$params = array(
				'conditions'=>array('User.section_id'=>$section_id, 'User.post_id'=>'15'),
				'recursive'=>-1,
				'fields'=>'User.id'
			);
			$user = $UserModel->find('first', $params);
			if($user == false){
				$user['name'] = 'フリー　'.$section_name;
				$user['section_id'] = $section_id;
				$user['post_id'] = 15;
				$user['employment_id'] = 7;
				$user['duty_code'] = 10;
				$user['username'] = $section_id.'9999';
				$user['password'] = $section_id.'1122';
				$User['User'] = $user;
				$UserModel->create();
				$UserModel->save($User);
			}
			
		}
		exit("HAPPY END");
	}
	
	//在庫管理しない、の在庫を削除
	function deleteStocks(){
		App::import('Model', 'Item');
    	$ItemModel = new Item();
    	App::import('Model', 'Stock');
    	$StockModel = new Stock();
    	
    	$params = array(
			'conditions'=>array('Item.stock_code'=>2),
			'recursive'=>1,
		);
		$ItemModel->contain('Subitem');
		$items = $ItemModel->find('all', $params);
		foreach($items as $item){
			foreach($item['Subitem'] as $subitem){
				$params = array( 'conditions'=>array('Stock.subitem_id'=>$subitem['id']), 'fields'=>'Stock.id');
				$stocks = $StockModel->find('all', $params);
				foreach($stocks as $stock){
					$StockModel->delete($stock['Stock']['id']);
					$this->out('delete_stock:'.$stock['Stock']['id']);
				}
			}
		}
    	exit("HAPPY END");
	}
	
}

?>