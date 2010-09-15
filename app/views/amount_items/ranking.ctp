<?php
	echo $javascript->link("prototype",false);
	echo $javascript->link("order_by_column",false);
?>
アイテムベスト100　
<a href="/buchedenoel/amount_items/ranking/1">年次</a> |
<a href="/buchedenoel/amount_items/ranking/2">月次</a> |
<a href="/buchedenoel/amount_items/ranking/3">週次</a> |
<a href="/buchedenoel/amount_items/ranking/4">日次</a> |
<div class="amountSections index">
<h2><?php echo $key_name; ?></h2>
<table id="order_by_column_table">
	<thead>
	<tr>
	<th>品番</th>
	<th>合計</th>
	<th>個数</th>
	<th>前合計</th>
	<th>前対比</th>
	<th>前個数</th>
	<th>同合計</th>
	<th>同対比</th>
	<th>同個数</th>
	</tr>
	</thead>
<tbody>
<?php
foreach($ranking_bests as $value){
		echo '<tr>';
		echo '<td>';
		echo $html->link($value['name'], array('controller'=>'items', 'action'=>'view/'.$value['id']));
		echo '</td>';
		echo '<td>'.$value['full_amount'].'</td>';
		echo '<td>'.$value['sales_qty'].'</td>';
		echo '<td>'.$value['prev_amount'].'</td>';
		echo '<td>'.$value['prev_percent'].'%</td>';
		echo '<td>'.$value['prev_qty'].'</td>';
		echo '<td>'.$value['year_amount'].'</td>';
		echo '<td>'.$value['year_percent'].'%</td>';
		echo '<td>'.$value['year_qty'].'</td>';
		echo '</tr>';
}
?>
</tbody>
</table>
</div>
<?php
$script = 'new OrderByColumn( "order_by_column_table", ["string","number","number","number","number","number"] );';
echo $javascript->codeBlock($script);
?>