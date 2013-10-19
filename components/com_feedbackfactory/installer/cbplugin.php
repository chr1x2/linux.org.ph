<?php
/*------------------------------------------------------------------------
com_wallfactory - Wall Factory 3.0.0
------------------------------------------------------------------------
author    TheFactory
copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support:  Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');

    class com_feedbackfactoryPluginInstallerScript {

        static  function install_cbplugin($pluginname) {

            $database = JFactory::getDbo();

            $extension = JTable::getInstance('extension');
            $cb_plugin_exists = $extension->find(array('type' => 'component', 'element' => 'com_comprofiler'));

            if( !$cb_plugin_exists ) {
                return false;
            }

            $query = "SELECT id FROM #__comprofiler_plugin where element='$pluginname.plugin'";
            $database->setQuery($query);
            $plugid = $database->loadResult();

            if (!$plugid) {
                if ( $pluginname == 'feedback_factory')
                    com_feedbackfactoryPluginInstallerScript::InstallCBPlugin('Feedback Factory - My Feedbacks','My Feedbacks','feedback_factory','plug_feedback_factory','getmyfeedbacksTab');
                }

            return true;
      }


      function InstallCBPlugin($plugintitle,$tabtitle,$pluginname,$folder,$class)
      {
          jimport('joomla.filesystem.path');
          $database = JFactory::getDbo();

    	$query = "INSERT INTO #__comprofiler_plugin set
        			`name`='$plugintitle',
    	    		`element`='$pluginname.plugin',
    				`type`='user',
    				`folder`='$folder',
    				`ordering`=99,
    				`published`=1,
    				`iscore`=0
    			";
    	$database->setQuery( $query );
    	$database->query();

    	$plugid = $database->insertid();

    	$query = "INSERT INTO #__comprofiler_tabs set
    			`title`='$tabtitle',
    			`ordering`=999,
    			`enabled`=1,
    			`pluginclass`='$class',
    			`pluginid`='{$plugid}',
    			`fields`=0,
    			`displaytype`='tab',
    			`position`='cb_tabmain',
    			`viewaccesslevel` = 2
    			";
    	$database->setQuery( $query );
    	$database->query();

    	@mkdir(JPATH_ROOT.'/components/com_comprofiler/plugin/user/'.$folder);


        //JFolder::create(JPATH_ROOT.'/components/com_comprofiler/plugin/user/'.$folder);

    	$source_file = JPATH_ROOT."/components/com_feedbackfactory/cb_plug/$pluginname.plugin.php";
    	$destination_file = JPATH_ROOT."/components/com_comprofiler/plugin/user/$folder/$pluginname.plugin.php";
        //JFile::copy($source_file, $destination_file);
          copy ($source_file, $destination_file);

    	$source_file = JPATH_ROOT."/components/com_feedbackfactory/cb_plug/$pluginname.plugin.xml";
    	$destination_file = JPATH_ROOT."/components/com_comprofiler/plugin/user/$folder/$pluginname.plugin.xml";
    	copy ($source_file, $destination_file);
        //  JFile::copy($source_file, $destination_file);
          echo "<span>Installed Plugin ".$plugintitle."</span><br/>";
          return JText::sprintf("FACTORY_CBPLUGIN_INSTALLED",$plugintitle);

      }

    }