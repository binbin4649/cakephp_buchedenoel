<div class="items form">
<?php echo $form->create('Item',array('type'=>'file','url'=>'csv_add'));?>
	<fieldset>
 		<legend><?php __('CSV Add Item');?></legend>
		<?php 
		echo $form->input('Item.depot', array(
			'type'=>'text',
			'label'=>__('Depot', true),
			'size'=>2
		));
		echo $form->input('Item.upload_file',array('label'=>'Upload CSV ','type'=>'file'));
		echo $form->end('submit');
		?>
	</fieldset>
</div>
<p style="margin:20px;">
<ul>
<li>新しい品番・JANコードなどを、旧システムから取り込むことができます。</li>
<li>JANコードを確認して、JANコードが無ければ新しく追加します。その際、親品番がなければ親品番も登録します。</li>
<li>単品管理のJANコードだった場合、在庫を1にして登録します。単品管理以外は在庫登録されません。</li>
<li>単品管理で在庫を1にする倉庫を指定できます。指定がない場合は倉庫番号（910）になります。</li>
<li>アニバ、ファサード、カフナ、LUV、sweetsは自動的に単品管理で登録されます。</li>
</ul>
</p>
<p style="margin:50px;">
【やり方】<br>
旧システム　→　商品照会<br>
条件を入力して商品一覧を押す　→　初回抽出を押す<br>
抽出○○件と表示が出る。300件以上は取り込めないと思います。条件を変えて下さい。<br>
CSV出力を押す　→　CSVファイルをデスクトップなど適当な所に保存する。<br>
このページの参照を押す　→　先程保存したCSVを選択する。<br>
Submitを押す。　→　しばらく待つ。以上。<br>
</p>