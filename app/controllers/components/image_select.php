<?php



class ImageSelectComponent extends Object {
	
    function itemImageSelect($Item){//Itemモデルの1レコードを配列で受け取り、1：ItemImageが無かったらnoimageを入れる　2：itemimage_idが無かったら入れて返す
    	$Model = 'ItemImage';
    	App::import('Model', $Model);
    	$itemImageModel = new $Model();
    	
    	if(empty($Item['Item']['itemimage_id'])){
    		$params = array(
				'conditions'=>array('ItemImage.item_id'=>$Item['Item']['id']),
				'recursive'=>0
			);
			$count = $itemImageModel->find('count', $params);
    	if($count == 0){
				$Item['Item']['itemimage_id'] = 'noimage';
			}else{
				$params = array(
					'conditions'=>array('ItemImage.item_id'=>$Item['Item']['id']),
					'recursive'=>0,
					'fields'=>array('ItemImage.id')
				);
				$first_image = $itemImageModel->find('first' ,$params);
				$Item['Item']['itemimage_id'] = $first_image['ItemImage']['id'];
			}
    	}
    	
        return $Item;
    }
    
    
    
}
?>