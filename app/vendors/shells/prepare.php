<?php
class PrepareShell extends Shell {

	//var $uses = array('Sale', 'SalesDateil', 'Subitem', 'OrdersSale', 'Order', 'OrderDateil', 'Stock', 'Depot', 'Item', 'Destination');
	//var $components = array('Selector', 'Print', 'Total',  'StratCsv');

	function startup(){
		$this->out("");
		$this->out("Start Shell");
		$this->hr();
		
		
		//テスト用
		//App::import('Model', 'AmountSection');
    	//$AmountSectionModel = new AmountSection();
		//$AmountSectionModel->dayAmount('305');
		
		
		
		//タグ発行csvのファイルを削除
		$old_file = array();
		$path = WWW_ROOT.DS.'files'.DS.'pricetagcsv'.DS;
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			$old_file[] = $file;
		}
		closedir($handle);
		foreach($old_file as $file_name){
			if($file_name != '.' AND $file_name != '..'){
				unlink($path.$file_name);
				$this->out("unlink:".$file_name);
			}
		}
		//カタログ印刷ファイルを削除
		$old_file = array();
		$path = WWW_ROOT.DS.'files'.DS.'print'.DS;
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			$old_file[] = $file;
		}
		closedir($handle);
		foreach($old_file as $file_name){
			if($file_name != '.' AND $file_name != '..'){
				unlink($path.$file_name);
				$this->out("unlink:".$file_name);
			}
		}
		//その時だけのCSVを削除
		$old_file = array();
		$path = WWW_ROOT.DS.'files'.DS.'user_csv'.DS;
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			$old_file[] = $file;
		}
		closedir($handle);
		foreach($old_file as $file_name){
			if($file_name != '.' AND $file_name != '..'){
				unlink($path.$file_name);
				$this->out("unlink:".$file_name);
			}
		}

	}

	function importSales(){
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		
		/*
		//旧、売上読み込み
		$path = WWW_ROOT.DS.'files'.DS.'prepare'.DS;
		$old_file = array();
		$counter = 0;
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			$old_file[] = $file;
		}
		closedir($handle);
		foreach($old_file as $file_name){
			if($file_name != '.' AND $file_name != '..' AND $counter <= 4){
				$counter++;
				$result = $SalesCsvComponent->inSales($file_name);
				if($result){
					$this->out($result.':'.$file_name);
					//$this->out($file_name);
				}else{
					exit("BAD END");
				}
			}
		}
		*/
		
		
		//在庫移動プログラム　旧　→　新
		//ファイル名がそのまま、旧倉庫番号になる
		$path = WWW_ROOT.DS.'files'.DS.'pre_zaiko'.DS;
		//$path = WWW_ROOT.'files'.DS.'pre_zaiko'.DS;
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
				$file_name = mb_convert_kana($file_name, 'a', 'UTF-8');
				$file_name = ereg_replace("[^0-9]", "", $file_name);//半角数字以外を削除
				$result = $SalesCsvComponent->inStock2($path, $file_name);
				if($result){
					$this->out($result.':'.$file_name);
					//$this->out($file_name);
				}else{
					exit("BAD END");
				}
			}
		}
		
		
		
		//2011年3月10日,JAN移行を試しに動かしてみる
		//NEXT：hoge.phpからreTryCostを移植してきて、テストする。とりあえず以上
		
		
		//旧から新へ、毎日JANを移行させる。為のプログラム
		$path = WWW_ROOT.DS.'files'.DS.'SyohinIchiran'.DS;
		App::import('Component', 'StratCsv');
   		$StratCsvComponent = new StratCsvComponent();
		$old_file = array();
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			$old_file[] = $file;
		}
		closedir($handle);
		foreach($old_file as $file_name){
			if($file_name != '.' AND $file_name != '..'){
				$file_name = mb_convert_kana($file_name, 'a', 'UTF-8');
				$result = $StratCsvComponent->sj2bsnItemCsv($path, $file_name);
				if($result){
					$this->out($result.':'.$file_name);
					//$this->out($file_name);
				}else{
					exit("BAD END");
				}
			}
		}
		
		
		//単品管理が複数あった場合、最新の在庫を残して、残りは在庫減修正する。
		/*
		App::import('Model', 'Stock');
    	$StockModel = new Stock();
		App::import('Model', 'Item');
    	$ItemModel = new Item();
		$params = array(
			'conditions'=>array('Item.stock_code'=>3),
			'recursive'=>1,
			//'fields'=>'Item.id'
		);
		$ItemModel->contain('Subitem.id');
		$items = $ItemModel->find('all', $params);
		foreach($items as $item){
			foreach($item['Subitem'] as $subitem){
				$params = array(
					'conditions'=>array('Stock.subitem_id'=>$subitem['id']),
					'recursive'=>-1,
				);
				$counter = $StockModel->find('count', $params);
				while($counter > 1){
					$params = array(
						'conditions'=>array('Stock.subitem_id'=>$subitem['id']),
						'recursive'=>-1,
						'order'=>array('Stock.created DESC'),
					);
					$stock = $StockModel->find('first', $params);
					if($stock['Stock']['quantity'] >= 1){
						if($StockModel->Mimus($subitem['id'], $stock['Stock']['depot_id'], $stock['Stock']['quantity'], 1135, 3)){
							$this->out('tanpincleaning:'.$subitem['id'].':'.$stock['Stock']['depot_id'].':'.$stock['Stock']['quantity']);
						}else{
							echo("BAD");
						}
					}
					$counter = $counter -1;
				}
			}
		}
		*/
		
		//部門別売上集計してCSV出力
		//とりあえず直営店だけ
		//$SalesCsvComponent->storeSales();
		$SalesCsvComponent->dairyReport();
		exit("HAPPY END");
	}
}
?>