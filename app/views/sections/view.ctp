<div class="sections view">
<p>
	<?php echo $html->link(__('List Sections', true), array('action'=>'index')); ?>
	　/　
	<?php echo $html->link($section['Section']['name'].'　予算・目標', array('controller'=>'amount_sections', 'action'=>'mark', $section['Section']['id'])); ?>
</p>
<h2><?php  __('Section View');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('System No.'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['name']; ?>
			&nbsp;
		</dd>
		<!--
		<dt<?php if ($i % 2 == 0) echo $class;?>>本日売上：前受金額</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo number_format($today_total['sale_total_total']).' ： '.number_format($today_total['prev_money_total']); ?>
			&nbsp;
		</dd>
		-->
	</dl>

	<div id='datail'>
	<a href="javascript:;" onmousedown="if(document.getElementById('in_dateil').style.display == 'none'){ document.getElementById('in_dateil').style.display = 'block'; }else{ document.getElementById('in_dateil').style.display = 'none'; }">
	details</a>
	<div id="in_dateil" style="display:none">
	<dl>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('English'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['name_english']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sales Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if(!empty($section['Section']['sales_code'])) echo $sales_code[$section['Section']['sales_code']]; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['kanjo_bugyo_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tax Method'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['tax_method']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tax Fraction'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['tax_fraction']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Post Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['post_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('District'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if(!empty($section['Section']['district'])) echo $district[$section['Section']['district']]; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Adress 1'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['adress_one']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Adress 2'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['adress_two']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tel'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['tel']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Fax'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['fax']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mail'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['mail']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section Open'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['start_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section Close'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['close_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Contact User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if(!empty($contact_user)) echo $contact_user['User']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
			echo $section['Section']['created_user'];
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['updated_user']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Remarks'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo nl2br($section['Section']['remarks']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['updated']; ?>
			&nbsp;
		</dd>

	<?php if($addForm->opneUser(open_users(), $opneuser, 'access_authority')):?>
		</dl><div class="viewline">Only Head Office Staff</div><dl>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Auto Share Priority'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['auto_share_priority']; ?>
			&nbsp;
		</dd>
	</dl>
	<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Section', true), array('action'=>'edit', $section['Section']['id'])); ?> </li>
	</ul>
	</div>

	<?php endif; ?>
</div>
</div>
</div>

<div class="related">
	<h3><?php __('Related Users');?></h3>
	<?php if (!empty($section['User'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('System Number'); ?></th>
		<th><?php __('Users Name'); ?></th>
		<th><?php __('Post'); ?></th>
		<th><?php __('Employment'); ?></th>
		<th><?php __('Work Situation'); ?></th>
		<th><?php __('Updated'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($section['User'] as $user):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $user['id'];?></td>
			<td>
			<?php
			if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
				echo $html->link($user['name'], array('controller'=> 'users', 'action'=>'view', $user['id']));
			}elseif($user['duty_code'] <> '30'){
				echo $html->link($user['name'], array('controller'=> 'users', 'action'=>'view', $user['id']));
			}else{
				echo $user['name'];
			}
			?>
			</td>
			<td><?php if(!empty($user['post_id'])) echo $post[$user['post_id']];?></td>
			<td><?php if(!empty($user['employment_id'])) echo $employment[$user['employment_id']];?></td>
			<td><?php if(!empty($user['duty_code'])) echo $duty_code[$user['duty_code']];?></td>
			<td><?php echo $user['updated'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>

<div class="Related">
	<h3><?php __('Depots');?></h3>
	<?php if (!empty($section['Depot'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Depot No.'); ?></th>
		<th>旧店舗番号</th>
		<th><?php __('Depot Name'); ?></th>
		<th><?php __('default'); ?></th>
		<th><?php __('Stock'); ?></th>
		<th><?php __('Updated'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($section['Depot'] as $depot):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $html->link($depot['id'], array('controller'=> 'depots', 'action'=>'view/'.$depot['id']));?></td>
			<td><?php echo $depot['old_system_no'];?></td>
			<td><?php echo $depot['name']; ?></td>
			<td><?php if($depot['id'] == $this->viewVars['section']['Section']['default_depot']) echo 'Default';?></td>

			<td><?php echo $html->link($depot['stock_total'], array('controller'=> 'stocks', 'action'=>'index/depot/'.$depot['id']));?></td>

			<td><?php echo $depot['updated'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
<ul>
	<li><?php echo $html->link(__('New Depot', true), array('controller'=>'depots', 'action'=>'add', $section['Section']['id'])); ?></li>
</ul>
<ul>
<li>営業開始開始日、営業終了日のどちらか、又は両方が入っている部門は、売上の集計対象となります。</li>
</ul>
</div>