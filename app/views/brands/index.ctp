<div class="brands index">
<p><a href="/buchedenoel/pages/masters">商品マスタ一覧</a></p>
<h2><?php __('Brands');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('*', true),'id');?></th>
	<th><?php echo $paginator->sort(__('Brand name', true), 'name');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th class="actions">Edit</th>
</tr>
<?php
$i = 0;
foreach ($brands as $brand):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $brand['Brand']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($brand['Brand']['name'], array('action'=>'view', $brand['Brand']['id'])); ?>
		</td>
		<td>
			<?php echo $brand['Brand']['updated']; ?>
		</td>
		<td class="actions">

			<?php echo $html->link('Edit', array('action'=>'edit', $brand['Brand']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< previous', array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next('next >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Brand', true), array('action'=>'add')); ?></li>
	</ul>
</div>
