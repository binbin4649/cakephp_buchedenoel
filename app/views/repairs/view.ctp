<div class="repairs view">
<p><?php echo $html->link(__('List Repairs', true), array('action'=>'index')); ?> </p>
<h2><?php  __('Repair View');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Repair']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Section']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Item'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Item']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Size'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Repair']['size']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Factory'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Factory']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Charge Person'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['User']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Control Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Repair']['control_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repairStatus[$repair['Repair']['status']]; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Estimate Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if(!empty($repair['Repair']['estimate_status'])) echo $estimateStatus[$repair['Repair']['estimate_status']]; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Reception Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Repair']['reception_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Store Arrival Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Repair']['store_arrival_date']; ?>
			&nbsp;
		</dd>
		<?php
		if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
			echo '<dt>工場納期</dt>';
			echo '<dd>';
			echo $repair['Repair']['factory_delivery_date'].'&nbsp;';
			echo '</dd>';
		}
		?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Shipping Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Repair']['shipping_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Customer Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Repair']['customer_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Customer Tel'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Repair']['customer_tel']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Repair Content'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Repair']['repair_content']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Remarks'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo nl2br($repair['Repair']['remark']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Repair Price'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
			echo number_format($repair['Repair']['repair_price']);
			if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
				echo '　:(下代)';
				echo number_format($repair['Repair']['reapir_cost']);
			}
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Repair']['created_user'].' : '.$repair['Repair']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $repair['Repair']['updated_user'].' : '.$repair['Repair']['updated']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
		<?php
		if($addForm->opneUser(open_users(), $opneuser, 'access_authority')){
			echo '<ul><li>';
			echo $html->link(__('Edit Repair', true), array('action'=>'edit', $repair['Repair']['id']));
			echo '</li></ul>';
			echo '<ul><li>';
			echo $addForm->switchAnchor('repairs/head_check/'.$repair['Repair']['id'], array(2, 3, 4, 5, 6, 7, 8, 9), 'Check and change the office. Are you all right?', 'Head Check Repair', $repair['Repair']['status']);
			echo '</li><li>';
			echo $addForm->switchAnchor('repairs/arrival_factory/'.$repair['Repair']['id'], array(4, 5, 6, 7, 8, 9), 'Arrival from the factory. Are you all right?', 'Arrival Factory', $repair['Repair']['status']);
			echo '</li><li>';
			echo $addForm->switchAnchor('repairs/ships_head/'.$repair['Repair']['id'], array(5, 6, 7, 8, 9), 'Ships Head. Are you all right?', 'Ships Head', $repair['Repair']['status']);
			echo '</li></ul>';
		}else{
			echo '<ul><li>';
			echo $html->link(__('Edit Repair', true), array('action'=>'store_edit', $repair['Repair']['id']));
			echo '</li></ul>';
			echo '<ul><li>';
			echo $addForm->switchAnchor('repairs/arrival_store/'.$repair['Repair']['id'], array(1, 2, 3, 4, 6, 7, 8, 9), 'Arrival Stores. Are you all right?', 'Arrival Store', $repair['Repair']['status']);
			echo '</li><li>';
			echo $addForm->switchAnchor('repairs/complete/'.$repair['Repair']['id'], array(1, 2, 3, 4, 7, 8, 9), 'Complete. Are you all right?', 'Complete', $repair['Repair']['status']);
			echo '</li></ul>';
		}
		?>
</div>
