<div class="nationalHolidays index">
<h2><?php __('NationalHolidays');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('date');?></th>
	<th><?php echo $paginator->sort('section_id');?></th>
</tr>
<?php
$i = 0;
foreach ($nationalHolidays as $nationalHoliday):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $nationalHoliday['NationalHoliday']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($nationalHoliday['NationalHoliday']['name'], array('action'=>'edit', $nationalHoliday['NationalHoliday']['id'])); ?>
		</td>
		<td>
			<?php echo $nationalHoliday['NationalHoliday']['date']; ?>
		</td>
		<td>
			<?php echo $nationalHoliday['NationalHoliday']['section_id']; ?>
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
		<li><?php echo $html->link(__('New NationalHoliday', true), array('action'=>'add')); ?></li>
	</ul>
</div>
<p>
月途中の実績から、今月の売上見込みを算出する際に、休日日数を考慮するためのデータ。<br>
具体的には、入力された日を土日に関係なく休日と見なし、そこから平日平均売上と休日平均売上を算出し、残りの平日日数と休日日数を掛けて月末着地予想とする。<br>
部門（section_id)は海外店舗など、特定の店舗にだけ適用される休日フラグ。
</p>