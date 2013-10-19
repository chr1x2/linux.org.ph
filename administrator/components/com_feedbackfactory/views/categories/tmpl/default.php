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

<form action="index.php" method="post" name="adminForm" id="adminForm" style="width: 98%; margin: 0px auto;">

	<table>
		<tr>
			<td align="left" width="100%">
				<label for="search"><?php echo JText::_('FEEDBACK_FILTER'); ?>:</label>
				<input type="text" id="search" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_('FEEDBACK_GO'); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('category').value='';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
			</td>
			<td><?php echo JHTML::_('grid.state', $this->lists['state']); ?></td>
		</tr>
	</table>

<table class="adminlist table-condensed" width="50%">
	<thead>
		<tr>
			<th width="20px"><?php echo JText::_('NUM'); ?></th>
			<th width="20px">
                <input type="checkbox" name="toggle" value="" class="checklist-toggle" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
            </th>
			<th class="title left"><?php echo JHTML::_('grid.sort', JText::_('FEEDBACK_TITLE'), 'c.title', $this->lists['order_Dir'], $this->lists['order'], 'categories'); ?></th>
			<th width="20%"><?php echo JHTML::_('grid.sort', JText::_('FEEDBACK_PUBLISHED'), 'c.published', $this->lists['order_Dir'], $this->lists['order'], 'categories'); ?></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<td colspan="12">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>

	<tbody>
	  <?php foreach ($this->categories as $i => $category): ?>
	    <tr class="row<?php echo $i % 2; ?>">
	      <td width="20px"><?php echo ($i + 1 + $this->pagination->limitstart); ?></td>
	      <td width="20px"><?php echo JHTML::_('grid.id', $i, $category->id); ?></td>
	      <td>
	        <a href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&controller=category&task=edit&cid[]=' . $category->id); ?>"><?php echo $category->title; ?></a>
	      </td>
	      <?php
            $img_publish=($category->published) ? JHtml::_('image','admin/tick.png','','',JText::_( 'COM_ADS_PUBLISHED')) : JHtml::_('image','admin/disabled.png','','',JText::_( 'COM_ADS_DISABLED'));
            $alt_publish=($category->published) ? JText::_( 'COM_ADS_PUBLISHED__CLICK_TO_UNPUBLISH' ) : JText::_( 'COM_ADS_UNPUBLISHED__CLICK_TO_PUBLISH' );


	      $state_src = $category->published ? 'publish' : 'unpublish';
		  $text_label = $category->published ? 'Published' : 'Unpublished';
		  $title = $category->published ? 'Published' : 'Publish item';
		  ?>
		  <td class="center">
              <span class = "editlinktip hasTip" title = "<?php echo JText::_($alt_publish);?>">
				<a  class="jgrid" href="<?php echo JRoute::_('index.php?option=com_feedbackfactory&controller=category&task=change&field=published&value=' . !$category->published . '&id=' . $category->id); ?>"
        		  title="<?php echo $title; ?>">
						<!--<span class="state <?php /*echo $state_src; */?>"><span class="text"><?php /*echo $text_label; */?></span></span>-->
                    <?php echo $img_publish;?></a>
              </span>
		  </td>

	    </tr>
	  <?php endforeach; ?>
	</tbody>
</table>

  <input type="hidden" name="controller" value="category" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="option" value="com_feedbackfactory" />
  <input type="hidden" name="task" value="categories" />
  <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>
