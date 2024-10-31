<?php
if (!defined('ABSPATH')) exit;

class Pektsekye_OptionCss_Model_Observer {  

  protected $_odsOption;        
  protected $_odsValue; 
                 
  protected $_productOptions = array();
  protected $_skipOIds = array();     
      
      
  public function __construct(){           
    include_once(Pektsekye_OCSS()->getPluginPath() . 'Model/Option.php' );
    $this->_odsOption = new Pektsekye_OptionCss_Model_Option();
    
    include_once(Pektsekye_OCSS()->getPluginPath() . 'Model/Option/Value.php');
    $this->_odsValue = new Pektsekye_OptionCss_Model_Option_Value();
     
    add_action('woocommerce_process_product_meta', array($this, 'save_product_options'), 11); //after the Product Options plugin  
    add_filter('pofw_csv_export_data_option_rows', array($this, 'add_data_to_csv_export_option_rows'), 10, 1);       
    add_filter('pofw_csv_export_data_option_value_rows', array($this, 'add_data_to_csv_export_option_value_rows'), 10, 1);
    add_action("pofw_csv_import_product_options_saved", array($this, 'save_product_options_from_csv'), 10, 2);                   
		add_action('delete_post', array($this, 'delete_post'));    	          		
  }	  


  public function getOptionModel(){
    include_once(Pektsekye_OCSS()->getPluginPath() . 'Model/Option.php');		
    return new Pektsekye_OptionCss_Model_Option();    
  }  
  
  
  public function getProductOptions($productId){
    if (!isset($this->_productOptions[$productId])){    
      $this->_productOptions[$productId] = $this->getOptionModel()->getProductOptions($productId);
    }
    return $this->_productOptions[$productId];
  }
  
 
  public function save_product_options($post_id){
    if (isset($_POST['pofw_ocss_changed']) && $_POST['pofw_ocss_changed'] == 1){
      $productId = (int) $post_id;  
          
      $options = array();
      
      if (isset($_POST['pofw_ocss_options'])){                          
        foreach ($_POST['pofw_ocss_options'] as $optionId => $o){
         
          $values = array();
          if (isset($o['values'])){          
            foreach ($o['values'] as $valueId => $v){      
              $values[] = array(
                'value_id' => (int) $valueId,          
                'ocss_value_id' => (int) $v['ocss_value_id'],                                      
                'css_class' => sanitize_text_field(stripslashes($v['css_class']))
              );                        
            }
          } 
                      
          $options[] = array(
            'option_id' => (int) $optionId,          
            'ocss_option_id' => (int) $o['ocss_option_id'],                       
            'css_class' => sanitize_text_field(stripslashes($o['css_class'])),
            'values' => $values
          );                         
        }                
      }      

      $this->_odsOption->saveOptions($productId, $options);                     
    }
  }
  

  public function add_data_to_csv_export_option_rows($rows){
       
    $options = $this->_odsOption->getAllOptions();

    foreach ($rows as $k => $row){ 
      $optionId = $row['option_id']; 
      $rows[$k]['css_class'] = isset($options[$optionId]) ? $options[$optionId]['css_class'] : '';                                 
    }
    
    return $rows;    
  }


  public function add_data_to_csv_export_option_value_rows($rows){  
    $values = $this->_odsValue->getAllValues();

    foreach ($rows as $k => $row){ 
      $valueId = $row['value_id']; 
      $rows[$k]['css_class'] = isset($values[$valueId]) ? $values[$valueId]['css_class'] : '';                                 
    }
    
    return $rows;    
  }
   
  
  public function save_product_options_from_csv($productId, $optionsData){

    $options = array();
    
    $this->_odsOption->deleteOptions($productId);
       
    foreach($optionsData as $o){       
      $values = array();
      if (isset($o['values'])){           
        foreach($o['values'] as $v){
          $values[] = array(
            'value_id' => (int) $v['value_id'],          
            'ocss_value_id' => -1,                               
            'css_class' => isset($v['css_class']) ? $v['css_class'] : ''
          );
        }       
      }
      
      $options[] = array(
        'option_id' => (int) $o['option_id'],          
        'ocss_option_id' => -1,                       
        'css_class' => isset($o['css_class']) ? $o['css_class'] : '',
        'values' => $values
      );      
      
    }    
    
    $this->_odsOption->saveOptions($productId, $options);                
  }      
      
	
	public function delete_post($id){
		if (!current_user_can('delete_posts') || !$id || get_post_type($id) != 'product'){
			return;
		}
		 		
    $this->_odsOption->deleteOptions($id);             
	}		
		
}
