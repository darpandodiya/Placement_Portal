/**************************************************************/
/* Prepares the cv to be dynamically expandable/collapsible   */
/**************************************************************/
function prepareList() {
    $('#expList').find('li:has(ul)')
    .click( function(event) {
        if (this == event.target) {
            $(this).toggleClass('expanded');
            $(this).children('ul').toggle('medium');/*
			$(this).css('background-color',"black");
			$(this).css('color',"white");*/
			$(this).children('#pl').toggle();
			$(this).children('#min').toggle();
        }
        //return false;
    })
    .addClass('collapsed')
    .children('ul').hide();
	
	$('#expList li #pl ,#expList li #min').click( function(event) {
        if (this == event.target) {
            $(this).parent().toggleClass('expanded');
            $(this).parent().children('ul').toggle('medium');
			$(this).parent().children('#pl').toggle();
			$(this).parent().children('#min').toggle();
        }
        return false;
    })
    .parent().addClass('collapsed')
    .children('ul').hide();
};

	$.fn.extend({ 
         disableSelection: function() { 
              this.each(function() { 
                  if (typeof this.onselectstart != 'undefined') {
                       this.onselectstart = function() { return false; };
                  } else if (typeof this.style.MozUserSelect != 'undefined') {
                       this.style.MozUserSelect = 'none';
                  } else {
                      this.onmousedown = function() { return false; };
                  }
              }); 
          } 
    });


/**************************************************************/
/* Functions to execute on loading the document               */
/**************************************************************/
$(document).ready( function() {
    prepareList();
	$('html').disableSelection();
});