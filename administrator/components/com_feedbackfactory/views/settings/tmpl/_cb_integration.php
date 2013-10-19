<?php
/**------------------------------------------------------------------------
com_feedbackfactory - Feedback Factory 2.0.0
------------------------------------------------------------------------
 * @author TheFactory
 * @copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thefactory.ro
 * Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access'); ?>

<?php if (!feedbackHelper::getCBIntegration() ): ?>
  <?php echo JText::_('You need to install Community Builder to use this option'); ?>
<?php else: ?>
  <table class="paramlist admintable">
      <tr>
        <td valign="top">
            <fieldset class="adminform">
                <legend><?php echo JText::_('FEEDBACK_CB_PLUGIN'); ?></legend>
                <div style="width: 420px;">
                <?php if (!$this->detectedCBPlugin) {	?>
                    <a href="<?php echo JURI::base();?>index.php?option=com_feedbackfactory&task=installCBPlugin"><img src="<?php echo JURI::root();?>components/com_feedbackfactory/assets/images/CB_Install.png" style="vertical-align:middle;">
                        <br /><strong><?PHP echo JText::_('Install CB Plugins') ;?></strong></a>
                <?php } else { ?>
                    <img src="<?php echo JURI::root();?>components/com_feedbackfactory/assets/images/CB_Install.png" style="vertical-align:middle;">
                    <br /><?php echo JText::_('Community Builder plugin (Feedbacks Tab display) is installed');
                } ?>
                </div>
            </fieldset>
        </td>
      </tr>
  </table>

  <table class="paramlist admintable">
      <tr><td>
        <fieldset class="adminform">
			<legend><?php echo JText::_( 'FEEDBACK_CB_AVATARS' ); ?></legend>
			<table class="adminlist" width="100%">

                <!-- allow_cb_avatars -->
                <tr class="hasTip" title="<?php echo JText::_('Enable use of Community Builder avatars'); ?>::<?php echo JText::_('Enable use of Community Builder avatars'); ?>">
                  <td width="40%" class="paramlist_key">
                    <span class="editlinktip">
                      <label for="use_cb_avatars"><?php echo JText::_('Enable use of Community Builder avatars'); ?></label>
                    </span>
                  </td>
                  <td class="paramlist_value">
                    <select id="use_cb_avatars" name="use_cb_avatars">
                      <option value="0" <?php echo (!$this->feedbackSettings->use_cb_avatars) ? 'selected="selected"' : ''; ?>><?php echo JText::_('No'); ?></option>
                      <option value="1" <?php echo ($this->feedbackSettings->use_cb_avatars) ? 'selected="selected"' : ''; ?>><?php echo JText::_('Yes'); ?></option>
                    </select>
                  </td>
                </tr>

                <!-- avatar_max_width -->
                <tr class="hasTip" for="avatar_max_width" title="<?php echo JText::_('Avatar maximum width'); ?>::<?php echo JText::_('Avatar maximum width in pixels'); ?>">
                    <td width="40%" class="paramlist_key">
                    <span class="editlinktip">
                      <label><?php echo JText::_('Avatar maximum width'); ?></label>
                    </span>
                    </td>
                    <td class="paramlist_value">
                        <input type="text" name="avatar_max_width" id="avatar_max_width" value="<?php echo $this->feedbackSettings->avatar_max_width; ?>" />
                    </td>
                </tr>

                  <!-- avatar_max_height -->
                  <tr class="hasTip" for="avatar_max_height" title="<?php echo JText::_('Avatar maximum height'); ?>::<?php echo JText::_('Avatar maximum height in pixels'); ?>">
                    <td height="40%" class="paramlist_key">
                      <span class="editlinktip">
                        <label><?php echo JText::_('Avatar maximum height'); ?></label>
                      </span>
                    </td>
                    <td class="paramlist_value">
                        <input type="text" name="avatar_max_height" id="avatar_max_height" value="<?php echo $this->feedbackSettings->avatar_max_height; ?>" />
                    </td>
                  </tr>
            </table>
      </fieldset>
      </td></tr>

  </table>
<?php endif; ?>

