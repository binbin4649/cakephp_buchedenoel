<div class="salesStateCodes view">
<p><?php echo $html->link(__('List SalesStateCodes', true), array('action'=>'index')); ?> </p>
<h2><?php  __('SalesStateCode');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('System No.'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $salesStateCode['SalesStateCode']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sales State Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $salesStateCode['SalesStateCode']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Explain'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo nl2br($salesStateCode['SalesStateCode']['explain']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cutom Order Approve'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $salesStateCode['SalesStateCode']['cutom_order_approve']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Order Approve'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $salesStateCode['SalesStateCode']['order_approve']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $salesStateCode['SalesStateCode']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $salesStateCode['SalesStateCode']['created_user']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $salesStateCode['SalesStateCode']['updated']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $salesStateCode['SalesStateCode']['updated_user']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit SalesStateCode', true), array('action'=>'edit', $salesStateCode['SalesStateCode']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete SalesStateCode', true), array('action'=>'delete', $salesStateCode['SalesStateCode']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $salesStateCode['SalesStateCode']['id'])); ?> </li>
		<li><?php echo $html->link(__('List SalesStateCodes', true), array('action'=>'index')); ?> </li>
	</ul>
</div>
<ul>
	<li>客注可否、卸受注可否ともに、親品番に設定されている場合は、親品番が優先される。</li>
</ul>