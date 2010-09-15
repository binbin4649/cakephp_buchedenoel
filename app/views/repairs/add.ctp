<?php
	echo $javascript->link("prototype",false);
	echo $javascript->link("scriptaculous",false);
?>
<div class="repairs form">
<?php echo $form->create('Repair');?>
	<fieldset>
 		<legend><?php __('Add Repair');?></legend>
	<?php
		echo '<div class="separater"><p>Auto Complete</p>';
		echo '<label>品番</label>';
		echo $ajax->autocomplete('AutoItemName',"getData",array());
		echo '</div>';
		echo $form->input('Repair.size',array(
			'size'=>4
		));
		echo $form->input('Repair.user_id', array(
			'label'=>__('Charge Person', true),
			'value'=>$user['User']['id'],
			'after'=>$user['User']['name'],
			'size'=>7
		));
		echo $form->input('Repair.section_id', array(
			'label'=>__('Section', true),
			'value'=>$section['Section']['id'],
			'after'=>$section['Section']['name'],
			'size'=>7
		));
		echo $form->input('Repair.estimate_status', array(
			'type'=>'select',
			'options'=>$EstimateStatus,
			'div'=>true,
			'label'=>__('Estimate Status', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Repair.reception_date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Reception Date', true),
			'minYear'=> MINYEAR,
			'maxYear' => MAXYEAR,
		));
		echo $form->input('Repair.store_arrival_date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Store Arrival Date', true),
			'minYear'=> MINYEAR,
			'maxYear' => MAXYEAR,
		));
		echo $form->input('Repair.control_number');
		echo $form->input('Repair.customer_name');
		echo $form->input('Repair.customer_tel');
		echo $form->input('Repair.repair_content', array(
			'size'=>50
		));
		echo $form->input('Repair.remark', array(
			'label'=>__('Remarks', true),
			'type'=>'textarea',
			'rows'=>5,
			'cols'=>50
		));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Repairs', true), array('action'=>'index'));?></li>
	</ul>
</div>
<p>品番は、半角英数で入力して下さい。</p>