<h2>親品番在庫</h2>
<?php echo $html->link($item['name'], array('controller'=>'items', 'action'=>'view/'.$item['id'])); ?>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>部門</th>
	<th>合計</th>
	<?php
	foreach($major_size as $size=>$value){
		echo '<th>'.$size.'</th>';
		$size_total[$size] = 0;
	}
	?>
</tr>
<?php
	$total = 0;
	foreach ($item_stocks as $section_id=>$stock):
		$total = $total + $stock['qty'];
?>
	<tr id="item-index">
		<td>
			<?php echo $html->link($stock['section_name'], array('controller'=>'sections', 'action'=>'view/'.$section_id)); ?>
		</td>
		<td>
			<?php echo $stock['qty']; ?>
		</td>
		<?php
		foreach($major_size as $size=>$value){
			echo '<td>'.@$stock['size'][$size].'</td>';
			$size_total[$size] = $size_total[$size] + @$stock['size'][$size];
		}
		?>
	</tr>
<?php endforeach; ?>
<tr>
	<td>合計</td>
	<td><?php echo $total; ?></td>
	<?php
		foreach($major_size as $size=>$value){
			echo '<td>'.@$size_total[$size].'</td>';
		}
	?>
</tr>
</table>