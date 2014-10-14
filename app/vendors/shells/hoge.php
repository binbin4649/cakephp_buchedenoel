<?php
class HogeShell extends Shell {

	//var $uses = array('Sale', 'SalesDateil', 'Subitem', 'OrdersSale', 'Order', 'OrderDateil', 'Stock', 'Depot', 'Item', 'Destination');
	//var $components = array('Selector', 'Print', 'Total',  'StratCsv');

	function startup(){
		
	}
	
	//設定された新店をザクっとつくる、と思ったけど、手動で作っちまったｗ
	//add section , 3depot , free user
	function bulkAddSection(){
		$section_name = ''; // 店舗名を入れる
		App::import('Model', 'Section');
    	$SectionModel = new Section();
		App::import('Model', 'Depot');
    	$DepotModel = new Depot();
		App::import('Model', 'User');
    	$UserModel = new User();
		
		
	}
	
	//決められたセクションにフリーを作る
	//./cake hoge newFreeUser -app /var/www/html/'.SITE_DIR.'/app
	function newFreeUser(){
		$section_id = ''; //部門IDを書き換える
		if(empty($section_id)){
			echo '部門ID入ってないよ!'."\n";
			exit;
		}
		App::import('Model', 'Section');
    	$SectionModel = new Section();
    	App::import('Model', 'User');
    	$UserModel = new User();
    	$params = array(
			'conditions'=>array('Section.id'=>$section_id),
			'recursive'=>-1,
		);
		$section = $SectionModel->find('first', $params);
    	$User = array();
    	$user = array();
    	$user['name'] = 'フリー　'.$section['Section']['name'];
		$user['section_id'] = $section_id;
		$user['post_id'] = 15;
		$user['employment_id'] = 7;
		$user['duty_code'] = 10;
		$user['username'] = $section_id.'9999';
		$user['password'] = $section_id.'1122';
		$User['User'] = $user;
		$UserModel->create();
		if($UserModel->save($User)){
			echo 'OK!';
		}else{
			echo 'ERROR';
		}
	}
	
	//テスト期間に入力されたテストデータを削除する。
	// created 2011-03-22 00:00:00 > 2011-03-24 18:00:00
	// order_status = 5
	//./cake hoge orderTestDelete -app /var/www/html/'.SITE_DIR.'/app
	//失敗したかも
	function orderTestDelete(){
		App::import('Model', 'Order');
    	$OrderModel = new Order();
    	App::import('Model', 'OrderDateil');
    	$OrderDateilModel = new OrderDateil();
		$params = array(
			'conditions'=>array('Order.order_status'=>5, 'Order.created >'=>'2011-03-22 00:00:00', 'Order.created <'=>'2011-03-24 18:00:00'),
			'recursive'=>1,
		);
		$OrderModel->contain('OrderDateil');
		$orders = $OrderModel->find('all', $params);
		foreach($orders as $order){
			$OrderModel->delete($order['Order']['id']);
			foreach($order['OrderDateil'] as $detail){
				$OrderDateilModel->delete($detail['OrderDateil']['id']);
			}
		}
    	exit("HAPPY END");
	}
	
