<div class="itemImageView">
	<table cellpadding = "0" cellspacing = "0">
	<?php
	if(empty($item['ItemImage'])){
		echo '<tr><td>';
		echo $html->image('/img/itemimage/noimage.jpg', array('width'=>300, 'height'=>300));
		echo '</td></tr>';
	}else{
		foreach ($itemimages as $itemImage){
			echo '<tr><td>';
			echo $html->image('/img/itemimage/'.$itemImage['id'].'.jpg', array('width'=>300, 'height'=>300));
			echo '<br>'.$itemImage['name'].'  ';
			if($this->viewVars['loginUser']['User']['access_authority'] == '1' or $this->viewVars['loginUser']['User']['username'] == 'admin'){
				echo $html->link('(Edit)', array('controller'=> 'item_images', 'action'=>'edit', $itemImage['id']));
			}
			echo '</td></tr>';
		}
	}
	?>
	</table>
	<h3><?php __('Related Tags');?></h3>
	<?php
	foreach($item['Tag'] as $tag){
		echo ' | <strong>';
		echo $tag['name'];
		echo '</strong> | ';
	}
	?>
</div>

<div class="itemsview">
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('System No.'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Item Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Item Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pair'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		<?php if(!empty($pair['Item']['id'])):?>
				<?php echo $html->link($pair['Item']['name'], array('controller'=> 'items', 'action'=>'view', $pair['Item']['id'])); ?>
		<?php endif; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Price'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo number_format($item['Item']['price']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Brand'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Brand']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Item Property'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		<?php if(!empty($item['Item']['itemproperty'])):?>
			<?php echo $item['Item']['itemproperty']; ?>
		<?php endif; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Item Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		<?php if(!empty($item['Item']['itemtype'])):?>
			<?php echo $item['Item']['itemtype']; ?>
		<?php endif; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Size Basic'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		<?php if(!empty($item['Item']['basic_size'])):?>
			<?php echo $item['Item']['basic_size']; ?>
		<?php endif; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Size Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		<?php if(!empty($item['Item']['order_size'])):?>
			<?php echo $item['Item']['order_size']; ?>
		<?php endif; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cutom Order App'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['cutom_order_approve']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Factory'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Factory']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sales State'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['SalesStateCode']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Process'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Process']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Material'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Material']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Stone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Stone']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Stone Other'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['stone_other']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Stone Spec'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['stone_spec']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Message Stamp'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['message_stamp']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Message Stamp Ja'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['message_stamp_ja']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Release'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['release_day']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Order End'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['order_end_day']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Demension'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['demension']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Weight'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['weight']; ?>
			&nbsp;
		</dd>

		<!--
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Part Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['part_id']; ?>
			&nbsp;
		</dd>
		-->

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Unit'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['unit']; ?>
			&nbsp;
		</dd>
				<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Stock Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['stock_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Custom Order Days'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['custom_order_days']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Repair Days'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['repair_days']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Trans Approve'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['trans_approve']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('In Chain'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['in_chain']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sales Sum Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['sales_sum_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo nl2br($item['Item']['remark']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['created_user'].':'.$item['Item']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['updated_user'].':'.$item['Item']['updated']; ?>
			&nbsp;
		</dd>

	<?php if($addForm->opneUser(open_users(), $opneuser, 'access_authority')):?>
		</dl><div class="viewline">Only Head Office Staff</div><dl>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Atelier Trans App'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['atelier_trans_approve']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Order Approve'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['order_approve']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Labor Cost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo number_format($item['Item']['labor_cost']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Supply Full Cost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo number_format($item['Item']['supply_full_cost']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo number_format($item['Item']['cost']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Percent Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['percent_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Secret Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo nl2br($item['Item']['secret_remark']); ?>
			&nbsp;
		</dd>
	</dl>
	<ul>
		<li><?php echo $html->link(__('Edit Item', true), array('action'=>'edit', $item['Item']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Item', true), array('action'=>'delete', $item['Item']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $item['Item']['id'])); ?> </li>
		<li><?php echo $html->link(__('Add Image', true), array('controller'=> 'item_images', 'action'=>'add/'.$item['Item']['id']));?></li>
		<?php
			if($item['Item']['stock_code'] != '単品管理'){
				echo '<li>';
				echo $html->link(__('New Subitem', true), array('controller'=> 'subitems', 'action'=>'add/'.$item['Item']['id']));
				echo '</li>';
			}
			?>
	</ul>
	<?php endif; ?>
	<?php
	if($item['Item']['stock_code'] == '単品管理'){
		echo '</dl><div class="viewline">Special Order</div><dl><ul>';
		if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
			echo '<li>';
			echo $html->link(__('Special Order', true).'(WS)', array('controller'=> 'orders', 'action'=>'special_add_ws/'.$item['Item']['id']));
			echo '</li>';
		}
		echo '<li>';
		echo $html->link(__('Special Order', true), array('controller'=> 'orders', 'action'=>'special_add/'.$item['Item']['id']));
		echo '</li>';
		echo '</ul>';
	}
	?>
</div>
<div class="itemViewRelated">
	<h3><?php __('Related Subitems');?></h3>
	<?php if (!empty($item['Subitem'])):?>
	<?php
		echo $paginator->counter(array(
		'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
		));
	?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Subitems'); ?></th>
		<th><?php __('Jan'); ?></th>
		<th><?php __('Name Kana'); ?></th>
		<th><?php __('Updated'); ?></th>
		<th><?php __('Stock'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($subitems as $subitem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		$paginator->options(array('url' => $item['Item']['id']));
	?>
		<tr<?php echo $class;?>>
			<td><?php echo $html->link($subitem['Subitem']['name'], array('controller'=> 'subitems', 'action'=>'view', $subitem['Subitem']['id']));?></td>
			<td><?php echo $subitem['Subitem']['jan'];?></td>
			<td><?php echo $subitem['Subitem']['name_kana'];?></td>
			<td><?php echo substr($subitem['Subitem']['updated'], 0, 10); ?></td>
			<td><?php echo $html->link($subitem['Subitem']['total_qty'], array('controller'=> 'stocks', 'action'=>'index/subitem/'.$subitem['Subitem']['id']));?></td>
		</tr>
	<?php endforeach; ?>
	</table>
	<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
	</div>
<?php endif; ?>
</div>
<ul>
	<li>基本サイズと客注サイズは印刷時に使うだけ。</li>
</ul>