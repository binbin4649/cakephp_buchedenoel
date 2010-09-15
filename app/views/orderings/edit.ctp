<div class="orderings form">
<p><?php echo $html->link(__('List Orderings', true), array('action'=>'index'));?></p>
<p><?php echo $html->link(__('Return Ordering No.'.$this->data['Ordering']['id'], true), array('action'=>'view/'.$this->data['Ordering']['id'])); ?></p>
<?php echo $form->create('Ordering');?>
	<fieldset>
 		<legend><?php __('Edit Ordering');?></legend>
	<?php
		$total_ordering = 0;
		$total_stock = 0;
		foreach($this->data['OrderingsDetail'] as $dateil){
			$total_ordering = $total_ordering + $dateil['ordering_quantity'];
			$total_stock = $total_stock + $dateil['stock_quantity'];
		}

		echo $form->input('id');
		echo '<div class="input"><label>'.__('Ordering No.', true).'</label>'.$this->data['Ordering']['id'].'　</div>';
		echo '<div class="input"><label>'.__('Ordering Qty', true).'</label>'.$total_ordering.'　</div>';
		echo '<div class="input"><label>'.__('Stock Qty', true).'</label>'.$total_stock.'　</div>';
		echo '<div class="input"><label>'.__('Status', true).'</label>'.$orderingStatus[$this->data['Ordering']['ordering_status']].'　</div>';
		echo '<div class="input"><label>'.__('Factory', true).'</label>'.$this->data['Factory']['name'].'　</div>';
		echo $form->input('date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Ordering Date', true),
			'empty'=>'(select)',
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
		));

		echo '<div class="input"><label>'.__('Total', true).'</label>'.number_format($this->data['Ordering']['total']).'　</div>';
		echo '<div class="input"><label>'.__('Dateil Total', true).'</label>'.number_format($this->data['Ordering']['dateil_total']).'　</div>';
		echo '<div class="input"><label>'.__('Total Tax', true).'</label>'.number_format($this->data['Ordering']['total_tax']).'　</div>';
		echo $form->input('adjustment', array(
			'label'=>__('Adjustment', true),
			'size'=>10
		));
		echo $form->input('remark', array(
			'label'=>__('Remarks', true)
		));
		echo $form->hidden('Ordering.total_tax', array('value'=>$this->data['Ordering']['total_tax']));
		echo $form->hidden('Ordering.dateil_total', array('value'=>$this->data['Ordering']['dateil_total']));

		echo '<div class="input"><label>'.__('Created', true).'</label>'.$this->data['Ordering']['created'].'　</div>';
		echo '<div class="input"><label>'.__('Created User', true).'</label>'.$this->data['Ordering']['created_user'].'　</div>';
		echo '<div class="input"><label>'.__('Updated', true).'</label>'.$this->data['Ordering']['updated'].'　</div>';
		echo '<div class="input"><label>'.__('Updated User', true).'</label>'.$this->data['Ordering']['updated_user'].'　</div>';
	?>
	<?php echo $form->end('Submit');?>
	</fieldset>
</div>