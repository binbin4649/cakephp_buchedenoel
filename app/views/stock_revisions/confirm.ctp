<div class="stockRevisions form">
<h2><?php  __('StockRevision Confirm');?></h2>
<?php echo $form->create('StockRevision', array('action'=>'add'));?>
	<dl><?php $i = 0; $class = ' class="altrow"';?>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Subitem Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['name']; ?>
			<?php echo $form->hidden('StockRevision.subitem_id', array('value'=>$subitem['Subitem']['id']));?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $depot['section_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Depot'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $depot['depot_name'].':'.$depot['depot_id']; ?>
			<?php echo $form->hidden('StockRevision.depot_id', array('value'=>$depot['depot_id']));?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $stockRevision['StockRevision']['quantity']; ?>
			<?php echo $form->hidden('StockRevision.quantity', array('value'=>$stockRevision['StockRevision']['quantity']));?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Stock Change'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $stockChange[$stockRevision['StockRevision']['stock_change']]; ?>
			<?php echo $form->hidden('StockRevision.stock_change', array('value'=>$stockRevision['StockRevision']['stock_change']));?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Reason Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $reasonType[$stockRevision['StockRevision']['reason_type']]; ?>
			<?php echo $form->hidden('StockRevision.reason_type', array('value'=>$stockRevision['StockRevision']['reason_type']));?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Reason'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo nl2br($stockRevision['StockRevision']['reason']); ?>
			<?php echo $form->hidden('StockRevision.reason', array('value'=>$stockRevision['StockRevision']['reason']));?>
			&nbsp;
		</dd>
	</dl>
<p>登録後の修正削除はできません。この内容で登録します。よろしいですか？</p>
<?php echo $form->end('Submit');?>
</div>
