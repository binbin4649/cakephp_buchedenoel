<?php

class CleaningComponent extends Object {

	//部門名を短縮形に変える
    function sectionName($section_name){
    	$section_name = trim($section_name);
		$section_name = str_replace('Anniversary', 'an', $section_name);
		$section_name = str_replace('by THE KISS OUTLET', 'outlet', $section_name);
		$section_name = str_replace('by THE KISS SELECTION', 'select', $section_name);
		$section_name = str_replace('THE KISS', '', $section_name);
		$section_name = str_replace('Ａｎｎｉｖｅｒｓａｒｙ', 'an', $section_name);
		$section_name = str_replace('Two of us', '', $section_name);
		$section_name = str_replace('Kapio', 'kp', $section_name);
		$section_name = str_replace('Ｋａｐｉｏ', 'kp', $section_name);
		$section_name = str_replace('Kahuna', 'kh', $section_name);
		//$section_name = str_replace('MACAU', 'MC', $section_name);
		//$section_name = str_replace('KOREA', 'KR', $section_name);
		//$section_name = str_replace('KOREA', 'KR', $section_name);
		$section_name = str_replace('イオンモール', 'イオン', $section_name);
		$section_name = str_replace('ららぽーと', '', $section_name);
		//ここから無理やり系
		$section_name = str_replace('MACAU girl’s talk！ MACAO', 'マカオGT', $section_name);
		$section_name = str_replace('MACAU  MACAO', 'マカオKISS', $section_name);
		$section_name = str_replace('KOREA  COEX-MALL', 'COEX', $section_name);
		$section_name = str_replace('kp　お台場メディアージュ', 'カピオお台場', $section_name);
		$section_name = str_replace('select エミフルＭＡＳＡＫＩ', 'エミフル', $section_name);
		$section_name = str_replace('an横浜店', 'らら横浜', $section_name);
		$section_name = str_replace('アミュプラザ鹿児島', 'アミュ鹿児島', $section_name);
		$section_name = str_replace('東京ドームラクーア', 'ラクーア', $section_name);
		$section_name = str_replace('ＴＯＫＹＯ－ＢＡＹ', 'ららぽーと', $section_name);
		$section_name = str_replace('千葉オーロラモールジュンヌ店', '千葉オーロラ', $section_name);
		$section_name = str_replace('an お台場メディアージュ', 'anお台場', $section_name);
		$section_name = str_replace('お台場メディアージュ', 'お台場カ', $section_name);
		$section_name = str_replace('北九州リバーウォーク', '北九州リバー', $section_name);
		$section_name = str_replace('outlet マリノアシティ福岡', 'outletマリノア', $section_name);
		$section_name = str_replace('outlet 那須ガーデン', 'outlet那須', $section_name);
		$section_name = str_replace('select 越谷レイクタウン', 'select越谷', $section_name);
		$section_name = str_replace('an 金沢フォーラス', 'an金沢', $section_name);
		$section_name = str_replace('ヴィーナスフォート', 'ヴィーナス', $section_name);
		$section_name = str_replace('福岡キャナルシティ', '福岡キャナル', $section_name);
		$section_name = str_replace('天神インキューブ', '天神インキュ', $section_name);
		$section_name = str_replace('梅田コムサストア', '梅田コムサ', $section_name);
		$section_name = str_replace('横浜赤レンガ倉庫', '横浜赤レンガ', $section_name);
		$section_name = str_replace('越谷レイクタウンアウトレット店', '越谷アウトレット', $section_name);
        return $section_name;
    }

	function factoryName($factory_name){
		$factory_name = str_replace('株式会社', '', $factory_name);
		$factory_name = str_replace('有限会社', '', $factory_name);
		return $factory_name;
	}

}
?>