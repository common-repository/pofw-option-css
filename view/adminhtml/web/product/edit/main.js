(function ($) {
  "use strict";

  $.widget("pektsekye.pofwOptionCss", { 


    _create : function () {

      $.extend(this, this.options);
                          
      this._on({                      
        "change input": $.proxy(this.setChanged, this)                                                                                                                    
      });                            
    },       
    
    
    setChanged : function(){
      $('#pofw_ocss_changed').val(1);     
    }  	        
    	
  }); 
   
})(jQuery);
