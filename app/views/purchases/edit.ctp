<script type="text/javascript" charset="utf-8">
$(function($){$(".datepicker").datepicker({dateFormat:'yy-mm-dd'});});
</script>
<a href="javascript:history.back();">戻る</a>
<div class="purchases form">
<?php 
	echo $javascript->link("jquery-1.5.1.min",false);
	echo $javascript->link("jquery-ui-1.8.14.custom.min",false);
	echo $javascript->link("ui/i18n/ui.datepicker-ja.js",false);
	echo $form->create('Purchase');
?>
	<fieldset>
 		<legend><?php __('Edit Purchase');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('invoices', array(
			'label'=>__('Invoices No', true),
		));
		echo $form->input('purchase_status', array(
			'options'=>$purchaseStatus
		));
		echo $form->input('factory_id');
		echo $form->input('date', array(
			'label'=>__('Purchase Date', true),
			'type'=>'text',
			'size'=>12,
			'class'=>'datepicker'
		));
		echo $form->input('total');
		echo $form->input('total_tax');
		echo $form->input('adjustment');
		echo $form->input('shipping');
		echo $form->input('remark', array(
			'type'=>'textarea',
			'label'=>__('Remarks', true),
			'rows'=>6,
			'cols'=>45
		));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<p>注意：締められた仕入れの支払いデータ、仕入れた商品の在庫データ、集計された仕入金額、等、は変更されません。</p>
