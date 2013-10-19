<?php
/**------------------------------------------------------------------------
com_feedbackfactory -  Feedback Factory 2.0.0
------------------------------------------------------------------------
 * @author TheFactory
 * @copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thefactory.ro
 * Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.html.pagination');

if (!defined('ITEMS_PER_PAGE')) {
	define("ITEMS_PER_PAGE", '5');
}

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

class getmyfeedbacksTab extends cbTabHandler {

	function getmyfeedbacksTab() {
		$this->cbTabHandler();
	}

	function getDisplayTab($tab,$user,$ui){
		$app = JFactory::getApplication();
        $Itemid   = $app->input->getInt('Itemid',0);
		require_once (JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_feedbackfactory'.DS.'lib'.DS.'helpers'.DS.'feedbackHelper.class.php');
		$FeedbacksItemid = feedbackHelper::getMenuItemId(array("task"=>"feedbacks"));
            //getMenuItemByTaskName("feedbacks");

		$database = JFactory::getDbo();

        if(!file_exists(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_feedbackfactory'.DS.'feedbackfactory.php')) {
			  return "<div>You must First install <a href='http://www.thefactory.ro/shop/joomla-components/feedback-factory.html'> Feedback Factory </a></div>";
		}

		require_once (JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_feedbackfactory'.DS.'feedbackSettings.class.php');

        $limitstart	= $app->getUserStateFromRequest('posts.limitstart', 'limitstart', 0, 'int');

		$query = "SELECT u.username,f.*
			FROM #__feedback_feedbacks f
			LEFT JOIN #__users u on f.user_id = u.id
			WHERE user_id = '$user->user_id' order by id desc";

		$database->setQuery($query);
		$nrfeedbacks = $database->loadObjectList();

		$total = count($nrfeedbacks);

		$pageNav = new JPagination( $total, $limitstart, ITEMS_PER_PAGE);

		$query .= " LIMIT $pageNav->limitstart, $pageNav->limit";
		$database->setQuery($query);
		$myfeedbacks = $database->loadObjectList();

		$return  = "\t\t<div>\n";
		$return .="<table width='100%'>";
		$return .='<form name="topForm'.$tab->tabid.'" action="index.php" method="post">';
		$return .="<input type='hidden' name='option' value='com_comprofiler' />";
		$return .="<input type='hidden' name='task' value='userProfile' />";
		$return .="<input type='hidden' name='user' value='".$user->user_id."' />";
		$return .="<input type='hidden' name='tab' value='".$tab->tabid."' />";
		$return .="<input type='hidden' name='act' value='' />";

		if($myfeedbacks) {
			$return	.= '<tr>';
			  $return .= '<th class="list_ratings_header">'.JText::_("Title").'</th>';
			  $return .= '<th class="list_ratings_header">'.JText::_("Date created").'</th>';
			  $return .= '<th class="list_ratings_header">'.JText::_("Date updated").'</th>';
			  $return .= '<th class="list_ratings_header">'.JText::_("Hits").'</th>';
			$return .= '</tr>';
			$k=0;
			foreach ($myfeedbacks as $feedback){
		     $link_view_details = JRoute::_("index.php?option=com_comprofiler&task=userprofile&user=$feedback->user_id&Itemid=$Itemid");
			 $link_view_add = JRoute::_("index.php?option=com_feedbackfactory&task=feedback&task=feedback&id=$feedback->id&Itemid=$FeedbacksItemid");

			 $return .='<tr class="mywatch'.$k.'">';
			 $return .='<td>';
			 $return .=' <a href="'.$link_view_add.'">'.$feedback->title.'</a>';
			 $return .='</td>';
			 $return .='<td>';
			 $return .= date('d.m.y, H:i',strtotime($feedback->date_created));
			 $return .='</td>';
			 $return .='<td>';
			 $return .= date('d.m.y, H:i',strtotime($feedback->date_updated));
			 $return .='</td>';
			 $return .='<td>';
			 $return .= $feedback->hits;
			 $return .='</td>';
			 $return .= "</tr>";
			 $k=1-$k;

			 }
		} else {

			$return .=	"".JText::_("No Feedbacks")."";

		}
		$return .= "<tr height='20px'>";
		$return .= "<td colspan='4' align='center'>";
		$return .= "</td>";
		$return .= "</tr>";
		
		$return .= "<tr>";
		$return .= "<td colspan='4' align='center'>";
		$return .= '<div class="pagination">';
		$return .= '<p class="counter">'.$pageNav->getPagesCounter().'</p>';
		$return .= $pageNav->getPagesLinks();
		$return .= '</div>';
		$return .= "</td>";
		$return .= "</tr>";
		$return .= "</form>";
		$return .= "</table>";
		$return .= "</div>";


		return $return;
	}
}
?>