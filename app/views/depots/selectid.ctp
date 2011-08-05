<div class="depots index">
<?php
echo $javascript->link("jquery",false);
echo $form->create('Depot' ,array('action'=>'selectid'));
echo $form->text('Depot.word');
echo $form->submit('Seach', array('div'=>false));
echo $form->end();
?>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>id</th>
	<th>倉庫名</th>
	<th>部門名</th>
	<th><?php echo __('Old Depot No.', true);?></th>
	<th><?php echo __('updated', true);?></th>
</tr>
<?php
$i = 0;
foreach ($depots as $depot):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $depot['Depot']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($depot['Depot']['name'],'', array('class'=>'senddata', 'value'=>$depot['Depot']['id'])); ?>
		</td>
		<td>
			<?php echo $depot['Section']['name']; ?>
		</td>
		<td>
			<?php echo $depot['Depot']['old_system_no']; ?>
		</td>
		<td>
			<?php echo substr($depot['Depot']['updated'], 0, 10); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<ul>
<li>検索は、「倉庫名」での部分一致検索になります。</li>
</ul>
<script type="text/javascript">
$(function(){
	$(".senddata").click(function() {
		var val_data = $(this).attr("value");
		window.parent.$("#InventoryDetailDepot").val(val_data);
		window.parent.tb_remove();
	});
});
</script>