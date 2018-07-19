<?php

  class boxberryrf {
    var $code, $title, $description, $icon, $enabled;


    function __construct() {
      global $order;

      $this->code = 'boxberryrf';
      $this->title = MODULE_SHIPPING_BOXBERRYRF_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_BOXBERRYRF_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_BOXBERRYRF_SORT_ORDER;
      $this->icon = 'images/icons/boxberry.png';
      $this->tax_class = MODULE_SHIPPING_BOXBERRYRF_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_BOXBERRYRF_STATUS == 'True') ? true : false);
	 
      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_BOXBERRYRF_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_BOXBERRYRF_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
        while ($check = vam_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }


    function quote($method = '') {
      global $order, $length, $width, $height, $volume, $shipping_weight;
	  //echo $shipping_weight;
	 $stoimost = MODULE_SHIPPING_BOXBERRYRF_COST;
	 
	 if(is_numeric($_SESSION['shipping_boxberry_plus_cost']))
		 $stoimost += $_SESSION['shipping_boxberry_plus_cost'];
	  
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_BOXBERRYRF_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_BOXBERRYRF_TEXT_WAY,
                                                     'cost' => $stoimost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_BOXBERRYRF_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_COST', '500', '6', '0', now())");
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_APIKEY', 'QQ0IX/EsznwysCxl/Lvv5g==', '6', '0', now())");
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_CURRENTCITY', 'Москва', '6', '0', now())");
	  
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_USE_TOTAL_SUM', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_TOTAL_SUM', '1000', '6', '0', now())");
	  
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_WEIGHT', '50', '6', '0', now())");
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_LENGTH', '50', '6', '0', now())");
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_WIDTH', '50', '6', '0', now())");
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_DEFAULT_HEIGHT', '50', '6', '0', now())");
	  
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYRF_SORT_ORDER', '0', '6', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_BOXBERRYRF_STATUS', 'MODULE_SHIPPING_BOXBERRYRF_COST',	  'MODULE_SHIPPING_BOXBERRYRF_USE_TOTAL_SUM',	  'MODULE_SHIPPING_BOXBERRYRF_DEFAULT_TOTAL_SUM',	  'MODULE_SHIPPING_BOXBERRYRF_DEFAULT_WEIGHT',	  'MODULE_SHIPPING_BOXBERRYRF_DEFAULT_LENGTH',	  'MODULE_SHIPPING_BOXBERRYRF_DEFAULT_WIDTH',	  'MODULE_SHIPPING_BOXBERRYRF_DEFAULT_HEIGHT',	  'MODULE_SHIPPING_BOXBERRYRF_APIKEY','MODULE_SHIPPING_BOXBERRYRF_CURRENTCITY','MODULE_SHIPPING_BOXBERRYRF_ALLOWED', 'MODULE_SHIPPING_BOXBERRYRF_TAX_CLASS', 'MODULE_SHIPPING_BOXBERRYRF_ZONE', 'MODULE_SHIPPING_BOXBERRYRF_SORT_ORDER');
    }
  }
?>
