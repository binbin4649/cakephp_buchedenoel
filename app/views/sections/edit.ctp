<div class="sections form">
<p><?php echo $html->link(__('List Sections', true), array('action'=>'index'));?></p>
<?php echo $form->create('Section');?>
	<fieldset>
 		<legend><?php __('Edit Section');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('Section.name', array(
			'label'=>__('Section Name', true),
			'size'=>40,
		));
		echo $form->input('Section.name_english', array(
			'label'=>__('English', true),
			'size'=>30,
		));
		//echo '<div class="input"><label>'.__('kyuuyo bugyo1', true).'</label>'.$this->data['Section']['kyuuyo_bugyo1'].'　</div>';
		//echo '<div class="input"><label>'.__('kyuuyo bugyo2', true).'</label>'.$this->data['Section']['kyuuyo_bugyo2'].'　</div>';
		//echo '<div class="input"><label>'.__('kyuuyo bugyo3', true).'</label>'.$this->data['Section']['kyuuyo_bugyo3'].'　</div>';
		//echo '<div class="input"><label>'.__('kyuuyo bugyo4', true).'</label>'.$this->data['Section']['kyuuyo_bugyo4'].'　</div>';
		echo $form->input('Section.kanjo_bugyo_code', array('label'=>__('Section Code', true)));
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
			'after'=>'市区町村、番地'
		));
		echo $form->input('Section.adress_two', array(
			'label'=>__('Adress2', true),
			'size'=>45,
			'after'=>'建物名、他'
		));
		echo $form->input('Section.tel', array('label'=>__('Tel', true)));
		echo $form->input('Section.fax', array('label'=>__('Fax', true)));
		echo $form->input('Section.mail', array(
			'label'=>__('Mail', true),
			'size'=>30
		));
		echo $form->input('Section.start_date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Section Opne', true),
			'empty'=>'select',
			'minYear'=>'2000',
			'maxYear' =>MAXYEAR,
		));
		echo $form->input('Section.close_date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>__('Section Close', true),
			'empty'=>'select',
			'minYear'=>'2000',
			'maxYear' =>MAXYEAR,
		));
		echo $form->input('Section.contact_user', array(
			'type'=>'text',
			'label'=>__('Contact User', true),
			'size'=>10,
			'after'=>'（'.$contact_user['User']['name'].'）',
			'value'=>$this->data['Section']['contact_user']
		));
		echo $form->input('Section.remarks', array('label'=>__('Remarks', true)));

		echo '<table class="itemimage"><tr><th colspan="2">'.__('Default Depot', true).'</th></tr>';
		foreach($this->data['Depot'] as $depot){
			echo '<tr><td>'.$depot['name'].'</td><td>';
			if($depot['id'] == $this->data['Section']['default_depot']){
				echo '<input type="radio" value="'.$depot['id'].'" name="data[Section][default_depot]" checked>';
			}else{
				echo '<input type="radio" value="'.$depot['id'].'" name="data[Section][default_depot]">';
			}
			echo '</td></tr>';
		}
		echo '</table>';

	?>
	<?php echo $form->end(__('Edit', true));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Section.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Section.id'))); ?></li>
		<li><?php echo $html->link(__('List Sections', true), array('action'=>'index'));?></li>
	</ul>
</div>