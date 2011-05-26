<?php
/* SVN FILE: $Id: bootstrap.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 *
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php is loaded
 * This is an application wide file to load any function that is not used within a class define.
 * You can also use this to include or require any files in your application.
 *
 */
/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * $modelPaths = array('full path to models', 'second full path to models', 'etc...');
 * $viewPaths = array('this path to views', 'second full path to views', 'etc...');
 * $controllerPaths = array('this path to controllers', 'second full path to controllers', 'etc...');
 *
 */
//EOF

//在庫が無くても永久に取り置き出来るモード、TRUEで在庫とか無視、通常はFALSE
define('EMERGENCY_LANDING', TRUE);

//AmountでOrderを無視して売上合計を直接入力するモード
define('AMOUNT_LANDING', TRUE);

define('MAXYEAR', 2011);
define('MINYEAR', 2009);
define('TAX_RATE', 5);//5=5%
define('INC_NAME_JA', '株式会社ザ･キッス');
define('INC_ADDRESS1', '東京都渋谷区道玄坂1-12-1');
define('INC_ADDRESS2', '渋谷マークシティ　ウエスト23F');
define('INC_POSTCODE', '150-0043');
define('INC_TEL', '03-5457-1122');
define('INC_FAX', '03-5457-1135');
define('BANK1', '三菱東京UFJ銀行　恵比寿支店　当座：1343727');
define('BANK2', 'みずほ銀行　　　 六本木支店　当座：148483');
define('BANK3', '三井住友銀行　　 渋谷支店　　当座：208352');
define('REPAIR_PERSON', '商品課　大塚');

//モデルキャッシュ関連
define('CACHE_TODAY', '86400');//1800 = 30分　86400＝24時間
define('CACHE_RANKING', '43200');//43200 = 12時間
define('CACHE_TODAY_RANKING', '3600');//3600 = 1時間
define('CACHE_WEEK', '43200');//43200 = 12時間 右カラム

//新店と既存店の基準日。基準日より新しければ新店、古ければ既存店。
define('NEW_SHOP_FLAG', '2011-04-01');

//海外店を指定する。そのうちＤＢにしたいです
function get_overseashop_list(){
	return array(
		'0'=>'406',//KOREA THE KISS COEX-MALL
		'1'=>'404',//MACAU girl’s talk！ MACAO
		'2'=>'405',//MACAU THE KISS MACAO
	);
}

function open_users(){
	return array(1, 3);
}

function get_year_list(){
	return array(
		'2009'=>'2009',
		'2010'=>'2010',
		'2011'=>'2011',
	);
}

function get_month_list(){
	return array(
		'01'=>'01',
		'02'=>'02',
		'03'=>'03',
		'04'=>'04',
		'05'=>'05',
		'06'=>'06',
		'07'=>'07',
		'08'=>'08',
		'09'=>'09',
		'10'=>'10',
		'11'=>'11',
		'12'=>'12',
	);
}

