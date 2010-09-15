<div class="itemImages form">
	<h2><?php __('Add ItemImage');?></h2>
	<fieldset>
 		<?php
 		echo '品番「 '.$html->link($this->viewVars['item']['Item']['name'], array('controller'=>'items', 'action'=>'view/'.$this->viewVars['item']['Item']['id'])).' 」に画像を追加します。';
 		echo $form->create('ItemImage',array('type'=>'file','url'=>'add/'.$this->viewVars['item']['Item']['id']));
		echo $form->input('ItemImage.upload_file',array('label'=>'Upload Image ','type'=>'file'));
		echo $form->input('ItemImage.name', array(
			'label'=>__('Image Comment', true),
			'size'=>40
		));
		echo $form->hidden('ItemImage.item_id', array(
			'value'=>$this->viewVars['item']['Item']['id']
		));
		echo $form->end(__('Add', true));
		?>
	</fieldset>
</div>
