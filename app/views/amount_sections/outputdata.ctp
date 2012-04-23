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
	<li>現在の基準日：<b><?php echo NEW_SHOP_FLAG; ?></b> | 基準日より新しければ新店、古ければ既存店。</li>
	<li>昨年の全店合計は店舗の営業開始日を基準に集計している。入力されていない場合、昨年の金額に含まれてこない。</li>
	<li>既存店前比の既存店とは、現在営業している店舗(closeになっていない)から新店と海外を省いた集計。</li>
	<li>全店前比の全店とは、部門分類が営業部門（店舗）かclose sectorでかつその月に１円以上売上があった部門。</li>
</ul>