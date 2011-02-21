<div class="items form">
<?php echo $form->create('Item',array('type'=>'file','url'=>'csv_add'));?>
	<fieldset>
 		<legend><?php __('CSV Add Item');?></legend>
		<?php 
		
		echo $form->input('Item.upload_file',array('label'=>'Upload CSV ','type'=>'file'));
		echo $form->end('submit');
		?>
	</fieldset>
</div>
<p style="margin:20px;">
新しい品番・JANコードなどを、旧システムから取り込むことができます。<br>
<br>
旧システム　→　商品照会<br>
条件を入力して商品一覧を押す　→　初回抽出を押す<br>
抽出○○件と表示が出る。300件以上は取り込めないと思います。条件を変えて下さい。<br>
CSV出力を押す　→　CSVファイルをデスクトップなど適当な所に保存する。<br>
このページの参照を押す　→　先程保存したCSVを選択する。<br>
Submitを押す。　→　しばらく待つ。以上。<br>
<br>
JANコードを確認して、JANコードが無ければ新しく追加します。それ以外の動作はしません。<br>
</p>