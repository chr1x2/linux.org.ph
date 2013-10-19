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
<?php ?>
<form action="index.php" method="post" name="adminForm" id="adminForm">

<table class="adminlist" width="100%">
		<tr valign="top">
			<td>
				<fieldset>
					<legend><?php echo JText::_('Category'); ?></legend>

					<table width="100%">
						<?php if ($this->category->id): ?>
						  <tr>
							  <td class="key" width="10%" align="right"><label for="id"><?php echo JText::_('ID'); ?>:</label></td>
							  <td width="80%"><strong><?php echo $this->category->id; ?></strong></td>
						  </tr>
						<?php endif; ?>

						<!-- title -->
						<tr>
							<td class="key" align="right"><label for="title"><?php echo JText::_('FEEDBACK_TITLE'); ?>:</label></td>
							<td><input name="title" id="title" value="<?php echo $this->category->title; ?>" style="width: 200px;" /></td>
						</tr>

						<!-- published -->
						<tr>
							<td class="key" align="right"><label for="published"><?php echo JText::_('FEEDBACK_PUBLISHED'); ?>:</label></td>
							<td>
							  <select name="published" id="published">
							    <option value="0" <?php echo ($this->category->published == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('No'); ?></option>
							    <option value="1" <?php echo ($this->category->published == 1) ? 'selected="selected"' : ''; ?>><?php echo JText::_('Yes'); ?></option>
							  </select>
							</td>
						</tr>
					</table>
				</fieldset>
			</td>
		</tr>
	</table>

  <input type="hidden" name="controller" value="category" />
  <input type="hidden" name="id" value="<?php echo $this->category->id; ?>" />
  <input type="hidden" name="option" value="com_feedbackfactory" />
  <input type="hidden" name="task" value="" />
</form>
