<div class="stockRevisions form">
<?php echo $form->create('StockRevision', array('action'=>'confirm'));?>
	<fieldset>
 		<legend><?php __('Add StockRevision');?></legend>
	<?php
		echo '<div class="input"><label>'.__('Subitem', true).'</label>'.$subitem['Subitem']['name'].'　</div>';
		echo $form->hidden('StockRevision.subitem_id', array('value'=>$subitem['Subitem']['id']));
		if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
			echo $form->input('StockRevision.depot_id', array(
				'size'=>3,
				'div'=>false,
				'label'=>'<a href="/buchedenoel/depots" target="_blank">倉庫番号</a>',
			));
			echo $form->input('StockRevision.stock_change', array(
				'type'=>'select',
				'options'=>$stockChange,
				'div'=>true,
				'label'=>__('Stock Change', true),
			));
		}else{
			echo $form->input('StockRevision.depot_id', array(
				'type'=>'select',
				'options'=>$sectionDepots,
				'div'=>true,
				'label'=>__('Depot No.', true),
			));
			echo $form->input('StockRevision.stock_change', array(
				'type'=>'select',
				'options'=>array('1'=>'在庫増'),
				'div'=>true,
				'label'=>__('Stock Change', true),
			));
		}

		echo $form->input('StockRevision.quantity', array(
			'label'=>__('Quantity', true),
			'size'=>1,
			'value'=>1
		));
		echo $form->input('StockRevision.reason_type', array(
			'type'=>'select',
			'options'=>$reasonType,
			'div'=>true,
			'label'=>__('Reason Type', true),
		));
		echo $form->input('StockRevision.reason');
	?>
	<?php echo $form->end('Submit');?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li>全て必須項目です。</li>
		<li>エラーメッセージが表示された場合は、子品番を選択するところからやり直してください。</li>
	</ul>
</div>
