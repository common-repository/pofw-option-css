<?php
if (!defined('ABSPATH')) exit;

class Pektsekye_OptionCss_Model_Option_Value {


  public function __construct() {
    global $wpdb;
    
    $this->_wpdb = $wpdb;   
    $this->_mainTable = "{$wpdb->base_prefix}pofw_optioncss_option_value";                        
  }    


  public function getValues($productId)
  {            
    $values = array();
   
    $productId = (int) $productId;     
    $select = "SELECT ocss_value_id, value_id, css_class FROM {$this->_mainTable} WHERE product_id={$productId}";
    $rows = $this->_wpdb->get_results($select, ARRAY_A);      
    
    foreach($rows as $r){
      $values[$r['value_id']] = array('ocss_value_id' => $r['ocss_value_id'], 'css_class' => $r['css_class']); 
    }
    
    return $values;                    
  }


  public function getAllValues()
  {            
    $values = array();
       
    $select = "SELECT value_id, css_class FROM {$this->_mainTable} WHERE css_class != ''";
    $rows = $this->_wpdb->get_results($select, ARRAY_A);      
    
    foreach($rows as $r){
      $values[$r['value_id']] = array('css_class' => $r['css_class']); 
    }
    
    return $values;                    
  }    


  public function saveValues($productId, $optionId, $values)
  { 
    $productId = (int) $productId;
    $optionId = (int) $optionId;
    
    foreach ($values as $r){
      $odsValueId = isset($r['ocss_value_id']) ? (int) $r['ocss_value_id'] : 0;    
      $valueId = (int) $r['value_id'];           
      $cssClass = esc_sql($r['css_class']);            

      if ($odsValueId > 0){             
        $this->_wpdb->query("UPDATE {$this->_mainTable} SET css_class = '{$cssClass}' WHERE ocss_value_id = {$odsValueId}");                        
      } else {
        $this->_wpdb->query("INSERT INTO {$this->_mainTable} SET product_id = {$productId}, option_id = {$optionId}, value_id = {$valueId}, css_class = '{$cssClass}'");           
      }    
    }                     
  }  
  

  public function deleteValues($productId)
  {  
    $productId = (int) $productId;
    $this->_wpdb->query("DELETE FROM {$this->_mainTable} WHERE product_id = {$productId}");  
  }      

}