function get_district(){ //都道府県
	return array(
	'20'=>__('Hokkaido',true),//北海道
	'30'=>__('Aomori',true),//青森県
	'40'=>__('Iwate',true),//岩手県
	'50'=>__('Miyagi',true),//宮城県
	'60'=>__('Akita',true),//秋田県
	'70'=>__('Yamagata',true),//山形県
	'80'=>__('Fukushima',true),//福島県
	'90'=>__('Ibaragi',true),//茨城県
	'100'=>__('Tochigi',true),//栃木県
	'110'=>__('Gunma',true),//群馬県
	'120'=>__('Saitama',true),//埼玉県
	'130'=>__('Chiba',true),//千葉県
	'140'=>__('Tokyo',true),//東京都
	'150'=>__('Kanagawa',true),//神奈川県
	'160'=>__('Niigata',true),//新潟県
	'170'=>__('Toyama',true),//富山県
	'180'=>__('Ishikawa',true),//石川県
	'190'=>__('Fukui',true),//福井県
	'200'=>__('Yamanashi',true),//山梨県
	'210'=>__('Nagano',true),//長野県　210と220が二つあるぞ
	'220'=>__('Gifu',true),//岐阜県
	'210'=>__('Shizuoka',true),//静岡県
	'220'=>__('Aichi',true),//愛知県
	'230'=>__('Mie',true),//三重県
	'240'=>__('Shiga',true),//滋賀県
	'250'=>__('Kyoto',true),//京都府
	'260'=>__('Osaka',true),//大阪府
	'265'=>__('Hyogo',true),//兵庫県
	'270'=>__('Nara',true),//奈良県
	'280'=>__('Wakayama',true),//和歌山県
	'290'=>__('Tottori',true),//鳥取県
	'300'=>__('Shimane',true),//島根県
	'310'=>__('Okayama',true),//岡山県
	'320'=>__('Hiroshima',true),//広島県
	'330'=>__('Yamaguchi',true),//山口県
	'340'=>__('Tokushima',true),//徳島県
	'350'=>__('Kagawa',true),//香川県
	'360'=>__('Ehime',true),//愛媛県
	'370'=>__('Kochi',true),//高知県
	'380'=>__('Fukuoka',true),//福岡県
	'390'=>__('Saga',true),//佐賀県
	'400'=>__('Nagasaki',true),//長崎県
	'410'=>__('Kumamoto',true),//熊本県
	'420'=>__('Oita',true),//大分県
	'430'=>__('Miyazaki',true),//宮崎県
	'440'=>__('Kagoshima',true),//鹿児島県
	'450'=>__('Okinawa',true),//沖縄県
	'460'=>__('Other',true)//その他
	);
}

function get_sex(){ //性別
	return array(
		'm'=>'Male',
		'f'=>'Female'
	);
}

function get_blood_type(){ //血液型
	return array(
		'A'=>'A',
		'B'=>'B',
		'O'=>'O',
		'AB'=>'AB'
	);
}

function get_duty_code(){ //在籍区分
	return array(
		'10'=>__('Enrollment',true),//在籍
		'20'=>__('Leave',true),//休職
		'30'=>__('Retirement',true)//退職
	);
}

function get_access_authority(){ //アクセス権限管理
	return array(
		'1'=>'Head Office Staff',
		'2'=>'Shop Staff',
		'3'=>'User Editor'
	);
}

function get_sales_code(){ //部門区分
	return array(
		'1'=>__('Sales(Shops)',true),//営業部門（店舗）
		'2'=>__('Sales(Not Shops)',true),//営業部門（店舗以外）
		'3'=>__('Non-business sector',true),//非営業部門
		'4'=>__('Close sector',true),
	);
}

function get_stock_code(){ //在庫管理区分、在庫管理しない：送料とかBOXとか
	return array(
		'1'=>__('Inventory Management',true),//在庫管理する
		'2'=>__('Not Inventory Management',true),//在庫管理しない
		'3'=>__('Single Management',true)//単品管理
	);
}

function get_unit(){ //寸法基準単位
	return array(
		'1'=>__('mm(Vertical*Width*Thickness)',true),//cm(縦x横x厚さ)
		'2'=>__('mm(Vertical*Width)',true),//cm(縦x横)
		'3'=>__('mm(Width*Thickness)',true),//cm(幅x厚さ)
		'4'=>__('mm(Diameter*Thickness)',true),//cm(直径x厚さ)
		'5'=>__('mm(Diameter*Width)',true),//cm(直径x幅)
		'6'=>__('mm(Diameter*Width*Thickness)',true),//cm(直径x幅x厚さ)
		'99'=>__('Other',true),//その他
	);
}

function get_order_approve(){ //卸受注可否
	return array(
		'1'=>__('Can Order',true),//卸受注可
		'2'=>__('Not Order',true)//卸受注不可
	);
}

function get_cutom_order_approve(){ //客注可否
	return array(
		'1'=>__('Can Custom Order',true),//客注可
		'2'=>__('Not Custom Order',true),//客注不可
		'3'=>__('Can Custom Order(Even)',true),//客注可（偶数可）
		'4'=>__('Can Custom Order(Odd)',true),//客注可（奇数のみ）
	);
}

