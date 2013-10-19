jQuery(document).ready(function($) {

	$("#faq_search_input").watermark("Begin Typing to Search");
	//.focus();
	
	var timeout;
	var svalue = 0;
	
	$("#faq_search_input").keyup(function()
	{
		var faq_search_input = $(this).val();
		var dataString = faq_search_input; //'keyword=' 
		
		var search_type = $(this).attr("class");
    
    //alert(search_type);
    
		switch (search_type) {
	        case 'mostcommented' :
	          svalue = 1;
	          break;
	        case 'top' :
	          svalue = 2;
	          break;
	        case 'completed':
	          svalue = 3;
	          break;	
	        case 'pending watermark':
	        case 'pending':
	          svalue = 4;
	          break;	
	        case 'started watermark':
	        case 'started':
	          svalue = 5;
	          break;	
	        case 'planned watermark':
	        case 'planned':
	          svalue = 6;
	          break;	    
	        // all feedbacks   
	        defaut:
	          svalue = 0;
	          break;
	       
		}
    
		if (faq_search_input.length > 2 || faq_search_input.length == 0)
		{			
			clearTimeout(timeout);
			timeout = setTimeout( function() { 
				
				$.ajax({
				type: "GET",
				url: route_search,
				//url: root + 'index.php?option=com_feedbackfactory&format=raw&task=search', 
				//data: "dataq="+dataString+"&search_type="+svalue,
				data: {
				dataq: dataString,
      			search_type: svalue 
				},
				beforeSend:  function() {
					$('input#faq_search_input').addClass('loading');
				},
				
				success: function(server_response)
				{
					if ( (svalue == 4) || (svalue == 5) || (svalue == 6))
					{
						$('#searchresultdata'+svalue).html(server_response).show();
					}
					else {
						$('#searchresultdata').html(server_response).show();
					}
					
					highlightTermsIn($(".message_body"));        
										
					if ($('input#faq_search_input').hasClass("loading")) {
					 	$("input#faq_search_input").removeClass("loading");
					  } 
				}
			});
			}, 2000);    		 			
		}
		
		return false;
		
	});

	var highlightTermsIn = function(jQueryElements) {
		var to_highlight = $("#faq_search_input").val();
        var wrapper = ">$1<b style='font-weight:bold;color:#666;background-color:rgb(255,255,102)'>$2</b>$3<";
        var regex = new RegExp(">([^<]*)?("+to_highlight+")([^>]*)?<","ig");
           
        jQueryElements.each(function(i) {
             $(this).html($(this).html().replace(regex, wrapper));
        }); 

	}
	//var regex = new RegExp('(<[^>]*>)|(\\b'+ search.replace(/([-.*+?^${}()|[\]\/\\])/g,"\\$1") +')', insensitive ? 'ig' : 'g');	
});

