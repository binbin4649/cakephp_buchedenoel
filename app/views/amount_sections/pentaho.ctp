<h3>Pentaho</h3>
<p>右クリック、「名前を付けて保存」、でダウンロードしてからエクセルで開いてください。</p>
<p>
<?php
 $mod = filemtime('/var/www/html/'.SITE_DIR.'/app/webroot/files/pentaho/nyukin_date.xls');
 echo "最終更新日：".date("Y/m/d H:i",$mod);
?>
</p>
<?php
echo '<ul>';
foreach($old_file as $value){
	echo '<li><a href="/'.SITE_DIR.'/files/pentaho/'.$value.'" target="_blank">'.$value.'</a></li>';
}
echo '</ul>';
?>
<br>
<p>
	毎日18時30分、23時50分に更新されます。<br>
	先月のデータも、変更があれば最新のデータに更新されます。
</p>

<p>
<strong>maeukezan.xls</strong><br>
今日現在の前受金残。<br>
未お渡し客注の一覧。ただし、前受金0円の客注は含まれない。
</p>

<p>
<strong>zenhi.xls</strong><br>
前比データ。12シート。<br>
今日、今月、今週の前年との比較データ。<br>
既存店だけのデータ、客数、点数の比較データもあり。
</p>
<p>
<strong>month.xls</strong><br>
今月の売上データ。3シート。<br>
時間帯別、年代別、需要別の売上。在庫上代、在庫数量、入出庫上代、入出庫数量などもあり。<br>
シート別で、個人別、ブランド別の売上集計もあり。
</p>

<p>
<strong>daily.xls</strong><br>
month.xlsの今日のみ集計バージョン。<br>
</p>

<p>
<strong>uriage_base_month.xls</strong><br>
売上ベースで、今月1日～当日集計時間までの数字。<br>
前年の数字は、前年当日の1日の数字が入っていますので、18時30分の集計では前比が悪くでます。
</p>
<p>
<strong>uriage_base_dairy.xls</strong><br>
売上ベースの、今日と前年当日だけの1日の比較。
</p>
<p>
<strong>nyukin_base_month.xls</strong><br>
入金ベースで、今月1日～当日集計時間までの数字。
</p>
<p>
<strong>nyukin_base_dairy.xls</strong><br>
入金ベースの、今日と前年当日だけの1日の比較。
</p>
<p>
	<strong>prev_month_bumon.xls</strong><br>
	先月の部門別集計。（デイリーレポートのmonth.salesと同じ内容）
</p>
<p>
	<strong>prev_month_brand.xls</strong><br>
	先月のブランド別集計。（デイリーレポートのmonth.brandと同じ内容）
</p>
<p>
	<strong>nyukin_date.xls</strong><br>
	先月1日から昨日までの、部門別、日付別の入金データ。
</p>
<p>
	<strong>nyukin_meisai2004.xls</strong><br>
	先月1日から昨日までの、入金ベースの売上データ。<br>
	～2004年までにオープンした店舗が対象。<br>
	0001,THE KISS名古屋ロフト<br>
	0002,THE KISS池袋アルタ<br>
	0004,THE KISS大宮ロフト<br>
	0005,THE KISS船橋ロフト<br>
	0006,THE KISS渋谷ロフト<br>
	0007,THE KISS吉祥寺ロフト<br>
	0009,THE KISS新宿アルタ<br>
	0013,THE KISS横浜ロフト<br>
	0020,THE KISS京都ロフト<br>
	0021,THE KISS北九州リバーウォーク<br>
	0023,THE KISS広島本通<br>
	0025,THE KISS 梅田ロフト<br>
	0028,THE KISS 仙台ロフト<br>
	0014,THE KISSお台場メディアージュ<br>
	0019,THE KISSららぽーとTOKYO-BAY<br>
	0003,Two of usアピタ知立<br>
	0012,THE KISS 神戸阪急<br>
	0015,THE KISS新潟アルタ<br>
	0022,THE KISS 東京ドームラクーア<br>
	0024,THE KISS 近鉄パッセ<br>
	0008,THE KISS天神インキューブ<br>
