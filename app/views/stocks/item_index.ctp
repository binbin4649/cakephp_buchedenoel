<h2>親品番在庫</h2>
<p>
<?php 
	echo $html->link($item['name'], array('controller'=>'items', 'action'=>'view/'.$item['id'])).'　/　';
	if($depo != 'defa'){
		echo $html->link('通常倉庫', array('controller'=>'stocks', 'action'=>'item_index/'.$item['id'])).'　/　';
	}else{
		echo '通常倉庫　/　';
	}
	if($depo != 'not_defa'){
		echo $html->link('通常以外', array('controller'=>'stocks', 'action'=>'item_index/'.$item['id'].'/not_defa')).'　/　';
	}else{
		echo '通常以外　/　';
	}
	if($depo != 'all'){
		echo $html->link('全倉庫', array('controller'=>'stocks', 'action'=>'item_index/'.$item['id'].'/all'));
	}else{
		echo '全倉庫　/　';
	}
?>
</p>
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
<ul>
<li>この在庫確認ページは、最長で2時間、情報が遅れている可能性があります。最新の在庫情報は在庫一覧から確認して下さい。</li>
<li>通常倉庫とは、部門詳細でデフォルトに指定されている倉庫のことです。店舗であれば取置、B品以外の倉庫にあたると思います。</li>
<li>通常以外とは、デフォルト以外の倉庫、全部です。店舗であれば取置やB品などの倉庫がこれにあたります。</li>
</ul>