<?php
class ItemImage extends AppModel {

	var $name = 'ItemImage';
	var $belongsTo = array('Item'=> array('className'=>'Item'));
	
	var $validate = array (
		'upload_file' => array (
			'valid_upload' => array (
				'rule' => array('validateUploadedFile', false),
				'message' => 'An error occurred whilst uploading'
			),
		),
	);

	
		/**
	* Custom validation rule for uploaded files.
	*
	*  @param Array $data CakePHP File info.
	*  @param Boolean $required Is this field required?
	*  @return Boolean
	*/
	/*
	function find() {
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);
		}
		$parent = get_parent_class($this);
		return call_user_func_array(array($parent, __FUNCTION__), $args);
	}
	*/
	function validateUploadedFile($data, $required = false) {
		$upload_info = array_shift($data);

		// No file uploaded.
		if ($required && $upload_info['size'] == 0) {
			return false;
		}

		// Check for Basic PHP file errors.
		if ($upload_info['error'] !== 0) {
			return false;
		}

		// Finally, use PHP’s own file validation method.
		return is_uploaded_file($upload_info['tmp_name']);
	}
	
	
	
	
}
?>