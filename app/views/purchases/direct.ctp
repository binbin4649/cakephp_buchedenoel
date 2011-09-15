<div class="transportDateils form">
<?php 
	echo $javascript->link("jquery",false);
	echo $javascript->link("thickbox",false);
	echo $form->create('Purchase', array('name'=>'form1', 'action'=>'direct'));
?>
	<fieldset>
 		<legend><?php __('Direct Purchase');?></legend>
	<?php
		//echo '<a href="/buchedenoel/depots" target="_blank">仕入倉庫</a>：';
		echo '　<a href="/buchedenoel/depots/selectid?keepThis=true&TB_iframe=true&height=400&width=550" title="倉庫選択" class="thickbox">仕入倉庫</a>';
		echo $form->input('Purchase.depot', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
			'size'=>4,
			'id'=>'InventoryDetailDepot'
		));
		echo '　JAN:';
		echo $form->input('PurchaseDetail.jan', array(
			'name'=>'input1',
			'type'=>'text',
			'maxlength'=>'13',
			'div'=>false,
			'label'=>false
		));
		echo '　　';
		echo $form->submit('Submit', array('div'=>false));
		echo '　　';
		echo $html->link('Reset', array('controller'=>'purchases', 'action'=>'direct/reset'));
		echo $form->end();
	?>
	</fieldset>
</div>
<div class="actions">
<?php
if(!empty($PurchaseDetail)):
	echo $form->create('Purchase', array('name'=>'qty', 'action'=>'direct'));
	$depot_id = '';
	$total_quantity = 0;
	echo '<table><tr><th></th><th>JAN</th><th>工場</th><th>子品番</th><th>倉庫</th><th>仕入数</th><th></th><th></th></tr>';
	$i = 1;
	while(!empty($PurchaseDetail)){
		$dateil = array_pop($PurchaseDetail);
		$key = $dateil['subitem_id'];
		$depot_id = $dateil['depot'];
		echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$dateil['subitem_jan'].'</td>';
		echo '<td>'.$dateil['factory_name'].'</td>';
		echo '<td>'.$dateil['subitem_name'].'</td>';
		echo '<td>'.$dateil['depot_name'].'</td>';
		echo '<td>'.$dateil['quantity'].'</td>';
		echo '<td>';
		echo $form->input('Purchase.Qty.'.$key, array(
			'type'=>'text',
			'size'=>1,
			'maxlength'=>3,
			'div'=>false,
			'label'=>false,
			'value'=>$dateil['quantity']
		));
		echo '</td>';
		echo '<td>'.$html->link('Del', array('controller'=>'purchases', 'action'=>'direct/del/'.$key)).'</td>';
		echo '</tr>';
		$total_quantity = $total_quantity + $dateil['quantity'];
		$i++;
	}
	echo '<tr><td colspan="4"></td><td>合計</td><td>'.$total_quantity.'</td><td></td></tr>';
	echo '<tr><td colspan="5"></td><td>'.$form->submit('Edit', array('div'=>false)).'</td><td></td></tr>';
	if(!empty($depot_id)) echo $form->hidden('Purchase.depot_id', array('value'=>$depot_id));
	echo '</table>';
	echo $form->end();
	echo $html->link(__('Buying process', true), array('controller'=>'purchases', 'action'=>'add/direct'));
	echo '　/　';
	echo $html->link(__('Return Ordering', true), array('controller'=>'purchases', 'action'=>'add/return'));
endif;
?>
</div>
<ul style="margin-top:80px;">
<li>連続入力するときは複数の工場は入力できません。いったん仕入を完了させてから次の工場を入力して下さい。</li>
<li>最初に倉庫番号を入力して下さい。連続入力時は入力値が維持されます。</li>
<li>JANコードの入力欄はフォーカスされますので、バーコード入力で連続入力が可能です。</li>
<li>数量を変更してEditボタンを押すと変更されます。</li>
<li>Resetをクリックすると全部消えます。なにかおかしくなった際にクリックして下さい。</li>
<li>Delをクリックするとその行だけ削除できますが、倉庫番号が維持されません。数量に0を入力しても削除でき倉庫番号が維持されるので、0入力をおすすめします。</li>
</ul>
<p>仕様</p>
<ul>
<li>単価に変更がある場合は、事前に変更するか、調整入力で調整して下さい。</li>
<li>納品書番号、金額、備考などは、入力が終わってから編集で入力して下さい、</li>
<li>発注入力からの返品は在庫が無いとできませんが、直接仕入の画面（この画面）からは在庫が無くても返品が可能です。</li>
</ul>