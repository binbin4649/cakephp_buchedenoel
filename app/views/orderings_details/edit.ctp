<div class="orderingsDetails form">
<p><?php echo $html->link(__('Return Ordering No.'.$this->data['Ordering']['id'], true), array('controller'=>'orderings', 'action'=>'view/'.$this->data['Ordering']['id'])); ?></p>
<?php echo $form->create('OrderingsDetail');?>
	<fieldset>
 		<legend><?php __('Edit OrderingsDetail');?></legend>
	<?php
		echo $form->input('id');
		echo '<div class="input"><label>'.__('Ordering no.', true).'</label>'.$this->data['OrderingsDetail']['ordering_id'].'　</div>';
		echo $form->hidden('OrderingsDetail.ordering_id', array('value'=>$this->data['OrderingsDetail']['ordering_id']));
		echo '<div class="input"><label>'.__('Order no.', true).'</label>'.$this->data['OrderingsDetail']['order_id'].'　</div>';
		echo '<div class="input"><label>'.__('Subitem', true).'</label>'.$this->data['Subitem']['name'].'　</div>';

		echo $form->input('OrderingsDetail.depot', array(
			'type'=>'select',
			'options'=>$depots,
			'div'=>true,
			'label'=>__('Depot', true),
			'selected'=>$this->data['OrderingsDetail']['depot'],
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('specified_date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Specified Date', true),
			'empty'=>'(select)',
			'minYear'=>'2009',
			'maxYear' => MAXYEAR,
		));
		echo $form->input('bid', array(
			'label'=>__('Order Bid', true),
			'size'=>10
		));
		echo $form->input('temporary_bid', array(
			'label'=>__('Temporary Bid', true),
			'size'=>10
		));
		echo $form->input('ordering_quantity', array(
			'label'=>__('Ordering Qty', true),
			'size'=>10
		));
		echo '<div class="input"><label>'.__('Stock Qty', true).'</label>'.$this->data['OrderingsDetail']['stock_quantity'].'　</div>';
		echo '<div class="input"><label>'.__('Created', true).'</label>'.$this->data['OrderingsDetail']['created'].'　</div>';
		echo '<div class="input"><label>'.__('Created User', true).'</label>'.$this->data['OrderingsDetail']['created_user'].'　</div>';
		echo '<div class="input"><label>'.__('Updated', true).'</label>'.$this->data['OrderingsDetail']['updated'].'　</div>';
		echo '<div class="input"><label>'.__('Updated User', true).'</label>'.$this->data['OrderingsDetail']['updated_user'].'　</div>';
		echo $form->hidden('OrderingsDetail.updated_user', array());
	?>
	<?php echo $form->end('Submit');?>
	</fieldset>
</div>