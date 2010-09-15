<div class="subitems index">
<h2><?php __('Subitems');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('item_id');?></th>
	<th><?php echo $paginator->sort('jan');?></th>
	<th><?php echo $paginator->sort('name_kana');?></th>
	<th><?php echo $paginator->sort('labor_cost');?></th>
	<th><?php echo $paginator->sort('supply_full_cost');?></th>
	<th><?php echo $paginator->sort('cost');?></th>
	<th><?php echo $paginator->sort('carat');?></th>
	<th><?php echo $paginator->sort('color');?></th>
	<th><?php echo $paginator->sort('clarity');?></th>
	<th><?php echo $paginator->sort('cut');?></th>
	<th><?php echo $paginator->sort('grade_report');?></th>
	<th><?php echo $paginator->sort('process_id');?></th>
	<th><?php echo $paginator->sort('material_id');?></th>
	<th><?php echo $paginator->sort('selldata_id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('created_user');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th><?php echo $paginator->sort('updated_user');?></th>
	<th><?php echo $paginator->sort('deleted');?></th>
	<th><?php echo $paginator->sort('deleted_date');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($subitems as $subitem):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $subitem['Subitem']['id']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['name']; ?>
		</td>
		<td>
			<?php echo $html->link($subitem['Item']['name'], array('controller'=> 'items', 'action'=>'view', $subitem['Item']['id'])); ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['jan']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['name_kana']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['labor_cost']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['supply_full_cost']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['cost']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['carat']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['color']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['clarity']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['cut']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['grade_report']; ?>
		</td>
		<td>
			<?php echo $html->link($subitem['Process']['name'], array('controller'=> 'processes', 'action'=>'view', $subitem['Process']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($subitem['Material']['name'], array('controller'=> 'materials', 'action'=>'view', $subitem['Material']['id'])); ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['selldata_id']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['created']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['created_user']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['updated']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['updated_user']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['deleted']; ?>
		</td>
		<td>
			<?php echo $subitem['Subitem']['deleted_date']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $subitem['Subitem']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $subitem['Subitem']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $subitem['Subitem']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $subitem['Subitem']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Subitem', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Items', true), array('controller'=> 'items', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Item', true), array('controller'=> 'items', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Processes', true), array('controller'=> 'processes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Process', true), array('controller'=> 'processes', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Materials', true), array('controller'=> 'materials', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Material', true), array('controller'=> 'materials', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Parts', true), array('controller'=> 'parts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Part', true), array('controller'=> 'parts', 'action'=>'add')); ?> </li>
	</ul>
</div>
