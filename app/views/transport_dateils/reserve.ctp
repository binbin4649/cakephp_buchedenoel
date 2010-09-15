<div class="transportDateils form">
<?php echo $form->create('TransportDateil', array('name'=>'form1', 'controller'=>'transport_dateils', 'action'=>'reserve'));?>
	<fieldset>
 		<legend><?php __('Stock Reserve');?></legend>
	<?php
		echo '出庫元倉庫：商品部（メイン）　';
		echo '　JAN:';
		echo $form->input('TransportDateil.transport', array(
			'name'=>'input1',
			'type'=>'text',
			'maxlength'=>'13',
			'div'=>false,
			'label'=>false
		));
		echo '　　';
		echo $form->submit('Submit', array('div'=>false));
		echo '　　';
		echo $html->link('Reset', array('controller'=>'transport_dateils', 'action'=>'reserve/reset'));
		echo $form->end();
	?>
	</fieldset>
</div>
<div class="actions">
<?php
//pr($TransportDateil);
if(!empty($TransportDateil)){
	$total_quantity = 0;
	echo '<table><tr><th>JAN</th><th>子品番</th><th>在庫数</th><th>取置数</th><th></th></tr>';
	foreach($TransportDateil as $key=>$dateil){
		echo '<tr>';
		echo '<td>'.$dateil['subitem_jan'].'</td>';
		echo '<td>'.$dateil['subitem_name'].'</td>';
		echo '<td>'.$dateil['view_quantity'].'</td>';
		echo '<td>'.$dateil['quantity'].'</td>';
		echo '<td>'.$html->link('Del', array('controller'=>'transport_dateils', 'action'=>'reserve/del/'.$key)).'</td>';
		echo '</tr>';
		$total_quantity = $total_quantity + $dateil['quantity'];
	}
	echo '<tr><td colspan="2"></td><td>合計</td><td>'.$total_quantity.'</td><td></td></tr>';
	echo '</table>';
	echo '<p>';
	echo $html->link('取り置き確定', array('controller'=>'transport_dateils', 'action'=>'reserve/indepot/'), null, sprintf(__('取り置きします。よろしいですか？', true), null));
	echo '</p>';
}

?>
</div>
