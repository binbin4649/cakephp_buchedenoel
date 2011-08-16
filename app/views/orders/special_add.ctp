<script type="text/javascript" charset="utf-8">
$(function($){$(".datepicker").datepicker({dateFormat:'yy-mm-dd'});});
</script>
<div class="subitems form">
<?php
	echo $javascript->link("jquery-1.5.1.min",false);
	echo $javascript->link("jquery-ui-1.8.14.custom.min",false);
	echo $javascript->link("ui/i18n/ui.datepicker-ja.js",false);
	echo $form->create('OrderDateils', array('controller'=>'order_dateils', 'action'=>'store_add/special'));
?>
	<fieldset>
 		<legend><?php __('Special Order');?></legend>
	<?php
		//echo $form->hidden('Subitem.item_id', array('value'=>$item['Item']['id']));
		echo '<div class="input"><label>'.__('Brand', true).'</label>'.$item['Brand']['name'].'　</div>';
		echo '<div class="input"><label>'.__('Parent Item:', true).'</label>'.$item['Item']['name'].'　</div>';
		echo '<div class="input"><label>'.__('Price', true).'</label>'.number_format($item['Item']['price']).'　</div>';
		echo $form->hidden('Subitem.item_id', array('value'=>$item['Item']['id']));
		echo $form->hidden('Order.order_type', array('value'=>4));
		echo $form->hidden('Order.order_status', array('value'=>1));
		echo $form->input('Order.depot_id', array(
			'type'=>'select',
			'label'=>__('Depot', true),
 			'options'=>$sectionDepot,
 			'selected'=>$userSection['Section']['default_depot']
		));
		/* order_typeが選択式になった時
		echo $form->input('Order.order_type', array(
			'label'=>__('Order Type', true),
			'type'=>'select',
			'options'=>$orderType,
		));
		*/
		/*
		echo '<div class="separater"><p>Only Wholesale</p>';
		echo $form->input("Order.destination_id", array(
			'type'=>'text',
			'label'=>__('Destination', true),
			'size'=>5,
			'after'=>'　<a href="/buchedenoel/destinations" target="_blank">出荷先</a>'
		));
		echo $form->input('Order.shipping', array(
			'label'=>__('Shipping', true),
			'size'=>5,
			'value'=>0
		));
		echo '</div>';
		*/
		echo $form->hidden('Order.destination_id', array('value'=>0));
		echo $form->hidden('Order.shipping', array('value'=>0));
		echo $form->input('Order.adjustment', array(
			'label'=>__('Adjustment', true),
			'size'=>5,
			'value'=>0
		));
		echo $form->input('Order.discount', array(
			'label'=>'割引',
			'size'=>5
		));
		echo $form->input('Order.span_no', array(
			'label'=>__('Span No.', true),
			'size'=>5
		));
		echo $form->input('OrderDateil.specified_date', array(
			'type'=>'text',
			'size'=>8,
			'label'=>__('Specified Date', true),
			'class'=>'datepicker'
		));
		
		/*
		echo $form->input('Order.contact1', array(
			'label'=>__('Contact1', true),
			'size'=>5,
			'value'=>$loginUser['User']['id']
		));
		echo $form->input('Order.contact2', array(
			'label'=>__('Contact2', true),
			'size'=>5
		));
		echo $form->input('Order.contact3', array(
			'label'=>__('Contact3', true),
			'size'=>5
		));
		echo $form->input('Order.contact4', array(
			'label'=>__('Contact4', true),
			'size'=>5
		));
		echo $form->input('Order.customers_name', array(
			'label'=>__('Customers Name', true),
			'size'=>20
		));
		echo $form->input('Order.partners_no', array(
			'label'=>__('Partners No.', true),
			'size'=>20
		));
		*/
		echo $form->input('Subitem.major_size', array(
			'type'=>'select',
			'options'=>$majorSize,
			'div'=>true,
			'label'=>__('Major Size', true),
			'value'=>'other'
		));
		echo $form->input('Subitem.minority_size', array(
			'label'=>__('Minority Size', true),
			'size'=>10
		));
		echo $form->input('OrderDateil.marking', array(
			'label'=>__('Marking', true),
			'size'=>20
		));
		echo $form->input('Order.remark', array(
			'type'=>'text',
			'label'=>__('Remarks', true),
			'size'=>30,
		));
		echo '<div class="separater"><p>Only Special case</p>';
		echo $form->input('Subitem.process_id', array(
			'label'=>__('Process', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Subitem.material_id', array(
			'label'=>__('Material', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Subitem.carat', array(
			'label'=>__('Carat', true),
			'size'=>4,
		));
		echo $form->input('Subitem.color', array(
			'type'=>'select',
			'options'=>$color,
			'div'=>true,
			'label'=>__('Color', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Subitem.clarity', array(
			'type'=>'select',
			'options'=>$clarity,
			'div'=>true,
			'label'=>__('Clarity', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Subitem.cut', array(
			'type'=>'select',
			'options'=>$cut,
			'div'=>true,
			'label'=>__('Cut', true),
			'empty'=>__('(Please Select)', true)
		));
		echo '</div>';
		echo $form->end(__('Register', true));
	?>
	</fieldset>
</div>
