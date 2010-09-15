<div class="users form">
<p><?php echo $html->link(__('List Users', true), array('action'=>'index'));?></p>
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Add User');?></legend>
	<?php
		echo $form->input('User.name', array(
			'label'=>__('Name', true),
			'size'=>30,
		));
		echo $form->input('User.name_kana', array('label'=>__('Kana', true)));
		echo $form->input('User.name_english', array('label'=>__('English', true)));
		echo $form->input('User.kyuuyo_bugyo_code', array(
			'label'=>__('Kyuyo Bugyo', true),
			'size'=>30,
		));
		echo $form->input('User.section_id', array(
			'label'=>__('Section', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('User.post_id', array(
			'label'=>__('Post', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('User.employment_id', array(
			'label'=>__('Employment', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('User.sex', array(
			'type'=>'select',
			'options'=>$sex,
			'div'=>true,
			'label'=>__('sex', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('User.post_code', array('label'=>__('Post Code', true),));
		echo $form->input('User.adress_one', array(
			'label'=>__('Adress1', true),
			'size'=>45,
		));
		echo $form->input('User.adress_two', array(
			'label'=>__('Adress2', true),
			'size'=>45,
		));
		echo $form->input('User.tel', array(
			'label'=>__('Tel', true),
			'size'=>30
		));
		echo $form->input('User.mail', array(
			'label'=>__('Mail', true),
			'size'=>30
		));

		echo $form->input('User.mobile_phone', array(
			'label'=>__('Mobile Phone', true),
			'size'=>30
		));
		echo $form->input('User.mobile_mail', array(
			'label'=>__('Mobile Mail', true),
			'size'=>30
		));
		echo $form->input('User.business_phone', array(
			'label'=>__('Business Phone', true),
			'size'=>30
		));
		echo $form->input('User.business_phone_mail', array(
			'label'=>__('Business Phone Mail', true),
			'size'=>30
		));
		echo $form->input('User.pension_number', array(
			'label'=>__('Pension Number', true),
			'size'=>30
		));

		echo $form->input('User.birth_day', array(
			'label'=>__('Birth day', true),
			'size'=>20
		));
		echo $form->input('User.blood_type', array(
			'type'=>'select',
			'options'=>$bloodType,
			'div'=>true,
			'label'=>__('Blood Type', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('User.duty_code', array(
			'type'=>'select',
			'options'=>$dutyCode,
			'div'=>true,
			'label'=>__('Work Situation', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('User.list_order', array(
			'label'=>__('Order of Priority', true),
			'size'=>5
		));

		echo $form->input('User.join_day', array(
			'label'=>__('Joined day', true),
			'size'=>20
		));
		echo $form->input('User.exit_day', array(
			'label'=>__('Exit day', true),
			'size'=>20
		));

		echo $form->input('User.access_authority', array(
			'type'=>'select',
			'options'=>$accessAuthority,
			'div'=>true,
			'label'=>__('Access Authority', true),
			'empty'=>__('(Please Select)', true)
		));
		echo $form->input('User.username', array('label'=>__('Login ID', true)));
		echo $form->input('User.password', array('label'=>__('Password', true)));
		echo $form->input('User.remarks', array(
			'label'=>__('Remarks', true)
		));
	?>
	<?php echo $form->end(__('Register', true));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Users', true), array('action'=>'index'));?></li>
	</ul>
</div>
