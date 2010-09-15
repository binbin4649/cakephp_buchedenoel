<div class="transports index">
<?php
if(!empty($csv)){
	echo '<p>';
	echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。</p>';
}
if(!empty($batch_print)){
	echo '<p>';
	echo '<a href="'.$batch_print['url'].'" target="_blank">'.$batch_print['name'].'</a>';
	echo '<br>移動伝票が一括出力されました。リンクをクリックして下さい。</p>';
}
?>
<h2><?php __('List Transports');?></h2>
<?php
$modelName = 'Transport';
echo $form->create($modelName ,array('action'=>'index'));
echo '移動ID';
echo $form->text($modelName.'.word', array(
	'size'=>1
));
echo '　';
echo '出庫倉庫ID';
echo $form->text($modelName.'.out_depot', array(
	'size'=>1
));
echo '　';
echo '入庫倉庫ID';
echo $form->text($modelName.'.in_depot', array(
	'size'=>1
));
echo '　';
echo '出庫担当ID';
echo $form->text($modelName.'.created_user_id', array(
	'size'=>1
));
echo '　';
echo $form->input($modelName.'.status', array(
	'type'=>'select',
	'options'=>$transportStatus,
	'label'=>__('Status', true),
	'empty'=>__('(Please Select)', true),
	'div'=>false
));
echo '　';
echo $form->submit('Seach', array('div'=>false));
?>

<br><a href="javascript:;" onmousedown="if(document.getElementById('in_exp').style.display == 'none'){ document.getElementById('in_exp').style.display = 'block'; }else{ document.getElementById('in_exp').style.display = 'none'; }">
detail</a>
<div id="in_exp" style="display:none">
<?php
echo '<br>';
echo $form->input($modelName.'.start_date', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
echo '～';
echo $form->input($modelName.'.end_date', array(
	'type'=>'date',
	'dateFormat'=>'YMD',
	'label'=>false,
	'minYear'=>MINYEAR,
	'maxYear' => MAXYEAR,
	'empty'=>'select',
	'div'=>false
));
if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo '　';
	echo 'CSV';
	echo $form->checkbox($modelName.'.csv');
	echo '　';
	echo '一括印刷';
	echo $form->checkbox($modelName.'.batch_print');
}
echo '　取置のみ';
echo $form->checkbox($modelName.'.layaway_only');
?>
</div>
	
	
	
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('*', true),'id');?></th>
	<th><?php echo $paginator->sort(__('Status', true),'transport_status');?></th>
	<th><?php echo $paginator->sort('out_depot');?></th>
	<th><?php echo $paginator->sort('in_depot');?></th>
	<th><?php echo $paginator->sort('delivary_date');?></th>
	<th><?php echo $paginator->sort('arrival_date');?></th>
	<th><?php echo $paginator->sort('created');?></th>
</tr>
<?php
$i = 0;
foreach ($transports as $transport):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($transport['Transport']['id'], array('action'=>'view', $transport['Transport']['id'])); ?>
		</td>
		<td>
			<?php echo $transportStatus[$transport['Transport']['transport_status']]; ?>
		</td>
		<td>
			<?php echo $transport['Transport']['out_depot']['depot_name'].':'.$transport['Transport']['out_depot']['depot_id']; ?>
		</td>
		<td>
			<?php echo $transport['Transport']['in_depot']['depot_name'].':'.$transport['Transport']['in_depot']['depot_id']; ?>
		</td>
		<td>
			<?php echo substr($transport['Transport']['delivary_date'], 5, 5); ?>
		</td>
		<td>
			<?php echo substr($transport['Transport']['arrival_date'], 5, 5); ?>
		</td>
		<td>
			<?php echo substr($transport['Transport']['created'], 5, 5); ?>
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