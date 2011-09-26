<script type="text/javascript" charset="utf-8">
$(function($){$(".datepicker").datepicker({dateFormat:'yy-mm-dd'});});
</script>
<div class="credits index">
<?php
echo $javascript->link("jquery-1.5.1.min",false);
echo $javascript->link("jquery-ui-1.8.14.custom.min",false);
echo $javascript->link("ui/i18n/ui.datepicker-ja.js",false);
if(!empty($csv)){
	echo '<p>';
	echo '<a href="'.$csv['url'].'" target="_blank">'.$csv['name'].'</a>';
	echo '<br>CSVが出力されました。右クリック「リンク先を保存」を選択して保存してください。</p>';
}
?>
<h2><?php __('Credits');?></h2>
<?php
$modelName = 'Credit';
echo $form->create($modelName ,array('action'=>'index'));
echo __('Id');
echo $form->text($modelName.'.id', array(
	'type'=>'text',
	'size'=>4,
	'div'=>false
));
echo '　';
echo __('Billing');
echo $form->text($modelName.'.billing_id', array(
	'type'=>'text',
	'size'=>4,
	'div'=>false
));
echo '　';
echo __('Bill No.');
echo $form->text($modelName.'.invoice_id', array(
	'type'=>'text',
	'size'=>4,
	'div'=>false
));
echo '　';
echo $form->submit('Seach', array('div'=>false));
?>
<br></br><a href="javascript:;" onmousedown="if(document.getElementById('in_exp').style.display == 'none'){ document.getElementById('in_exp').style.display = 'block'; }else{ document.getElementById('in_exp').style.display = 'none'; }">
detail</a>
<div id="in_exp" style="display:none">
<?php
echo __('Credit Date', true);
echo '　';
echo $form->input($modelName.'.start_date', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'label'=>false,
	'class'=>'datepicker'
));
echo '～';
echo $form->input($modelName.'.end_date', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'label'=>false,
	'class'=>'datepicker'
));
echo '<br><br>';
echo __('Created', true);
echo $form->input($modelName.'.start_created', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'label'=>false,
	'class'=>'datepicker'
));
echo '～';
echo $form->input($modelName.'.end_created', array(
	'type'=>'text',
	'size'=>8,
	'div'=>false,
	'label'=>false,
	'class'=>'datepicker'
));
echo '　　';
if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
	echo '　';
	echo 'CSV出力';
	echo $form->checkbox($modelName.'.csv');
}
echo $form->end();
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
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort(__('Bill No.', true), 'invoice_id');?></th>
	<th><?php echo $paginator->sort(__('Credit Date', true), 'date');?></th>
	<th><?php echo $paginator->sort(__('Billing', true), 'billing_id');?></th>
	<th><?php echo $paginator->sort('reconcile_amount');?></th>
</tr>
<?php
$i = 0;
foreach ($credits as $credit):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($credit['Credit']['id'], array('action'=>'view', $credit['Credit']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($credit['Credit']['invoice_id'], array('controller'=>'invoices', 'action'=>'view', $credit['Credit']['invoice_id'])); ?>
		</td>
		<td>
			<?php echo $credit['Credit']['date']; ?>
		</td>
		<td>
			<?php echo mb_substr($credit['Billing']['name'], 0, 10); ?>
		</td>
		<td>
			<?php echo number_format($credit['Credit']['reconcile_amount']); ?>
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
		<li><?php echo $html->link(__('New Credit', true), array('action'=>'add')); ?></li>
	</ul>
</div>
<ul>
	<li>請求先、請求書検索は、システム番号での検索です。</li>
</ul>