<div class="bankAcuts form">
<?php echo $form->create('BankAcut');?>
	<fieldset>
 		<legend><?php __('Edit BankAcut');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('BankAcut.name', array(
			'label'=>__('Bank Name', true),
			'size'=>25
		));
		echo $form->input('BankAcut.account_number', array(
			'label'=>__('Account Number', true),
			'size'=>25
		));
		echo $form->input('BankAcut.account_type', array(
			'type'=>'select',
			'options'=>$accountType,
			'div'=>true,
			'label'=>__('Account Type', true)
		));
		echo $form->input('BankAcut.bank_code', array(
			'label'=>__('Bank Code', true),
			'size'=>10
		));
		echo $form->input('BankAcut.branch_code', array(
			'label'=>__('Branch Code', true),
			'size'=>10
		));
		echo $form->input('BankAcut.remark', array(
			'type'=>'textarea',
			'label'=>__('Remarks', true),
			'rows'=>2,
			'cols'=>40
		));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List BankAcuts', true), array('action'=>'index'));?></li>
	</ul>
</div>
