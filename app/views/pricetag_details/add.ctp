<?php
	echo $javascript->link("prototype",false);
	echo $javascript->link("scriptaculous",false);
?>
<h2><?php __('Add PricetagDetail');?></h2>
<?php
	if(!empty($print)){
		echo '<p>';
		echo 'タグCSVを出力しました。右クリック「～リンク先を保存」を選択してダウンロードして下さい。<br>';
		echo '<a href="'.$print['url'].'" target="_blank">'.$print['file'].'</a>';
		echo '</p>';
	}
?>
<div class="form">
	<fieldset>
 	<?php
 	echo $form->create('PricetagDetail');
 	echo '品番：';
	echo $ajax->autocomplete('AutoItemName',"getData",array());
	echo $form->hidden('step', array('value'=>'1'));
	echo '<input type="submit" value="Enter" />　';
	echo $html->link(__('Reset', true), array('action'=>'add'));
	if(!empty($subitems)){
		echo $form->create('PricetagDetail');
		echo $form->hidden('Item.name', array('value'=>$item['Item']['name']));
		echo '<table class="itemVars"><tr>';
		echo '<td>'.$item['Item']['name'].' / ￥'.$item['Item']['price'].' / '.$item['Factory']['name'];
		echo '</td></tr><tr><td>';
		foreach($subitems as $subitem){
			if(empty($subitem['Subitem']['major_size']) or $subitem['Subitem']['major_size'] == 'other'){
				if(!empty($subitem['Subitem']['minority_size'])){
					$size = $subitem['Subitem']['minority_size'];
				}
			}else{
				$size = $subitem['Subitem']['major_size'];
			}
			if(empty($size)) $size = '#';
			echo '<div class="onesize">'.$size;
			echo $form->input("subitem.".$subitem['Subitem']['id'], array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
				'size'=>1
			));
			echo '</div>';
		}
		echo $form->hidden('Section.name', array('value'=>$user['Section']['name']));
		echo $form->hidden('Section.id', array('value'=>$user['Section']['id']));
		echo $form->hidden('Item.price', array('value'=>$item['Item']['price']));
		echo $form->hidden('Factory.id', array('value'=>$item['Factory']['id']));
		echo $form->hidden('Factory.name', array('value'=>$item['Factory']['name']));
		echo $form->hidden('step', array('value'=>'2'));
		echo '<input type="submit" value="Submit" />';
		echo '</td>';
		echo '</tr></table>';
	}

	if(!empty($details)){
		echo '<table class="itemDetail"><tr><th>品番</th><th>小品番</th><th>工場</th><th>価格</th><th>数量</th><th></th></tr>';
		foreach($details as $key=>$value){
			echo '<tr>';
			echo '<td>'.$value['Item']['name'].'</td>';
			echo '<td>'.$key.'</td>';
			echo '<td>'.$value['Factory']['name'].'</td>';
			echo '<td>'.number_format($value['Item']['price']).'</td>';
			echo '<td>'.$value['Subitem']['quantity'].'</td>';
			echo '<td>'.$html->link(__('Del', true), array('action'=>'add/del/'.$value['Subitem']['id'])).'</td>';
			echo '</tr>';
		}
		echo '<tr><td></td><td></td><td></td><td>合計</td><td></td>';
		echo '<td>'.$html->link(__('AllDelete', true), array('action'=>'add/alldel/')).'</td></tr>';
		echo '</table>';
		if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
			echo '<p>'.$html->link(__('Output CSV Data', true), array('action'=>'add/csv/'), null, sprintf(__('CSV tag is output. Are you sure?', true), null)).'</p>';
		}else{
			echo '<p>'.$html->link(__('Be Ordering', true), array('action'=>'add/ordering/'), null, sprintf(__('Tags to the items of the order. Are you sure?', true), null)).'</p>';
		}


	}
	?>
	</fieldset>
</div>