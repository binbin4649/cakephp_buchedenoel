<?php
	echo $javascript->link("jquery",false);
	echo $javascript->link("thickbox",false);
	extract($this->data);
	$inventory_id =  $Inventory['id'];
	echo $html->link('棚卸番号:'.$inventory_id.'　へ戻る', array('controller'=>'inventories', 'action'=>'view', $inventory_id));
	echo '　｜　';
	echo $html->link('棚卸詳細', array('controller'=>'inventory_details', 'action'=>'index', $inventory_id));
?>
<div class="form">
<?php echo $form->create('InventoryDetail', array('name'=>'form1'));?>
<?php echo $form->hidden('Inventory.id', array('value'=>$Inventory['id'])); ?>
	<fieldset>
 		<legend>棚卸番号：<?php echo $inventory_id; ?>の、入力画面</legend>
	<?php
		if(!empty($InventoryDetail['depot_name'])){
			echo '倉庫：'.$InventoryDetail['depot_name'].':'.$InventoryDetail['depot'].'　';
			echo 'スパン：'.$InventoryDetail['span'].'　';
			echo 'フェイス：'.$InventoryDetail['face'].'　';
			echo $form->hidden('InventoryDetail.depot', array('value'=>$InventoryDetail['depot']));
			echo $form->hidden('InventoryDetail.span', array('value'=>$InventoryDetail['span']));
			echo $form->hidden('InventoryDetail.face', array('value'=>$InventoryDetail['face']));
		}else{
			echo '　<a href="/buchedenoel/depots/selectid?keepThis=true&TB_iframe=true&height=400&width=550" title="棚卸倉庫選択" class="thickbox">倉庫</a>';
			echo $form->input('InventoryDetail.depot', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
				'size'=>3,
				'maxLength'=>4,
			));
			echo '　スパン：';
			echo $form->input('InventoryDetail.span', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
				'size'=>3,
				'maxLength'=>4,
			));
			echo '　フェイス：';
			echo $form->input('InventoryDetail.face', array(
				'type'=>'text',
				'div'=>false,
				'label'=>false,
				'size'=>2,
				'maxLength'=>3,
			));
		}
		echo '　JAN:';
		echo $form->input('InventoryDetail.jan', array(
			'name'=>'input1',
			'type'=>'text',
			'maxlength'=>'13',
			'div'=>false,
			'label'=>false
		));
		echo '　　';
		echo $form->submit('Submit', array('div'=>false));
		echo '　　';
		echo $html->link('Reset', array('action'=>'reset', $this->data['Inventory']['id']));
		echo $form->end();
	?>
	</fieldset>
</div>
<div class="actions">
<?php

if(!empty($Details)):
	echo $form->create('InventoryDetail', array('name'=>'qty'));
	echo $form->hidden('Inventory.id', array('value'=>$Inventory['id']));
	echo $form->hidden('InventoryDetail.depot', array('value'=>$InventoryDetail['depot']));
	echo $form->hidden('InventoryDetail.span', array('value'=>$InventoryDetail['span']));
	echo $form->hidden('InventoryDetail.face', array('value'=>$InventoryDetail['face']));
	$total_quantity = 0;
	echo '<table><tr><th></th><th>JAN</th><th>子品番</th><th>倉庫：S：F</th><th>数量</th><th></th></tr>';
	$i = 1;
	while(!empty($Details)){
		$dateil = array_pop($Details);
		$key = $dateil['subitem_id'];
		echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$dateil['subitem_jan'].'</td>';
		echo '<td>'.$dateil['subitem_name'].'</td>';
		echo '<td>倉庫：'.$dateil['depot_id'].':S'.$dateil['span'].':F'.$dateil['face'].'</td>';
		echo '<td>'.$dateil['quantity'].'</td>';
		echo '<td>';
		echo $form->input('InventoryDetail.Qty.'.$key, array(
			'type'=>'text',
			'size'=>1,
			'maxlength'=>4,
			'div'=>false,
			'label'=>false,
			'value'=>$dateil['quantity']
		));
		echo '</td>';
		echo '</tr>';
		$total_quantity = $total_quantity + $dateil['quantity'];
		$i++;
	}
	echo '<tr><td colspan="3"></td><td>合計</td><td>'.$total_quantity.'</td><td></td></tr>';
	echo '<tr><td colspan="5"></td><td>'.$form->submit('Edit', array('div'=>false)).'</td></tr>';
	echo '</table>';
	echo $form->end();
	echo $html->link('棚卸入力', array(
		'controller'=>'inventory_details', 
		'action'=>'input'), 
		null, 
		sprintf(__(' %s 点を棚卸入力します。よろしいですか？', true), 
		$total_quantity));
endif;
?>
</div>
<ul>
<li>Reset：全部削除したい時、表示・動作が可笑しくなった時、などにクリックして下さい。直るかもしれません。</li>
<li>倉庫：倉庫番号(Id)を入力して下さい。</li>
<li>スパン・フェイス：半角数字で入力して下さい。半角数字以外は自動削除されます。</li>
</ul>