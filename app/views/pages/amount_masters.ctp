<h2>実績集計テーブル</h2>
<div class="masterPages">
	<ul>
		<li><?php echo $html->link('ペア別', array('controller'=> 'amount_pairs', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('ブランド別', array('controller'=> 'amount_brands','action'=>'index')); ?></li>
		<li><?php echo $html->link('品番別', array('controller'=> 'amount_items', 'action'=>'index')); ?> </li>

		<li><?php echo $html->link('部門区分別', array('controller'=> 'amount_sales_codes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('部門別', array('controller'=> 'amount_sections', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('倉庫別', array('controller'=> 'amount_depots', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('従業員別', array('controller'=> 'amount_users', 'action'=>'index')); ?> </li>

		<li><?php echo $html->link('取引先別', array('controller'=> 'amount_companies', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('出荷先別', array('controller'=> 'amount_destinations', 'action'=>'index')); ?> </li>

		<li><?php echo $html->link('工場・仕入先別', array('controller'=> 'amount_factories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('商品属性別', array('controller'=> 'amount_itemproperties', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('商品タイプ別', array('controller'=> 'amount_itemtypes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('基本サイズ別', array('controller'=> 'amount_major_sizes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('素材別', array('controller'=> 'amount_materials', 'action'=>'index')); ?> </li>

		<li><?php echo $html->link('加工別', array('controller'=> 'amount_processes', 'action'=>'index')); ?> </li>

		<li><?php echo $html->link('販売状況別', array('controller'=> 'amount_sales_state_codes', 'action'=>'index')); ?> </li>

		<li><?php echo $html->link('石別', array('controller'=> 'amount_stones', 'action'=>'index')); ?> </li>

	</ul>
</div>

