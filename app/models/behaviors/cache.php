<?php
class CacheBehavior extends ModelBehavior {
	static $cacheData = array();
	var $enabled = true;
	function setup(&$model, $config = array()) {}
	/**
	 * メソッドキャッシュ
	 */
	function cacheMethod(&$model, $expire, $method, $args = array()){
		$this->enabled = false;
		// キャッシュキー
		$cachekey = get_class($model) . '_' . $method . '_'  . $expire . '_' . md5(serialize($args));
		// 変数キャッシュの場合
		if(!$expire){
			if (isset($this->cacheData[$cachekey])) {
				$this->enabled = true;
				return $this->cacheData[$cachekey];
			}
			$ret = call_user_func_array(array($model, $method), $args);
			$this->enabled = true;
			$this->cacheData[$cachekey] = $ret;
			return $ret;
		}
		// サーバーキャッシュの場合
		$ret = Cache::read($cachekey);
		if(!empty($ret)){
			$this->enabled = true;
			return $ret;
		}
		$ret = call_user_func_array(array($model, $method), $args);
		$this->enabled = true;
		Cache::write($cachekey, $ret, $expire);
		// クリア用にモデル毎のキャッシュキーリストを作成
		$cacheListKey = get_class($model) . '_cacheMethodList';
		$list = Cache::read($cacheListKey);
		$list[$cachekey] = 1;
		Cache::write($cacheListKey, $list);
		return $ret;
	}
	/**
	 * 再帰防止判定用
	 */
	function cacheEnabled(&$model){
		return $this->enabled;
	}
	/**
	 * キャッシュクリア
	 */
	function cacheDelete(&$model){
		$cacheListKey = get_class($model) . '_cacheMethodList';
		$list = Cache::read($cacheListKey);
		if(empty($list)) return;
		foreach($list as $key => $tmp){
			Cache::delete($key);
		}
		Cache::delete($cacheListKey);
	}
	/**
	 * 追加・変更・削除時にはキャッシュをクリア
	 */
	function afterSave(&$model, $created) {
		$this->cacheDelete($model);
	}
	function afterDelete(&$model) {
		$this->cacheDelete($model);
	}
}