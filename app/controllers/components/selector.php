<?php

class SelectorComponent extends Object {

    function sizeSelector($major_size, $minority_size){

		if(empty($major_size) or $major_size == 'other'){
    		if(!empty($minority_size)){
				$size = $minority_size;
    		}else{
    			$size = NULL;
    		}
    	}else{
    		$size = $major_size;
    	}
    	return $size;
    }

	function costSelector($item_id, $subitem_cost){
		App::import('Model', 'Item');
    	$ItemModel = new Item();
		if(!empty($subitem_cost)){
			return $subitem_cost;
		}else{
			$params = array(
				'conditions'=>array('Item.id'=>$item_id),
				'recursive'=>0
			);
			$item = $ItemModel->find('first' ,$params);
			return $item['Item']['cost'];
		}
	}






}

?>