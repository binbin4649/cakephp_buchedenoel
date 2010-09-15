<?php echo $html->link('取引先', array('controller'=> 'companies','action'=>'index')); ?>
 |
 <?php echo $html->link('請求先', array('controller'=> 'billings', 'action'=>'index')); ?>
 |
 <?php echo $html->link('出荷先', array('controller'=> 'destinations', 'action'=>'index')); ?>
<div class="destinations index">
<h2><?php __('Destinations');?></h2>
<?php
echo $form->create('Destination' ,array('action'=>'index'));
echo $form->text('Destination.word');
echo $form->submit('Seach', array('div'=>false));
echo '<br>';
echo $form->checkbox('Destination.trade_type');
echo '停止を含む';
echo $form->end();
?>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>ID</th>
	<th><?php echo __('Destinations', true); ?></th>
	<th><?php echo __('Company', true); ?></th>
	<th><?php echo __('Updated', true); ?></th>
</tr>
<?php
$i = 0;
foreach ($destinations as $destination):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<input type="text" size="3" value="<?php echo $destination['Destination']['id']; ?>" />
		</td>
		<td>
			<?php echo $html->link($destination['Destination']['name'], array('action'=>'view', $destination['Destination']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($destination['Destination']['company_name'], array('controller'=>'companies', 'action'=>'view', $destination['Destination']['company_id'])); ?>
		</td>
		<td>
			<?php echo $destination['Destination']['updated']; ?>
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
		<li><?php echo $html->link(__('New Destination', true), array('action'=>'add')); ?></li>
	</ul>
</div>
<p>
検索は、卸先の名称、住所の一部、電話番号で検索できます。
</p>