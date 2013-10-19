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

<div id="feedback-wrapper_search" class="update">
  <h1><?php echo JText::_('FEEDBACK_SEARCH_RESULTS'); ?></h1>
	  <?php echo $this->loadTemplate('list');  ?>
</div>

<script>
  var root = "<?php echo JUri::root(); ?>";
</script>
