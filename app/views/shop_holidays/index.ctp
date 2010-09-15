<div class="shopHolidays index">
<h2><?php __('ShopHolidays');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('section_id');?></th>
	<th><?php echo $paginator->sort('date');?></th>
</tr>
<?php
$i = 0;
foreach ($shopHolidays as $shopHoliday):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $shopHoliday['ShopHoliday']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($shopHoliday['Section']['name'], array('controller'=> 'shop_holidays', 'action'=>'edit', $shopHoliday['ShopHoliday']['id'])); ?>
		</td>
		<td>
			<?php echo $shopHoliday['ShopHoliday']['date']; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New ShopHoliday', true), array('action'=>'add')); ?></li>
	</ul>
</div>
<p>
店舗の休業日を入力する。<br>
集計した際に、休業日の場合は「休」と表示し集計対象に含めない。これが入力されていない場合は0円と表示される。<br>
</p>
