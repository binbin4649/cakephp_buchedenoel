<?php

class JanCodeComponent extends Object {

    function janGenerator($brand_id,$item_name,$major_size,$minority_size){
    	/*
    	*JANコードを生成して返す
    	*頭から2桁、ブランドコード
    	*頭から3～7桁、親品番の数字だけを抜き出し、5桁以下なら前に0を追加、5桁以上なら親品番数字の後ろから切り詰める
    	*頭から8～10桁、ただの連番
    	*頭から11～12桁、サイズの数字だけを抜き出したもの
    	*13桁目、チェックデジット
    	*
		*/
    	$Model = 'Subitem';
    	App::import('Model', $Model);
    	$SubitemModel = new $Model();

		$brand_id = sprintf('%02d', $brand_id);
    	$brand_id = substr($brand_id, 0, 2);
    	$item_int = mb_ereg_replace("[^0-9]","", $item_name);
    	$item_int = sprintf('%05d', $item_int);
    	$item_int = substr($item_int, 0, 5);
    	if(empty($major_size) or $major_size == 'other'){
    		if(!empty($minority_size)){
    			$minority_size = mb_ereg_replace("[^0-9]","", $minority_size);
    			$minority_size = sprintf('%02d', $minority_size);
				$size = substr($minority_size, 0, 2);
    		}else{
    			$size = '00';
    		}
    	}else{
    		$major_size = mb_ereg_replace("[^0-9]","", $major_size);
    		$major_size = sprintf('%02d', $major_size);
    		$size = substr($major_size, 0, 2);
    	}

    	$renban = '001';
		while($renban < 1000){
			$jan_code12 = $brand_id.$item_int.$renban.$size;
			$jan_code13 = check_digit($jan_code12);
			$params = array(
				'conditions'=>array('Subitem.jan'=>$jan_code13),
				'recursive'=>0
			);
			$count = $SubitemModel->find('count', $params);
			if($count == 0){
				return $jan_code13;
			}
			$renban++;
			$renban = sprintf('%03d', $renban);
		}
		return false;
    }

}

	function check_digit($jan_code12){
		$jan_splits = str_split($jan_code12);
		$math_counter = 0;
		$a_jan = 0;
		$b_jan = 0;
		for($i=0 ; $i < 12 ; $i++){
			if($math_counter == 0){
				$s_jan = array_shift($jan_splits);
				$a_jan = $a_jan + $s_jan;
				$math_counter = 1;
			}else{
				$s_jan = array_shift($jan_splits);
				$b_jan = $b_jan + $s_jan;
				$math_counter = 0;
			}
		}
		$c_jan = ($b_jan * 3 + $a_jan) % 10;
		$check_jan = (10 - $c_jan) % 10;
		$jan_code = $jan_code12.$check_jan;
		return $jan_code;
	}

?>