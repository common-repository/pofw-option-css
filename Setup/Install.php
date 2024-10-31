<?php
if (!defined('ABSPATH')) exit;

class Pektsekye_OptionCss_Setup_Install {
	

	public static function install(){
	
		if ( !class_exists( 'WooCommerce' ) ) { 
		  deactivate_plugins('pofw-option-css');
		  wp_die( __('The POFW Option CSS plugin requires WooCommerce to run. Please install WooCommerce and activate.', 'pofw-option-css'));
	  }

    if ( version_compare( WC()->version, '3.0', "<" ) ) {
      wp_die(sprintf(__('WooCommerce %s or higher is required (You are running %s)', 'pofw-option-css'), '3.0', WC()->version));
    }	
    	
		self::create_tables();
				
	}


	private static function create_tables(){
		global $wpdb;

		$wpdb->hide_errors();
		 
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta(self::get_schema());
	}


	private static function get_schema(){
		global $wpdb;

		$collate = '';

		if ($wpdb->has_cap('collation')){
			if (!empty( $wpdb->charset)){
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if (!empty( $wpdb->collate)){
				$collate .= " COLLATE $wpdb->collate";
			}
		}
		
		return "
CREATE TABLE {$wpdb->prefix}pofw_optioncss_option (
  `ocss_option_id` int(11) unsigned NOT NULL auto_increment,
  `product_id` int(11) unsigned NOT NULL,
  `option_id` int(11) unsigned NOT NULL,  
  `css_class` VARCHAR(128),           
  PRIMARY KEY (ocss_option_id)    
) $collate;		
CREATE TABLE {$wpdb->base_prefix}pofw_optioncss_option_value (
  `ocss_value_id` int(11) NOT NULL auto_increment,
  `product_id` int(11) unsigned NOT NULL,
  `option_id` int(11) unsigned NOT NULL,  
  `value_id` int(11) unsigned NOT NULL,    
  `css_class` VARCHAR(128),         
  PRIMARY KEY (ocss_value_id)    
) $collate;		
		";
		
	}

}
