<div class="transportDateils form">
<?php echo $form->create('Sale', array('name'=>'form1'));?>
	<fieldset>
 		<legend><?php __('Sell Input');?></legend>
	<?php
		echo '倉庫：';
		if(!empty($section['Section']['out_depot'])){
			echo $sectionDepots[$section['Section']['out_depot']];
			echo $form->hidden('Sale.depot', array('value'=>$section['Section']['out_depot']));
		}else{
			echo $form->input('Sale.depot', array(
			'type'=>'select',
				'options'=>$sectionDepots,
				'div'=>false,
				'value'=>$section['Section']['default_depot'],
				'label'=>false
			));
		}
		echo '　JAN:';
		echo $form->input('Sale.subitem_jan', array(
			'name'=>'input1',
			'type'=>'text',
			'maxlength'=>'13',
			'div'=>false,
			'label'=>false
		));
		echo '　　';
		echo $form->submit('Submit', array('div'=>false));
		echo '　　';
		echo $html->link('Reset', array('controller'=>'sales', 'action'=>'add/reset'));
		echo $form->end();
	?>
	</fieldset>
</div>
<div class="actions form">
<?php
if(!empty($subitems)):
	$total_quantity = 0;
	$total_price = 0;
	echo $form->create('SaleDateil' ,array('url'=> array('controller'=>'sales', 'action'=>'add')));
	
	echo '<table><tr><th>子品番</th><th>金額</th><th>倉庫</th><th>スパン</th><th>割引</th><th>調整</th><th>備考</th><th>数量</th><th></th></tr>';
	foreach($subitems as $key=>$dateil){
		echo '<tr>';
		echo '<td>'.$dateil['Subitem']['name'].'</td>';
		echo '<td>'.number_format($dateil['Subitem']['price']).'</td>';	
		echo '<td>';
		echo $form->input("SaleDateil.".$key.".depot", array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
			'size'=>1,
			'value'=>$dateil['Subitem']['depot']
		));
		echo '</td>';
		echo '<td>';
		echo $form->input("SaleDateil.".$key.".span", array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
			'size'=>1
		));
		echo '</td>';
		echo '<td>';
		echo $form->input("SaleDateil.".$key.".discount", array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
			'size'=>1
		));
		echo '</td>';
		echo '<td>';
		echo $form->input("SaleDateil.".$key.".adjustment", array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
			'size'=>1
		));
		echo '</td>';
		echo '<td>';
		echo $form->input("SaleDateil.".$key.".sub_remark", array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
			'size'=>1
		));
		echo '</td>';
		echo '<td>'.$dateil['Subitem']['qty'].'</td>';
		echo '<td>'.$html->link('Del', array('controller'=>'sales', 'action'=>'add/del/'.$key)).'</td>';
		echo '</tr>';
		$total_quantity = $total_quantity + $dateil['Subitem']['qty'];
		$total_price = $total_price + ($dateil['Subitem']['price'] * $dateil['Subitem']['qty']);
	}
	echo '<tr><td>合計</td><td>'.number_format($total_price).'</td><td></td><td></td><td></td><td></td><td></td><td>'.$total_quantity.'</td><td></td></tr>';
	echo '</table>';
	echo $form->submit('Enter');
	echo '<br><p>スパン、割引などは、Enterを押す直前にまとめて入力して下さい。</p>';
	endif;
?>
</div>
