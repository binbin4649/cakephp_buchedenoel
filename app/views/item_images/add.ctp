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
<ul style='margin-top:20px;'>
<li>画像は、正方形のJPG、500pxがベストです。</li>
<li>ex）500 x 500px .jpg</li>
<li>サイズが小さいと画像が荒れます。大きいと表示に時間がかかる恐れがあります。</li>
<li>正方形じゃないと、画像が歪んでしまいます。</li>
<li>ファイル名は勝手に連番になります。</li>
<li>画像コメント：画像に説明が必要な場合は入力して下さい。ただし長いと途中でカットされてしまうかもしれませんので簡潔に。</li>
</ul>