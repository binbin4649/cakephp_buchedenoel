<div class="transports form">
<p><?php echo $html->link(__('List Transports', true), array('action'=>'index'));?></p>
<p><?php echo $html->link(__('Return No.'.$this->data['Transport']['id'], true), array('action'=>'view/'.$this->data['Transport']['id']));?></p>
<?php echo $form->create('Transport', array('action'=>'input_reserve'));?>
	<fieldset>
 		<legend><?php __('Input Reserve');?></legend>
	<?php
		$time = time()+(86400 * 6);
		$date_y = date('Y' ,$time);
		$date_m = date('m' ,$time);
		$date_d = date('d' ,$time);

		echo $form->input('id');
		echo '<div class="input"><label>'.__('Status', true).'</label>'.$transportStatus[$this->data['Transport']['transport_status']].'　</div>';
		echo '<div class="input"><label>'.__('Out Section', true).'</label>'.$this->data['Transport']['out_depot']['section_name'].'　</div>';
		echo '<div class="input"><label>'.__('Out Depot', true).'</label>'.$this->data['Transport']['out_depot']['depot_name'].':'.$this->data['Transport']['out_depot']['depot_id'].'　</div>';
		echo $form->hidden('Transport.out_depot', array('value'=>$this->data['Transport']['out_depot']['depot_id']));
		echo '<div class="input"><label>'.__('In Section', true).'</label>'.$this->data['Transport']['in_depot']['section_name'].'　</div>';
		echo '<div class="input"><label>'.__('In Depot', true).'</label>'.$this->data['Transport']['in_depot']['depot_name'].':'.$this->data['Transport']['in_depot']['depot_id'].'　</div>';
		echo $form->input('Transport.in_depot', array(
			'type'=>'text',
			'label'=>'<a href="/'.SITE_DIR.'/depots" target="_blank">'.__('Depot No.', true).'</a>：',
			'size'=>5,
			'value'=>$this->data['Transport']['in_depot']['depot_id']
		));
		echo $form->input('Transport.arrival_date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Arrival Date', true),
			'selected'=>array('year'=>$date_y, 'month'=>$date_m, 'day'=>$date_d),
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
			'div'=>false
		));
		echo $form->input('Transport.remark', array(
			'label'=>__('Remarks', true)
		));
		//echo $form->input('delivary_date');
		//echo $form->input('layaway_type');
		//echo $form->input('layaway_user');

		echo '<div class="input"><label>'.__('Created', true).'</label>'.$this->data['Transport']['created_user'].'　'.$this->data['Transport']['created'].'　</div>';
		echo '<div class="input"><label>'.__('Updated', true).'</label>'.$this->data['Transport']['updated_user'].'　'.$this->data['Transport']['updated'].'　</div>';

		echo '<table class="itemDetail"><tr><th>子品番</th><th>出庫数</th><th>入庫済み数</th></tr>';
		foreach($this->data['TransportDateil'] as $Dateil){
			echo '<tr>';
			echo '<td>'.$Dateil['subitem_name'].'</td>';
			echo '<td>'.$Dateil['out_qty'].'</td>';
			echo '<td>'.$Dateil['in_qty'].'</td>';
			echo $form->hidden('TransportDateil.'.$Dateil['id'].'.subitem_id', array('value'=>$Dateil['subitem_id']));
			echo $form->hidden('TransportDateil.'.$Dateil['id'].'.pairing_quantity', array('value'=>$Dateil['pairing_quantity']));
			echo $form->hidden('TransportDateil.'.$Dateil['id'].'.in_depot', array('value'=>$this->data['Transport']['in_depot']['depot_id']));
			echo '</td></tr>';
		}
		echo '</table>';
	?>

	<?php echo $form->end('Submit');?>
	</fieldset>
</div>
<?php //pr($this->data);?>