<p><a href="javascript:history.back();">戻る</a></p>
<?php
if(!empty($print)){
	echo '<br>今出力したピックリスト：<a href="'.$print['url'].'" target="_blank">'.$print['file'].'</a>';
}
echo '<h3>直営</h3>';
echo '<ul>';
foreach($old_file as $value){
	if(substr($value, 0, 6) == 'retail'){
		echo '<li><a href="/buchedenoel/files/order-picklist/'.$value.'" target="_blank">'.$value.'</a></li>';
	}
}
echo '</ul>';

echo '<h3>ホールセール</h3>';
echo '<ul>';
foreach($old_file as $value){
	if(substr($value, 0, 2) == 'ws'){
		echo '<li><a href="/buchedenoel/files/order-picklist/'.$value.'" target="_blank">'.$value.'</a></li>';
	}
}
echo '</ul>';
?>