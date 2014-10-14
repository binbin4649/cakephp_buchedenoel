<?php
class AddFormHelper extends AppHelper{
	//var $helpers = array('Html');

	function tagTagTable($tags, $checked){//商品分類タグを3列のテーブルで出力
		$out = '<table class="tagtag">';
		$out .= '<tr><th colspan="3">Tag</th></tr>';
		$counter = 0;
		foreach($tags as $key=>$value){
			$counter++;
			if($counter == 1){
				$out .= '<tr>';
			}
			$out .= '<td>';
			$out .= '<input type="checkbox" name="data[Tag][Tag][]" ';
			if(isset($checked)){
				foreach($checked as $check_id){
					if($check_id['id'] == $key){
						$out .= ' checked="checked" ';
					}
				}
			}
			$out .= 'value="'.$key.'" id="TagTag'.$key.'" /><label for="TagTag'.$key.'">'.$value.'</label>';
			$out .= '</td>';
			if($counter == 3){
				$out .= '</tr>';
				$counter = 0;
			}
		}
		if($counter == 1){
			$out .= '<td></td><td></td></tr>';
		}elseif($counter == 2){
			$out .= '<td></td></tr>';
		}
		$out .= '</table>';
		return $out;
	}

	function mainImageTable($itemimage, $checked){//メイン画像を選択する、ラジオボタン付きのテーブルを出力
		$out = '<table class="itemimage">';
		//$out .= '<tr><th colspan="2">Item Image</th></tr>';
		$out .= '<tr><th>Item Image</th><th>Default</th></tr>';
		foreach($itemimage as $image){
			$out .= '<tr><td>';
			//$out .= $html->image('/img/itemimage/'.$image['id'].'.jpg', array('width'=>75, 'height'=>75));
			$out .= '<img src="/'.SITE_DIR.'/img/itemimage/'.$image['ItemImage']['id'].'.jpg" width="75" height="75">';
			$out .= '</td><td>';
			if($image['ItemImage']['id'] == $checked){
				$out .= '<input type="radio" value="'.$image['ItemImage']['id'].'" name="data[Item][itemimage_id]" checked>';
			}else{
				$out .= '<input type="radio" value="'.$image['ItemImage']['id'].'" name="data[Item][itemimage_id]">';
			}
			$out .= '</td></tr>';
		}
		$out .= '</table>';
		return $out;

	}

	function switchAnchor($url, $closes, $messe, $links, $status){
		/*
		 * $url, コントローラー、アクション、IDを含めたURL
		 * $close, アンカーを無効にするコード集。配列。
		 * $messe, ダイアログに表示されるメッセージ。
		 * $links,リンクに表示される文字列。英語で。
		 * $status,引き渡されるステータスのコード。又は現在のステータスコード。又はコントロールするためのコード
		 *
		 * closesに指定がない場合はオープンする
		 */
		foreach($closes as $close){
			if($close == $status){
				return '<div class="disabled">'.__($links, true).'</div>';
			}
		}
		if(!empty($messe)){
			$out = '<a href="/'.SITE_DIR.'/'.$url.'" onclick="return confirm(&#039;';
			$out .= __($messe, true).'&#039;);">'.__($links, true).'</a>';
			return $out;
		}
		return '<a href="/'.SITE_DIR.'/'.$url.'">'.__($links, true).'</a>';
	}

	function opneAnchor($url, $opnes, $messe, $links, $params){
		/*
		 * スイッチアンカーのオープン版
		 * オープン配列とパラメーター配列が一致したときオープンにする
		 * 第2引数の配列にオープン対象になる配列を入れる
		 * 第5引数に対象の配列を入れる
		 */
		foreach($prams as $param){
			foreach($opnes as $opne){
				if($param == $opne){
					if(!empty($messe)){
						$out = '<a href="/'.SITE_DIR.'/'.$url.'" onclick="return confirm(&#039;';
						$out .= __($messe, true).'&#039;);">'.__($links, true).'</a>';
						return $out;
					}
					return '<a href="/'.SITE_DIR.'/'.$url.'">'.__($links, true).'</a>';
				}
			}
		}
		return '<div class="disabled">'.__($links, true).'</div>';
	}

	function opneUser($opnes, $user, $column){
		/*
		 *opnes　配列
		 *user　１DB一式
		 *column　判定に使われるDBのカラム
		 *opnesの条件にuserが一致したらtrue。ただし例外もあり。adminとか
		 */
		if($user['User']['username'] == 'admin'){
			return true;
		}
		foreach($opnes as $opne){
			if($opne == $user['User'][$column]){
				return true;
			}
		}
		return false;
	}





}


?>