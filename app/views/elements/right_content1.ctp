<h2>本日の売上速報</h2>
<div><?php echo $html->link('本日の売上速報', array('controller'=>'amount_sections', 'action'=>'todayindex')); ?></div>


<h2>商品　今週のTOP10</h2>
<div><ul class="yuirssreader">
<?php
foreach($item_right as $value){
	echo '<li>';
	echo $html->link($value['name'], array('controller'=>'items', 'action'=>'view/'.$value['id']));
	echo '<p class="byline"><cite>'.number_format($value['full_amount']).'円</cite></p>';
	echo '</li>';
}

?>
</ul></div>
<h2>直営　今週のTOP10</h2>
<div><ul class="yuirssreader">
<?php
foreach($section_right as $value){
	echo '<li>';
	$title = mb_substr($value['name'], 0, 20);
	echo $html->link($title, array('controller'=>'sections', 'action'=>'view/'.$value['id']));
	echo '<p class="byline"><cite>'.number_format($value['full_amount']).'円</cite></p>';
	echo '</li>';
}
?>
</ul></div>
<h2>個人売　今週のTOP10</h2>
<div><ul class="yuirssreader">
<?php
foreach($user_right as $value){
	echo '<li>';
	$title = mb_substr($value['name'], 0, 20);
	echo $html->link($title, array('controller'=>'users', 'action'=>'view/'.$value['id']));
	echo '<p class="byline"><cite>'.number_format($value['full_amount']).'円</cite></p>';
	echo '</li>';
}
?>
</ul></div>
