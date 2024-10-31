<?php
if (!defined('ABSPATH')) exit;

class Pektsekye_OptionCss_Block_Adminhtml_Product_Edit_Tab_Options {

  protected $_odsValue;
  protected $_odsOption;
    
  protected $_productOptions;      
 
  
	public function __construct() {
    include_once(Pektsekye_OCSS()->getPluginPath() . 'Model/Option.php');
    $this->_odsOption = new Pektsekye_OptionCss_Model_Option();
    	
    include_once(Pektsekye_OCSS()->getPluginPath() . 'Model/Option/Value.php');
    $this->_odsValue = new Pektsekye_OptionCss_Model_Option_Value();
  }



  public function getProductId() {
    global $post;    
    return (int) $post->ID;  
  }
  
  
  public function getProductOptions() {  
    if (!isset($this->_productOptions)){
      $this->_productOptions = $this->_odsOption->getProductOptions($this->getProductId());
    }    
    return $this->_productOptions;              
  }


  public function getOptions(){  
    $options = array();
    
    $odsOptions = $this->_odsOption->getOptions($this->getProductId());
    $odsValues = $this->_odsValue->getValues($this->getProductId());      
    
    foreach($this->getProductOptions() as $optionId => $option){    
      $optionId = (int) $optionId;
      
      $values = array();
      foreach($option['values'] as $value){
        $vId = (int) $value['value_id'];        
        $values[$vId] = array(
         'ocss_value_id' => isset($odsValues[$vId]) ? $odsValues[$vId]['ocss_value_id'] : -1,            
         'title' => $value['title'],
         'css_class' => isset($odsValues[$vId]) ? $odsValues[$vId]['css_class'] : ''               
        );                
      }
 
      $options[$optionId] = array(
        'ocss_option_id' => isset($odsOptions[$optionId]) ? $odsOptions[$optionId]['ocss_option_id'] : -1,    
        'title' => $option['title'],
        'css_class' => isset($odsOptions[$optionId]) ? $odsOptions[$optionId]['css_class'] : '',
        'values' => $values
      );                 
    }
    
    return $options;
  }
  
  
  public function getProductOptionsPluginEnabled(){
    return function_exists('Pektsekye_PO');  
  }
   
  
  public function toHtml() {

    
    echo '<div id="pofw_ocss_product_data" class="panel woocommerce_options_panel hidden">';
    
    include_once(Pektsekye_OCSS()->getPluginPath() . 'view/adminhtml/templates/product/edit/tab/options.php');
    
    echo ' </div>';
  }


}
