<h3>売上CSV</h3>
<p>右クリック、「名前を付けて保存」、でダウンロードしてからエクセルで開いてください。</p>
<?php
echo '<ul>';
foreach($old_file as $value){
	echo '<li><a href="/buchedenoel/files/store_sales/'.$value.'" target="_blank">'.$value.'</a></li>';
}
echo '</ul>';
?>
