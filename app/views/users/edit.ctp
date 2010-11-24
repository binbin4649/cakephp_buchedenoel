<div class="users form">
<p><?php echo $html->link(__('List Users', true), array('action'=>'index'));?></p>
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit User');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('User.name', array(
			'label'=>__('User Name', true),
			'size'=>30
		));
		echo '<div class="input"><label>'.__('Kana', true).'</label>'.$this->data['User']['name_kana'].'　</div>';
		echo $form->input('User.name_english', array('label'=>__('English', true)));
		echo '<div class="input"><label>'.__('Staff Number', true).'</label>'.$this->data['User']['kyuuyo_bugyo_code'].'　</div>';
		echo $form->input('User.section_id', array(
			'type'=>'text',
			'label'=>__('Section', true),
			'size'=>10,
			'after'=>'（'.$this->data['Section']['name'].'）',
			'value'=>$this->data['Section']['id']
		));
		echo '<div class="input"><label>'.__('Post', true).'</label>'.$this->data['Post']['name'].'　</div>';
		echo '<div class="input"><label>'.__('Employment', true).'</label>'.$this->data['Employment']['name'].'　</div>';
		if(!empty($this->data['User']['sex'])){
			echo '<div class="input"><label>'.__('Sex', true).'</label>'.$sex[$this->data['User']['sex']].'　</div>';
		}
		echo '<div class="input"><label>'.__('Post Code', true).'</label>'.$this->data['User']['post_code'].'　</div>';
		echo '<div class="input"><label>'.__('Adress1', true).'</label>'.$this->data['User']['adress_one'].'　</div>';
		echo '<div class="input"><label>'.__('Adress2', true).'</label>'.$this->data['User']['adress_two'].'　</div>';
		echo '<div class="input"><label>'.__('Tel', true).'</label>'.$this->data['User']['tel'].'　</div>';
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
		echo '<div class="input"><label>'.__('Birth day', true).'</label>'.$this->data['User']['birth_day'].'　</div>';
		echo $form->input('User.blood_type', array(
			'type'=>'select',
			'options'=>$bloodType,
			'div'=>true,
			'label'=>__('Blood Type', true),
			'empty'=>__('(Please Select)', true)
		));
		if($loginUser['User']['id'] == 1135){
			echo $form->input('User.duty_code', array(
				'type'=>'select',
				'options'=>$dutyCode,
				'div'=>true,
				'label'=>__('Work Situation', true),
				'empty'=>__('(Please Select)', true)
			));
		}else{
			if(!empty($this->data['User']['duty_code'])){
				echo '<div class="input"><label>'.__('Work Situation', true).'</label>'.$dutyCode[$this->data['User']['duty_code']].'　</div>';
			}
		}
		echo $form->input('User.list_order', array(
			'label'=>__('Order of Priority', true),
			'size'=>5
		));
		echo $form->input('User.old_system_no', array(
			'label'=>__('Old System No', true),
			'size'=>10
		));
		echo $form->input('User.old_system_start', array(
			'type'=>'text',
			'label'=>__('Old System Start', true),
			'size'=>10
		));
		echo '<div class="input"><label>'.__('Joined day', true).'</label>'.$this->data['User']['join_day'].'　</div>';
		echo '<div class="input"><label>'.__('Exit day', true).'</label>'.$this->data['User']['exit_day'].'　</div>';

		if($addForm->opneUser(array($this->data['User']['id']), $opneuser, 'id')):
			echo $form->input('User.username', array('label'=>__('Login ID', true)));
			echo $form->input('User.password', array('label'=>__('Password', true)));
		endif;

		if($addForm->opneUser(array('3'), $opneuser, 'access_authority')):
			echo $form->input('User.pension_number', array(
				'label'=>__('Pension Number', true),
				'size'=>30
			));
			echo $form->input('User.access_authority', array(
				'type'=>'select',
				'options'=>$accessAuthority,
				'div'=>true,
				'label'=>__('Access Authority', true),
				'empty'=>__('(Please Select)', true)
			));
		endif;
		echo $form->input('User.remarks', array(
			'label'=>__('Remarks', true)
		));
	?>
	<?php echo $form->end(__('Edit', true));?>
	</fieldset>
</div>