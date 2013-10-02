<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2013 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.2.0 RC 2013-09-04
 * @since       3.2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.modelitem');

/**
 * iCagenda Submit Event Model
 */
jimport( 'joomla.form.form' );

class iCagendaModelSubmit extends JModelItem
{
	/**
	 * @var msg
	 */
	protected $msg;

	function getForm()
	{
	    $form=JForm::getInstance('submit', JPATH_COMPONENT.'/models/forms/submit.xml');
	    return $form;
	}

	function getDb()
	{
		$data =new stdClass();
		$data->id = null;
		$data->ordering=0;
		$data->state=0;
		$data->access=1;
		$data->language='*';
		$menuID 					= JRequest::getVar('menuID', '', 'post');

		$data->username 			= JRequest::getVar('username', '', 'post');

		$data->title 				= JRequest::getVar('title', '', 'post');
		$data->catid 				= JRequest::getVar('catid', '', 'post');
		$data->image 				= JRequest::getVar('image', '', 'post');

		$data->dates 				= JRequest::getVar('dates', '', 'post');


//		$ctrl=unserialize($data->dates);
//		if(is_array($ctrl)){
//			$dates=unserialize($data->dates);
//		}else{
			$dates=$this->getDates($data->dates);
//		}
		rsort($dates);

		$datesall = $data->dates[0];
//		if($datesall){
//			$datesAr=$this->getDates($data->dates);
//			$data->dates = serialize($datesAr);
//			$datesnext = $this->getNextDates($data->dates);
//			$datesnext = $datesall;
//			$datesnext = $this->mktdate($datesnext);
//		} else {
//			$datesnext = '0000-00-00 00:00:00';
//		}

		if ($datesall) {
			$data->dates 			= serialize($dates);
		} else {
			$dates = array('0000-00-00 00:00:00');
			$data->dates 			= serialize($dates);
		}

			$datesget = unserialize($data->dates);
			$datesnext = $datesget[0];

		//print_r($data->dates);


		$data->startdate 			= JRequest::getVar('startdate', '', 'post');
		$data->enddate 				= JRequest::getVar('enddate', '', 'post');

//		if($data->startdate){
			$periodnext = $data->startdate;
//		}
//		if(($data->startdate) AND ($data->dates)){
			if ($datesnext < $periodnext) {
				$data->next = $periodnext;
			} else {
				$data->next = $datesnext;
			}
//		}


		$data->desc 				= JRequest::getVar('desc', '', 'post');

		$data->place 				= JRequest::getVar('place', '', 'post');
//if ($data->place == '') {
//	JError::raiseWarning('101', JText::_('TEST'));
//	return false;
//}
		$data->email 				= JRequest::getVar('email', '', 'post');
		$data->phone 				= JRequest::getVar('phone', '', 'post');
		$data->website 				= JRequest::getVar('website', '', 'post');
		$data->file 				= JRequest::getVar('file', '', 'post');
//		$data->file = $this->upload('file');

		if (!isset($data->file)) {
			$file = JRequest::getVar('jform', null, 'files', 'array');
			$fileUrl = $this->upload($file);
			$data->file = $fileUrl;
		}

		$data->address 				= JRequest::getVar('address', '', 'post');
		$data->city 				= JRequest::getVar('city', '', 'post');
		$data->country 				= JRequest::getVar('country', '', 'post');
		$data->lat 					= JRequest::getVar('lat', '', 'post');
		$data->lng 					= JRequest::getVar('lng', '', 'post');


		$data->alias 				= JRequest::getVar('alias', '', 'post');
		// URL
		jimport( 'joomla.filter.output' );
		if(empty($data->alias)) {
			$data->alias = $data->title;
		}
		$data->alias = JFilterOutput::stringURLSafe($data->alias);




		$data->id 					= JRequest::getVar('id', '', 'post');



$user = JFactory::getUser();

$u_id=$user->get('id');
$u_mail=$user->get('email');

// logged-in Users: Name/User Name Option
$nameJoomlaUser = JComponentHelper::getParams('com_icagenda')->get('nameJoomlaUser', 1);
if ($nameJoomlaUser == 1) {
	$u_name=$user->get('name');
} else {
	$u_name=$user->get('username');
}

		$data->created_by 			= $u_id;
		$data->created_by_alias 	= JRequest::getVar('created_by_alias', '', 'post');
		$data->created_by_email 	= JRequest::getVar('created_by_email', '', 'post');
		$data->created 				= JRequest::getVar('created', '', 'post');
		$data->checked_out 			= JRequest::getVar('checked_out', '', 'post');
		$data->checked_out_time 	= JRequest::getVar('checked_out_time', '', 'post');

		$data->params 	= JRequest::getVar('params', '', 'post');

		if (isset($data->params) && is_array($data->params)) {
			// Convert the params field to a string.
			$parameter = new JRegistry;
			$parameter->loadArray($data->params);
			$data->params = (string)$parameter;
		}

		$db	= $this->getDbo();
		$db->insertObject('#__icagenda_events', $data, id);

		self::notificationUserEmail($data->created_by_email);

		// Get the "event" URL
		$baseURL = JURI::base();
		$subpathURL = JURI::base(true);

// To be tested
//			$temp = str_replace('http://', '', $baseURL);
//			$temp = str_replace('https://', '', $temp);
//			$parts = explode($temp, '/', 2);
//			$subpathURL = count($parts) > 1 ? $parts[1] : '';


		$baseURL = str_replace('/administrator', '', $baseURL);
		$subpathURL = str_replace('/administrator', '', $subpathURL);

		$urlsend = str_replace('&amp;','&', JRoute::_('index.php?option=com_icagenda&view=submit&layout=send&Itemid='.(int)$menuID));


		// Sub Path filtering
		$subpathURL = ltrim($subpathURL, '/');

		// URL List filtering
		$urlsend = ltrim($urlsend, '/');
		if(substr($urlsend,0,strlen($subpathURL)+1) == "$subpathURL/") $urlsend = substr($urlsend,strlen($subpathURL)+1);
		$urlsend = rtrim($baseURL,'/').'/'.ltrim($urlsend,'/');

			// get the application object
			$app = JFactory::getApplication();

			// redirect after successful registration
			$app->redirect(htmlspecialchars_decode($urlsend) , JText::_( 'COM_ICAGENDA_EVENT_SUBMISSION_CONFIRMATION' ), JText::_( 'COM_ICAGENDA_EVENT_SUBMISSION' ));


	}

