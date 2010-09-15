<h2>商品関連マスタ</h2>
<div class="masterPages">
	<ul>
		<li><?php echo $html->link('商品新規登録', array('controller'=> 'items','action'=>'add')); ?></li>
		<li><?php echo $html->link('工場・仕入先', array('controller'=> 'factories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('ブランド', array('controller'=> 'brands', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('販売状況', array('controller'=> 'sales_state_codes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('加工方法・特殊加工', array('controller'=> 'processes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('使用素材・特殊素材', array('controller'=> 'materials', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('使用ストーン・メインルース', array('controller'=> 'stones', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('商品分類タグ', array('controller'=> 'tags', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('倉庫', array('controller'=> 'depots', 'action'=>'index')); ?> </li>
	</ul>
</div>
