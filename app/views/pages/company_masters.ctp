<h2>取引先関連マスタ</h2>
<div class="masterPages">
	<ul>
		<li><?php echo $html->link('取引先', array('controller'=> 'companies','action'=>'index')); ?></li>
		<li><?php echo $html->link('請求先', array('controller'=> 'billings', 'action'=>'index')); ?></li>
		<li><?php echo $html->link('出荷先', array('controller'=> 'destinations', 'action'=>'index')); ?></li>
		<li><?php echo $html->link('ブランド別掛率', array('controller'=> 'brand_rates', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('入金口座', array('controller'=> 'bank_acuts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('取引先分類', array('controller'=> 'groupings', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('CSV Update Company', array('controller'=> 'companies', 'action'=>'csv_update')); ?> </li>
	</ul>
</div>

