<div class="subitems view">
<h2><?php  __('Subitem');?></h2>
<p><?php __('Parent Item:');?><?php echo $html->link($subitem['Item']['name'], array('controller'=> 'items', 'action'=>'view', $subitem['Item']['id'])); ?></p>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('System No.'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Subitem Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Jan'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['jan']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Major Size'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['major_size']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Minority Size'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['minority_size']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name Kana'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['name_kana']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Process'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($subitem['Process']['name'], array('controller'=> 'processes', 'action'=>'view', $subitem['Process']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Material'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($subitem['Material']['name'], array('controller'=> 'materials', 'action'=>'view', $subitem['Material']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Selldata Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?> >
			<?php
			if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
				echo $html->link($subitem['Subitem']['selldata_id'], array('controller'=> 'orders', 'action'=>'view', $subitem['Subitem']['selldata_id']));
			}else{
				echo $html->link($subitem['Subitem']['selldata_id'], array('controller'=> 'orders', 'action'=>'store_view', $subitem['Subitem']['selldata_id']));
			}
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['created_user']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['updated']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['updated_user']; ?>
			&nbsp;
		</dd>
	</dl><div class="viewline">Only Anniversary</div><dl>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Carat'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['carat']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Color'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['color']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Clarity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['clarity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cut'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['cut']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Stone Cost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo number_format($subitem['Subitem']['stone_cost']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Grade Report'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['grade_report']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Grade Cost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo number_format($subitem['Subitem']['grade_cost']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Metal Gram'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['metal_gram'].'g'; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Metal Cost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo number_format($subitem['Subitem']['metal_cost']); ?>
			&nbsp;
		</dd>

	<?php if($this->viewVars['loginUser']['User']['access_authority'] == '1' or $this->viewVars['loginUser']['User']['username'] == 'admin'):?>
		</dl><div class="viewline">Only Head Office Staff</div><dl>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Purchase price'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['labor_cost']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Supply Full Cost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['supply_full_cost']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Average cost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subitem['Subitem']['cost']; ?>
			&nbsp;
		</dd>
	</dl>
	<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Subitem', true), array('action'=>'edit', $subitem['Subitem']['id'])); ?> </li>
		<li><?php echo $html->link(__('New Part', true), array('controller'=> 'parts', 'action'=>'add/'.$subitem['Subitem']['id']));?> </li>
	</ul>
	</div>
	<?php endif; ?>

</div>

<div class="actions">
	<ul>	
		<?php echo '<li>'.$addForm->switchAnchor('stock_revisions/add/'.$subitem['Subitem']['id'], array(2), null, 'Stock Revision', $subitem['Item']['stock_code']).'</li>'; ?>
	</ul>
</div>


<div class="related">
	<h3><?php __('Related Parts');?></h3>
	<?php if (!empty($subitem['Part'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Item Name'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Supply Code'); ?></th>
		<th><?php __('Updated'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($subitem['Part'] as $part):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $html->link($part['id'], array('controller'=> 'parts', 'action'=>'view', $part['id'])); ?></td>
			<td>
			<?php echo $html->link($part['item_name'], array('controller'=> 'items', 'action'=>'view', $part['item_id'])); ?>
			</td>
			<td><?php echo $part['quantity'];?></td>
			<td><?php echo $part['supply_code'];?></td>
			<td><?php echo $part['updated'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
<br>
<a href="javascript:;" onmousedown="if(document.getElementById('in_exp').style.display == 'none'){ document.getElementById('in_exp').style.display = 'block'; }else{ document.getElementById('in_exp').style.display = 'none'; }">
Explanation</a>
<div id="in_exp" style="display:none">
<ul>
<li>仕入原価は、発注時に表示される固定値。総平均原価は、仕入の度に計算される変動値。</li>
<li>仕入原価が「0」の場合、親品番の原価が、発注時に表示されます。</li>
<li>子品番の仕入原価が入っていない場合は、親品番の原価が採用される。</li>
<li>原価として採用される順位：仕入原価　→　親品番の原価</li>
<li></li>
</ul>
</div>