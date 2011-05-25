<?php
//計算周りのコンポーネント
class TotalComponent extends Object {
	
	function not_chang_rank($values){
		// (id=>value)配列を受け取って、valueで昇順ソートして順位をつけた配列(id=>rank)を並び順を変えずに返す。
		$ranking = $values;
		arsort($ranking);
		$sort = array();
		$rank = 1;
		foreach($ranking as $id=>$val){
			$sort[$id] = $rank;
			$rank++;
		}
		foreach($values as $id=>$val){
			$values[$id] = $sort[$id];
		}
		return $values;
	}
	
	function fprate2($value , $mark){
		//Floating point rate 2 浮動小数点の率で小数点第2位まで返す
		//例えば、 $value=実績 , $mark=目標
		App::import('Helper', 'Number');
   		$NumberHelper = new NumberHelper();
   		if(empty($value) OR empty($mark)){
   			return '0%';
   		}else{
   			return $NumberHelper->precision(($value / $mark) * 100, 2).'%';
   		}
	}
	
    function slipTotal($subitems, $tax_method, $tax_fraction){
    	/*伝票単位の計算関数
    	*合計金額を計算して返す。
    	*$subitems、連想配列（キー＝＞（money=>金額、quantity=>数量）
    	*
		*/
    	$total = 0;//合計金額
    	$detail_total = 0;//明細合計
    	$tax = 0;//消費税
    	if($tax_method == '1' or empty($tax_method)){//伝票単位またはNULL
    		foreach($subitems as $subitem){
    			$detail_total = $detail_total + ($subitem['money'] * $subitem['quantity']);
    		}
    		$tax = $detail_total * TAX_RATE / 100;
    		if($tax_fraction == '1' or empty($tax_fraction)) $tax = floor($tax);//消費税、切り捨て
    		if($tax_fraction == '2') $tax = ceil($tax);//消費税、切り上げ
    		if($tax_fraction == '3') $tax = round($tax);//消費税、四捨五入
    		$result['total'] = $detail_total + $tax;
    		$result['detail_total'] = $detail_total;
    		$result['tax'] = $tax;
    		return $result;
    	}
    	if($tax_method == '2'){//明細単位
    		foreach($subitems as $subitem){
    			$detail_tax = ($subitem['money'] * $subitem['quantity']) * TAX_RATE / 100;
    			if($tax_fraction == '1' or empty($tax_fraction)) $detail_tax = floor($detail_tax);
    			if($tax_fraction == '2') $detail_tax = ceil($detail_tax);
    			if($tax_fraction == '3') $detail_tax = round($detail_tax);
    			$detail_total = $detail_total + ($subitem['money'] * $subitem['quantity'] + $detail_tax);
    			$tax = $tax + $detail_tax;
    		}
    		$result['total'] = $detail_total + $tax;
    		$result['detail_total'] = $detail_total;
    		$result['tax'] = $tax;
    		return $result;
    	}
    	if($tax_method == '3'){//単品単位
    		foreach($subitems as $subitem){
    			$single_tax = $subitem['money'] * TAX_RATE / 100;
    			if($tax_fraction == '1' or empty($tax_fraction)) $single_tax = floor($single_tax);
    			if($tax_fraction == '2') $single_tax = ceil($single_tax);
    			if($tax_fraction == '3') $single_tax = round($single_tax);
    			//$detail_total = $detail_total + (($subitem['money'] + $single_tax) * $subitem['quantity']);
    			$detail_total = $detail_total + ($subitem['money'] * $subitem['quantity']);
    			$tax = $tax + ($single_tax * $subitem['quantity']);
    		}
    		$result['total'] = $detail_total + $tax;
    		$result['detail_total'] = $detail_total;
    		$result['tax'] = $tax;
    		return $result;
    	}
    	if($tax_method == '4'){//請求単位、伝票単位計算関数では消費税の計算をしない
    		foreach($subitems as $subitem){
    			$detail_total = $detail_total + ($subitem['money'] * $subitem['quantity']);
    		}
    		$result['total'] = $detail_total;
    		$result['detail_total'] = $detail_total;
    		$result['tax'] = 'By Monthly Bill';
    		return $result;
    	}
		return false;
    }

    function rate_cal($rate_fraction, $rate, $price, $percent_code){
    	if($percent_code == 2) return $price;
		if(empty($rate)) return $price;
		$result = ($price * $rate) / 10000;
		if($rate_fraction == '1' or empty($rate_fraction)) $result = floor($result);
    	if($rate_fraction == '2') $result = ceil($result);
    	if($rate_fraction == '3') $result = round($result);
    	return $result;
    }

    //単品単位で消費税を計算。売上計上区分が経費の場合は消費税を計算しない。端数は切り捨て。
    function single_tax($price, $subitem_id){
    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	$params = array(
			'conditions'=>array('Subitem.id'=>$subitem_id),
			'recursive'=>0,
		);
		$subitem = $SubitemModel->find('first' ,$params);
		if($subitem['Item']['sales_sum_code'] == 2){
			return 0;
		}else{
			$tax = $price * TAX_RATE / 100;
			$tax = floor($tax);
			return $tax;
		}
    }

	// 整形後のdiscountとadjustment、割引と調整を再計算したprice、の三つを返す
	function PriceCalculation($price, $discount, $adjustment){
		if(empty($price)) $price = 0; //親品番マスタの価格が入ってなかった場合は0を入れる。これは仕様的に、これでいいのだろうか。
		if(!empty($discount) and $price >= 1 ){
			$discount = mb_convert_kana($discount, 'a', 'UTF-8');
			$discount = ereg_replace("[^0-9]", "", $discount);//半角数字以外を削除
			$discount = '0.'.sprintf('%02d', $discount);//2桁に合わせる、1桁の場合は先頭を0で埋める
			$price = $price - ($price * $discount);
		}else{
			$discount = '';
		}
		if(!empty($adjustment)){
			$adjustment = mb_convert_kana($adjustment, 'a', 'UTF-8');
			$adjustment = ereg_replace("[^0-9\-]", "", $adjustment);//半角数字とハイフン以外削除
			$price = $price + $adjustment;
		}else{
			$adjustment = '';
		}
		$out['price'] = $price;
		$out['discount'] = $discount;
		$out['adjustment'] = $adjustment;
		return $out;
	}



}

?>