	function notificationUserEmail ($email)
	{
		// Load Joomla Config
		$config = JFactory::getConfig();

		// Create User Mailer
		$mailer = JFactory::getMailer();

		// Create Admin Mailer
		$adminmailer = JFactory::getMailer();

		// Get Global Joomla Contact Infos
		if(version_compare(JVERSION, '3.0', 'ge')) {
			$mailfrom = $config->get('mailfrom');
			$fromname = $config->get('fromname');
		} else {
			$mailfrom = $config->getValue('config.mailfrom');
			$fromname = $config->getValue('config.fromname');
		}

		// Set Sender of Notification Email
		$mailer->setSender(array( $mailfrom, $fromname ));
		$adminmailer->setSender(array( $mailfrom, $fromname ));

		// Set Recipient of User Notification Email
		$userrecipient = $email;
		$mailer->addRecipient($userrecipient);

		// Set Subject of User Notification Email
		$subject = 'test';
		$mailer->setSubject($subject);

		// Set Body of User Notification Email
		$body = 'Body';
		$mailer->setBody($body);

		// Send User Notification Email
		if (isset($email)) {
			$send = $mailer->Send();
		}
	}

	function getDates ($dates)
	{
		$dates=str_replace('d=', '', $dates);
		$dates=str_replace('+', ' ', $dates);
		$dates=str_replace('%3A', ':', $dates);
		$ex_dates=explode('&', $dates);
		return $ex_dates;
	}

	function getNextDates ($dates)
	{
		$nodate='0000-00-00 00:00:00';
		$today=time();
		$day= date('d');
		$m= date('m');
		$y= date('y');
		$today=mktime(0,0,0,$m,$day,$y);
		$next=$this->mkt($dates[0]);

		if(count($dates)){

			while ($next <= $today) {
				$dd = $this->mkt($dates[0]);
				$nextDate=$dd;
				foreach($dates as $d){
					$d=$this->mkt($d);
					if ($d>=$today){
						$nextDate=$d;
					}
				}
//				echo ' today : '.$today;
//				echo ' next : '.$next;
//				echo ' date next : '.$d;

				return date('Y-m-d H:i', $nextDate);
			}

		}

	}

//	function getNext ($dates)
//	{
//		$dates=unserialize($dates);
//		$today=time();
//		if(count($dates)){
//			$next=$dates[0];
//			if ($this->mkt($next)<$today){
//				foreach($dates as $d){
//					$MktD=$this->mkt($d);
//					if ($MktD>=$today){
//						$next=$d;
//					}
//				}
//			}
//			return $next;
//		}
//	}

	function upload ($file){
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');

		$filename = JFile::makeSafe($file['name']['file']);

//		$filename = JRequest::getVar('file', '', 'post');

		if($filename!=''){

			$src = $file['tmp_name']['file'];
			$dest =  JPATH_SITE.'/images/icagenda/files/'.$filename;

			if(!is_dir($dest)){
				mkdir($intDir, 0755);
			}


			if ( JFile::upload($src, $dest, false) ){
				echo 'upload';
				return 'images/icagenda/files/'.$filename;
			}

			return 'images/icagenda/files/'.$filename;
		}
	}

	function mkt($data)
	{
		$data=str_replace(' ', '-', $data);
		$data=str_replace(':', '-', $data);
		$ex_data=explode('-', $data);
		if (isset($ex_data['3']))$hour=$ex_data['3'];
		if (isset($ex_data['4']))$min=$ex_data['4'];
		if ((isset($hour)) && (isset($min)) && ($hour!='') && ($hour!=NULL) && ($min!='') && ($min!=NULL)) {
			$result=mktime($ex_data['3'], $ex_data['4'], '00', $ex_data['1'], $ex_data['2'], $ex_data['0']);
		} else {
			$result=mktime('00', '00', '00', $ex_data['1'], $ex_data['2'], $ex_data['0']);
		}
		return $result;
	}

	function mktdate($data)
	{
		$data=str_replace(' ', '-', $data);
		$data=str_replace(':', '-', $data);
		$ex_data=explode('-', $data);
		$result=mktime('00', '00', '00', $ex_data['1'], $ex_data['2'], $ex_data['0']);
		return $result;
	}

	function mkttime($data)
	{
		$data=str_replace(' ', '-', $data);
		$data=str_replace(':', '-', $data);
		$ex_data=explode('-', $data);
		$result=mktime($ex_data['3'], $ex_data['4'], '00', '00', '00', '00');
		return $result;
	}

}
