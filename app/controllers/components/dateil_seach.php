<?php

class DateilSeachComponent extends Object {

    function dateSqlArray($date_array){

    	$date = $date_array['year'];
		if(!empty($date_array['month'])){
			$date .= '-'.$date_array['month'];
		}else{
			$date .= '-01';
		}
		if(!empty($date_array['day'])){
			$date .= '-'.$date_array['day'];
		}else{
			$date .= '-01';
		}

        return $date;
    }

    function printXML($items, $file_name){
    	$print_logo = file(WWW_ROOT.'/img/print-logo.jpg');
    	$print_logo = implode(null, $print_logo);
    	$page_counter = 1;
    	$page = 1;
    	$rect_x = 105;
    	$rect_y = 100;
    	$xml = '<?php header("Content-type: application/pxd; charset=UTF-8"); '."\n";
    	$xml .= 'header("Content-Disposition:inline;filename=\"'.$file_name.'.pxd\""); '."\n";
    	$xml .= 'print \'<?xml version="1.0" encoding="utf-8"?>\'; ?>'."\n";
    	$xml .= '<pxd paper-type="a4" title="[THE KISS Inc.] Catalog" xmlns:xlink="http://www.w3.org/1999/xlink">';

    	foreach($items as $item){
    		$image = file(WWW_ROOT.'/img/itemimage/'.$item['Item']['itemimage_id'].'.jpg');
    		$image = implode(null, $image);
    		//$image_path = WWW_ROOT.'/img/itemimage/'.$item['Item']['itemimage_id'].'.jpg';
    		//$image_path = fileExistsInPath('/img/itemimage/'.$item['Item']['itemimage_id'].'.jpg');
    		if($page_counter == 1){
    			$xml .= '<page>';
    			$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">';
    		}

    		$image_x = $rect_x + 5;
    		$image_y = $rect_y + 7;
    		$text_x = $rect_x + 12;
    		$text_y = $rect_y + 318;
    		$text2_x = $rect_x + 12;
    		$text2_y = $rect_y + 352;
    		$text2_5x = $rect_x + 118;
    		$text2_5y = $rect_y + 352;
    		$text3_x = $rect_x + 12;
    		$text3_y = $rect_y + 384;
    		/*
    		if($item['Item']['sales_state_code_id'] == 3){
    			$fill = '#cccccc';
    			$fill_opacity = '0.3';
    		}else{
    			$fill = 'none';
    			$fill_opacity = '0';
    		}
    		*/
    	if(!empty($item['Item']['title'])){
    			$item['Item']['title'] = mb_substr($item['Item']['title'], 0, 11);
    			$item['Item']['title'] = str_replace('&', '＆', $item['Item']['title']);
    		}else{
    			$item['Item']['title'] = '';
    		}
    		if(!empty($item['Item']['basic_size'])){
    			$item['Item']['basic_size'] = mb_substr($item['Item']['basic_size'], 0, 10);
    			$item['Item']['basic_size'] = str_replace('&', '＆', $item['Item']['basic_size']);
    		}else{
    			$item['Item']['basic_size'] = '';
    		}

    		$xml .= '<image x="'.$image_x.'" y="'.$image_y.'" width="280" height="280" xlink:href="data:;base64,'.base64_encode($image).'"/>';
    		$xml .= '<text x="'.$text_x.'" y="'.$text_y.'" font-size="28" fill="#333333" font-family="ＭＳ ゴシック">'.$item['Item']['name'].'</text>';
    		$xml .= '<text x="'.$text2_x.'" y="'.$text2_y.'" font-size="25" fill="#333333" font-family="ＭＳ ゴシック" letter-spacing="-1">\\'.number_format($item['Item']['price']).'</text>';
    		$xml .= '<text x="'.$text2_5x.'" y="'.$text2_5y.'" font-size="25" fill="#333333" font-family="ＭＳ ゴシック" letter-spacing="-1">'.$item['Item']['basic_size'].'</text>';
    		$xml .= '<text x="'.$text3_x.'" y="'.$text3_y.'" font-size="26" fill="#333333" font-family="ＭＳ ゴシック" letter-spacing="-1">'.$item['Item']['title'].'</text>';
    		//$xml .= '<rect x="'.$rect_x.'" y="'.$rect_y.'" width="300" height="400" stroke-width="1" stroke="#666666" fill="'.$fill.'" fill-opacity="'.$fill_opacity.'" />';
    		$xml .= '<rect x="'.$rect_x.'" y="'.$rect_y.'" width="300" height="400" stroke-width="1" stroke="#666666" fill="none" />';

    		$rect_x = $rect_x + 315;
    		if($rect_x >= 1995){
    			$rect_x = 105;
    			$rect_y = $rect_y + 440;
    		}
    		$page_counter++;

    		if($page_counter == 37){
    			$xml .= '<text x="1890" y="60" font-size="26" fill="#808080" font-family="ＭＳ ゴシック">'.date('Y/m/d').'</text>';
    			$xml .= '<text x="1990" y="2900" font-size="28" fill="#333333" font-family="ＭＳ ゴシック">'.$page.'</text>';
    			$xml .= '<image x="110" y="2790" width="1290" height="120" xlink:href="data:;base64,'.base64_encode($print_logo).'"/>';
    			$xml .= '</svg></page>';
    			$page_counter = 1;
    			$rect_x = 105;
    			$rect_y = 100;
    			$page++;
    		}
    	}
    	if($page_counter < 37 and $page_counter > 1){
    		$xml .= '<text x="1890" y="60" font-size="26" fill="#808080" font-family="ＭＳ ゴシック">'.date('Y/m/d').'</text>';
    		$xml .= '<text x="1990" y="2900" font-size="28" fill="#333333" font-family="ＭＳ ゴシック">'.$page.'</text>';
    		$xml .= '<image x="130" y="2790" width="1290" height="120" xlink:href="data:;base64,'.base64_encode($print_logo).'"/>';
    		$xml .= '</svg></page></pxd>';
    	}else{
    		$xml .= '</pxd>';
    	}
    	return $xml;
    }

