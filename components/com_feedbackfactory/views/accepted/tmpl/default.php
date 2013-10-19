<?php
/*------------------------------------------------------------------------
com_feedbackfactory - Feedback Factory 2.0.0
------------------------------------------------------------------------
author TheFactory
copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access'); ?>

<h1><?php echo JText::_('FEEDBACK_ACCEPTED'); ?></h1>
<div class="faqsearch">
  <div class="faqsearchinputbox">
  	<input name="query" type="text" id="faq_search_input" class="pending" />
  </div>
</div>

<br />

<div id="feedback-wrapper">
  <form action="<?php echo JRoute::_('index.php'); ?>" method="post" id="feedback-form" name="feedback-form" style="width: 98%; margin: 0px auto;">
	
  	<div id="tabs" style="width: 100%;">
	  
  	  <?php echo JHtml::_('tabs.start','accepted-feedbacks'); ?> 
      	
  	    <?php echo JHtml::_('tabs.panel',JText::_('FEEDBACK_ACCEPTED_PENDING'), 'tabs-1'); ?>
		  <fieldset>
		  	<legend><?php echo JText::_('FEEDBACK_ACCEPTED_PENDING'); ?></legend>
		  	  <div id="searchresultdata4" class="faq-articles" style="border: 0px solid red;">
		  	   <div class="update">
		  	   <?php if ($this->feedbacks_pending): ?>
		  	  		<?php $this->feedbacks = $this->feedbacks_pending;  echo $this->loadTemplate('list'); ?>
	  				<div class="feedback-spacer"></div>
		  		<?php else: ?>	
		  			<?php echo $this->loadTemplate('no_feedback'); ?>
		  		<?php endif; ?>	
				</div>
	  	  	  </div>	
		  </fieldset>
		
		<?php echo JHtml::_('tabs.panel',JText::_('FEEDBACK_ACCEPTED_STARTED'), 'tabs-2'); ?>
		  <fieldset>
		  	<legend><?php echo JText::_('FEEDBACK_ACCEPTED_STARTED'); ?></legend>
		  	  <div id="searchresultdata5" class="faq-articles" style="border: 0px solid red;">
		  	  <div class="update">
		  	  <?php if ($this->feedbacks_started): ?>
		  		<?php $this->feedbacks = $this->feedbacks_started; echo $this->loadTemplate('list'); ?>
					<div class="feedback-spacer"></div>
	  			<?php else: ?>	
		  			<?php echo $this->loadTemplate('no_feedback'); ?>
		  		<?php endif; ?>
	  	  	  </div>
	  	  	</div>  		
		  </fieldset>
		
		<?php echo JHtml::_('tabs.panel',JText::_('FEEDBACK_ACCEPTED_PLANNED'), 'tabs-3'); ?>
		  <fieldset>
		  	<legend><?php echo JText::_('FEEDBACK_ACCEPTED_PLANNED'); ?></legend>
		  	  <div id="searchresultdata6" class="faq-articles" style="border: 0px solid red;">
		  	  <div class="update">
		  	  <?php if ($this->feedbacks_planned): ?>
		  		<?php $this->feedbacks = $this->feedbacks_planned; echo $this->loadTemplate('list'); ?>
		 			<div class="feedback-spacer"></div>
	  			<?php else: ?>	
		  			<?php echo $this->loadTemplate('no_feedback'); ?>
		  		<?php endif; ?>
	  	  	  </div>
	  	  	</div>  		
		  </fieldset>
	  
	  <?php echo JHtml::_('tabs.end'); ?>
	  
	</div>
	
  	<input type="hidden" name="option" value="com_feedbackfactory" />
  	<input type="hidden" name="accepted_status" id="accepted_status" value="" />
  	<input type="hidden" name="task" value="" />
     <!-- <input type="hidden" name="task" value="accepted" />-->
  </form>
</div>
  
<script>
	jQuery(document).ready(function ($) {
		$('.pagination a').live('click', function (event) {
			event.preventDefault();
			
			var href   = $(this).attr('href');
			var tab_index = $(this).parents('fieldset:first').find('.faq-articles').attr('id');
			var update = $(this).parents('fieldset:first').find('.update');

			switch (tab_index) {
		        case 'searchresultdata4' :
		          t = 'pending';
		          break;
		        case 'searchresultdata5' :
		          t = 'started';
		          break;
		        case 'searchresultdata6' :
		          t = 'planned';
		          break;	
		        default:
		          t = 'pending';
		          break;  
			}
			
		$.ajax({
				'type': "GET",	
				'url': href,
				'data': 'format=raw&type='+t,
				success: function (message) {
					update.html(message);
					highlightTermsIn($(".message_body")); 
				}
			});
		
		});

	  /*if($().tabs)
	    {
	      $("#tabs").tabs({ selected: 0 });
	    }
	  else
	    {
	      $("#tabs").html("<h1>jQuery UI library is missing or not loaded! This page cannot be displayed properly!</h1>");
	    }*/
    
	  $('#tabs dl#accepted-feedbacks dt.tabs-1').click( function () {
	    $('input#faq_search_input').removeClass('watermark');
	  	$('input#faq_search_input').attr('class', 'pending');
	  });
	 
	  $('#tabs dl#accepted-feedbacks dt.tabs-2').click( function () {
	  	 $('input#faq_search_input').removeClass('watermark');
	     $('input#faq_search_input').attr('class', 'started');
	  });
	  
	  $('#tabs dl#accepted-feedbacks dt.tabs-3').click( function () {
	  	 $('input#faq_search_input').removeClass('watermark');
		 $('input#faq_search_input').attr('class', 'planned');
	  }); 
  
 	  var highlightTermsIn = function(jQueryElements) {
		var to_highlight = $("#faq_search_input").val();
        var wrapper = ">$1<b style='font-weight:bold;color:#666;background-color:rgb(255,255,102)'>$2</b>$3<";
        var regex = new RegExp(">([^<]*)?("+to_highlight+")([^>]*)?<","ig");
           
        jQueryElements.each(function(i) {
             $(this).html($(this).html().replace(regex, wrapper));
        }); 
	  }
  
	var root = "<?php echo JUri::root(); ?>";    
  });
</script>
