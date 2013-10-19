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
<?php JHTML::_('behavior.framework');  ?>
<!--<style>
  .icon-32-refresh { background-image: url(../images/toolbar/icon-32-refresh.png); }
</style>-->

<form action="index.php" method="post" name="adminForm" id="adminForm" style="width: 98%; margin: 0px auto;">

	<table>
		<tr>
			<td align="left" width="100%">
				<label for="search"><?php echo JText::_('FEEDBACK_FILTER'); ?>:</label>
				<input type="text" id="search" name="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_('FEEDBACK_GO'); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
			</td>
			<!-- category filter -->
			<td>
			  <select id="category_filter" name="category_filter" onchange="submitform();">
  			  <option value="0" <?php echo $this->lists['category_filter'] == 0 ? 'selected="selected"' : ''; ?>><?php echo JText::_('- All Categories -'); ?></option>
  			  <?php foreach ($this->categories as $i=>$category): ?>
  			  <option value="<?php echo $category['id'];?>" <?php echo $this->lists['category_filter'] == $category['id'] ? 'selected="selected"' : ''; ?>><?php echo $category['title']; ?></option>
			  <?php endforeach; ?>  			 
			  </select>
			</td>
		</tr>
	</table>

<table class="adminlist table-striped" width="100%">
	<thead>
		<tr>
			<th width="20px"><?php echo JText::_('NUM'); ?></th>
			<th width="20px">
                <input type="checkbox" name="toggle" value="" class="checklist-toggle" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
            </th>
			<th class="title left"><?php echo JHTML::_('grid.sort', JText::_('FEEDBACK_TITLE'), 'f.title', $this->lists['order_Dir'], $this->lists['order'], 'feedbacks'); ?></th>
			<th class="title left" width="5%"><?php echo JHTML::_('grid.sort', JText::_('FEEDBACK_NO_VOTES'), 'f.hits', $this->lists['order_Dir'], $this->lists['order'], 'feedbacks'); ?></th>
			<th class="title left" width="15%"><?php echo JHTML::_('grid.sort', JText::_('FEEDBACK_STATUS'), 's.status', $this->lists['order_Dir'], $this->lists['order'], 'feedbacks'); ?></th>
			<th class="title left" width="15%"><?php echo JHTML::_('grid.sort', JText::_('FEEDBACK_CATEGORY'), 'c.title', $this->lists['order_Dir'], $this->lists['order'], 'feedbacks'); ?></th>
			<th class="title left" width="10%"><?php echo JHTML::_('grid.sort', JText::_('FEEDBACK_SUGGESTED_BY'), 'username', $this->lists['order_Dir'], $this->lists['order'], 'feedbacks'); ?></th>
			<th width="11%"><?php echo JHTML::_('grid.sort', JText::_('FEEDBACK_CREATED_AT'), 'f.date_created', $this->lists['order_Dir'], $this->lists['order'], 'feedbacks'); ?></th>
			<th width="11%"><?php echo JHTML::_('grid.sort', JText::_('FEEDBACK_UPDATED_AT'), 'f.date_updated', $this->lists['order_Dir'], $this->lists['order'], 'feedbacks'); ?></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<td colspan="9">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>

	<tbody>
	  <?php foreach ($this->feedbacks as $i => $feedback): ?>
	    <tr class="row<?php echo $i % 2; ?>">
	      <td width="20px"><?php echo ($i + 1 + $this->pagination->limitstart); ?></td>
	      <td width="20px"><?php echo JHTML::_('grid.id', $i, $feedback->id); ?></td>
	      <td><a href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&controller=feedback&task=edit&cid[]=' . $feedback->id); ?>"><?php echo feedbackHelper::trimText($feedback->title,120); ?></a></td>
	      <td><?php echo ( $feedback->hits != null ) ? $feedback->hits : 0; ?></td>
	      <td><a href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&controller=status&task=edit&cid[]=' . $feedback->status_id); ?>"><?php echo $feedback->status; ?></a></td>
	      <td><a href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&controller=category&task=edit&cid[]=' . $feedback->category_id); ?>"><?php echo $feedback->category_title; ?></a></td>
	      <td><!--<a href="<?php //echo JRoute::_('index.php?option=com_feedbackfactory&controller=user&task=edit&cid[]=' . $feedback->user_id); ?>">--><?php echo $feedback->username; ?><!--</a>--></td>
	      <td style="text-align: center;"><?php echo $feedback->date_created; ?></td>
	      <td style="text-align: center;"><?php echo $feedback->date_updated; ?></td>
	    </tr>
	  <?php endforeach; ?>
	</tbody>
</table>

  <input type="hidden" name="controller" value="feedback" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="option" value="com_feedbackfactory" />
  <input type="hidden" name="task" value="feedbacks" />
  <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>
