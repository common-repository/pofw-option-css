<?php
if (!defined('ABSPATH')) exit;
?>
<div class="pofw-ocss-container">
<?php if (!$this->getProductOptionsPluginEnabled()): ?>
  <div class="pofw_optioncss-create-ms"><?php echo __('Please, install and enable the <a href="https://wordpress.org/plugins/pofw-option-css/" target="_blank">Product Options</a> plugin.', 'pofw-option-css'); ?></div>
<?php else: ?>
  <div id="pofw_ocss_options">
    <?php foreach ($this->getOptions() as $optionId => $option): ?>
      <div>
        <div class="pofw-ocss-option-title">
          <span class="pofw-title"><?php echo htmlspecialchars($option['title']); ?></span>         
          <input type="hidden" name="pofw_ocss_options[<?php echo $optionId; ?>][ocss_option_id]" value="<?php echo $option['ocss_option_id']; ?>"/>                    
        </div>  
        <div class="pofw-ocss-option-css">
          <input type="text" name="pofw_ocss_options[<?php echo $optionId; ?>][css_class]" value="<?php echo htmlspecialchars($option['css_class']); ?>" autocomplete="off"/>                             
        </div>        
        <div class="pofw-ocss-values">
          <?php foreach ($option['values'] as $valueId => $value): ?>
            <div class="pofw-ocss-value">
              <div class="pofw-ocss-value-title">
                <span><?php echo htmlspecialchars($value['title']); ?></span>
              </div>
              <div class="pofw-ocss-value-css">
                <input id="pofw_ocss_value_<?php echo $valueId; ?>_css" name="pofw_ocss_options[<?php echo $optionId; ?>][values][<?php echo $valueId; ?>][css_class]" type="text" value="<?php echo htmlspecialchars($value['css_class']); ?>" class="pofw-ocss-value-css-input" autocomplete="off">                    
                <input type="hidden" name="pofw_ocss_options[<?php echo $optionId; ?>][values][<?php echo $valueId; ?>][ocss_value_id]" value="<?php echo $value['ocss_value_id']; ?>"/>                            
              </div>                        
            </div>          
          <?php endforeach; ?>        
        </div>                  
      </div>    
    <?php endforeach; ?>               
    <input type="hidden" id="pofw_ocss_changed" name="pofw_ocss_changed" value="0">        
  </div> 
   <script type="text/javascript">
      var config = {};
  
      jQuery('#pofw_ocss_options').pofwOptionCss(config);   
        
  </script>                 
<?php endif; ?>     
</div>

    