	function print2XML($items, $file_name){
    	App::import('Model', 'SalesStateCode');
    	$SalesStateCodeModel = new SalesStateCode();
    	App::import('Model', 'Process');
    	$ProcessModel = new Process();
    	App::import('Model', 'Material');
    	$MaterialModel = new Material();
    	App::import('Model', 'Stone');
    	$StoneModel = new Stone();

    	$print_logo = file(WWW_ROOT.'/img/print-logo.jpg');
    	$print_logo = implode(null, $print_logo);
    	$page_counter = 1;
    	$page = 1;
    	$rect_x = 105;
    	$rect_y = 100;
    	$xml = '<?php header("Content-type: application/pxd; charset=UTF-8"); '."\n";
    	$xml .= 'header("Content-Disposition:inline;filename=\"'.$file_name.'.pxd\""); '."\n";
    	$xml .= 'print \'<?xml version="1.0" encoding="utf-8"?>\'; ?>'."\n";
    	$xml .= '<pxd paper-type="a4" title="[THE KISS Inc.] Catalog" xmlns:xlink="http://www.w3.org/1999/xlink">'."\n";

    	foreach($items as $item){
    		$image = file(WWW_ROOT.'/img/itemimage/'.$item['Item']['itemimage_id'].'.jpg');
    		$image = implode(null, $image);
    		if($page_counter == 1){
    			$xml .= '<page>'."\n";
    			$xml .= '<svg x="0" y="0" width="21cm" height="29.7cm" viewBox="0 0 2100 2970">'."\n";
    		}

    		$image_x = $rect_x + 7;
    		$image_y = $rect_y + 9;
    		$text_x = $rect_x + 310;//品番
    		$text_y = $rect_y + 45;
    		$text2_x = $rect_x + 760;//金額
    		$text2_y = $rect_y + 45;
    		$text3_x = $rect_x + 310;//タイトル、販売状況
    		$text3_y = $rect_y + 103;
    		$text4_x = $rect_x + 310;//基本サイズ、客注サイズ、サイズ直し可否
    		$text4_y = $rect_y + 163;
    		$text5_x = $rect_x + 310;//素材、加工、石
    		$text5_y = $rect_y + 222;
    		$text6_x = $rect_x + 175;//メッセージ
    		$text6_y = $rect_y + 265;
    		$text7_x = $rect_x + 175;//メッセージ ja
    		$text7_y = $rect_y + 285;

    		$line_x1 = $rect_x + 300;
    		$line_y = $rect_y + 53;
    		$line_x2 = $rect_x + 910;
    		$line2_y = $rect_y + 113;
    		$line3_y = $rect_y + 175;
    		$line4_y = $rect_y + 232;

    		if(!empty($item['Item']['title'])){
    			$item['Item']['title'] = mb_substr($item['Item']['title'], 0, 11);
    			$item['Item']['title'] = str_replace('&', '＆', $item['Item']['title']);
    		}else{
    			$item['Item']['title'] = '';
    		}
    		if(!empty($item['Item']['basic_size'])){
    			$item['Item']['basic_size'] = mb_substr($item['Item']['basic_size'], 0, 10);
    			$item['Item']['basic_size'] = str_replace('&', '＆', $item['Item']['basic_size']);
    		}else{
    			$item['Item']['basic_size'] = '';
    		}
    		if(!empty($item['Item']['order_size'])){
    			$item['Item']['order_size'] = mb_substr($item['Item']['order_size'], 0, 12);
    			$item['Item']['order_size'] = str_replace('&', '＆', $item['Item']['order_size']);
    		}else{
    			$item['Item']['order_size'] = '';
    		}

    		$SalesStateCode_text = '';
    		if(!empty($item['Item']['sales_state_code_id'])){
    			/*
    			if($item['Item']['sales_state_code_id'] == 3){
    				$fill = '#cccccc';
    				$fill_opacity = '0.3';
    			}else{
    				$fill = 'none';
    				$fill_opacity = '0';
    			}
    			*/
    			$params = array(
					'conditions'=>array('SalesStateCode.id'=>$item['Item']['sales_state_code_id']),
					'recursive'=>0,
					'fields'=>array('SalesStateCode.name')
				);
				$SalesStateCode = $SalesStateCodeModel->find('first' ,$params);
				$SalesStateCode_text = ' ('.$SalesStateCode['SalesStateCode']['name'].')';
    		}
    		$order_size_text = '';
    		if(!empty($item['Item']['order_size'])){
    			$order_size_text = ' ('.$item['Item']['order_size'].')';
    		}
    		$trans_approve_text = '';
    		if(!empty($item['Item']['trans_approve'])){
    			$trans_approve_text = ' ※'.$item['Item']['trans_approve'];
    		}
    		$process_text = '';
    		if(!empty($item['Item']['process_id'])){
    			$params = array(
					'conditions'=>array('Process.id'=>$item['Item']['process_id']),
					'recursive'=>0,
					'fields'=>array('Process.name')
				);
				$Process = $ProcessModel->find('first' ,$params);
				$process_text = ' / '.$Process['Process']['name'];
    		}
    		$material_text = '';
    		if(!empty($item['Item']['material_id'])){
    			$params = array(
					'conditions'=>array('Material.id'=>$item['Item']['material_id']),
					'recursive'=>0,
					'fields'=>array('Material.name')
				);
				$Material = $MaterialModel->find('first' ,$params);
				$material_text = $Material['Material']['name'];
    		}
    		$stone_text = '';
    		if(!empty($item['Item']['stone_id'])){
    			$params = array(
					'conditions'=>array('Stone.id'=>$item['Item']['stone_id']),
					'recursive'=>0,
					'fields'=>array('Stone.name')
				);
				$Stone = $StoneModel->find('first' ,$params);
				$stone_text = ' / '.$Stone['Stone']['name'];
    		}
			$text3 = $item['Item']['title'].$SalesStateCode_text;
			$text4 = $item['Item']['basic_size'].$order_size_text.$trans_approve_text;
    		$text5 = $material_text.$process_text.$stone_text;

    		$xml .= '<image x="'.$image_x.'" y="'.$image_y.'" width="280" height="280" xlink:href="data:;base64,'.base64_encode($image).'"/>."\n"';
    		$xml .= '<text x="'.$text_x.'" y="'.$text_y.'" font-size="28" fill="#333333" font-family="ＭＳ ゴシック">'.$item['Item']['name'].'</text>."\n"';
    		$xml .= '<text x="'.$text2_x.'" y="'.$text2_y.'" font-size="28" fill="#333333" font-family="ＭＳ ゴシック">\\'.number_format($item['Item']['price']).'</text>."\n"';
    		$xml .= '<text x="'.$text3_x.'" y="'.$text3_y.'" font-size="26" fill="#333333" font-family="ＭＳ ゴシック" letter-spacing="-1">'.$text3.'</text>."\n"';
    		$xml .= '<text x="'.$text4_x.'" y="'.$text4_y.'" font-size="26" fill="#333333" font-family="ＭＳ ゴシック" letter-spacing="-1">'.$text4.'</text>'."\n";
    		$xml .= '<text x="'.$text5_x.'" y="'.$text5_y.'" font-size="23" fill="#333333" font-family="ＭＳ ゴシック" letter-spacing="-1">'.$text5.'</text>'."\n";

    		$xml .= '<text x="'.$text6_x.'" y="'.$text6_y.'" font-size="18" fill="#333333" font-family="ＭＳ ゴシック" letter-spacing="-2">'.$item['Item']['message_stamp'].'</text>'."\n";
    		$xml .= '<text x="'.$text7_x.'" y="'.$text7_y.'" font-size="17" fill="#333333" font-family="ＭＳ ゴシック" letter-spacing="-2">'.$item['Item']['message_stamp_ja'].'</text>'."\n";
    		//$xml .= '<rect x="'.$rect_x.'" y="'.$rect_y.'" width="930" height="300" stroke-width="1" stroke="#666666" fill="'.$fill.'" fill-opacity="'.$fill_opacity.'" />';
    		$xml .= '<rect x="'.$rect_x.'" y="'.$rect_y.'" width="930" height="300" stroke-width="1" stroke="#666666" fill="none" />'."\n";
    		$xml .= '<line x1="'.$line_x1.'" y1="'.$line_y.'" x2="'.$line_x2.'" y2="'.$line_y.'" stroke-width="1" stroke="#e6e6e6" stroke-linecap="round" />'."\n";
    		$xml .= '<line x1="'.$line_x1.'" y1="'.$line2_y.'" x2="'.$line_x2.'" y2="'.$line2_y.'" stroke-width="1" stroke="#e6e6e6" stroke-linecap="round" />'."\n";
    		$xml .= '<line x1="'.$line_x1.'" y1="'.$line3_y.'" x2="'.$line_x2.'" y2="'.$line3_y.'" stroke-width="1" stroke="#e6e6e6" stroke-linecap="round" />'."\n";
    		$xml .= '<line x1="'.$line_x1.'" y1="'.$line4_y.'" x2="'.$line_x2.'" y2="'.$line4_y.'" stroke-width="1" stroke="#e6e6e6" stroke-linecap="round" />'."\n";

    		$rect_x = $rect_x + 945;
    		if($rect_x >= 1995){
    			$rect_x = 105;
    			$rect_y = $rect_y + 330;
    		}
    		$page_counter++;

    		if($page_counter == 17){
    			$xml .= '<text x="1890" y="60" font-size="26" fill="#808080" font-family="ＭＳ ゴシック">'.date('Y/m/d').'</text>'."\n";
    			$xml .= '<text x="1990" y="2900" font-size="28" fill="#333333" font-family="ＭＳ ゴシック">'.$page.'</text>'."\n";
    			$xml .= '<image x="110" y="2790" width="1290" height="120" xlink:href="data:;base64,'.base64_encode($print_logo).'"/>'."\n";
    			$xml .= '</svg></page>';
    			$page_counter = 1;
    			$rect_x = 105;
    			$rect_y = 100;
    			$page++;
    		}
    	}
    	if($page_counter < 17 and $page_counter > 1){
    		$xml .= '<text x="1890" y="60" font-size="26" fill="#808080" font-family="ＭＳ ゴシック">'.date('Y/m/d').'</text>'."\n";
    		$xml .= '<text x="1990" y="2900" font-size="28" fill="#333333" font-family="ＭＳ ゴシック">'.$page.'</text>'."\n";
    		$xml .= '<image x="130" y="2790" width="1290" height="120" xlink:href="data:;base64,'.base64_encode($print_logo).'"/>'."\n";
    		$xml .= '</svg></page></pxd>'."\n";
    	}else{
    		$xml .= '</pxd>';
    	}
    	return $xml;
    }






}
?>