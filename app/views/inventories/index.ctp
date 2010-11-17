<div class="inventories index">
<h2><?php __('Inventories');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th></th>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('section_id');?></th>
	<th><?php echo $paginator->sort('status');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
</tr>
<?php
$i = 0;
foreach ($inventories as $inventory):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr>
		<td>
			<?php
			if($inventory['Inventory']['status'] == 1){
				echo $html->link(__('Input', true), array('controller'=>'inventory_details', 'action'=>'add', $inventory['Inventory']['id'])); 
			}else{
				echo __('Input', true);
			}
			?>
		</td>
		<td>
			<?php echo $html->link(__($inventory['Inventory']['id'], true), array('controller'=>'inventories', 'action'=>'view', $inventory['Inventory']['id'])); ?>
		</td>
		<td>
			<?php echo $inventory['Inventory']['section_id']; ?>
		</td>
		<td>
			<?php echo $status[$inventory['Inventory']['status']]; ?>
		</td>
		<td>
			<?php echo $inventory['Inventory']['created']; ?>
		</td>
		<td>
			<?php echo $inventory['Inventory']['updated']; ?>
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
	<li><?php 
	echo $html->link(__('New Inventory', true), array('action'=>'add'), null, sprintf(__('%s inventory begins. Are you sure?', true), $loginUser['User']['section_name'])); 
	?> </li>
	</ul>
</div>
<ul>
<li>棚卸を開始する時は、棚卸開始をクリックして下さい。尚、1つの部門で複数の棚卸は開始できません。</li>
<li>新しい棚卸が作られると、棚卸中というデータが追加されます。Inputをクリックすると入力画面に、IDをクリックすると詳細画面に移ります。</li>
<li></li>
</ul>