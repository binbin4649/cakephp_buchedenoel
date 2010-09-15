<div class="bankAcuts index">
<h2><?php __('BankAcuts');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort(__('Bank Name', true),'name');?></th>
	<th><?php echo $paginator->sort('account_number');?></th>
	<th><?php echo $paginator->sort('account_type');?></th>
</tr>
<?php
$i = 0;
foreach ($bankAcuts as $bankAcut):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $bankAcut['BankAcut']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($bankAcut['BankAcut']['name'], array('action'=>'view', $bankAcut['BankAcut']['id'])); ?>
		</td>
		<td>
			<?php echo $bankAcut['BankAcut']['account_number']; ?>
		</td>
		<td>
			<?php echo $accountType[$bankAcut['BankAcut']['account_type']]; ?>
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
		<li><?php echo $html->link(__('New BankAcut', true), array('action'=>'add')); ?></li>
	</ul>
</div>
