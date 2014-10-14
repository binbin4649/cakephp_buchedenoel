<?php
	echo $javascript->link("prototype",false);
	echo $javascript->link("order_by_column",false);
	foreach($ranking_store as $section_name=>$value){
		foreach($value as $key_name=>$amount){

		}
	}
?>
営業部門（店舗）
<a href="/'.SITE_DIR.'/amount_sections/ranking/1/1">年次</a> |
<a href="/'.SITE_DIR.'/amount_sections/ranking/1/2">月次</a> |
<a href="/'.SITE_DIR.'/amount_sections/ranking/1/3">週次</a> |
<a href="/'.SITE_DIR.'/amount_sections/ranking/1/4">日次</a> |
　営業部門（店舗以外）
<a href="/'.SITE_DIR.'/amount_sections/ranking/2/1">年次</a> |
<a href="/'.SITE_DIR.'/amount_sections/ranking/2/2">月次</a> |
<a href="/'.SITE_DIR.'/amount_sections/ranking/2/3">週次</a> |
<a href="/'.SITE_DIR.'/amount_sections/ranking/2/4">日次</a> |
<div class="amountSections index">
<h2><?php echo $key_name; ?></h2>
<table id="order_by_column_table">
	<thead>
	<tr>
	<th>部門</th>
	<th>合計</th>
	<th>前合計</th>
	<th>前対比</th>
	<th>同合計</th>
	<th>同対比</th>

	<th>クリー</th>
	<th>刻印</th>
	<th>リング</th>
	<th>ネック</th>
	<th>その他</th>
	<th>ペア</th>
	</tr>
	</thead>
<tbody>
<?php
foreach($ranking_store as $section_name=>$value){
	$section_name = str_replace('Anniversary', 'An', $section_name);
	$section_name = str_replace('by THE KISS OUTLET', 'OUTLET', $section_name);
	$section_name = str_replace('by THE KISS SELECTION', 'SELECT', $section_name);
	foreach($value as $key_name=>$amount){
		echo '<tr>';
		echo '<td>'.$section_name.'</td>';
		echo '<td>'.$amount['full_amount'].'</td>';
		echo '<td>'.$amount['prev_amount'].'</td>';
		echo '<td>'.$amount['prev_percent'].'%</td>';
		echo '<td>'.$amount['year_amount'].'</td>';
		echo '<td>'.$amount['year_percent'].'%</td>';
		echo '<td>'.$amount['cleaningkit_percent'].'%</td>';
		echo '<td>'.$amount['kokuin_percent'].'%</td>';
		echo '<td>'.$amount['ring_percent'].'%</td>';
		echo '<td>'.$amount['neck_percent'].'%</td>';
		echo '<td>'.$amount['other_percent'].'%</td>';
		echo '<td>'.$amount['pair_percent'].'%</td>';
		echo '</tr>';
	}
}
?>
</tbody>
</table>
</div>
<?php
$script = 'new OrderByColumn( "order_by_column_table", ["string","number","number","number","number","number","number","number","number","number","number","number"] );';
echo $javascript->codeBlock($script);
?>