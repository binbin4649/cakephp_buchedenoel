<?php echo $html->link('取引先', array('controller'=> 'companies','action'=>'index')); ?>
 |
 <?php echo $html->link('請求先', array('controller'=> 'billings', 'action'=>'index')); ?>
 |
 <?php echo $html->link('出荷先', array('controller'=> 'destinations', 'action'=>'index')); ?>
<div class="billings index">
<h2><?php __('Billings');?></h2>
<?php
echo $form->create('Billing' ,array('action'=>'index'));
echo $form->text('Billing.word');
echo $form->submit('Seach', array('div'=>false));
echo '<br>';
echo $form->checkbox('Billing.trade_type');
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
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('total_day');?></th>
	<th><?php echo $paginator->sort('payment_day');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
</tr>
<?php
$i = 0;
foreach ($billings as $billing):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $billing['Billing']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($billing['Billing']['name'], array('action'=>'view', $billing['Billing']['id'])); ?>
		</td>
		<td>
			<?php echo $billing['Billing']['total_day']; ?>
		</td>
		<td>
			<?php echo $billing['Billing']['payment_day']; ?>
		</td>
		<td>
			<?php echo $billing['Billing']['updated']; ?>
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
		<li><?php echo $html->link(__('New Billing', true), array('action'=>'add')); ?></li>
	</ul>
</div>
<p>
検索は、卸先の名称、住所の一部、電話番号で検索できます。
</p>
