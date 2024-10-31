( function ($) {
  "use strict";
  
  $.widget("pektsekye.pofwOptionCss", {
    _create: function(){   		    

      $.extend(this, this.options);
                
      this.addCssClasses();
                                
    },    
    
    
    addCssClasses : function(){
      var ii,ll, oId, vId, optionDiv, type;
      var l = this.optionIds.length;
      for (var i=0;i<l;i++){ 
        oId = this.optionIds[i];
        
        optionDiv = this.element.find('[name^="pofw_option['+oId+']"]').first().closest('div.field');
 
        type = this.optionTypes[oId];
        
        if (type == 'radio' || type == 'checkbox'){ 
          ll = this.vIdsByOId[oId].length;
          for (ii=0;ii<ll;ii++){        
            vId = this.vIdsByOId[oId][ii];         
            if (this.vCssClasses[vId]){
              $('#pofw_option_value_' + vId).closest('div.choice').addClass(this.vCssClasses[vId]);
            }
          }        

        } else if (type == 'drop_down' || type == 'multiple') {
          ll = this.vIdsByOId[oId].length;
          for (ii=0;ii<ll;ii++){        
            vId = this.vIdsByOId[oId][ii];         
            if (this.vCssClasses[vId]){
              $('#pofw_option_' + oId + ' option[value="'+vId+'"]').addClass(this.vCssClasses[vId]);
            }
          }
        }
        
        if (this.oCssClasses[oId]){
          optionDiv.addClass(this.oCssClasses[oId]); 
        } 
      }   
    }      
    
  });

})(jQuery);
    