function get_trans_approve(){ //サイズ直し可否
	return array(
		'1'=>__('Can Resize',true),//サイズ直し可
		'2'=>__('Not Resize',true)//サイズ直し不可
	);
}

function get_atelier_trans_approve(){ //アトリエサイズ直し可否
	return array(
		'1'=>__('Can Resize',true),//サイズ直し可
		'2'=>__('Not Resize',true)//サイズ直し不可
	);
}

function get_percent_code(){ //掛率適用区分
	return array(
		'1'=>__('Rate Apply',true),//掛率適用
		'2'=>__('Not Rate Apply',true)//掛率適用なし
	);
}

function get_sales_sum_code(){ //計上区分
	return array(
		'1'=>__('Product Cost',true),//仕入
		'2'=>__('Expenses',true)//経費
	);
}

function get_color(){// 4Cのカラー
	return array(
		'D'=>'D',
		'E'=>'E',
		'F'=>'F',
		'G'=>'G',
		'H'=>'H',
		'I'=>'I',
		'J'=>'J',
		'K'=>'K',
		'L'=>'L',
		'M'=>'M',
		'N'=>'N',
		'O'=>'O',
		'P'=>'P',
		'Q'=>'Q',
		'R'=>'R'
	);
}

function get_clarity(){// 4Cのクラリティー
	return array(
		'FL'=>'FL',
		'IF'=>'IF',
		'VVS1'=>'VVS1',
		'VVS2'=>'VVS2',
		'VS1'=>'VS1',
		'VS2'=>'VS2',
		'SI1'=>'SI1',
		'SI2'=>'SI2',
		'I1'=>'I1',
		'I2'=>'I2',
		'I3'=>'I3',
	);
}

function get_cut(){// 4Cのカット
	return array(
		'3EXHC'=>'3EXHC',
		'3EX'=>'3EX',
		'HC'=>'HC',
		'EX'=>'EX',
		'VG'=>'VG',
		'G'=>'G',
		'F'=>'F',
		'P'=>'P',
	);
}

function get_supply_code(){//支給品か？どうか？
	return array(
		'1'=>__('Articles supplied',true),//支給品
		'2'=>__('Parts',true),//構成部品
	);
}

function get_tax_method(){//消費税計算方法
	return array(
		'1'=>__('By Bill',true),//伝票単位
		'2'=>__('By Breakdown',true),//明細単位
		'3'=>__('By Production',true),//単品単位
		'4'=>__('By Monthly Bill',true),//請求単位
	);
}

function get_tax_fraction(){//端数処理の方法
	return array(
		'1'=>__('Dropfration',true),//切り捨て
		'2'=>__('Revaluation',true),//切り上げ
		'3'=>__('Round Off',true),//四捨五入
	);
}

function get_total_day(){//締め日
	return array(
		'1'=>__('End Of Every Month',true),//毎月末締め
		'2'=>__('Every 5th',true),//毎月5日締め
		'3'=>__('Every 10th',true),//毎月10日締め
		'4'=>__('Every 15th',true),//毎月15日締め
		'5'=>__('Every 20th',true),//毎月20日締め
		'6'=>__('Every 25th',true),//毎月25日締め
		'98'=>__('Any Time',true),//随時
		'99'=>__('Other',true),
	);
}

function get_payment_day(){//支払日、回収日
	return array(
		'1'=>__('End Of Month',true),//当月末
		'2'=>__('End Of Next Month',true),//翌月末
		'3'=>__('End Of Next Next Month',true),//翌々月末
		'4'=>__('Next 5th',true),//翌月5日
		'5'=>__('Next 10th',true),//翌月10日
		'6'=>__('Next 15th',true),//翌月15日
		'7'=>__('Next 20th',true),//翌月20日
		'8'=>__('Next 25th',true),//翌月25日
		'9'=>__('Next Next 5th',true),//翌々月5日
		'10'=>__('Next Next 10th',true),//翌々月10日
		'11'=>__('Next Next 15th',true),//翌々月15日
		'12'=>__('Next Next 20th',true),//翌々月20日
		'13'=>__('Next Next 25th',true),//翌々月25日
		'98'=>__('Any Time',true),//随時
		'99'=>__('Other',true),
	);
}

