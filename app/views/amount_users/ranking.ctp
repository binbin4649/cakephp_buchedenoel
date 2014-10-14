<?php
	echo $javascript->link("prototype",false);
	echo $javascript->link("order_by_column",false);
	foreach($ranking_user as $user_name=>$value){
		foreach($value as $key_name=>$amount){

		}
	}
?>
<a href="/'.SITE_DIR.'/amount_users/ranking/2/1">年次</a> |
<a href="/'.SITE_DIR.'/amount_users/ranking/2/2">月次</a> |
<a href="/'.SITE_DIR.'/amount_users/ranking/2/3">週次</a> |
<a href="/'.SITE_DIR.'/amount_users/ranking/2/4">日次</a> |
<div class="amountSections index">
<h2><?php echo $key_name; ?></h2>
<table id="order_by_column_table">
	<thead>
	<tr>
	<th>名前</th>
	<th>合計</th>
	<th>前合計</th>
	<th>前対比</th>
	<th>同合計</th>
	<th>同対比</th>
	</tr>
	</thead>
<tbody>
<?php
foreach($ranking_user as $user_name=>$value){
	foreach($value as $key_name=>$amount){
		echo '<tr>';
		echo '<td>'.$user_name.'</td>';
		echo '<td>'.$amount['full_amount'].'</td>';
		echo '<td>'.$amount['prev_amount'].'</td>';
		echo '<td>'.$amount['prev_percent'].'%</td>';
		echo '<td>'.$amount['year_amount'].'</td>';
		echo '<td>'.$amount['year_percent'].'%</td>';
		echo '</tr>';
	}
}
?>
</tbody>
</table>
</div>
<?php
$script = 'new OrderByColumn( "order_by_column_table", ["string","number","number","number","number","number"] );';
echo $javascript->codeBlock($script);
?>