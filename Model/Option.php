<?php
if (!defined('ABSPATH')) exit;

class Pektsekye_OptionCss_Model_Option {
           
  protected $_wpdb;          
  protected $_odsValue;
     
      
  public function __construct(){
    global $wpdb;    
    $this->_wpdb = $wpdb; 
    $this->_mainTable = "{$wpdb->base_prefix}pofw_optioncss_option"; 
    
    include_once(Pektsekye_OCSS()->getPluginPath() . 'Model/Option/Value.php');
    $this->_odsValue = new Pektsekye_OptionCss_Model_Option_Value();                        		
  }	


  public function getProductOptions($productId)
  {
    $productOptions = array();
    if (function_exists('Pektsekye_PO')){
      include_once(Pektsekye_PO()->getPluginPath() . 'Model/Option.php' );
      $optionModel = new Pektsekye_ProductOptions_Model_Option();
      $productOptions = $optionModel->getProductOptions($productId);
    }
    return $productOptions;  
  }


  public function getOptions($productId)
  {            
    $options = array();
   
    $productId = (int) $productId;     
    $select = "SELECT ocss_option_id, option_id, css_class FROM {$this->_mainTable} WHERE product_id={$productId}";
    $rows = $this->_wpdb->get_results($select, ARRAY_A);      
    
    foreach ($rows as $r){
      $options[$r['option_id']] = array('ocss_option_id' => $r['ocss_option_id'], 'css_class' => $r['css_class']); 
    }
    
    return $options;                    
  }


  public function getAllOptions()
  {            
    $options = array();
       
    $select = "SELECT option_id, css_class FROM {$this->_mainTable} WHERE css_class != ''";
    $rows = $this->_wpdb->get_results($select, ARRAY_A);      
    
    foreach($rows as $r){
      $options[$r['option_id']] = array('css_class' => $r['css_class']); 
    }
    
    return $options;                    
  }    


  public function saveOptions($productId, $options)
  { 
    $productId = (int) $productId;

    foreach ($options as $r){
      $odsValueId = isset($r['ocss_option_id']) ? (int) $r['ocss_option_id'] : 0;    
      $optionId = (int) $r['option_id']; 
      $cssClass = esc_sql($r['css_class']);                    

      if ($odsValueId > 0){             
        $this->_wpdb->query("UPDATE {$this->_mainTable} SET css_class = '{$cssClass}' WHERE ocss_option_id = {$odsValueId}");                        
      } else {
        $this->_wpdb->query("INSERT INTO {$this->_mainTable} SET product_id = {$productId}, option_id = {$optionId}, css_class = '{$cssClass}'");           
      }    
    
      $this->_odsValue->saveValues($productId, $optionId, $r['values']);    
    }  
                       
  }  
  

  public function deleteOptions($productId)
  {  
    $productId = (int) $productId;
    $this->_wpdb->query("DELETE FROM {$this->_mainTable} WHERE product_id = {$productId}");  
  
    $this->_odsValue->deleteValues($productId);   
  }


}
