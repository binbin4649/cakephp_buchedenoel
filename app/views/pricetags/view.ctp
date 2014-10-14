<div class="view">
<p><?php echo $html->link(__('Tag Order List', true), array('action'=>'index')); ?> </p>
<h2><?php  __('PriceTag Order');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('No.'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pricetag['Pricetag']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $status[$pricetag['Pricetag']['pricetag_status']]; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pricetag['Section']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Total Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pricetag['Pricetag']['total_quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Remarks'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo nl2br($pricetag['Pricetag']['remark']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('File'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
			if(!empty($prints)){
				foreach($prints as $print){
					echo '<a href="/'.SITE_DIR.'/files/pricetagcsv/'.$print.'" target="_blank">'.$print.'</a><br>';
				}
				echo '右クリック「リンク先を保存」を選択して保存してください。';
			}
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pricetag['Pricetag']['created_user'].' : '.$pricetag['Pricetag']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pricetag['Pricetag']['updated_user'].' : '.$pricetag['Pricetag']['updated']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php if($addForm->opneUser(array('1'), $opneuser, 'access_authority')): ?>
<div class="actions">
	<ul>
		<li><?php echo $addForm->switchAnchor('pricetags/csv/'.$pricetag['Pricetag']['id'], array(2, 3, 4), 'CSV Data OutPut OK?', 'Output CSV Data', $pricetag['Pricetag']['pricetag_status']); ?></li>
		<li><?php echo $addForm->switchAnchor('pricetags/comp/'.$pricetag['Pricetag']['id'], array(1, 3, 4), 'Complete OK?', 'Complete', $pricetag['Pricetag']['pricetag_status']); ?></li>
	</ul>
</div>
<?php endif; ?>
<?php if($addForm->opneUser(array('1'), $opneuser, 'access_authority') or $addForm->opneUser(array($pricetag['Section']['id']), $opneuser, 'section_id')): ?>
<div class="actions">
	<ul>
		<li><?php echo $addForm->switchAnchor('pricetags/cancel/'.$pricetag['Pricetag']['id'], array(3, 4), 'Cancel OK?', 'Cancel', $pricetag['Pricetag']['pricetag_status']); ?></li>
	</ul>
</div>
<?php endif; ?>
	<h3><?php __('Pricetag Detail');?></h3>
	<?php if (!empty($pricetag['PricetagDetail'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('*'); ?></th>
		<th><?php __('Subitem'); ?></th>
		<th><?php __('Qty'); ?></th>
		<th><?php __('Created'); ?></th>
		<th></th>
	</tr>
	<?php
		$total_quantity = 0;
		$i = 0;
		foreach ($pricetag['PricetagDetail'] as $PricetagDetail):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
			$total_quantity = $total_quantity + $PricetagDetail['quantity'];
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $PricetagDetail['id'];?></td>
			<td><?php echo $PricetagDetail['Subitem']['name'];?></td>
			<td><?php echo $PricetagDetail['quantity'];?></td>
			<td><?php echo $PricetagDetail['created'];?></td>
			<td>
				<?php if($addForm->opneUser(array('1'), $opneuser, 'access_authority') or $addForm->opneUser(array($pricetag['Section']['id']), $opneuser, 'section_id')): ?>
				<?php echo $addForm->switchAnchor('pricetags/del/'.$PricetagDetail['id'], array(2, 3, 4), 'Delete OK?', 'Del', $pricetag['Pricetag']['pricetag_status']); ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	<tr>
	<td></td>
	<td>合計</td>
	<td><?php echo $total_quantity;?></td>
	<td></td>
	</tr>
	</table>
<?php endif; ?>
<p>
CSVファイルのファイル名の見方<br>
ブランド番号　-　部門番号　-　発注番号　-　年月日時分秒.csv<br>
</p>