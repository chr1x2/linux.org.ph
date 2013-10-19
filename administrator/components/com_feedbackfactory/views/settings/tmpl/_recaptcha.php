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

<p><?php echo JText::_('Feedback Factory uses the'); ?> <a href="http://recaptcha.net/">ReCapthca</a> <?php echo JText::_('anti-bot service.'); ?></p>
<p>
  <?php echo JText::_('In order to enable it on your site, you must register for an'); ?> <a href="https://admin.recaptcha.net/accounts/signup/?next=%2Frecaptcha%2Fcreatesite%2F" target="_blank"><?php echo JText::_('account'); ?></a>
  <?php echo JText::_('and then fill in the required information'); ?>.
</p>

<table class="adminlist">
  <!-- recaptcha_public_key -->
  <tr class="hasTip" title="<?php echo JText::_('FEEDBACK_RECAPTCHA_PUBLIC_KEY'); ?>::<?php echo JText::_('FEEDBACK_RECAPTCHA_PUBLIC_KEY'); ?>">
    <td width="40%" class="paramlist_key">
      <span class="editlinktip">
        <label for="recaptcha_public_key"><?php echo JText::_('FEEDBACK_RECAPTCHA_PUBLIC_KEY'); ?></label>
      </span>
    </td>
    <td class="paramlist_value">
	    <input type="text" size="70" name="recaptcha_public_key" id="recaptcha_public_key" value="<?php echo base64_decode($this->feedbackSettings->recaptcha_public_key); ?>" />
    </td>
  </tr>

  <!-- recaptcha_private_key -->
  <tr class="hasTip" title="<?php echo JText::_('FEEDBACK_RECAPTCHA_PRIVATE_KEY'); ?>::<?php echo JText::_('FEEDBACK_RECAPTCHA_PRIVATE_KEY'); ?>">
    <td width="40%" class="paramlist_key">
      <span class="editlinktip">
        <label for="recaptcha_private_key"><?php echo JText::_('FEEDBACK_RECAPTCHA_PRIVATE_KEY'); ?></label>
      </span>
    </td>
    <td class="paramlist_value">
	    <input type="text" size="70" name="recaptcha_private_key" id="recaptcha_private_key" value="<?php echo base64_decode($this->feedbackSettings->recaptcha_private_key); ?>" />
    </td>
  </tr>
</table>
