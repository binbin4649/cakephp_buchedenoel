<?php
class ImageValidationComponent extends Object {
    /**
     * 

     */
    function jpgAndMaxSize($upload_file){
    	$type_result = false;
    	$size_result = false;
    	$result = false;
    	
    	if($upload_file['type'] == 'image/pjpeg') $type_result = true;
    	if($upload_file['type'] == 'image/jpeg') $type_result = true;
    	if($upload_file['size'] < 300000) $size_result = true;
    	
    	if($type_result == true AND $size_result == true ) $result = true;
        return $result;
    }
}
?>