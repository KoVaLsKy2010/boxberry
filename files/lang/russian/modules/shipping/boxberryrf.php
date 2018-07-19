<?php

if(!empty($_POST["nname"])) 
	$_SESSION['box_nname'] = $_POST["nname"];
	
$nname  = vam_db_prepare_input('('. $_SESSION['box_nname'].')');

if(isset($_POST['boxberry_price_plus']) && !empty($_POST['boxberry_price_plus']) && is_numeric($_POST['boxberry_price_plus']) ){
	$_SESSION['shipping_boxberry_plus_cost'] = $_POST['boxberry_price_plus'];
} 
	
if (function_exists($_SESSION['cart']->show_weight()) ){ 
	
	$S_WE = $_SESSION['cart']->show_weight();
	$S_LE = $_SESSION['cart']->show_length();
	$S_WI = $_SESSION['cart']->show_width();
	$S_HE = $_SESSION['cart']->show_height();
	
	if($S_WE > 0){
		$boxberry_total_weight = $S_WE*1000; // in gramms
	}else{
		$boxberry_total_weight = MODULE_SHIPPING_BOXBERRYRF_DEFAULT_WEIGHT; // in gramms
	}
	
	if($S_LE > 0){
		$boxberry_length =$S_LE; // in sm
	}else{
		$boxberry_length = MODULE_SHIPPING_BOXBERRYRF_DEFAULT_LENGTH; // in sm
	}
	
	if($S_WI > 0){
		$boxberry_width = $S_WI; // in sm
	}else{
		$boxberry_width = MODULE_SHIPPING_BOXBERRYRF_DEFAULT_WIDTH; // in sm
	}
	
	if($S_HE > 0){
		$boxberry_height = $S_HE; // in sm
	}else{
		$boxberry_height = MODULE_SHIPPING_BOXBERRYRF_DEFAULT_HEIGHT; // in sm
	}

}else{
	
	$boxberry_length = MODULE_SHIPPING_BOXBERRYRF_DEFAULT_LENGTH; // in sm
	$boxberry_width = MODULE_SHIPPING_BOXBERRYRF_DEFAULT_WIDTH; // in sm
	$boxberry_height = MODULE_SHIPPING_BOXBERRYRF_DEFAULT_HEIGHT; // in sm
	$boxberry_total_weight = MODULE_SHIPPING_BOXBERRYRF_DEFAULT_WEIGHT; // in gramms
	
}

$boxberry_total_sum = ((MODULE_SHIPPING_BOXBERRYRF_USE_TOTAL_SUM == 'True') ? $_SESSION['cart']->show_total() : MODULE_SHIPPING_BOXBERRYRF_DEFAULT_TOTAL_SUM);

	
define('MODULE_SHIPPING_BOXBERRYRF_RESALT_TOTAL_WEIGHT', $boxberry_total_weight);
define('MODULE_SHIPPING_BOXBERRYRF_RESALT_WIDTH', $boxberry_width);
define('MODULE_SHIPPING_BOXBERRYRF_RESALT_HEIGHT', $boxberry_height);
define('MODULE_SHIPPING_BOXBERRYRF_RESALT_LENGTH', $boxberry_length);
define('MODULE_SHIPPING_BOXBERRYRF_RESALT_SUM', $boxberry_total_sum);

define('MODULE_SHIPPING_BOXBERRYRF_TEXT_TITLE', 'Boxberry до пункта выдачи по РФ');
define('MODULE_SHIPPING_BOXBERRYRF_TEXT_DESCRIPTION', 'Boxberry до пункта выдачи');
define('MODULE_SHIPPING_BOXBERRYRF_TEXT_WAY', 'Ваша покупка будет доставлена в пункт выдачи заказов Boxberry. '.$nname.' <span class="click_text"></span>');

define('MODULE_SHIPPING_BOXBERRYRF_STATUS_TITLE' , 'Разрешить модуль курьерская доставка');
define('MODULE_SHIPPING_BOXBERRYRF_STATUS_DESC' , 'Вы хотите разрешить модуль курьерская доставка?');
define('MODULE_SHIPPING_BOXBERRYRF_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_SHIPPING_BOXBERRYRF_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_SHIPPING_BOXBERRYRF_COST_TITLE' , 'Наценка на стоимость доставки');
define('MODULE_SHIPPING_BOXBERRYRF_COST_DESC' , 'Стоимость доставки данным способом.');
define('MODULE_SHIPPING_BOXBERRYRF_TAX_CLASS_TITLE' , 'Налог');
define('MODULE_SHIPPING_BOXBERRYRF_TAX_CLASS_DESC' , 'Использовать налог.');
define('MODULE_SHIPPING_BOXBERRYRF_ZONE_TITLE' , 'Зона');
define('MODULE_SHIPPING_BOXBERRYRF_ZONE_DESC' , 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.');
define('MODULE_SHIPPING_BOXBERRYRF_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_SHIPPING_BOXBERRYRF_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');



define('MODULE_SHIPPING_BOXBERRYRF_APIKEY_TITLE' , 'Ключ интеграции');
define('MODULE_SHIPPING_BOXBERRYRF_APIKEY_DESC' , 'Находися по адресу http://api.boxberry.de/?act=settings&sub=view');
define('MODULE_SHIPPING_BOXBERRYRF_CURRENTCITY_TITLE' , 'Город отправки груза');
define('MODULE_SHIPPING_BOXBERRYRF_CURRENTCITY_DESC' , 'Город отправки груза');

define('MODULE_SHIPPING_BOXBERRYRF_USE_TOTAL_SUM_TITLE' , 'Передавать объявленную стоимость посылки');
define('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_TOTAL_SUM_TITLE' , 'Объявленная стоимость посылки по умолчанию');
define('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_WEIGHT_TITLE' , 'Вес по умолчанию, грамм');
define('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_LENGTH_TITLE' , 'Глубина коробки по умолчанию, см');
define('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_WIDTH_TITLE' , 'Длина по умолчанию, см');
define('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_HEIGHT_TITLE' , 'Высота по умолчанию, см');

define('MODULE_SHIPPING_BOXBERRYRF_USE_TOTAL_SUM_DESC' , 'Если нет, то используется Объявленная стоимость посылки по умолчанию');
define('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_TOTAL_SUM_DESC' , 'Объявленная стоимость посылки по умолчанию');
define('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_WEIGHT_DESC' , 'Вес по умолчанию');
define('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_LENGTH_DESC' , 'Глубина коробки по умолчанию');
define('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_WIDTH_DESC' , 'Длина по умолчанию');
define('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_HEIGHT_DESC' , 'Высота по умолчанию');


?>