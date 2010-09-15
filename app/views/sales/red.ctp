<div class="view">
<?php echo '<p>'.$html->link(__('Return View No.'.$sale['Sale']['id'], true), array('controller'=>'sales', 'action'=>'view/'.$sale['Sale']['id'])).'</p>'; ?>
	<fieldset>
 		<h3><?php __('Return Sales');?></h3>
	<?php
		echo $form->create('Sale', array('action'=>'red'));
		echo $form->hidden('Sale.id', array('value'=>$sale['Sale']['id']));
		echo '<dl>';
		echo '<dt>'.__('Sale No.').'</dt><dd>'.$sale['Sale']['id'].'　</dd>';
		echo '<dt>'.__('Sale Date').'</dt><dd>'.$sale['Sale']['date'].'　</dd>';
		//echo '<dt>'.__('Return Sales Date').'</dt><dd>';
		echo '<dt>赤伝日付</dt><dd>';
		echo $form->input('Sale.date', array(
			'type'=>'date',
			'dateFormat'=>'YMD',
			'label'=>false,
			'minYear'=>MINYEAR,
			'maxYear' => MAXYEAR,
			'selected'=>date('Y-m-d'),
			'div'=>false
		));
		echo '</dd>';
		echo '</dl>';

		$total_quantity = 0;
		echo '<table class="itemDetail"><tr><th colspan="6">売上明細</th></tr><tr><th>子品番</th><th>売上単価</th><th>参考上代</th><th>刻印</th><th>数量</th></tr>';
		foreach($sale['SalesDateil'] as $detail){
			echo '<tr>';
			echo '<td>'.$detail['subitem_name'].'</td>';
			echo '<td>'.number_format($detail['bid']).'</td>';
			echo '<td>'.number_format($detail['ex_bid']).'</td>';
			echo '<td>'.$detail['marking'].'</td>';
			echo '<td>'.$detail['bid_quantity'].'</td>';
			echo '</tr>';
			$total_quantity = $total_quantity + $detail['bid_quantity'];
		}
		echo '<tr><td></td><td></td><td></td><td>数量合計</td><td>'.$total_quantity.'</td></tr>';
		echo '</table>';
		echo '<p>上記内容で赤伝売上を立てます。取消できませんので、よく確認して送信を押して下さい。</p>';
		echo $form->end(__('Submit', true));
	?>
	</fieldset>
</div>