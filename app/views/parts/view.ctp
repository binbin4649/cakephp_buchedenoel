<div class="parts view">
<h2><?php  __('Part');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parts Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($item['Item']['name'], array('controller'=> 'items', 'action'=>'view', $item['Item']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Subitem'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($part['Subitem']['name'], array('controller'=> 'subitems', 'action'=>'view', $part['Subitem']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Supply Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['supply_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['updated']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php if($this->viewVars['loginUser']['User']['access_authority'] == '1' or $this->viewVars['loginUser']['User']['username'] == 'admin'):?>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Part', true), array('action'=>'edit', $part['Part']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Part', true), array('action'=>'delete', $part['Part']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $part['Part']['id'])); ?> </li>
	</ul>
</div>
<?php endif; ?>