	//ホンさんシステムから売上吸い上げ
	//./cake hoge uptakeSales -app /var/www/html/'.SITE_DIR.'/app
	function uptakeSales(){
		$path = WWW_ROOT.'files'.DS.'reTryCost'.DS;
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		$old_file = array();
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			$old_file[] = $file;
		}
		closedir($handle);
		foreach($old_file as $file_name){
			if($file_name != '.' AND $file_name != '..' AND $file_name != 'file_division.sh' AND $file_name != 'uptake.csv'){
				$result = $SalesCsvComponent->uptakeSale($path, $file_name);
				if($result){
					$this->out($result.':'.$file_name);
				}else{
					exit("BAD END");
				}
			}
			mysql_ping();
		}
	}
	
	// section に start_date を適当（適切？）に入れ込むスクリプト
	// ./cake hoge sectionInsertStartdate -app /var/www/html/'.SITE_DIR.'/app
	function sectionInsertStartdate(){
		App::import('Model', 'Section');
    	$SectionModel = new Section();
		
		$params = array(
			'conditions'=>array('Section.sales_code'=>1, 'Section.start_date'=>NULL),
			//'conditions'=>array('Section.sales_code'=>1, 'Section.start_date'=>'0000-00-00'),
			'recursive'=>-1,
		);
		$sections = $SectionModel->find('all', $params);
		$i = 0;
		foreach($sections as $section){
			$SectionModel->create();
			$SectionModel->id = null;
			$section['Section']['start_date'] = '2008-01-01';
			$SectionModel->save($section);
			$i++;
		}
		echo $i;
	}
	
	//客注＆取置の手引き用に、ダミー取置データ（移動データ）を作成
	//全部門分の取置データを作る
	function transportDammy(){
		App::import('Model', 'Transport');
    	$TransportModel = new Transport();
    	App::import('Model', 'TransportDateil');
    	$TransportDateilModel = new TransportDateil();
    	App::import('Model', 'Section');
    	$SectionModel = new Section();
    	
    	$section_list = $SectionModel->find('list');
    	//pr($section_list);
    	foreach($section_list as $section_id=>$section_name){
    		
    		$transport = array();
    		$TransportModel->create();
    		/*
    		$params = array(
				'conditions'=>array('Transport.id'=>$section_id),
				'recursive'=>1,
			);
			$transport = $TransportModel->find('first', $params);
			pr($transport);
			exit;
			*/
			
			$transport['Transport'] = array(
				'id'=>$section_id,
				'out_depot'=>910,
				'in_depot'=>null,
				'transport_status'=>2,
				'delivary_date'=>null,
				'arrival_date'=>null,
				'layaway_type'=>1,
				'layaway_user'=>null,
				'created_user'=>2063,
				'created'=>date('Y-m-d'),
				'updated'=>date('Y-m-d'),
				'print_file '=>null,
			);
			$TransportModel->save($transport);
    	}
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
	
	//旧システム→在庫管理→在庫一覧表　ZAIKO.CSV
	//コスト0円のに、改めてコストを挿入、上代無くてCSVにあった場合は上書きする
	function reTryCost(){
		//$path = WWW_ROOT.DS.'files'.DS.'reTryCost'.DS;
		$path = WWW_ROOT.'files'.DS.'reTryCost'.DS;
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		$old_file = array();
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			$old_file[] = $file;
		}
		closedir($handle);
		foreach($old_file as $file_name){
			if($file_name != '.' AND $file_name != '..'){
				//$file_name = mb_convert_kana($file_name, 'a', 'UTF-8');
				//$file_name = ereg_replace("[^0-9]", "", $file_name);//半角数字以外を削除
				$result = $SalesCsvComponent->reTryCost($path, $file_name);
				if($result){
					$this->out($result.':'.$file_name);
				}else{
					exit("BAD END");
				}
			}
		}
	}
	
	//（とりあえず）レート変更に伴う、海外店の売上歴史書き換えプログラム
	// ./cake hoge amountSectionsEdit -app /var/www/html/'.SITE_DIR.'/app
	function amountSectionsEdit(){
		$range_en = '2011-09-31';//どこまでの期間の分を書き換えるか、ケツを設定する。ちなみにケツも含まれる。
		$range = strtotime($range_en);
		$sections = array('404', '405', '406', '422');
		App::import('Model', 'AmountSection');
    	$AmountSectionModel = new AmountSection();
    	
    	foreach($sections as $section){
    		$params = array(
				'conditions'=>array(
					'AmountSection.section_id'=>$section, 
					'AmountSection.start_day <='=>date('Y-m-d'),
					'AmountSection.end_day <='=>date('Y-m-d'),
				),
				'recursive'=>-1,
			);
			$amount_sections = $AmountSectionModel->find('all', $params);
			foreach($amount_sections as $val){
				$start = strtotime($val['AmountSection']['start_day']);
				$end = strtotime($val['AmountSection']['end_day']);
				if($start <= $range & $end <= $range){
					$AmountSectionModel->create();
					if($section == 406 OR $section == 422) $value_rate = '0.741'; //KOREA
					if($section == 404 OR $section == 405) $value_rate = '0.714'; //MACAU
					if($val['AmountSection']['full_amount'] > 1) $val['AmountSection']['full_amount'] = floor($val['AmountSection']['full_amount'] * $value_rate);
					if($val['AmountSection']['item_amount'] > 1) $val['AmountSection']['item_amount'] = floor($val['AmountSection']['item_amount'] * $value_rate);
					if($val['AmountSection']['tax_amount'] > 1) $val['AmountSection']['tax_amount'] = floor($val['AmountSection']['tax_amount'] * $value_rate);
					if($val['AmountSection']['cost_amount'] > 1) $val['AmountSection']['item_amount'] = floor($val['AmountSection']['cost_amount'] * $value_rate);
					if($val['AmountSection']['expense_amount'] > 1) $val['AmountSection']['expense_amount'] = floor($val['AmountSection']['expense_amount'] * $value_rate);
					if($val['AmountSection']['purchase_amount'] > 1) $val['AmountSection']['purchase_amount'] = floor($val['AmountSection']['purchase_amount'] * $value_rate);
					if($val['AmountSection']['stock_price_amount'] > 1) $val['AmountSection']['stock_price_amount'] = floor($val['AmountSection']['stock_price_amount'] * $value_rate);
					if($val['AmountSection']['stock_cost_amount'] > 1) $val['AmountSection']['stock_cost_amount'] = floor($val['AmountSection']['stock_cost_amount'] * $value_rate);
					if($val['AmountSection']['mark'] > 1) $val['AmountSection']['mark'] = floor($val['AmountSection']['mark'] * $value_rate);
					if($val['AmountSection']['plan'] > 1) $val['AmountSection']['plan'] = floor($val['AmountSection']['plan'] * $value_rate);
					if($val['AmountSection']['addsub'] > 1) $val['AmountSection']['addsub'] = floor($val['AmountSection']['addsub'] * $value_rate);
					$AmountSectionModel->save($val);
				}
			}
    	}
    	
    	exit("HAPPY END");
	}
	
	// modelテスト用
	function modelTest(){
//		App::import('Component', 'Cleaning');
//		$CleaningComponent = new CleaningComponent();
//		$result = $CleaningComponent->
		
		
		App::import('Model', 'Section');
    	$SectionModel = new Section();
    	$result = $SectionModel->amountSectionList();
    	pr($result);
    	$result = $SectionModel->amountSectionList5();
    	pr($result);
    	$result = $SectionModel->amountSectionList6();
    	pr($result);
    	exit;
	}
	
}

?>