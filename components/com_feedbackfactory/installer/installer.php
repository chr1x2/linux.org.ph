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

    class TheFactoryFeedbackFactoryInstaller {

        public $cbplugins=null;
        public $plugins=null;
        public $modules=null;
        public $menus=null;
        public $message=null;

        public $SQL=null;
        public $version=null;
        public $versionprevious=null;
        public $extension_message=null;

        protected $_extension=null;
        protected $_adapter=null;
        protected $_componentid=null;
        protected $_sourcepath=null;

        public function __construct($extensionname, $adapter)
        {
            $this->_extension=$extensionname;
            $this->_adapter=$adapter;
            //$this->_sourcepath=$adapter->getParent()->getPath('source').'/components/'.$extensionname.'/installer';
			$this->_sourcepath=$adapter->getParent()->getPath('source').'/site/installer';
			$this->version=$this->getCurrentVersion();
			$this->versionprevious=$this->getPreviousVersion();
		
            @ignore_user_abort(true);
        }

        public function AddMenuItem($menuname, $menuitemtitle, $itemalias, $link, $access=0, $params=null)
        {
            if (!isset($this->menus[$menuname])) $this->menus[$menuname]=array();

            $this->menus[$menuname][]=array('name'=>$menuitemtitle, 'alias'=>$itemalias, 'link'=>$link, 'access'=>$access, 'params'=>$params);

        }

        public function getCurrentVersion()
        {
            //$configfile=$this->_adapter->getParent()->getPath('source').'/administrator/components/'.$this->_extension.'/application.ini';
			$configfile=$this->_adapter->getParent()->getPath('source').'/admin/application.ini';

            if (!file_exists($configfile))
            {
                return null;
            }

            if (function_exists('parse_ini_file'))
            {
                $ini=parse_ini_file($configfile, true);
            }
            else
            {
                jimport('joomla.registry.registry');
                jimport('joomla.filesystem.file');

                $handler=JRegistryFormat::getInstance('INI');
                $data=$handler->stringToObject(file_get_contents($configfile));

                $ini=JArrayHelper::fromObject($data);
            }
            return $ini['extension']['version'];
        }

        /**
         * getPreviousVersion
         *
         * @return null
         */
        public function getPreviousVersion()
        {
            $configfile=JPATH_ADMINISTRATOR.'/components/'.$this->_extension.'/application.ini';
			
            if (!file_exists($configfile))
            {
                return null;
            }

            if (function_exists('parse_ini_file'))
            {
                $ini=parse_ini_file($configfile, true);
            }
            else
            {
                jimport('joomla.registry.registry');
                jimport('joomla.filesystem.file');

                $handler=JRegistryFormat::getInstance('INI');
                $data=$handler->stringToObject(file_get_contents($configfile));

                $ini=JArrayHelper::fromObject($data);
            }
            return $ini['extension']['version'];
        }


        /**
         * AddSQLStatement
         *
         * @param $sql
         */
        public function AddSQLStatement($sql)
        {
            $this->SQL[]=$sql;
        }

        /**
         * AddSQLFromFile
         *
         * @param $filename
         */
        public function AddSQLFromFile($filename)
        {
            $filename=$this->_sourcepath."/$filename";
			
            if (!file_exists($filename)) return;
            $contents=fread(fopen($filename, 'r'), filesize($filename));

            $db=JFactory::getDbo();
            $sql=$db->splitSql($contents);

            if (count($this->SQL))
            {
                $this->SQL=array_merge($this->SQL, $sql);
            }
            else
            {
                $this->SQL=$sql;
            }
        }

        public function AddModule($module_name, $module_title, $module_params='')
        {
            $this->modules[]=array('name'=>$module_name, 'title'=>$module_title, 'params'=>$module_params);
        }

        /**
        * AddPlugin
        *
        * @param $plugin_name
        * @param $plugin_title
        * @param $plugin_type
        * @param $plugin_params
        */
        public function AddPlugin($plugin_name, $plugin_title, $plugin_type, $plugin_params)
        {
           $this->plugins[]=array('name'=>$plugin_name, 'title'=>$plugin_title, 'type'=>$plugin_type, 'params'=>$plugin_params);
        }

       /**
        * AddCBPlugin
        *
        * @param $plugintitle
        * @param $tabtitle
        * @param $pluginname
        * @param $classname
        */
        public function AddCBPlugin($plugintitle, $tabtitle, $pluginname, $classname)
        {
           $this->cbplugins[]=array('title'=>$plugintitle, 'tab'=>$tabtitle, 'name'=>$pluginname, 'class'=>$classname
           );
        }

        public function AddMessageFromFile($filename)
        {
            $filename=$this->_sourcepath."/$filename";
            if (!file_exists($filename)) return;
            $contents=fread(fopen($filename, 'r'), filesize($filename));
            $this->message[]=$contents;
        }

        public function AddMessage($msg)
        {
            $this->message[]=$msg;
        }

        /**
         * install
         */
        public function install()
        {
            $db=JFactory::getDbo();
            //Install Menus
            $db->setQuery("SELECT `extension_id` FROM `#__extensions` WHERE `element` ='{$this->_extension}'");
            $this->_componentid=$db->loadResult();
            // Add Menus
            if (count($this->menus))
            {
                require_once(dirname(__FILE__).'/menu.php');
                foreach ($this->menus as $menuname=>$menuitems)
                {
                    $menu=new TheFactoryInstallerMenuHelper();
                    $menu->title=$menuname;
                    $menu->componentid=$this->_componentid;
                    $j=0;
                    foreach ($menuitems as $item)
                    {
                        $menu->AddMenuItem($item['name'], $item['alias'], $item['link'], $j++, $item['access'], $item['params']);
                    }
                    $this->extension_message[]=$menu->storeMenu();
                }
            }

            //Install CB Plugins
            if (count($this->cbplugins))
            {
                $db->setQuery("SELECT * FROM `#__extensions` WHERE `element`='com_comprofiler'");
                $comprofiler=$db->loadResult();
                if (count($comprofiler)<=0)
                {
                    $this->extension_message[]="<div>";
                    $this->extension_message[]="<h2>Community Builder not detected</h2> <br />";
                    $this->extension_message[]="</div>";
                }
                else
                {
                    require_once(dirname(__FILE__).'/cbplugin.php');
                    $cbpluginhelper=new com_feedbackfactoryPluginInstallerScript();
                    foreach ($this->cbplugins as $plugin)
                    {
                        $this->extension_message[]=$cbpluginhelper->InstallCBPlugin($plugin['title'], $plugin['tab'], $plugin['name'], 'plug_'.$plugin['name'], $plugin['class']);
                    }
                }
            }
            //Install SQL
            if (count($this->SQL))
            {
                foreach ($this->SQL as $sql)
                {
                    if (trim($sql))
                    { //empty queries
                        $db->setQuery($sql);
                        if (!$db->query()) $this->errors[]=$db->getErrorMsg();
                    }
                }
            }

            if ($this->message)
            {
                $this->extension_message[]="<table width='100%'>";
                foreach ($this->message as $message)
                {
                    $this->extension_message[]="<tr>";
                    $this->extension_message[]="<td><div>{$message}</div></td>";
                    $this->extension_message[]="</tr>";
                }
                $this->extension_message[]="</table>";
            }


        }

    }
