<h3>売上CSV</h3>
<p>右クリック、「名前を付けて保存」、でダウンロードしてからエクセルで開いてください。</p>
<?php
echo '<ul>';
foreach($old_file as $value){
	echo '<li><a href="/buchedenoel/files/store_sales/'.$value.'" target="_blank">'.$value.'</a></li>';
}
echo '</ul>';
?>
<ul>
	<li>表に載るのは、営業店舗だけ。close は含まれない。</li>
	<li>店舗の営業開始日で新店かどうかを判断している。その基準日はシステムに直接入力されている。</li>
	<li>昨年の全店合計は店舗の営業開始日を基準に集計している。入力されていない場合、昨年の金額に含まれてこない。</li>
</ul>