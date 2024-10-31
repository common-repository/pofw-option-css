<?php
if (!defined('ABSPATH')) exit;
?>
<?php if (count($this->getProductOptions()) > 0): ?>   
<script type="text/javascript"> 
    var config = {};
    
    var pofwOcssData = <?php echo $this->getOptionsDataJson(); ?>;
    
    jQuery.extend(config, pofwOcssData);
      
    jQuery("#pofw_product_options").pofwOptionCss(config);
    
</script>        
<?php endif; ?>