</p>
<p>
	<strong>nyukin_meisai2004-2008.xls</strong><br>
	先月1日から昨日までの、入金ベースの売上データ。<br>
	2004～2008年までにオープンした店舗が対象。<br>
	0029,THE KISS 広島府中<br>
	0031,THE KISS熊本上通り<br>
	0032,THE KISSアミュプラザ鹿児島<br>
	0033,THE KISSさいたまコクーン<br>
	0038,THE KISS福岡キャナルシティ<br>
	0039,THE KISS 千葉オーロラモールジュンヌ店<br>
	0042,THE KISS名古屋パルコ<br>
	0043,THE KISSラゾーナ川崎<br>
	0046,THE KISSららぽーと柏の葉<br>
	0047,THE KISS渋谷パルコ<br>
	0048,THE KISS静岡パルコ<br>
	0202,THE KISS Anniversary 金沢フォーラス<br>
	0036,THE KISS梅田コムサストア<br>
	0044,THE KISSららぽーと豊洲<br>
	0049,THE KISS立川モディ<br>
	0201,Anniversary お台場メディアージュ<br>
	0203,THE KISS Anniversaryららぽーと横浜店<br>
	0204,THE KISS Anniversaryそごう横浜<br>
	0205,THE KISS 池袋西武<br>
	0601,by THE KISS OUTLET マリノアシティ福岡<br>
	0301,Two of us イオンモール高崎<br>
	0306,by THE KISS SELECTION エミフルＭＡＳＡＫＩ<br>
	0501,Kapio スパリゾートハワイアンズ<br>
	8008,THE KISS大宮マルイ<br>
	0030,THE KISS札幌ロフト<br>
	0504,Ｋａｐｉｏ　お台場メディアージュ<br>
	0505,THE KISS Anniversary ららぽーとTOKYO-BAY店<br>
	0303,Two of usアピタ長久手<br>
	0304,Two of usイオンモール羽生<br>
	0016,THE KISS札幌アルタ<br>
	6600,THE KISS 北千住マルイ<br>
</p>
<p>
	<strong>nyukin_meisai2008-2013.xls</strong><br>
	先月1日から昨日までの、入金ベースの売上データ。<br>
	2008～2013年までにオープンした店舗が対象。<br>
	0052,THE KISS横浜赤レンガ倉庫<br>
	0053,THE KISSヴィーナスフォート<br>
	0054,THE KISSあべのロフト<br>
	0055,THE KISSなんばマルイ<br>
	0602,by THE KISS OUTLET 那須ガーデン<br>
	0308,by THE KISS SELECTION 越谷レイクタウン<br>
	0603,by THE KISS OUTLET  越谷レイクタウンアウトレット店<br>
	0502,立川ﾓﾃﾞｨ Kapio<br>
	6604,Kahuna小田急新宿<br>
	0208,THE KISS Anniversary 銀座サロン店<br>
	0209,THE KISS Anniversary シェラトン店<br>
	0058,THE KISS 新潟ロフト<br>
	0056,THE KISS 横浜ビブレ<br>
	0057,THE KISS あべのキューズモール<br>
	0701,via CapriキャナルシティOPA<br>
	0801,THE KISS sweets ダイバーシティ東京 プラザ店<br>
	0059,THE KISS立川ロフト<br>
	0309,toU by THE KISS　イオンモールナゴヤドーム前SC店<br>
	0210,THE KISS Anniversary 神戸三宮店<br>
</p>
<p>
	<strong>nyukin_meisai2013.xls</strong><br>
	先月1日から昨日までの、入金ベースの売上データ。<br>
	2013年以降にオープンした店舗が対象。<br>
	0302,Two of usイオンモール神戸北<br>
	0060,THE KISS 宇都宮パルコ店<br>
	0702,via Capri ヴィーナスフォート<br>
	8035,新宿マルイアネックス<br>
	0310,ｔｏＵイオンモール倉敷<br>
	0062,THEKISSマルイシティ池袋店<br>
	0311,toU by THEKISS させぼ五番街店<br>
	0703,Via capri コレットマーレみなとみらい<br>
	0802,THE KISS sweets 新潟ラブラ2店<br>
	6605,Kahuna梅田阪神<br>
	0312,toU by THE KISS 横浜ワールドポーターズ<br>
	0313,toU by THE KISS　シャミネ鳥取<br>
	0063,THE KISS　和歌山MIO<br>
	0803,THE KISS sweets アミュプラザ博多<br>
</p>
<p>
	<strong>zaiko_chosei.xls</strong><br>
	先月1日から今日までの、在庫調整の履歴。
</p>