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

    class TheFactoryInstallerMenuHelper
    {
        public $id=null;
        public $module_id=null;
        public $menutype=null;
        public $componentid=null;
        public $title=null;
        public $menu_list=array();

        /**
         * _getMenuType_ID
         */
        protected function _getMenuType_ID()
        {
    	$jversion = new JVersion();
    	if($jversion->isCompatible('3.0')){
    	    $menuType=JTableMenuType::getInstance('Menutype', 'JTable');
    	} else {
            $menuType=JTable::getInstance('menutype');
    	}

            // Joomla 1.6 will fail this
            $menuType->set("_tbl_key", "title");
            $menuType->load($this->title);
            $this->id=$menuType->id;
            $this->menutype=$menuType->menutype;
        }

        /**
         * _getMenuModule_ID
         */
        protected function _getMenuModule_ID()
        {

            $module=JTable::getInstance('module');
            // Joomla 1.6 will fail this
            $module->set("_tbl_key", "title");
            $module->load($this->title);
            $this->module_id=$module->id;
        }

        /**
         * storeMenu
         */
        public function storeMenu()
        {

            $f=new JFilterInput();
            $this->_getMenuType_ID();
    	$jversion = new JVersion();
            if($jversion->isCompatible('3.0')){
    	    $menuType=JTableMenuType::getInstance('Menutype', 'JTable');
            } else {
            $menuType=JTable::getInstance('menutype');
    	}
            $menuType->id=$this->id;
            $this->menutype=$menuType->menutype=$f->clean($this->title, 'word');
            $menuType->title=$this->title;
            $menuType->store();
            $this->storeMenuModule();
            return JText::sprintf("%s",$menuType->title);
        }

        /**
         * storeMenuModule
         *
         * @return object
         */
        public function storeMenuModule()
        {

            $db=JFactory::getDbo();

            $this->_getMenuModule_ID();
            $module=JTable::getInstance('module');
            $module->id=$this->module_id;
            $module->title=$this->title;
            $module->position='position-7';
            $module->module='mod_menu';
            $module->published=1;
            $module->access=1;
            $module->params='{"menutype":"'.$this->menutype.'"}';
            $module->client_id=0;
            $module->store();

            $module->reorder('position='.$db->Quote($module->position));

            // module assigned to show on All pages by default
            // Clean up possible garbage first
            $query='DELETE FROM `#__modules_menu` WHERE `moduleid` = '.(int)$module->id;
            $db->setQuery($query);
            if (!$db->query())
            {
                JFactory::getApplication()->enqueueMessage($db->getError(),'error');
                return;
            }

            $query='INSERT INTO `#__modules_menu` VALUES ( '.(int)$module->id.', 0 )';
            $db->setQuery($query);
            if (!$db->query())
            {
                JFactory::getApplication()->enqueueMessage($db->getError(),'error');
                return;
            }

            // Add Menu Items
            if (count($this->menu_list))
            {
                //remove all menu items

                foreach ($this->menu_list as $k=>$menuitem)
                {
                    $menuitem->setLocation(1, 'last-child');
                    $menuitem->component_id=$this->componentid;
                    $menuitem->menutype=$this->menutype;
                    $menuitem->store();
                }
            }

        }

        /**
         * AddMenuItem
         *
         * @param      $title
         * @param      $alias
         * @param      $link
         * @param      $ordering
         * @param int  $access
         * @param null $params
         */
        public function AddMenuItem($title, $alias, $link, $ordering, $access=0, $params=null)
        {

            $menu=JTable::getInstance('menu');
            $menu->set("_tbl_key", "title");
            $menu->load($title);
            $menu->set("_tbl_key", "id");
            $menu->title=$title;
            $menu->alias=$alias;
            $menu->link=$link;
            $menu->type="component";
            $menu->access=$access;
            $menu->published=1;
            $menu->parent_id=1;
            $menu->level=1;

    	$jversion = new JVersion();
    	if(!$jversion->isCompatible('3.0')){
            $menu->ordering=$ordering;
    	}
            $menu->client_id=0;
            $this->menu_list[$title]=$menu;
        }
    }