function get_payment_code(){//支払い方法
	return array(
		'1'=>__('Cash',true),//現金
		'2'=>__('Cheque',true),//手形
		'99'=>__('Other',true),//その他
	);
}

function get_trading_flag(){//取引継続区分
	return array(
		'1'=>__('Continuation',true),//継続中
		'2'=>__('Pause',true),//一時休止
		'3'=>__('Stop',true),//停止
	);
}

function get_itemproperty(){//アイテム属性
	return array(
		'6'=>'Pair',
		'1'=>'Pair/Ladys',
		'2'=>'Pair/Mens',
		'3'=>'Ladys',
		'4'=>'Mens',
		'5'=>'Other',
	);
}

function get_itemtype(){//アイテムの型、タイプ
	return array(
		'1'=>__('Ring',true),//リング
		'2'=>__('Necklace',true),//ネックレス
		'3'=>__('Necklace Chain',true),//ネックレスチェーン
		'4'=>__('Pendant Top',true),//ペンダントトップ
		'5'=>__('bracelet',true),//ブレスレット・バングル
		'6'=>__('earring',true),//ピアス
		'7'=>__('Anklet',true),//アンクレット
		'8'=>__('Clock',true),//ウオッチ
		'9'=>__('Strap',true),//ストラップ
		'10'=>__('lighter',true),//ライター
		'11'=>__('Marriage',true),//マリッジ
		'12'=>__('Engage',true),//エンゲージ
		'13'=>__('Charm',true),//チャーム
		'99'=>__('Other',true),//その他
	);
}

function get_memo_sections(){//部門、店舗含む
	return array(
		'1'=>__('Salers',true),//営業部
		'2'=>__('Product',true),//商品部
		'3'=>__('Management',true),//管理部
		'4'=>__('Marketing',true),//マーケティング室
		'5'=>__('Design',true),//デザイン室
		'6'=>__('System',true),//システム室
		'7'=>__('Shops',true),//直営店
		'8'=>__('Customer Center',true),//カスタマーセンター
		'99'=>__('Other',true),//その他
	);
}

function get_top_flag(){//掲示板の記事をトップに表示するかのフラグ
	return array(
		'none'=>__('Normal',true),//通常
		'top'=>__('Top Expression',true),//トップ表示
		'only'=>__('Office Staff Only',true),//本社専用
	);
}

function get_major_size(){
	return array(
		'#1'=>'#1',
		'#3'=>'#3',
		'#5'=>'#5',
		'#7'=>'#7',
		'#9'=>'#9',
		'#11'=>'#11',
		'#13'=>'#13',
		'#15'=>'#15',
		'#17'=>'#17',
		'#19'=>'#19',
		'#21'=>'#21',
		'40cm'=>'40cm',
		'50cm'=>'50cm',
		'other'=>'その他',
	);
}

function get_invoice_type(){
	return array(
		'1'=>'月締め',
		'2'=>'都度請求（代引き）',
		'3'=>'都度請求',
		'4'=>'請求不要',
		'99'=>'その他',
	);
}

function get_trade_type(){//取引状態
	return array(
		'1'=>'継続',
		'2'=>'休止',
		'3'=>'停止',
		'4'=>'契約前',
	);
}

function get_shipping_flag(){
	return array(
		'1'=>'送料発生する',
		'2'=>'送料発生しない',
	);
}

function get_cancel_flag(){
	return array(
		'1'=>'適用',
		'2'=>'適用無',
	);
}

function get_ordering_status(){
	return array(
		'1'=>'保留',
		'2'=>'確定',
		'3'=>'印刷済',
		'4'=>'FAX済',
		'5'=>'入荷済',
		'6'=>'取消',
	);
}

function get_purchase_status(){
	return array(
		'1'=>'保留',
		'2'=>'仕入済',
		'3'=>'締済',
		'4'=>'取消',
	);
}

