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


class pkg_feedbackfactoryInstallerScript {

    function postflight($route,$adapter) {

	   $session = JFactory::getSession();
        echo $session->get('com_feedbackfactory_install_msg');
        $session->set('com_feedbackfactory_install_msg',null);

    }
}