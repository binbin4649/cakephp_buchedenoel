<div class="amountUsers index">
<h2><?php __('AmountUsers');?></h2>
<?php
$modelName = 'AmountUser';
$subModel = 'User';
$sub_id = 'user_id';
echo $form->create($modelName ,array('action'=>'index'));
echo $form->input($modelName.'.'.$sub_id, array(
	'type'=>'text',
	'label'=>$subModel,
	'div'=>false,
	'size'=>7
));
echo '　';
echo $form->input($modelName.'.amount_type', array(
	'type'=>'select',
	'options'=>$amountType,
	'label'=>'Amount Type',
	'empty'=>__('(Select)', true),
	'div'=>false
));
echo '<br><br>開始日';
echo $form->input($modelName.'.start_day', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>'2006',
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '　終了日';
echo $form->input($modelName.'.end_day', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>'2006',
	'maxYear' => MAXYEAR,
	'empty'=>'select',
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
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('full_amount');?></th>
	<th><?php echo $paginator->sort('cost_amount');?></th>
	<th><?php echo $paginator->sort('rank');?></th>
	<th><?php echo $paginator->sort('mark');?></th>
	<th><?php echo $paginator->sort('plan');?></th>
</tr>
<?php
$i = 0;
foreach ($amountUsers as $amountUser):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $amountUser['AmountUser']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($amountUser['AmountUser']['name'], array('action'=>'edit', $amountUser['AmountUser']['id'])); ?>
		</td>
		<td>
			<?php echo $amountUser['AmountUser']['full_amount']; ?>
		</td>
		<td>
			<?php echo $amountUser['AmountUser']['cost_amount']; ?>
		</td>
		<td>
			<?php echo $amountUser['AmountUser']['rank']; ?>
		</td>
		<td>
			<?php echo $amountUser['AmountUser']['mark']; ?>
		</td>
		<td>
			<?php echo $amountUser['AmountUser']['plan']; ?>
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
		<li><?php echo $html->link(__('New AmountUser', true), array('action'=>'add')); ?></li>
	</ul>
</div>
