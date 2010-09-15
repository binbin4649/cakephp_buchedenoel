<div class="purchases index">
<h2><?php __('Purchase List');?></h2>
<?php
$modelName = 'Purchase';
echo $form->create($modelName ,array('action'=>'index'));
echo $form->text($modelName.'.word');
echo '　';
echo $form->input($modelName.'.status', array(
	'type'=>'select',
	'options'=>$purchaseStatus,
	'label'=>__('Status', true),
	'empty'=>__('(Please Select)', true),
	'div'=>false
));
echo '　';
echo $form->submit('Seach', array('div'=>false));
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
	<th><?php echo $paginator->sort('invoices');?></th>
	<th><?php echo $paginator->sort('purchase_status');?></th>
	<th><?php echo $paginator->sort('factory_id');?></th>
	<th><?php echo $paginator->sort('date');?></th>
	<th><?php echo $paginator->sort('total');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('created_user');?></th>
</tr>
<?php
$i = 0;
foreach ($purchases as $purchase):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($purchase['Purchase']['id'], array('action'=>'view', $purchase['Purchase']['id'])); ?>
		</td>
		<td>
			<?php echo $purchase['Purchase']['invoices']; ?>
		</td>
		<td>
			<?php echo $purchase['Purchase']['purchase_status_name']; ?>
		</td>
		<td>
			<?php echo $purchase['Factory']['name']; ?>
		</td>
		<td>
			<?php echo $purchase['Purchase']['date']; ?>
		</td>
		<td>
			<?php echo number_format($purchase['Purchase']['total']); ?>
		</td>
		<td>
			<?php echo $purchase['Purchase']['created']; ?>
		</td>
		<td>
			<?php echo $purchase['Purchase']['created_user_name']; ?>
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
<ul>
	<li>仕入番号で検索できます。</li>
</ul>