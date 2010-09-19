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
				'recursive'=>0,
				'fields'=>array('Item.cost')
			);
			$item = $ItemModel->find('first' ,$params);
			return $item['Item']['cost'];
		}
	}
	
	function costSelector2($subitem_id){
		App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	$params = array(
			'conditions'=>array('Subitem.id'=>$subitem_id),
			'recursive'=>1,
			'fields'=>array('Subitem.cost')
		);
		$SubitemModel->contain('Item.cost');
		$subitem = $SubitemModel->find('first' ,$params);
		if(!empty($subitem['Subitem']['cost'])){
			return $subitem['Subitem']['cost'];
		}else{
			return $subitem['Item']['cost'];
		}
	}






}

?>