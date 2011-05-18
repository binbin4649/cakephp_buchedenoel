<!--Menu Start-->
<div class="yui-b" id="tocWrapper">
<!--IE6で、改行コードが入っていると、メニューリンクが改行されて2行になる。FireFoxだとOK-->
<div id="toc">
<ul>
<?php
//sect=カテゴリー名　item=リンク名　$menu_list[名称]0[sect OR item]1[url ※カテゴリーの場合は0]

if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	$menu_list = array(
		__('BuchedeNoel',true)=>array('sect', '0'),
		__('TOP',true)=>array('item', 'top/index'),
		__('Board List',true)=>array('item', 'memo_datas/index'),
		__('Board Search',true)=>array('item', 'memo_datas/search'),
		//商品
		__('Item',true)=>array('sect', '0'),
		__('Item Saech',true)=>array('item', 'items/index'),
		__('Tag Order List',true)=>array('item', 'pricetags/index'),
		__('List Repairs',true)=>array('item', 'repairs/index'),
		//在庫
		__('Stocking',true)=>array('sect', '0'),
		__('List Depots',true)=>array('item', 'depots/index'),
		__('Stock Reserve',true)=>array('item', 'transport_dateils/reserve'),
		__('Moving spot',true)=>array('item', 'transport_dateils/add'),
		__('Moving List',true)=>array('item', 'transports/index'),
		__('Stocks',true)=>array('item', 'stocks/index'),
		__('Stock Log',true)=>array('item', 'stock_logs/index'),
		__('Revision List',true)=>array('item', 'stock_revisions/index'),
		//売上店舗
		__('Store Sales',true)=>array('sect', '0'),
		__('Input Sale(JAN)',true)=>array('item', 'sales/add'),
		__('Sell Input',true)=>array('item', 'order_dateils/store_add'),
		__('Store Sale List',true)=>array('item', 'orders/store_index'),
		__('Sale Item List',true)=>array('item', 'order_dateils/index'),
		//受注
		__('Sales',true)=>array('sect', '0'),
		__('Order Input',true)=>array('item', 'order_dateils/add'),
		__('Order List',true)=>array('item', 'orders/index'),
		__('Sales List',true)=>array('item', 'sales/index'),
		__('Invoice List',true)=>array('item', 'invoices/index'),
		__('Credit List',true)=>array('item', 'credits/index'),
		//発注
		__('Ordering',true)=>array('sect', '0'),
		__('Ordering Input',true)=>array('item', 'orderings_details/add'),
		__('Ordering List',true)=>array('item', 'orderings/index'),
		__('Purchase List',true)=>array('item', 'purchases/index'),
		__('Pay List',true)=>array('item', 'pays/index'),
		//従業員
		__('User',true)=>array('sect', '0'),
		__('User Saech',true)=>array('item', 'users/index'),
		__('Section List',true)=>array('item', 'sections/index/1'),
		//マスタ
		__('Master',true)=>array('sect', '0'),
		__('Item Master',true)=>array('item', 'pages/masters'),
		__('User Master',true)=>array('item', 'pages/users_masters'),
		__('Company Master',true)=>array('item', 'pages/company_masters'),
		__('Inventory',true)=>array('item', 'inventories/index'),
		//__('Amount Master',true)=>array('item', 'pages/amount_masters'),
		//スタートアップ
		__('Start Up',true)=>array('sect', '0'),
		__('ItemCSV Insert',true)=>array('item', 'items/csv_add'),
		__('SalesCSV Insert',true)=>array('item', 'sales/csv_update'),
		__('StockCSV Insert',true)=>array('item', 'stocks/csv_add'),
	);
}else{
	$menu_list = array(
		__('BuchedeNoel',true)=>array('sect', '0'),
		__('TOP',true)=>array('item', 'top/index'),
		__('Board List',true)=>array('item', 'memo_datas/index'),
		__('Board Search',true)=>array('item', 'memo_datas/search'),
		
		__('Item',true)=>array('sect', '0'),
		__('Item Saech',true)=>array('item', 'items/index'),
		__('Tag Order List',true)=>array('item', 'pricetags/index'),
		__('List Repairs',true)=>array('item', 'repairs/index'),
			
		__('Stocking',true)=>array('sect', '0'),
		__('List Depots',true)=>array('item', 'depots/index'),
		__('Moving spot',true)=>array('item', 'transport_dateils/add'),
		__('Moving List',true)=>array('item', 'transports/index'),
		__('Stocks',true)=>array('item', 'stocks/index'),
		__('Stock Log',true)=>array('item', 'stock_logs/index'),
		__('Revision List',true)=>array('item', 'stock_revisions/index'),
		
		__('Store Sales',true)=>array('sect', '0'),
		__('Input Sale(JAN)',true)=>array('item', 'sales/add'),
		__('Sell Input',true)=>array('item', 'order_dateils/store_add'),
		__('Store Sale List',true)=>array('item', 'orders/store_index'),
		__('Sale Item List',true)=>array('item', 'order_dateils/index'),
		
		__('User',true)=>array('sect', '0'),
		__('User Saech',true)=>array('item', 'users/index'),
		__('Section List',true)=>array('item', 'sections/index/1'),
		
		__('Master',true)=>array('sect', '0'),
		__('Inventory',true)=>array('item', 'inventories/index'),
	);
}



$counter = 0;
foreach($menu_list as $key=>$value){
	if($value[1] == $selected){
		echo '<li class="selected"><a href="/buchedenoel/'.$value[1].'/">'.$key.'</a></li>';
	}elseif($value[0] == 'sect'){
		if($counter == 0){
			echo '<li class="sect first">'.$key.'</li>';
			$counter++;
		}else{
			echo '<li class="sect">'.$key.'</li>';
		}
	}else{
		echo '<li class="item"><a href="/buchedenoel/'.$value[1].'">'.$key.'</a></li>';
	}
}
?>
</ul>
</div>
</div>
<!--Menu End-->