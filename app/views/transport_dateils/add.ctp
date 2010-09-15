<div class="transportDateils form">
<?php echo $form->create('TransportDateil', array('name'=>'form1'));?>
	<fieldset>
 		<legend><?php __('Add TransportDateil');?></legend>
	<?php
		if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
			echo '<a href="/buchedenoel/depots" target="_blank">出庫元倉庫</a>：';
			if(!empty($section['Section']['out_depot'])){
				echo $sectionDepots[$section['Section']['out_depot']];
				echo $form->hidden('TransportDateil.depot', array('value'=>$section['Section']['out_depot']));
			}else{
				echo $form->input('TransportDateil.depot', array(
					'type'=>'text',
					'div'=>false,
					'label'=>false,
					'size'=>4,
					'value'=>$section['Section']['default_depot'],
				));
			}
		}else{
			echo '出庫元倉庫：';
			if(!empty($section['Section']['out_depot'])){
				echo $sectionDepots[$section['Section']['out_depot']];
				echo $form->hidden('TransportDateil.depot', array('value'=>$section['Section']['out_depot']));
			}else{
				echo $form->input('TransportDateil.depot', array(
				'type'=>'select',
					'options'=>$sectionDepots,
					'div'=>false,
					'value'=>$section['Section']['default_depot'],
					'label'=>false
				));
			}
		}
		/*
		echo '　数量:';
		echo $form->input('TransportDateil.quantity', array(
			'type'=>'text',
			'div'=>false,
			'label'=>false,
			'size'=>1
		));
		*/
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
		echo $html->link('Reset', array('controller'=>'transport_dateils', 'action'=>'add/reset'));
		echo $form->end();
	?>
	</fieldset>
</div>
<div class="actions">
<?php
//pr($TransportDateil);
if(!empty($TransportDateil)):
	echo $form->create('TransportDateil', array('name'=>'qty'));
	$total_quantity = 0;
	$total_price = 0;
	echo '<table><tr><th></th><th>JAN</th><th>子品番</th><th>倉庫</th><th>在庫数</th><th>移動数</th><th></th></tr>';
	//foreach($TransportDateil as $key=>$dateil){
	$i = 1;
	while(!empty($TransportDateil)){
		$dateil = array_pop($TransportDateil);
		$key = $dateil['subitem_id'];
		//pr($dateil);
		//exit;
		echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$dateil['subitem_jan'].'</td>';
		echo '<td>'.$dateil['subitem_name'].'</td>';
		echo '<td>'.$sectionDepots[$dateil['out_depot']].':'.$dateil['out_depot'].'</td>';
		echo '<td>'.$dateil['view_quantity'].'</td>';
		//echo '<td>'.$dateil['quantity'].'</td>';
		echo '<td>';
		echo $form->input('TransportDateil.Qty.'.$key, array(
			'type'=>'text',
			'size'=>1,
			'maxlength'=>4,
			'div'=>false,
			'label'=>false,
			'value'=>$dateil['quantity']
		));
		echo '</td>';
		echo '<td>'.$html->link('Del', array('controller'=>'transport_dateils', 'action'=>'add/del/'.$key)).'</td>';
		echo '</tr>';
		$total_quantity = $total_quantity + $dateil['quantity'];
		$total_price = $total_price + ($dateil['item_price'] * $dateil['quantity']);
		$i++;
	}
	echo '<tr><td colspan="4"></td><td>合計</td><td>'.$total_quantity.'</td><td>'.number_format($total_price).'</td></tr>';

	echo '<tr><td colspan="5"></td><td>'.$form->submit('Edit', array('div'=>false)).'</td><td></td></tr>';

	echo '</table>';
	echo $form->end();
?>
</div>
<div class="depots form">
<fieldset>
<?php
echo $form->create('TransportDateil' ,array('action'=>'add'));
echo '移動先倉庫:';
echo $form->text('Depot.word');
echo '　　';
if(!empty($section['Section']['out_depot'])) echo $form->hidden('TransportDateil.depot', array('value'=>$section['Section']['out_depot']));
echo $form->submit('Seach', array('div'=>false));
echo $form->end();
endif;
?>
<?php if(!empty($paginator)):?>
<ul>
<?php
foreach ($depots as $depot){
	$links = 'No:'.$depot['Depot']['id'].'　/　'.$depot['Section']['name'].'　/　'.$depot['Depot']['name'];
	$confirm_messe = '合計：'.$total_quantity.'点　'.$depot['Section']['name'].'/'.$depot['Depot']['name'];
	echo '<li>';
	echo $html->link($links, array('controller'=>'transport_dateils', 'action'=>'add/indepot/'.$depot['Depot']['id']), null, sprintf(__(' %s へ移動します。よろしいですか？', true), $confirm_messe));
	//echo $html->link($links, array('controller'=>'transport_dateils', 'action'=>'add/indepot/'.$depot['Depot']['id']));
	echo '</li>';
}
?>
</ul>
</fieldset>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
<?php endif; ?>
</div>