<script type="text/javascript" charset="utf-8">
//ラインハイライト 3ライナー
$(function(){var overcells = $("table td"),hoverClass = "hover",current_r;
overcells.hover(function(){var $this = $(this);(current_r = $this.parent().children("table td")).addClass(hoverClass);},
function(){ current_r.removeClass(hoverClass);});});
</script>
<?php 
	echo $javascript->link("jquery-1.5.1.min",false);
	echo $javascript->link("jquery-ui-1.8.14.custom.min",false);
	$datetime = date("Y-m-d H:i:s",mktime());
	
?>
<div class="amountSections index">
<h2>本日の売上速報</h2>
<p> ( <?php echo $datetime; ?> ) 更新</p>
<table id="order_by_column_table" style="width:500px;">
	<thead>
	<tr>
	<th>部門</th>
	<th>合計</th>
	<th></th>
	<th></th>
	<th></th>
	<th></th>
	</tr>
	</thead>
<tbody>
<?php
$area_text = '';
foreach($today as $value){
	echo '<tr id="item-index">';
	echo '<td>'.$value['name'].'</td>';
	echo '<td>'.number_format($value['today']).'</td>';
	echo '<td></td>';
	echo '<td></td>';
	echo '<td></td>';
	echo '<td></td>';
	echo '</tr>';
	$area_text .= $value['name'].' | '.number_format($value['today'])."\n";
}
echo '<tr><td>合計</td><td>'.number_format($today['total']).'</td><td></td><td></td><td></td><td></td></tr>';
$area_text .= '合計'.' | '.number_format($today['total'])."\n";
?>
</tbody>
</table>
</div>
<div style="margin-top:30px;"></div>
<textarea rows="3" cols="30"><?php echo $area_text; ?></textarea>