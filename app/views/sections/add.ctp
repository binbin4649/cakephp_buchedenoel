<div class="sections form">
<p><?php echo $html->link(__('List Sections', true), array('action'=>'index'));?></p>
<?php echo $form->create('Section');?>
	<fieldset>
 		<legend><?php __('Add Section');?></legend>
	<?php
		echo $form->input('Section.name', array(
			'label'=>__('Section Name', true),
			'size'=>40,
		));
		echo $form->input('Section.name_english', array(
			'label'=>__('English', true),
			'size'=>30,
		));
		//echo $form->input('Section.kyuuyo_bugyo1', array('label'=>__('Kyuuyo Bugyo 1', true)));
		//echo $form->input('Section.kyuuyo_bugyo2', array('label'=>__('Kyuuyo Bugyo 2', true)));
		//echo $form->input('Section.kyuuyo_bugyo3', array('label'=>__('Kyuuyo Bugyo 3', true)));
		//echo $form->input('Section.kyuuyo_bugyo4', array('label'=>__('Kyuuyo Bugyo 4', true)));
		//echo $form->input('Section.kyuuyo_bugyo5', array('label'=>__('Kyuuyo Bugyo 5', true)));
		//echo $form->input('Section.kyuuyo_bugyo_highrank_code', array('label'=>__('Kyuuyo Bugyo 1', true)));
		//echo $form->input('Section.kyuuyo_bugyo_code', array('label'=>__('Kyuuyo Bugyo 2', true)));
		echo $form->input('Section.kanjo_bugyo_code', array('label'=>__('Kanjou Bugyo', true)));
		echo $form->input('Section.sales_code', array(
			'type'=>'select',
			'options'=>$salesCode,
			'div'=>true,
			'label'=>__('Sales Code', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Section.tax_method', array(
			'type'=>'select',
			'options'=>$taxMethod,
			'div'=>true,
			'label'=>__('Tax Method', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Section.tax_fraction', array(
			'type'=>'select',
			'options'=>$taxFraction,
			'div'=>true,
			'label'=>__('Tax Fraction', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Section.post_code', array('label'=>__('Post Code', true),));
		echo $form->input('Section.district', array(
			'type'=>'select',
			'options'=>$district,
			'div'=>true,
			'label'=>__('District', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('Section.adress_one', array(
			'label'=>__('Adress1', true),
			'size'=>45,
		));
		echo $form->input('Section.adress_two', array(
			'label'=>__('Adress2', true),
			'size'=>45,
		));
		echo $form->input('Section.tel', array('label'=>__('Tel', true)));
		echo $form->input('Section.fax', array('label'=>__('Fax', true)));
		echo $form->input('Section.mail', array(
			'label'=>__('Mail', true),
			'size'=>30
		));
		echo $form->input('Section.remarks', array('label'=>__('Remarks', true)));
	?>
	<?php echo $form->end(__('Register', true));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Sections', true), array('action'=>'index'));?></li>
	</ul>
</div>
