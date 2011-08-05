
<div class="destinations index">
<?php
echo $javascript->link("jquery",false);
echo $form->create('Destination' ,array('action'=>'selectid'));
echo $form->text('Destination.word');
echo $form->submit('Seach', array('div'=>false));
echo '　';
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
			<?php //echo $html->link($destination['Destination']['name'], array('action'=>'view', $destination['Destination']['id'])); ?>
			<?php 
				echo $html->link($destination['Destination']['name'],'', array('class'=>'senddata', 'value'=>$destination['Destination']['id']));
			?>
		</td>
		<td>
			<?php 
				if(empty($destination['Destination']['company_name'])){
					echo '取引先が登録されていません。';
				}else{
					echo $destination['Destination']['company_name'];
				}
				
			?>
		</td>
		<td>
			<?php echo substr($destination['Destination']['updated'], 0, 10); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<p>
検索は、卸先の名称、住所の一部、電話番号で検索できます。
</p>
<script type="text/javascript">
$(function(){
	$(".senddata").click(function() {
		//href = $(this).attr("href");
		var val_data = $(this).attr("value");
		window.parent.$("#OrderDateilDestinationId").val(val_data);
		window.parent.tb_remove();
	});
});
</script>