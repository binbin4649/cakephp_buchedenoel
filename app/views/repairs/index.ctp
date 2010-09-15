<div class="repairs index">
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Repair', true), array('action'=>'add')); ?></li>
	</ul>
</div>
<?php
if(!empty($csv)){
	echo '<p>';
	echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。</p>';
}
?>
<h2><?php __('List Repairs');?></h2>
<?php
$modelName = 'Repair';
echo $form->create($modelName ,array('action'=>'index'));
echo __('Control Number');
echo $form->text($modelName.'.control_number', array(
	'type'=>'text',
	'size'=>2,
	'div'=>false
));
echo '　';
echo __('Customer Name');
echo $form->text($modelName.'.customer_name', array(
	'type'=>'text',
	'size'=>4,
	'div'=>false
));
echo '　';
echo $form->input($modelName.'.status', array(
	'type'=>'select',
	'options'=>$repairStatus,
	'label'=>'Status',
	'empty'=>__('(Select)', true),
	'div'=>false
));
echo '　';
echo $form->input($modelName.'.estimate_status', array(
	'type'=>'select',
	'options'=>$estimateStatus,
	'label'=>'　',
	'empty'=>__('(Select)', true),
	'div'=>false
));
echo '　';
echo $form->submit('Seach', array('div'=>false));
?>
<br></br><a href="javascript:;" onmousedown="if(document.getElementById('in_exp').style.display == 'none'){ document.getElementById('in_exp').style.display = 'block'; }else{ document.getElementById('in_exp').style.display = 'none'; }">
detail</a>
<div id="in_exp" style="display:none">
<?php
echo 'ブランドid';
echo $form->input($modelName.'.brand_id', array(
	'type'=>'select',
	'options'=>$brands,
	'label'=>'',
	'empty'=>__('(Select)', true),
	'div'=>false
));

echo __('Section').'id';
echo $form->input($modelName.'.section_id', array(
	'type'=>'select',
	'options'=>$sections,
	'label'=>'',
	'empty'=>__('(Select)', true),
	'div'=>false
));

echo '品番id';
echo $form->text($modelName.'.item_id', array(
	'type'=>'text',
	'size'=>2,
	'div'=>false
));
echo '　';
echo '工場id';
echo $form->text($modelName.'.factory_id', array(
	'type'=>'text',
	'size'=>2,
	'div'=>false
));
if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo '　';
	echo 'CSV出力';
	echo $form->checkbox($modelName.'.csv');
}
?>
</div>
<?php echo $form->end(); ?>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('control_number');?></th>
	<th><?php echo $paginator->sort('section_id');?></th>
	<th><?php echo $paginator->sort('工場', 'factory_id');?></th>
	<th><?php echo $paginator->sort('status');?></th>
	<th><?php echo $paginator->sort('estimate_status');?></th>
	<th><?php echo $paginator->sort('reception_date');?></th>
	<th><?php echo $paginator->sort('store_arrival_date');?></th>
	<th><?php echo $paginator->sort('shipping_date');?></th>
	<th><?php echo $paginator->sort('customer_name');?></th>
</tr>
<?php
$i = 0;
foreach ($repairs as $repair):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($repair['Repair']['control_number'], array('action'=>'view', $repair['Repair']['id'])); ?>
		</td>
		<td>
			<?php echo $repair['Section']['name']; ?>
		</td>
		<td>
			<?php echo $repair['Factory']['name']; ?>
		</td>
		<td>
			<?php echo $repairStatus[$repair['Repair']['status']]; ?>
			<?php if(!empty($repair['Repair']['factory_delivery_date'])) echo '*'; ?>
		</td>
		<td>
			<?php if(!empty($repair['Repair']['estimate_status'])) echo $estimateStatus[$repair['Repair']['estimate_status']]; ?>
		</td>
		<td>
			<?php echo $repair['Repair']['reception_date']; ?>
		</td>
		<td>
			<?php echo $repair['Repair']['store_arrival_date']; ?>
		</td>
		<td>
			<?php echo $repair['Repair']['shipping_date']; ?>
		</td>
		<td>
			<?php echo $repair['Repair']['customer_name']; ?>
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
<?php
if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo '<hr><h4>工場依頼書</h4><ul>';
	echo '<li>';
	echo $html->link(__('Request Repair List', true), array('controller'=>'repairs', 'action'=>'requestprint'));
	echo '</li>';
	echo '<li>';
	echo $addForm->switchAnchor('repairs/requestprint/output', array(), 'Reservation is in a state and outputs a list of request for the repair. Are you all right?', 'Request Repair OutPut', null);
	echo '</li></ul><hr>';
}
?>
<p>工場、品番の検索は、システム番号を入力して検索して下さい。</p>