<?php 
/*------------------------------------------------------------------------
com_feedbackfactory - Feedback Factory 1.2.0
------------------------------------------------------------------------
author TheFactory
copyright Copyright (C) 2011 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access'); ?>
<?php jimport('joomla.access.rules'); ?>

<?php if (!count($this->comments)): ?>
  <?php echo JText::_('FEEDBACK_NO_COMMENTS_FOUND'); ?>
<?php endif; ?>

<?php foreach ($this->comments as $comment): ?>
<div>
  <div class="feedbackfactory-comment">
    <div class="feedbackfactory-comment-header ui-widget-header">
      <span style="float: right; width: 10%;"></span>

      <span>
        <!-- Owner -->
        <span class="feedbackfactory-icon feedbackfactory-user feedbackfactory-comment-user">
          <?php if (!empty($comment->author_url)): ?>
            <a href="<?php echo $comment->author_url; ?>"><?php echo $comment->author_name; ?></a>
          <?php else: ?>
            <?php echo $comment->author_name; ?>
          <?php endif; ?>
        </span>

        <!-- Date -->
        <span class="feedbackfactory-icon feedbackfactory-date"><?php echo $comment->date_added; ?></span>

        <!-- Delete -->
        <?php //if (!JFactory::getUser() isRoot) 
        if (!JFactory::getUser()->authorise('core.admin')) 
			$canDelete = false;
		else 
			$canDelete = true;
        ?>
        <?php if ($canDelete): ?>
          <span class="delete_comment" id="comment_<?php echo $comment->id; ?>">(<a href="#">delete</a>)</span>
        <?php endif; ?>
      </span>
    </div>

    <?php if ($this->isCBIntegration && $this->feedbackSettings->use_cb_avatars && $this->feedback->enable_cb_avatar): ?>
        <div style="clear: both; float: right;">

            <?php $author_avatar_image = FeedbackHelper::getAvatar($comment->user_id, 'cb');
                  echo $author_avatar_image;  ?>
        </div>
    <?php endif; ?>

    <div class="feedbackfactory-comment-content">
      <?php echo $comment->comment; ?>
    </div>


  </div>
</div>
<?php endforeach; ?>

<div id="pagination" class="pagination">
  <?php echo $this->pagination->getPagesLinks(); ?>
</div>

<script>
  jQuery(document).ready(function ($) {
    // Pagination links
    $("#pagination a").click(function () {
      var href         = $(this).attr("href");
      var height       = $("#feedbackfactory-comments").css("height");
      var targetOffset = $("#fieldset-comments").offset().top;
   
      $.post(href, { format: "raw" }, function (response) {
        $("#feedbackfactory-comments").html(response);
        $('html').animate({scrollTop: targetOffset}, 'fast');
      });

      return false;
    });

    // Delete comment
    $(".delete_comment a").click(function () {
      var id     = $(this).parent().attr("id");
      var parent = $(this).parent();

      id = id.split("_");
      id = id[1];

      $.post("<?php echo JRoute::_('index.php?option=com_feedbackfactory&controller=comment&task=delete', false); ?>", {
        id:     id,
        format: "raw"
      }, function (response) {
        switch (response.status)
        {
          case 1:
            alert(response.message);
          break;

          case 2:
            parent.html(response.message);
          break;
          case 3:
              alert(response.message);
              break;  
        }
      }, "json");

      return false;
    });

  });
</script>
