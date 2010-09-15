<div class="brandRates index">
<h2><?php __('BrandRates');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('*', true),'id');?></th>
	<th><?php echo $paginator->sort('company_id');?></th>
	<th><?php echo $paginator->sort('brand_id');?></th>
	<th><?php echo $paginator->sort('rate');?></th>
	<th><?php echo $paginator->sort('cancel_flag');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($brandRates as $brandRate):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $brandRate['BrandRate']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($brandRate['BrandRate']['company_name'], array('controller'=>'companies', 'action'=>'view', $brandRate['BrandRate']['company_id'])); ?>
		</td>
		<td>
			<?php echo $html->link($brandRate['BrandRate']['brand_name'], array('controller'=>'brands', 'action'=>'view', $brandRate['BrandRate']['brand_id'])); ?>
		</td>
		<td>
			<?php echo $brandRate['BrandRate']['rate']; ?>
		</td>
		<td>
			<?php echo $brandRate['BrandRate']['cancel_flag']; ?>
		</td>
		<td>
			<?php echo $brandRate['BrandRate']['updated']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $brandRate['BrandRate']['id'])); ?>
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