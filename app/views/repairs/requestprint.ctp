<?php
if(!empty($print)){
	echo '<br>工場依頼書：<a href="'.$print['url'].'" target="_blank">'.$print['file'].'</a>';
}
echo '<h3>Request List Old</h3>';
echo '<ul>';
foreach($old_file as $value){
	echo '<li><a href="/buchedenoel/files/repair-request/'.$value.'" target="_blank">'.substr($value, 0, 30).'</a></li>';
}
echo '</ul>'
?>