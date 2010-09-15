<div class="items form">
<p><?php echo $html->link(__('List Items', true), array('action'=>'index'));?></p>
<?php echo $form->create('Item');?>
	<fieldset>
 		<legend><?php __('Add Item');?></legend>
	<?php
	//var_dump($this);
		echo $form->input('Item.name', array(
			'label'=>__('Item Name', true),
			'size'=>25
		));
		echo $form->input('Item.title', array(
			'label'=>__('Item Title', true),
			'size'=>35
		));
		echo $form->input('Item.price', array(
			'label'=>__('Price', true),
			'size'=>15,
			'after'=>__('(out tax)', true)
		));
		echo $form->input('Item.brand_id', array(
			'label'=>__('Brand', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.itemproperty', array(
			'type'=>'select',
			'options'=>$itemproperty,
			'div'=>true,
			'label'=>__('Item Property', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.itemtype', array(
			'type'=>'select',
			'options'=>$itemtype,
			'div'=>true,
			'label'=>__('Item Type', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.basic_size', array(
			'label'=>__('Size Basic', true),
			'size'=>25,
			'after'=>'例）#7～13',
		));
		echo $form->input('Item.order_size', array(
			'label'=>__('Size Order', true),
			'size'=>25,
			'after'=>'例）#5～23 偶数可',
		));
		echo $form->input('Item.factory_id', array(
			'label'=>__('Factory', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.sales_state_code_id', array(
			'label'=>__('Sales State', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.process_id', array(
			'label'=>__('Process', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.material_id', array(
			'label'=>__('Material', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.stone_id', array(
			'label'=>__('Stone', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.stone_other', array(
			'label'=>__('Stone Other', true),
			'size'=>30
		));
		echo $form->input('Item.stone_spec', array(
			'label'=>__('Stone Spec', true),
			'size'=>30
		));
		echo $form->input('Item.message_stamp', array(
			'label'=>__('Message Stamp', true),
			'size'=>40
		));
		echo $form->input('Item.message_stamp_ja', array(
			'label'=>__('Message Stamp Ja', true),
			'size'=>40
		));
		echo $form->input('Item.release_day', array(
			'type'=>'date','dateFormat'=>'YMD',
			'label'=>__('Release', true),
			'minYear'=>'2009',
			'maxYear' => date('Y'),
			'empty'=>'select',
		));
		echo $form->input('Item.order_end_day', array(
			'type'=>'date','dateFormat'=>'YMD',
			'label'=>__('Order End', true),
			'minYear'=>'2009',
			'maxYear' => date('Y'),
			'empty'=>'select',
		));
		echo $form->input('Item.demension', array(
			'label'=>__('Demension', true),
			'size'=>30
		));
		echo $form->input('Item.weight', array(
			'label'=>__('Weight', true),
			'size'=>30
		));

		//echo $form->input('Item.part_id');

		echo $form->input('Item.unit', array(
			'type'=>'select',
			'options'=>$unit,
			'div'=>true,
			'label'=>__('Unit', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.stock_code', array(
			'type'=>'select',
			'options'=>$stockCode,
			'div'=>true,
			'label'=>__('Stock Code', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.order_approve', array(
			'type'=>'select',
			'options'=>$orderApprove,
			'div'=>true,
			'label'=>__('Order Approve', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.cutom_order_approve', array(
			'type'=>'select',
			'options'=>$cutomOrderApprove,
			'div'=>true,
			'label'=>__('Custom Order App', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.custom_order_days', array(
			'label'=>__('Custom Order Days', true),
			'size'=>3,
			'maxlength'=>2
		));
		echo $form->input('Item.repair_days', array(
			'label'=>__('Repair Days', true),
			'size'=>3,
			'maxlength'=>2
		));
		echo $form->input('Item.trans_approve', array(
			'type'=>'select',
			'options'=>$transApprove,
			'div'=>true,
			'label'=>__('Trans Approve', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.in_chain', array(
			'label'=>__('in Chain', true),
			'size'=>30
		));
		echo $form->input('Item.atelier_trans_approve', array(
			'type'=>'select',
			'options'=>$atelierTransApprove,
			'div'=>true,
			'label'=>__('Atelier Trans App', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.labor_cost', array(
			'label'=>__('Labor Cost', true),
			'size'=>15
		));
		echo $form->input('Item.supply_full_cost', array(
			'label'=>__('Supply Fullcost', true),
			'size'=>15
		));
		echo $form->input('Item.percent_code', array(
			'type'=>'select',
			'options'=>$percentCode,
			'div'=>true,
			'label'=>__('Percent Code', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.sales_sum_code', array(
			'type'=>'select',
			'options'=>$salesSumCode,
			'div'=>true,
			'label'=>__('Sales Sum Code', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Item.remark', array(
			'type'=>'textarea',
			'label'=>__('Notes', true),
			'rows'=>6,
			'cols'=>45
		));
		echo $form->input('Item.secret_remark', array(
			'type'=>'textarea',
			'label'=>__('Secret Notes', true),
			'rows'=>6,
			'cols'=>45
		));
		echo $addForm->tagTagTable($this->viewVars['tags'], $this->data['Tag']);
		/*
		echo $form->input('Tag.Tag', array(
			'type'=>'select',
			'div'=>true,
			'label'=>__('Tag', true),
			'multiple'=>'checkbox'
		));
		*/
	?>
	</fieldset>
<?php echo $form->end(__('Register', true));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Items', true), array('action'=>'index'));?></li>
	</ul>
</div>
<ul>
	<li>画像は、参照(View)から登録して下さい。</li>
	<li>メイン画像の選択は、編集(Edit)から登録して下さい。</li>
	<li>ペア品番は、編集(Edit)から登録して下さい。</li>
</ul>