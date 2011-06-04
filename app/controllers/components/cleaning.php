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
		$section_name = str_replace('MACAU', 'MC', $section_name);
		$section_name = str_replace('KOREA', 'KR', $section_name);
		$section_name = str_replace('KOREA', 'KR', $section_name);
		$section_name = str_replace('イオンモール', 'イオン', $section_name);
		
        return $section_name;
    }

	function factoryName($factory_name){
		$factory_name = str_replace('株式会社', '', $factory_name);
		$factory_name = str_replace('有限会社', '', $factory_name);
		return $factory_name;
	}

}
?>