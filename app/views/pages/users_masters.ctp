<h2>従業員関連マスタ</h2>
<div class="masterPages">
	<ul>
		<li><?php echo $html->link('従業員新規登録', array('controller'=> 'users','action'=>'add')); ?></li>
		<li><?php echo $html->link('部門・店舗マスタ', array('controller'=> 'sections', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('役職マスタ', array('controller'=> 'posts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('雇用体系マスタ', array('controller'=> 'employments', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('掲示板カテゴリ', array('controller'=> 'memo_categories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link('CSV Update Users', array('controller'=> 'users', 'action'=>'csv_update')); ?> </li>
	</ul>
</div>
<h2>休日設定マスタ</h2>
<div class="masterPages">
	<ul>
		<li><?php echo $html->link('祝祭日マスタ', array('controller'=> 'national_holidays','action'=>'index')); ?></li>
		<li><?php echo $html->link('休業日マスタ', array('controller'=> 'shop_holidays','action'=>'index')); ?></li>
	</ul>
</div>