function log_plus(){
	return array(
		'1'=>'仕入',
		'2'=>'入庫',
		'3'=>'修正',
		'4'=>'出庫取消',
		'5'=>'売上取消',
	);
}

function log_mimus(){
	return array(
		'1'=>'売上',
		'2'=>'出庫',
		'3'=>'修正',
		'4'=>'取置'
	);
}

function get_pay_status(){//1は保留でシステム的に使っているものなので、選択できないように含めていない
	return array(
		'2'=>'実行前',
		'3'=>'支払済',
		'4'=>'取消',
	);
}

function get_pay_way_type(){
	return array(
		'1'=>'現金',
		'2'=>'手形',
		'99'=>'その他',
	);
}

function get_transport_status(){
	return array(
		'1'=>'出庫前',
		'2'=>'出庫済',
		'3'=>'入庫済',
		'4'=>'取消',
	);
}

function get_stock_change(){
	return array(
		'1'=>'在庫増',
		'2'=>'在庫減',
	);
}

function get_reason_type(){
	return array(
		'1'=>'盗難',
		'2'=>'クレーム対応',
		'3'=>'業務使用',
		'4'=>'移動ミス',
		'5'=>'棚卸ミス',
		'6'=>'業務ミス',
		'7'=>'協賛',
		'99'=>'その他',
	);
}

function get_pricetag_status(){
	return array(
		'1'=>'保留',
		'2'=>'締切',
		'3'=>'完了',
		'4'=>'取消',
	);
}

function get_order_type(){
	return array(
		'1'=>'受注(卸)',
		'2'=>'客注',
		'3'=>'注残破棄(卸)',
		'4'=>'特別注文',
		'5'=>'手配済',
		'6'=>'現売',
		'7'=>'取置',
	);
}

function get_order_status(){
	return array(
		'1'=>'未完',
		'2'=>'PL印刷済',
		'3'=>'確定',
		'4'=>'完了',
		'5'=>'取消',
		'6'=>'社販',
	);
}

function get_layaway_type(){
	return array(
		'1'=>'取置入力待ち',
		'2'=>'取置入力済み',
	);
}

function get_sale_type(){
	return array(
		'1'=>'卸売上',
		'2'=>'通常売上',
		'3'=>'社販',
		'4'=>'その他',
	);
}

function get_sale_status(){
	return array(
		'1'=>'印刷前',
		'2'=>'印刷済',
		'3'=>'請求済',
		'4'=>'赤伝',
		'5'=>'取消',
		'6'=>'その他',
		'7'=>'通常売上',
	);
}

function get_invoice_status(){
	return array(
		'1'=>'印刷前',
		'2'=>'印刷済',
		'3'=>'完了',
		'4'=>'取消',
		'5'=>'その他',
	);
}

function get_credit_methods(){
	return array(
		'1'=>'振込',
		'2'=>'現金',
		'3'=>'小切手',
		'4'=>'手形',
		'5'=>'その他',
	);
}

function get_account_type(){
	return array(
		'1'=>'普通',
		'2'=>'当座',
	);
}

function get_amount_type(){
	return array(
		'1'=>'年次',
		'2'=>'月次',
		'3'=>'週次',
		'4'=>'日次'
	);
}

function get_repair_status(){
	return array(
		'1'=>'受付',
		'2'=>'本社確認',
		'3'=>'工場依頼',
		'4'=>'工場上がり',
		'5'=>'本社出荷',
		'6'=>'店舗着',
		'7'=>'完了',
		'8'=>'保留',
		'9'=>'取消'
	);
}

function get_estimate_status(){
	return array(
		'1'=>'受付（要見積）',
		'2'=>'見積依頼',
		'3'=>'見積連絡',
		'4'=>'見積確認',
		'5'=>'保留'
	);
}

function get_orderings_type(){
	return array(
		'1'=>'客注',
		'2'=>'プロパー',
		'3'=>'単品',
		'4'=>'修理',
		'99'=>'その他',
	);
}

function get_inventory_status(){
	return array(
		'1'=>'棚卸中',
		'2'=>'終了',
	);
}

?>