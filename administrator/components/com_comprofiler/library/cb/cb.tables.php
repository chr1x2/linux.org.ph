<?php
/**
* Joomla/Mambo Community Builder
* @version $Id: cb.tables.php 1900 2012-11-01 14:57:41Z beat $
* @package Community Builder
* @subpackage cb.tables.php
* @author Beat
* @copyright (C) 2004-2011 www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

// ensure this file is being included by a parent file
if ( ! ( defined( '_VALID_CB' ) || defined( '_JEXEC' ) || defined( '_VALID_MOS' ) ) ) { die( 'Direct Access to this location is not allowed.' ); }


class moscomprofilerPlugin extends comprofilerDBTable {
	/** @var int */
	var $id					=	null;
	/** @var varchar */
	var $name				=	null;
	/** @var varchar */
	var $element			=	null;
	/** @var varchar */
	var $type				=	null;
	/** @var varchar */
	var $folder				=	null;
	/** @var varchar */
	var $backend_menu		=	null;
	/** @var tinyint unsigned */
	var $access				=	null;
	/** @var int */
	var $ordering			=	null;
	/** @var tinyint */
	var $published			=	null;
	/** @var tinyint */
	var $iscore				=	null;
	/** @var tinyint */
	var $client_id			=	null;
	/** @var int unsigned */
	var $checked_out		=	null;
	/** @var datetime */
	var $checked_out_time	=	null;
	/** @var text */
	var $params				=	null;
	/**
	* Constructor
    * @param  CBdatabase  $db   A database connector object
	*/
	function moscomprofilerPlugin( &$db ) {
		$this->comprofilerDBTable( '#__comprofiler_plugin', 'id', $db );
	}
	function check() {
		$ok		=	( $this->name );
		if ( ! $ok ) {
			$this->_error	=	"Save not allowed";
		}
		return $ok;
	}
}
class moscomprofilerLists extends comprofilerDBTable {

	var $listid				=	null;
	var $title				=	null;
	var $description		=	null;
	var $published			=	null;
	var $default			=	null;
	var $viewaccesslevel	=	null;
	var $usergroupids		=	null;
	var $useraccessgroupid	=	null;
	var $sortfields			=	null;
	var $filterfields		=	null;
	var $ordering			=	null;
	var $col1title			=	null;
	var $col1enabled		=	null;
	var $col1fields			=	null;
	var $col1captions		=	null;
	var $col2title			=	null;
	var $col2enabled		=	null;
	var $col2fields			=	null;
	var $col2captions		=	null;
	var $col3title			=	null;
	var $col3enabled		=	null;
	var $col3fields			=	null;
	var $col3captions		=	null;
	var $col4title			=	null;
	var $col4enabled		=	null;
	var $col4fields			=	null;
	var $col4captions		=	null;
	/** @var text */
	var $params				=	null;

    /**
    * Constructor
    * @param  CBdatabase  $db   A database connector object
    */
	function moscomprofilerLists( &$db ) {

		$this->comprofilerDBTable( '#__comprofiler_lists', 'listid', $db );

	} //end func

	function store( $listid=0, $updateNulls=false) {
			global $_CB_database, $_POST;

		if ( ( ! isset( $_POST['listid'] ) ) || $_POST['listid'] == null || $_POST['listid'] == '' ) {
			$this->listid = (int) $listid;
		} else {
			$this->listid = (int) cbGetParam( $_POST, 'listid', 0 );
		}
		$sql="SELECT COUNT(*) FROM #__comprofiler_lists WHERE listid = ".  (int) $this->listid;
		$_CB_database->SetQuery($sql);
		$total = $_CB_database->LoadResult();
		if($this->default==1) {
			$sql="UPDATE #__comprofiler_lists SET `default` = 0";
			$_CB_database->SetQuery($sql);
			$_CB_database->query();
		}
		if ( $total > 0 ) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );

		} else {
			// new record
			$sql="SELECT MAX(ordering) FROM #__comprofiler_lists";
			$_CB_database->SetQuery($sql);
			$max = $_CB_database->LoadResult();
			$this->ordering=$max+1;
			$this->listid = null;
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
		}
		if ( !$ret ) {
			$this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}


} //end class
class moscomprofilerFields extends comprofilerDBTable {

   var $fieldid			= null;
   var $name			= null;
   var $tablecolumns	= null;
   var $table			= null;
   var $title			= null;
   var $description		= null;
   var $type			= null;
   var $maxlength		= null;
   var $size			= null;
   var $required		= null;
   var $tabid			= null;
   var $ordering		= null;
   var $cols			= null;
   var $rows			= null;
   var $value			= null;
   var $default			= null;
   var $published		= null;
   var $registration	= null;
   var $profile			= null;
   var $displaytitle	= null;
   var $readonly		= null;
   var $searchable		= null;
   var $calculated		= null;
   var $sys				= null;
   var $pluginid		= null;
   /**
    * Field's params: once loaded properly contains:
    * @var cbParamsBase
    */
   var $params			= null;

    /**
    * Constructor
    * @param  CBdatabase  $db   A database connector object
    */
	function moscomprofilerFields( &$db ) {
		$this->comprofilerDBTable( '#__comprofiler_fields', 'fieldid', $db );
	}

	function store( $fieldid = 0, $updateNulls = false ) {
			global $_CB_database;

			$this->fieldid			=	$fieldid;

			$fieldHandler			=	new cbFieldHandler();

			$sql					=	'SELECT COUNT(*) FROM #__comprofiler_fields WHERE fieldid = ' . (int) $this->fieldid;
			$_CB_database->SetQuery( $sql );
			$total					=	$_CB_database->LoadResult();

			if ( $total > 0 ) {
				// existing record:
				$ret				=	$this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );	// escapes values
				if ( $ret ) {
					$ret			=	$fieldHandler->adaptSQL( $this );
				}
			} else {
				// new record:

				$sql				=	'SELECT COUNT(*) FROM #__comprofiler_fields WHERE name = ' . $_CB_database->Quote( $this->name );
				$_CB_database->SetQuery($sql);
				if ( $_CB_database->LoadResult() > 0 ) {
					$this->_error	=	"The field name ".$this->name." is already in use!";
					return false;
				}
				$sql				=	'SELECT MAX(ordering) FROM #__comprofiler_fields WHERE tabid = ' . (int) $this->tabid;
				$_CB_database->SetQuery( $sql );
				$max				=	$_CB_database->LoadResult();
				$this->ordering		=	$max + 1;
				$this->fieldid		=	null;
				$this->table		=	$fieldHandler->getMainTable( $this );
				$this->tablecolumns	=	implode( ',', $fieldHandler->getMainTableColumns( $this ) );

				$ret				=	$fieldHandler->adaptSQL( $this );

				if ($ret) {
					$ret			=	$this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );		// do inserObject last to keep insertId intact
				}
			}
			if ( ! $ret ) {
				$this->_error		=	get_class( $this ) . "::store failed: " . addslashes( str_replace( "\n", '\n', $this->_error . ' ' . $this->_db->getErrorMsg() ) );
				return false;
			} else {
				return true;
			}
	}
	/**
	*	Delete method for fields deleting also fieldvalues, but not the data column in the comprofiler table.
	*	For that, deleteColumn() method must be called separately.
	*
	*	@param id of row to delete
	*	@return true if successful otherwise returns and error message
	*/
	function deleteDataDescr( $oid = null ) {
		$fieldHandler				=	new cbFieldHandler();
		$ret						=	$fieldHandler->adaptSQL( $this, 'drop' );
		if ( $ret ) {
			$ret					=	$this->delete( $oid );
		}
		return $ret;
	}
	/**
	*	Delete method for fields deleting also fieldvalues, but not the data column in the comprofiler table.
	*	For that, deleteDataDescr() method must be called instead.
	*
	*	@param id of row to delete
	*	@return true if successful otherwise returns and error message
	*/
	function delete( $oid = null ) {
		$k							=	$this->_tbl_key;
		if ( $oid ) {
			$this->$k				=	(int) $oid;
		}

		$result					=	true;

		//Find all fieldValues related to the field
		$this->_db->setQuery( "SELECT `fieldvalueid` FROM #__comprofiler_field_values WHERE `fieldid`=" . (int) $this->$k );
		$fieldvalues				=	$this->_db->loadObjectList();
		$rowFieldValues				=	new moscomprofilerFieldValues($this->_db);
		if ( count( $fieldvalues ) > 0 ) {
			//delete each field value related to a field
			foreach ( $fieldvalues AS $fieldvalue ) {
				$result				=	$rowFieldValues->delete( $fieldvalue->fieldvalueid ) && $result;
			}
		}
		//Now delete the field itself without deleting the user data, preserving it for reinstall
		//$this->deleteColumn( $this->table, $this->name );	// this would delete the user data
		$result						=	parent::delete( $this->$k ) && $result;
		return $result;
	}
	/**
	 * Returns the database columns used by the field
	 *
	 * @return array    Names of columns
	 */
	function getTableColumns() {
		if ( $this->tablecolumns !== null ) {
			if ( $this->tablecolumns === '' ) {
				return array();
			} else {
				return explode( ',', $this->tablecolumns );
			}
		} else {
			return array( $this->name );		// pre-CB 1.2 database structure support
		}
	}
	/**
	 * OBSOLETE DO NOT USE: kept in 1.2 for compatibility reasons only
	 * @access private
	 */
	function createColumn( $table, $column, $type) {
		global $_CB_database;

		if ( ( $table == '' ) || ( $type == '' ) ) {
			return true;
		}
		$sql = "SELECT * FROM " . $_CB_database->NameQuote( $table );
		$_CB_database->setQuery( $sql, 0, 1 );
		$obj = null;
		if ( ! ( $_CB_database->loadObject( $obj ) && array_key_exists( $column, $obj ) ) ) {
			$sql = "ALTER TABLE " . $_CB_database->NameQuote( $table )
				 . "\n ADD " . $_CB_database->NameQuote( $column ) . " " . $type;		// don't escape type, as default text values are quoted
			$_CB_database->SetQuery( $sql );
			$ret = $_CB_database->query();
			if ( !$ret ) {
				$this->_error .= get_class( $this )."::createColumn failed <br />" . $this->_db->getErrorMsg();
				return false;
			} else {
				return true;
			}
		} else {
			return $this->changeColumn( $table, $column, $type);
		}
	}
	/**
	 * OBSOLETE DO NOT USE: kept in 1.2 for compatibility reasons only
	 * @access private
	 */
	function changeColumn( $table, $column, $type, $oldColName = null ) {
		global $_CB_database;

		if ( ( $table == '' ) || ( $type == '' ) ) {
			return true;
		}
		if ( $oldColName === null ) {
			$oldColName		=	$column;
		}
		$sql = "ALTER TABLE " . $_CB_database->NameQuote( $table )
				. "\n CHANGE " . $_CB_database->NameQuote( $oldColName )
				. " " . $_CB_database->NameQuote( $column )
				. " " . $type;														// don't escape type, as default text values are quoted
		$_CB_database->SetQuery( $sql );
		$ret = $_CB_database->query();
		if ( !$ret ) {
			$this->_error .= get_class( $this )."::changeColumn failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}
	/**
	 * OBSOLETE DO NOT USE: kept in 1.2 for compatibility reasons only
	 * @access private
	 */
	function deleteColumn( $table, $column) {
			global $_CB_database;
		$sql = "ALTER TABLE " . $_CB_database->NameQuote( $table)
				. "\n DROP " .  $_CB_database->NameQuote( $column)
				;
		$_CB_database->SetQuery($sql);
		$ret = $_CB_database->query();
		if ( !$ret ) {
			$this->_error .= get_class( $this )."::deleteColumn failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}
} //end class

class moscomprofilerTabs extends comprofilerDBTable {

   var $tabid				=	null;
   var $title				=	null;
   var $description			=	null;
   var $ordering			=	null;
   var $ordering_register	=	null;
   var $width				=	null;
   var $enabled				=	null;
   var $pluginclass			=	null;
   var $pluginid			=	null;
   var $fields				=	null;
   var $params				=	null;
   /**	@var int  system tab: >=1: from comprofiler core: can't be deleted. ==2: always enabled. ==3: collecting element (menu+status): rendered at end. */
   var $sys					=	null;
   var $displaytype			=	null;
   var $position			=	null;
   var $viewaccesslevel		=	null;
   var $useraccessgroupid	=	null;

    /**
    * Constructor
    * @param  CBdatabase  $db   A database connector object
    */
	function moscomprofilerTabs( &$db ) {

		$this->comprofilerDBTable( '#__comprofiler_tabs', 'tabid', $db );

	} //end func

	function store( $updateNulls=false) {
		global $_CB_database, $_POST;

		$sql = "SELECT COUNT(*) FROM #__comprofiler_tabs WHERE tabid = ". (int) $this->tabid;
		$_CB_database->SetQuery($sql);
		$total = $_CB_database->LoadResult();
		if ( $total > 0 ) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );	// escapes values!

		} else {
			$sql = "SELECT MAX(ordering) FROM #__comprofiler_tabs";
			$_CB_database->SetQuery($sql);
			$max = $_CB_database->LoadResult();
			$this->ordering = $max + 1;
			// new record
			$this->tabid = null;
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );

		}
		if ( !$ret ) {
			$this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}
} //end class
class moscomprofilerFieldValues extends comprofilerDBTable {
   var $fieldvalueid	=	null;
   var $fieldid			=	null;
   var $fieldtitle		=	null;
   var $ordering		=	null;
   var $sys				=	null;

    /**
    * Constructor
    *
    * @param  CBdatabase  $db   A database connector object
    */

	function moscomprofilerFieldValues( &$db ) {

		$this->comprofilerDBTable( '#__comprofiler_field_values', 'fieldvalueid', $db );

	} //end func

	function store( $fieldvalueid=0, $updateNulls=false) {
			global $_CB_database, $_POST;

		if ( ( ! isset( $_POST['fieldvalueid'] ) ) || $_POST['fieldvalueid'] == null || $_POST['fieldvalueid'] == '' ) {
			$this->fieldvalueid = (int) $fieldvalueid;
		} else {
			$this->fieldvalueid = (int) cbGetParam( $_POST, 'fieldvalueid', 0 );
		}
		$sql = "SELECT COUNT(*) FROM #__comprofiler_field_values WHERE fieldvalueid = " . (int) $this->fieldvalueid;
		$_CB_database->SetQuery($sql);
		$total = $_CB_database->LoadResult();
		if ( $total > 0 ) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );

		} else {
			// new record
			$this->fieldvalueid = null;
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
		}
		if ( !$ret) {
			$this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {

			return true;
		}
	}


} //end class
class moscomprofiler extends comprofilerDBTable {

	// IMPORTANT: ALL VARIABLES HERE MUST BE NULL in order to not be updated if not set.
	/**
	 * @var int
	 */
	var $id						=	null;
	/**
	 * @var int
	 */
	var $user_id				=	null;
	var $firstname				=	null;
	var $middlename				=	null;
	var $lastname				=	null;
	var $hits					=	null;
	var $message_last_sent		=	null;
	var $message_number_sent	=	null;
	var $avatar					=	null;
	var $avatarapproved			=	null;
	var $approved				=	null;
	var $confirmed				=	null;
	var $lastupdate				=	null;
	var $registeripaddr			=	null;
	var $cbactivation			=	null;
	var $banned					=	null;
	var $banneddate				=	null;
	var $unbanneddate			=	null;
	var $bannedby				=	null;
	var $unbannedby				=	null;
	var $bannedreason			=	null;
	var $acceptedterms			=	null;

    /**
    * Constructor
    *
    * @param  CBdatabase  $db   A database connector object
    */
	function moscomprofiler( &$db ) {
		$this->comprofilerDBTable( '#__comprofiler', 'id', $db );
	}
	/**
	* Inserts a new row in the database table
	*
	* @param  boolean  $updateNulls  TRUE: null object variables are also updated, FALSE: not.
	* @return boolean                TRUE if successful otherwise FALSE
	*/
	function storeNew( $updateNulls = false ) {
		$ok					=	$this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
		if ( ! $ok ) {
			$this->_error	=	strtolower(get_class($this))."::storeNew failed: " . $this->_db->getErrorMsg();
		}
		return $ok;
	}
	/**
	 * OBSOLETE AND BUGGY: DO NOT USE
	 * KEPT FOR 3PD COMPATIBILITY ONLY
	 */
	function storeExtras( $id=0, $updateNulls=false) {
		global $_CB_database, $_POST;

		if ( ( ! isset( $_POST['id'] ) ) || $_POST['id'] == null || $_POST['id'] == '' ) {
			$this->id = (int) $id;
		} else {
			$this->id = (int) cbGetParam( $_POST, 'id', 0 );
		}
		$sql = "SELECT count(*) FROM #__comprofiler WHERE id = ". (int) $this->id;
		$_CB_database->SetQuery($sql);
		$total = $_CB_database->LoadResult();
		if ( $total > 0 ) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );	// escapes values

		} else {
			// new record
			$sql = "SELECT MAX(id) FROM #__users";
			$_CB_database->SetQuery($sql);
			$last_id		= $_CB_database->LoadResult();
			$this->id		= $last_id;
			$this->user_id	= $last_id;
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );					// escapes values

		}
		if ( !$ret ) {
			$this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}
	/**
	*	Merges two object into one by reference ( avoids "_db", "_tbl", "_tbl_key", and $o2->($o2->_tbl_key) )
	*
	*	@deprecated CB 1.2.2
	*
	*   @static function:
	*	@param object $o1 first object
	*	@param object $o2 second object
	*	@return object
	*/
	function & dbObjectsMerge( &$o1, &$o2 ) {
		$r = new stdClass();

		$class_vars = get_object_vars($o1);
		foreach ($class_vars as $name => $value) {
			if (($name != "_db") and ($name != "_tbl") and ($name != "_tbl_key")) {
				$r->$name =& $o1->$name;
			}
		}
		$class_vars = get_object_vars($o2);
		$k = $o2->_tbl_key;
		foreach ($class_vars as $name => $value) {
			if (($name != $k) and ($name != "_db") and ($name != "_tbl") and ($name != "_tbl_key")) {
				$r->$name =& $o2->$name;
			}
		}
		return $r;
	}

} // class moscomprofiler
/**
 * WIP: EXPERIMENTAL: use at your own risk, no backwards compatibility guarrantee
 *
 * Class for single cb User tables object
 *
 */
class moscomprofilerUser extends moscomprofiler  {
	/** @var string */
	var $name					=	null;
	/** @var string */
	var $username				=	null;
	/** @var string */
	var $email					=	null;
	/** @var string */
	var $password				=	null;
	/** @var string */
	var $usertype				=	null;
	/** @var int */
	var $block					=	null;
	/** @var int */
	var $sendEmail				=	null;
	/** @var int */
	var $gid					=	null;
	/** @var array */
	var $gids					=	array();
	/** @var datetime */
	var $registerDate			=	null;
	/** @var datetime */
	var $lastvisitDate			=	null;
	/** @var string */
	var $activation				=	null;
	/** @var string */
	var $params					=	null;

	var $_cmsUserTable			=	'#__users';
	var $_cmsUserTableKey		=	'id';
	var $_cmsUserTableUsername	=	'username';
	var $_cmsUserTableEmail	=	'email';
	var $_cmsUserTableGid		=	'gid';

	/** CMS User object
	 *  @var JUser */
	var $_cmsUser				=	null;
	/** CB user table row
	 *  @var moscomprofiler */
	var $_comprofilerUser		=	null;
	/** CB Tabs
	 *  @var cbTabs */
	public $_cbTabs				=	null;

	var $_nonComprofilerVars		 =	array( 'name', 'username', 'email', 'password', 'params'	, 	'usertype', 'block', 'sendEmail', 'gid', 'gids', 'registerDate', 'activation', 'lastvisitDate' );
	var $_frontendNonComprofilerVars =	array( 'name', 'username', 'email', 'password', 'params' );
	/**
	 * Constructor
	 *
	 * @param  CBdatabase $db
	 * @return moscomprofilerUser
	 */
	function moscomprofilerUser( &$db ) {
		parent::moscomprofiler( $db );
		if ( checkJversion() == 2 ) {
			$this->_cmsUserTableGid					=	null;
		}
		$this->_reinitNonComprofileVars();
	}
	/**
	 * Resets public properties
	 *
	 * @param  mixed  $value  The value to set all properties to, default is null
	 */
	function reset( $value=null ) {
		parent::reset( $value );
		$this->_reinitNonComprofileVars();
	}
	/**
	 * Initializes non-comprofiler vars for CMS users table
	 *
	 * J2.5.5 introduced 2 new columns 'lastResetTime' and 'resetCount' to the CMS users table, but forgot to introduce it to JUser (Joomla bug #28703). JUser thus gets those only in J2.5.6.
	 * This function attempts to get the real database columns names that get loaded into JUser (and into $this moscomprofilerUser object) into $this->_nonComprofilerVars
	 *
	 * @since 1.8.1
	 *
	 * @return void
	 */
	protected function _reinitNonComprofileVars() {
		static $cache				=	array();

		if ( ! $cache ) {
			if ( $this->_cmsUser ) {
				$obj				=	$this->_cmsUser;
			} else {
				global $_CB_framework;
				$obj				=	$_CB_framework->_getCmsUserObject( $this->id );
			}

			$tableBased				=	false;

			// Try getting the users table column names:
			if ( is_callable( array( $obj, 'getTable' ) ) ) {
				/** @var $jUserTable JTableUser */
				$jUserTable			=	$obj->getTable();
				if ( is_callable( array( $jUserTable, 'getFields' ) ) ) {
					// Get the fields of the table instead of the variables of the user object itself:
					// (Joomla 2.5 does anyway call that function on reset() when it load()s the user table object, and then caches the result, so it is fast)
					$obj			=	$jUserTable->getFields();
					$tableBased		=	true;
				}
			}

			// Sets the keys for non-private variables based on:
			if ( $tableBased ) {
				// based on table:
				$cache				=	array_keys( $obj );
			} else {
				// based on object:
				foreach ( $obj as $k => $v ) {
					if ( $k[0] != '_' ) {
						$cache[] 	=	$k;
					}
				}
			}
			// Now also adds the private CMS/CB variables gid and gids:
			foreach ( array( 'gid', 'gids' ) as $k ) {
				if ( ! in_array( $k, $cache ) ) {
					$cache[]		=	$k;
				}
			}
		}
		// Reset the list of not comprofiler table columns completely:
		$this->_nonComprofilerVars	=	$cache;
	}
	/**
	*	Loads user from database
	*
	*	@param  int  $oid  [optional] User id
	*	@return boolean    TRUE: success, FALSE: error in database access
	*/
	function load( $oid = null ) {
		$k						=	$this->_tbl_key;

		if ($oid !== null) {
			$this->$k			=	(int) $oid;
		}

		$oid					=	$this->$k;

		if ( $oid === null ) {
			return false;
		}
		//BB fix : resets default values to all object variables, because NULL SQL fields do not overide existing variables !
		//Note: Prior to PHP 4.2.0, Uninitialized class variables will not be reported by get_class_vars().
		$class_vars				=	get_class_vars(get_class($this));
		foreach ( $class_vars as $name => $value ) {
			if ( ($name != $k) && ($name != "_db") && ($name != "_tbl") && ($name != "_tbl_key") && ! ( ( $name == '_cbTabs' ) && ( ( (int) $this->$k ) === (int) $oid ) ) ) {
				$this->$name	=	$value;
			}
		}
		$this->reset();
		//end of BB fix.
	/*
		$query = "SELECT *"
		. "\n FROM " . $this->_tbl . " c, " . $this->_cmsUserTable . " u"
		. "\n WHERE c." . $this->_tbl_key . " = u." . $this->_cmsUserTableKey
		. " AND c." . $this->_tbl_key . " = " . (int) $oid
		;
		$this->_db->setQuery( $query );

		// the following is needed for being able to edit a backend user in CB from CMS which is not yet synchronized with CB:
	*/
		$query					=	'SELECT c.*, u.*'			// don't use * as in case the left join is null, the second loaded id would overwrite the first id with null 
		. "\n FROM " . $this->_cmsUserTable . ' AS u'
		. "\n LEFT JOIN " . $this->_tbl . ' AS c ON c.' . $this->_tbl_key . ' = u.' . $this->_cmsUserTableKey
		. " WHERE u." . $this->_cmsUserTableKey . ' = ' . (int) $oid
		;
		$this->_db->setQuery( $query );

		$arr					=	$this->_db->loadAssoc( );

		if ( $arr === null ) {
			$query				=	'SELECT u.*, c.*'			// don't use * as in case the left join is null, the second loaded id would overwrite the first id with null
			. "\n FROM " . $this->_tbl . ' AS c'
			. "\n LEFT JOIN " . $this->_cmsUserTable . ' AS u ON c.' . $this->_tbl_key . ' = u.' . $this->_cmsUserTableKey
			. " WHERE c." . $this->_tbl_key . ' = ' . (int) $oid
			;
			$this->_db->setQuery( $query );

			$arr				=	$this->_db->loadAssoc( );
		}
		if ( $arr !== null ) {
			$this->bindThisUserFromDbArray( $arr, $oid );
			return true;
		} else {
			return false;
		}
	}
	/**
	* Copy the named array or object content into this object as vars
	* All $arr values are filled in vars of object
	* @access private
	*
	* @param  array               $arr    The input array
	* @param  moscomprofilerUser  $obj    The object to fill
	* @param  int                 $oid    id
	*/
	function bindThisUserFromDbArray( $arr, $oid = null  ) {
		foreach ( $arr as $kk => $v ) {
			$this->$kk		=	$v;
		}
		if ( $oid ) {
			// in case the left join is null, the second loaded id will be NULL and override id:
			$k					=	$this->_tbl_key;
			$this->$k			=	(int) $oid;
		}
		$this->afterBindFromDatabase();
	}
	/**
	 * This function should be called just after binding the moscomprofilerUser object from database
	 * to load the gids
	 * and to fix the CMS database storage bugs.
	 * It should be avoided externally, but is used by cb.lists.php
	 */
	function afterBindFromDatabase( ) {
		if ( checkJversion() == 2 ) {
			global $_CB_framework;

			$gids			=	array_values( (array) JFactory::getAcl()->getGroupsByUser( $this->id, false ) );

			foreach ( $gids as $k => $v ) {
				$gids[$k]	=	(string) $v;
			}

			$this->gids		=	$gids;
			$this->gid		=	(int) $_CB_framework->acl->getBackwardsCompatibleGid( $this->gids );
		} else {
			$this->gids		=	array( $this->gid );
			if ( ( checkJversion() == 0 ) && ( checkJversion( 'dev_level' ) < 11 ) ) {
				// revert effect of _cbMakeHtmlSafe on user save in older joomla/mambo versions:
				$this->name	=	cbUnHtmlspecialchars( $this->name );
			}
		}
	}
	/**
	 * Loads a list of moscomprofilerUser into an existing array if they are not already in it
	 * (indexed by key of this table)
	 * @since 1.4 (experimental)
	 *
	 * @param  array    $usersIds      array of id to load
	 * @param  array    $objectsArray  IN/OUT   (int) id => $class  (e.g. moscomprofilerUser) with method bindThisUserFromDbArray
	 * @param  string   $class
	 */
	function loadUsersMatchingIdIntoList( $usersIds, &$objectsArray, $class ) {
		// avoids re-loading already loaded ids:
		$usersIds			=	array_diff( $usersIds, array_keys( $objectsArray ) );

		$idsCount			=	count( $usersIds );
		if ( $idsCount > 0 ) {

			// in case the left join is null, the second loaded u.id will be NULL and override id:
			$query			=	'SELECT *, u.' . $this->_cmsUserTableKey
			. "\n FROM " . $this->_cmsUserTable . ' AS u'
			. "\n LEFT JOIN " . $this->_tbl . ' AS c ON c.' . $this->_tbl_key . ' = u.' . $this->_cmsUserTableKey
			. " WHERE u." . $this->_cmsUserTableKey . ( $idsCount == 1 ? ' = ' . (int) end( $usersIds ) : ' IN (' . implode( ',', cbArrayToInts( $usersIds ) ) . ')' );
			$this->_db->setQuery( $query );
			$resultsArray = $this->_db->loadAssocList( $this->_cmsUserTableKey );

			if ( is_array($resultsArray) ) {
				foreach ( $resultsArray as $k => $value ) {
					$objectsArray[(int) $k]	=	new $class( $this->_db );			// self (CBUser has method below too)
					$objectsArray[(int) $k]->bindThisUserFromDbArray( $value );
				}
			}
			unset( $resultsArray );
		}
	}
	/**
	*	Loads user username from database
	*
	*	@param  string   $username
	*	@return boolean    TRUE: success, FALSE: error in database access
	*/
	function loadByUsername( $username ) {
		return $this->_loadBy_field( $username, $this->_cmsUserTableUsername );
	}
	/**
	*	Loads user username from database
	*
	*	@param  string   $username
	*	@return boolean    TRUE: success, FALSE: error in database access
	*/
	function loadByEmail( $username ) {
		return $this->_loadBy_field( $username, $this->_cmsUserTableEmail );
	}
	/**
	*	Loads first user from database according to a given field
	*	@access private
	*
	*	@param  string   $fieldValue
	*	@param  string   $fieldName   Name of database field
	*	@return boolean    TRUE: success, FALSE: error in database access
	*/
	function _loadBy_field( $fieldValue, $fieldName ) {
		if ( $fieldValue == null ) {
			return false;
		}
		//BB fix : resets default values to all object variables, because NULL SQL fields do not overide existing variables !
		//Note: Prior to PHP 4.2.0, Uninitialized class variables will not be reported by get_class_vars().
		$class_vars				=	get_class_vars(get_class($this));
		foreach ($class_vars as $name => $value) {
			if ( ($name != $this->_tbl_key) and ($name != "_db") and ($name != "_tbl") and ($name != "_tbl_key") ) {
				$this->$name	=	$value;
			}
		}
		$this->reset();
		//end of BB fix.
		$query					=	'SELECT c.*, u.*'			// let u.id override c.id in case comprofiler entry is missing
		. "\n FROM " . $this->_cmsUserTable . ' AS u'
		. "\n LEFT JOIN " . $this->_tbl . ' AS c ON c.' . $this->_tbl_key . ' = u.' . $this->_cmsUserTableKey
		. " WHERE u." . $this->_db->NameQuote( $fieldName ) . ' = ' . $this->_db->Quote( $fieldValue )
		;
		$this->_db->setQuery( $query, 0, 1 );

		$arr					=	$this->_db->loadAssoc( );

		if ( $arr ) {
			foreach ( $arr as $k => $v ) {
				$this->$k		=	$v;
			}
			if ( checkJversion() == 2 ) {
				global $_CB_framework;

				$gids			=	array_values( (array) JFactory::getAcl()->getGroupsByUser( $this->id, false ) );

				foreach ( $gids as $k => $v ) {
					$gids[$k]	=	(string) $v;
				}

				$this->gids		=	$gids;
				$this->gid		=	(int) $_CB_framework->acl->getBackwardsCompatibleGid( $this->gids );
			} else {
				$this->gids		=	array( $this->gid );
			}
			return true;
		} else {
			return false;
		}
	}
	function bindSafely( &$array, $ui, $reason, &$oldUserComplete ) {
		global $_CB_framework, $ueConfig, $_PLUGINS;

		// Some basic sanitizations and securitizations: usertype will be re-computed based on gid in store()

		$this->id						=	(int) $this->id;

		if ( checkJversion() == 2 ) {
			$this->gids					=	( is_array( $this->gids ) ? $this->gids : array( $this->gid ) );
			$this->gid					=	(int) $_CB_framework->acl->getBackwardsCompatibleGid( $this->gids );
		} else {
			$this->gid					=	(int) $this->gid;
			$this->gids					=	array( $this->gid );
		}

		if ( ! $this->gid ) {
			$this->gid					=	null;
		}
		if ( $ui == 1 ) {
			if ( $this->id ) {
				// Front-end edit user: no changes in gid/usertype and confirmed/approved states
				$this->gid				=	(int) $oldUserComplete->gid;
				$this->gids				=	$oldUserComplete->gids;
				$this->usertype			=	$oldUserComplete->usertype;
				$this->block			=	(int) $oldUserComplete->block;
				$this->sendEmail		=	(int) $oldUserComplete->sendEmail;
				$this->confirmed		=	(int) $oldUserComplete->confirmed;
				$this->approved			=	(int) $oldUserComplete->approved;
			} else {
				// Front-end user registration: handle this here, so it is available to all plugins:
				$this->usertype			=	$_CB_framework->getCfg( 'new_usertype' );
				$this->gid				=	(int) $_CB_framework->acl->get_group_id( $this->usertype, 'ARO' );
				$this->gids				=	array( $this->gid );

				if ( $ueConfig['reg_admin_approval'] == 0) {
					$this->approved		=	1;
				} else {
					$this->approved		=	0;
					$this->block		=	1;
				}
				if ( $ueConfig['reg_confirmation'] == 0 ) {
					$this->confirmed	=	1;
				} else {
					$this->confirmed	=	0;
					$this->block		=	1;
				}
				if ( ( $this->confirmed == 1 ) && ( $this->approved == 1 ) ) {
					$this->block		=	0;
				} else {
					$this->block		=	1;
				}
				$this->sendEmail		=	0;

			}
			// Nb.: Backend user edit and new user are handled in core plugin CBfield_userparams field handler class
		}

		// By default, don't touch the hashed password, unless a new password is set by the saveTabsContents binding:
		$this->password					=	null;

		$this->_original_email			=	$this->email;						// needed for checkSafely()

		// Process the fields in form by CB field plugins:

		$_PLUGINS->loadPluginGroup('user');

		$this->_cbTabs					=	new cbTabs( 0, $ui, null, false );
		$this->_cbTabs->saveTabsContents( $this, $array, $reason );
		$errors							=	$_PLUGINS->getErrorMSG( false );
		if ( count( $errors ) > 0 ) {
			$this->_error				=	$errors;
			return false;
		}

		// Now do CMS-specific stuff, specially bugs-workarounds:

		$postCopy						=	array();
		if ( $ui == 1 ) {
			$vars						=	$this->_frontendNonComprofilerVars;
		} else {
			$vars						=	$this->_nonComprofilerVars;
		}
		foreach ( $vars as $k ) {
			if ( isset( $this->$k ) ) {
				$postCopy[$k]			=	$this->$k;
			}
		}
		if ( isset( $postCopy['password'] ) ) {
			$postCopy['verifyPass']		=	$postCopy['password'];			// Mambo and Joomla 1.0 has it in password2 and checks it in bind() !
			$postCopy['password2']		=	$postCopy['password'];			// Joomla 1.5 has it in password2 and checks it in bind() !
		}

		$this->_mapUsers();
		$row							=&	$this->_cmsUser;

		$pwd							=	$this->password;						// maybe cleartext at that stage.
		if ( $pwd == '' ) {
			$pwd						=	null;									// empty: don't update/change
			$this->password				=	null;
		}

		$rowBindResult					=	$row->bind( $postCopy );				// in Joomla 1.5, this modifies $postCopy and hashes password !
		if ( ! $rowBindResult ) {
			if ( checkJversion() == 1 ) {
				$this->_error			=	$row->getErrors();
				foreach ( array_keys( $this->_error ) as $ek ) {
					$this->_error[$ek]	=	stripslashes( $this->_error[$ek] );
				}
			} else {
				$this->_error			=	array( stripslashes( $row->getError() ) );
			}
			return false;
		}


		// Finally, emulate a pre-joomla 1.0.11 bug where jos_users was wtih htmlspecialchars ! :
		if ( checkJversion() == 0 ) {
			if ( checkJversion( 'dev_level' ) < 11 ) {
				_cbMakeHtmlSafe($row);
			}
		}
		$row->password					=	$pwd;		// J1.0: no htmlspecialchars on password, J1.5: restore cleartext password at this stage.
		return true;
	}

	function checkSafely() {
		global $_CB_framework;

		if ( $this->_cmsUser === null ) {
			$this->_mapUsers();
		}
		$row							=&	$this->_cmsUser;

		if ( is_callable( array( $row, 'check' ) ) ) {

			// fix a joomla 1.0 bug preventing from saving profile without changing email if site switched from uniqueemails = 0 to = 1 and duplicates existed
			$original_uniqueemail		=	$_CB_framework->getCfg( 'uniquemail' );
			if ( $_CB_framework->getCfg( 'uniquemail' ) && ( $row->email == $this->_original_email ) ) {
				global $mosConfig_uniquemail;	// this is voluntarily a MAMBO/JOOMLA 1.0 GLOBAL TO FIX A BUG
				$mosConfig_uniquemail	=	0;	// this is voluntarily a MAMBO/JOOMLA 1.0 GLOBAL TO FIX A BUG
			}

			$rowCheckResult				=	$row->check();

			if ( $original_uniqueemail && ( $row->email == $this->_original_email ) ) {
				$mosConfig_uniquemail	=	$original_uniqueemail;	// this is voluntarily a MAMBO/JOOMLA 1.0 GLOBAL TO FIX A BUG
			}

			if ( ! $rowCheckResult ) {
				$this->_error			=	( checkJversion() == 1 ? stripslashes( implode( '<br />', $row->getErrors() ) ) : stripslashes( $row->getError() ) );
				return false;
			}
		}
		return true;
	}
	/**
	* If table key (id) is NULL : inserts new rows
	* otherwise updates existing row in the database tables
	*
	* Can be overridden or overloaded by the child classes
	*
	* @param  boolean  $updateNulls  TRUE: null object variables are also updated, FALSE: not.
	* @return boolean                TRUE if successful otherwise FALSE
	*/
	function store( $updateNulls = false ) {
		global $_CB_framework, $_CB_database, $ueConfig;

		$this->id									=	(int) $this->id;

		if ( checkJversion() == 2 ) {
			$this->gids								=	( is_array( $this->gids ) ? $this->gids : array( $this->gid ) );
			$this->gid								=	(int) $_CB_framework->acl->getBackwardsCompatibleGid( $this->gids );
		} else {
			$this->gid								=	(int) $this->gid;
			$this->gids								=	array( $this->gid );
		}

		$isNew										=	( $this->id == 0 );

		$oldUsername								=	null;
		$oldGid										=	null;
		$oldGids									=	array();
		$oldBlock									=	null;

		if ( ! $isNew ) {
			// get actual username to update sessions in case:
			$sql			=	'SELECT ' . $_CB_database->NameQuote( $this->_cmsUserTableUsername )
							.	( checkJversion() < 2 ? ', ' . $_CB_database->NameQuote( $this->_cmsUserTableGid ) : null )
							.	', '	. $_CB_database->NameQuote( 'block' )
							.	' FROM ' . $_CB_database->NameQuote( $this->_cmsUserTable ) . ' WHERE ' . $_CB_database->NameQuote( $this->_cmsUserTableKey ) . ' = ' . (int) $this->user_id;
			$_CB_database->setQuery( $sql );
			$oldEntry								=	null;
			if ( $_CB_database->loadObject( $oldEntry ) ) {
				$oldUsername						=	$oldEntry->username;
				if ( checkJversion() == 2 ) {
					$gids							=	array_values( (array) JFactory::getAcl()->getGroupsByUser( $this->id, false ) );

					foreach ( $gids as $k => $v ) {
						$gids[$k]					=	(string) $v;
					}

					$oldGids						=	$gids;
					$oldGid							=	(int) $_CB_framework->acl->getBackwardsCompatibleGid( $oldGids );
				} else {
					$oldGid							=	(int) $oldEntry->gid;
					$oldGids						=	array( $oldEntry->gid );
				}
				$oldBlock							=	$oldEntry->block;
			}
		}

		// insure usertype is in sync with gid:
/*
 * This could be a better method:
		if ( checkJversion() == 1 ) {
			$gdataArray								=	$_CB_framework->acl->get_group_data( (int) $this->gid, 'ARO' );
			if ( $gdataArray ) {
				$this->usertype						=	$gdataArray[3];
			} else {
				user_error( sprintf( 'comprofilerUser::store: gacl:get_group_data: for user_id %d, name of group_id %d not found in acl groups table.', $this->id, $this->gid ), E_USER_WARNING );
				$this->usertype						=	'Registered';
			}
		} else {
			$this->usertype							=	$_CB_framework->acl->get_group_name( (int) $gid, 'ARO' );
		}
*/
		if ( checkJversion() == 2 ) {
			$this->usertype							=	null;
		} else {
			if ( checkJversion() == 1 ) {
				$query								= 'SELECT name'
													. "\n FROM #__core_acl_aro_groups"
													. "\n WHERE id = " . (int) $this->gid
													;
			} else {
				$query								= 'SELECT name'
													. "\n FROM #__core_acl_aro_groups"
													. "\n WHERE group_id = " . (int) $this->gid
													;
			}
			$_CB_database->setQuery( $query );
			$this->usertype							=	$_CB_database->loadResult();
		}

		if ( ( ! $isNew ) && ( $this->confirmed == 0 ) && ( $this->cbactivation == '' ) && ( $ueConfig['reg_confirmation'] != 0 ) ) {
			$this->_setActivationCode();
		}

		// creates CMS and CB objects:
		$this->_mapUsers();

		// remove the previous email set in bindSafely() and needed for checkSafely():
		unset( $this->_original_email );

		// stores first into CMS to get id of user if new:
		if ( is_callable( array( $this->_cmsUser, 'store' ) ) ) {
			$result									=	$this->_cmsUser->store( $updateNulls );
			if ( ! $result ) {
				$this->_error						=	$this->_cmsUser->getError();
			}
		} else {
			if ( checkJversion() == 2 ) {
				$this->_cmsUser->groups				=	$this->gids;
				}
			$result									=	$this->_cmsUser->save();	// Joomla 1.5 native
			if ( ! $result ) {
				$this->_error						=	$this->_cmsUser->getError();
				if ( class_exists( 'JText' ) ) {
					$this->_error					=	JText::_( $this->_error );
				}
			}
		}
		if ( $result ) {
			// synchronize id and user_id:
			if ( $isNew ) {
				if ( $this->_cmsUser->id == 0 ) {
					// this is only for mambo 4.5.0 backwards compatibility. 4.5.2.3 $row->store() updates id on insert
					$sql			=	'SELECT ' . $_CB_database->NameQuote( $this->_cmsUserTableKey ) . ' FROM ' . $_CB_database->NameQuote( $this->_cmsUserTable ) . ' WHERE ' . $_CB_database->NameQuote( $this->_cmsUserTableUsername ) . ' = ' . $_CB_database->Quote( $this->username);
					$_CB_database->setQuery( $sql );
					$this->_cmsUser->id				=	(int) $_CB_database->loadResult();
				}
				$this->id							=	$this->_cmsUser->id;
				$this->_comprofilerUser->id		=	$this->_cmsUser->id;

				if ( ( $this->confirmed == 0 ) && ( $this->cbactivation == '' ) && ( $ueConfig['reg_confirmation'] != 0 ) ) {
					$this->_setActivationCode();
				}
			}

			// stores CB user into comprofiler: if new, inserts, otherwise updates:
			if ( $this->user_id == 0 ) {
				$this->user_id						=	$this->_cmsUser->id;
				$this->_comprofilerUser->user_id	=	$this->user_id;
				$result								=	$this->_comprofilerUser->storeNew( $updateNulls );
			} else {
				$result								=	$this->_comprofilerUser->store( $updateNulls );
			}
			if ( ! $result ) {
				$this->_error						=	$this->_comprofilerUser->getError();
			}
		}
		if ( $result ) {
			// update the ACL:
			if ( checkJversion() == 2 ) {
				$query							=	'SELECT m.id AS aro_id, a.group_id FROM #__user_usergroup_map AS a'
												.	"\n INNER JOIN #__usergroups AS m ON m.id= a.group_id"
												.	"\n WHERE a.user_id = " . (int) $this->id
												;
			} elseif ( checkJversion() == 1 ) {
				$query							=	'SELECT a.id AS aro_id, m.group_id FROM #__core_acl_aro AS a'
												.	"\n INNER JOIN #__core_acl_groups_aro_map AS m ON m.aro_id = a.id"
												.	"\n WHERE a.value = " . $_CB_database->Quote( (int) $this->id )
												;
			} else {
				$query							=	'SELECT a.aro_id, m.group_id FROM #__core_acl_aro AS a'
												.	"\n INNER JOIN #__core_acl_groups_aro_map AS m ON m.aro_id = a.aro_id"
												.	"\n WHERE a.value = " . $_CB_database->Quote( (int) $this->id )
												;
			}
			$_CB_database->setQuery( $query );
			$aro_group							=	null;
			$result								=	$_CB_database->loadObject( $aro_group );

			if ( $result && ( $aro_group->group_id != $this->gid ) ) {
				if ( checkJversion() == 2 ) {
//					$query							=	'UPDATE #__user_usergroup_map'
//													.	"\n SET group_id = " . (int) $this->gid
//													.	"\n WHERE user_id = " . (int) $this->id
//													.	( $oldGid ? "\n AND group_id = " . (int) $oldGid : null )
//													;
//					$_CB_database->setQuery( $query );
//					$result							=	$_CB_database->query();
				} else {
					$query							=	'UPDATE #__core_acl_groups_aro_map'
													.	"\n SET group_id = " . (int) $this->gid
													.	"\n WHERE aro_id = " . (int) $aro_group->aro_id
													;
					$_CB_database->setQuery( $query );
					$result							=	$_CB_database->query();
				}
			}
			if ( $result && ( ! $isNew ) && ( ( $oldUsername != $this->username ) || ( $aro_group->group_id != $this->gid ) || ( $oldGid != $this->gid ) || self::_ArraysEquivalent( $oldGids, $this->gids ) || ( ( $oldBlock == 0 ) && ( $this->block == 1 ) ) ) ) {
				// Update current sessions state if there is a change in gid or in username:
				if ( $this->block == 0 ) {
					$sessionGid			=	1;
					if ( $_CB_framework->acl->is_group_child_of( $this->usertype, 'Registered', 'ARO' ) || $_CB_framework->acl->is_group_child_of( $this->usertype, 'Public Backend', 'ARO' ) ) {
						// Authors, Editors, Publishers and Super Administrators are part of the Special Group:
						$sessionGid		=	2;
					}
					$query				=	'UPDATE #__session '
										.	"\n SET username = " . $_CB_database->Quote( $this->username );

					if ( checkJversion() < 2 ) {
						$query			.=	', usertype = ' . $_CB_database->Quote( $this->usertype );
					}

					if ( checkJversion() <= 1 ) {
						$query			.=	', gid = ' . (int) $sessionGid;
					}

					$query				.=	"\n WHERE userid = " . (int) $this->id;
					//TBD: here maybe jaclplus fields update if JACLplus installed....
					$_CB_database->setQuery( $query );
					$result				=	$_CB_database->query();

					if ( checkJversion() >= 2 ) {
						// This is needed for instant adding of groups to logged-in user (fixing bug #3581):
						$session					=	JFactory::getSession();
						$jUser						=	$session->get( 'user' );

						if ( $jUser->id == $this->id ) {
							JAccess::clearStatics();
							$session->set( 'user', new JUser( (int) $this->id ) );
						}
					}
				} else {
					// logout user now that user login has been blocked:
					if ( $_CB_framework->myId() == $this->id ) {
						$_CB_framework->logout();
					}
					$_CB_database->setQuery( "DELETE FROM #__session WHERE userid = " . (int) $this->id );			//TBD: check if this is enough for J 1.5
					$result				=	$_CB_database->query();
				}
			}
			if ( ! $result ) {
				$this->_error					=	$_CB_database->stderr();
				return false;
			}
		}
		return $result;
	}
	/**
	 * Are all of the int values of array $a1 in array $a2 and the other way around too (means arrays contain same integer values) ?
	 *
	 * @param  array    $a1
	 * @param  array    $a2
	 * @return boolean
	 */
	protected static function _ArraysEquivalent( $a1, $a2 ) {
		cbArrayToInts( $a1 );
		cbArrayToInts( $a2 );
		return self::_allValuesOfArrayInArray( $a1, $a2 ) && self::_allValuesOfArrayInArray( $a2, $a1 );
	}
	/**
	 * Are all of the values of array $a1 in array $a2 ?
	 *
	 * @param  array    $a1
	 * @param  array    $a2
	 * @return boolean
	 */
	protected static function _allValuesOfArrayInArray( $a1, $a2 ) {
		foreach ( $a1  as $v ) {
			if ( ! in_array( $v, $a2 ) ) {
				return false;
			}
		}
		return true;
	}

	function storeDatabaseValue( $name, $value, $triggers = true ) {
		global $_CB_framework, $_PLUGINS;

		if ( $this->id && ( isset( $this->$name ) ) ) {
			$ui								=	$_CB_framework->getUi();

			$user							=	new moscomprofilerUser( $this->_db );
			$oldUserComplete				=	new moscomprofilerUser( $this->_db );
			foreach ( array_keys( get_object_vars( $this ) ) as $k ) {
				if ( substr( $k, 0, 1 ) != '_' ) {
					$user->$k				=	$this->$k;
					$oldUserComplete->$k	=	$this->$k;
				}
			}

			if ( $name != 'password' ) {
				$user->password				=	null;
			}

			// In case of Password, save cleartext value for the onAfter event:
			$currentvalue					=	$user->$name;

			if ( $triggers ) {
				if ( $ui == 1 ) {
					$_PLUGINS->trigger( 'onBeforeUserUpdate', array( &$user, &$user, &$oldUserComplete, &$oldUserComplete ) );
				} elseif ( $ui == 2 ) {
					$_PLUGINS->trigger( 'onBeforeUpdateUser', array( &$user, &$user, &$oldUserComplete ) );
				}
			}

			// In case of Password, hashed value:
			$user->$name					=	$value;

			$return							=	$user->store();

			if ( $name == 'password' ) {
				// In case of Password, cleartext value for the onAfter event:
				$user->$name				=	$currentvalue;
			}

			if ( $triggers ) {
				if ( $return ) {
					if ( $ui == 1 ) {
						$_PLUGINS->trigger( 'onAfterUserUpdate', array( &$user, &$user, $oldUserComplete ) );
					} elseif ( $ui == 2 ) {
						$_PLUGINS->trigger( 'onAfterUpdateUser', array( &$user, &$user, $oldUserComplete ) );
					}
				}
			}

			// Check if error is present in temporary user object:
			$error							=	$user->getError();
			if ( $error ) {
				// Pass error to current user object so can be output properly:
				$this->_error				=	$error;
			}

			unset( $user, $oldUserComplete );
			return $return;
		}

		return false;
	}
	/**
	 * Updates only in database $this->block
	 *
	 * @return boolean   Store query error
	 */
	function storeBlock( $triggers = true ) {
		if ( $this->id ) {
			return $this->storeDatabaseValue( 'block', (int) $this->block, $triggers );
		}
		return false;
	}
	/**
	 * Updates only in database the cleartext $this->password
	 *
	 * @return boolean   Store query error
	 */
	function storePassword( $triggers = true ) {
		if ( $this->id ) {
			return $this->storeDatabaseValue( 'password', $this->hashAndSaltPassword( $this->password ), $triggers );
		}
		return false;
	}
	/**
	 * Updates only in database $this->approved
	 *
	 * @return boolean   Store query error
	 */
	function storeApproved( $triggers = true ) {
		if ( $this->id ) {
			return $this->storeDatabaseValue( 'approved', (int) $this->approved, $triggers );
		}
		return false;
	}
	/**
	 * Updates only in database $this->approved
	 *
	 * @return boolean   Store query error
	 */
	function storeConfirmed( $triggers = true ) {
		if ( $this->id ) {
			return $this->storeDatabaseValue( 'confirmed', (int) $this->confirmed, $triggers );
		}
		return false;
	}
	/**
	 * Saves a new or existing CB+CMS user
	 * WARNINGS:
	 * - You must verify authorization of user to perform this (user checkCBpermissions() )
	 * - You must $this->load() existing user first
	 *
	 * @param  array   $array   Raw unfiltered input, typically $_POST
	 * @param  int     $ui      1 = Front-end (limitted rights), 2 = Backend (almost unlimitted), 0 = automated (full)
	 * @param  string  $reason  'edit' or 'register'
	 * @return boolean
	 */
	function saveSafely( &$array, $ui, $reason ) {
		global $_CB_framework, $_CB_database, $ueConfig, $_PLUGINS;

		// Get current user state and store it into $oldUserComplete:

		$oldUserComplete						=	new moscomprofilerUser( $this->_db );
		foreach ( array_keys( get_object_vars( $this ) ) as $k ) {
			if( substr( $k, 0, 1 ) != '_' ) {		// ignore internal vars
				$oldUserComplete->$k			=	$this->$k;
			}
		}
		if ( $oldUserComplete->gids === null ) {
			$oldUserComplete->gids				=	array();
		}


		// 1) Process and validate the fields in form by CB field plugins:
		// 2) Bind the fields to CMS User:
		$bindResults							=	$this->bindSafely( $array, $ui, $reason, $oldUserComplete );

		if ( $bindResults ) {
			// During bindSafely, in saveTabContents, the validations have already taken place, for mandatory fields.
			if ( ( $this->name == '' ) && ( $this->username == '' ) && ( $this->email != '' ) ) {
				$this->username						=	$this->email;
				$this->_cmsUser->username			=	$this->username;
			}
			// Checks that name is set. If not, uses the username as name, as Mambo/Joola mosUser::store() uses name for ACL
			// and ACL bugs with no name.
			if ( $this->name == '' ) {
				$this->name							=	$this->username;
				$this->_cmsUser->name				=	$this->name;
			} elseif ( $this->username == '' ) {
				$this->username						=	$this->name;
				$this->_cmsUser->username			=	$this->username;
			}

			if ( ! $this->checkSafely() ) {
				$bindResults					=	false;
			}
		}

		// For new registrations or backend user creations, set registration date and password if neeeded:
		$isNew									=	( ! $this->id );
		$newCBuser								=	( $oldUserComplete->user_id == null );

		if ( $isNew ) {
			if ( checkJversion() != 1 ) {
				// J1.5 works better with null here... has bug that it offsets the time by server date, others need this:
				$this->registerDate				=	$_CB_framework->dateDbOfNow();
			}
		}

		if ( $bindResults ) {
			if ( $isNew ) {
				if ( $this->password == null ) {
					$this->setRandomPassword();
					$ueConfig['emailpass']		=	1;		// set this global to 1 to force password to be sent to new users.
				}
			}

			// In backend only: if group has been changed and where original group was a Super Admin: check if there is at least a super-admin left:
			if ( $ui == 2 ) {
				$myGids							=	$_CB_framework->acl->get_groups_below_me( null, true );
				$cms_admin						=	$_CB_framework->acl->mapGroupNamesToValues( 'Administrator' );
				$cms_super_admin				=	$_CB_framework->acl->mapGroupNamesToValues( 'Superadministrator' );
				$i_am_super_admin				=	$_CB_framework->acl->amIaSuperAdmin();
				$i_am_admin						=	in_array( $cms_admin, $myGids );

				if ( ! $isNew ) {
					if ( checkJversion() == 2 ) {

						if ( $i_am_super_admin && ( $_CB_framework->myId() == $this->id ) ) {
							// Check that a fool Super User does not block himself:
							if ( $this->block && ! $oldUserComplete->block ) {
								$this->_error	=	'Super Users can not block themselves';
								return false;
							}
							// Check that a fool Super User does not demote himself from Super-User rights:
							if ( $this->gids != $oldUserComplete->gids ) {
								$staysSuperUser		=	$_CB_framework->acl->authorizeGroupsForAction( $this->gids,'core.admin', null );
								if ( ! $staysSuperUser ) {
									$this->_error	=	'You cannot demote yourself from your Super User permission';
									return false;
								}
							}
						}
						// Check that a non-Super User/non-admin does not demote an admin or a Super user:
						if ( $this->gids != $oldUserComplete->gids ) {
							if ( ( ! $i_am_super_admin ) && ! ( CBuser::getMyInstance()->authoriseAction( 'core.admin' ) || ( CBuser::getMyInstance()->authoriseAction( 'core.manage', 'com_users' ) && CBuser::getMyInstance()->authoriseAction( 'core.edit', 'com_users' )  && CBuser::getMyInstance()->authoriseAction( 'core.edit.state', 'com_users' ) ) ) ) {
								// I am not a Super User and not an Users administrator:
								$userIsSuperUser	=	JUser::getInstance( $this->id )->authorise( 'core.admin' );
								// User is super-user: Check if he stays so:
								if ( $userIsSuperUser ) {
									$staysSuperUser		=	$_CB_framework->acl->authorizeGroupsForAction( $this->gids, 'core.admin', null );
									if ( ! $staysSuperUser ) {
										$this->_error	=	'You cannot remove a Super User permission. Only Super Users can do that.';
										return false;
									}
								}
								$userCanAdminUsers	=	( CBuser::getInstance( $this->id )->authoriseAction( 'core.manage', 'com_users' ) || CBuser::getInstance( $this->id )->authoriseAction( 'core.manage' ) )
														&& CBuser::getInstance( $this->id )->authoriseAction( 'core.edit', 'com_users' )
														&& CBuser::getInstance( $this->id )->authoriseAction( 'core.edit.state', 'com_users' );
								// User is users-administrator: check if he can stay so:
								if ( $userCanAdminUsers ) {
									$staysUserAdmin	=	( $_CB_framework->acl->authorizeGroupsForAction( $this->gids, 'core.manage', 'com_users' ) || $_CB_framework->acl->authorizeGroupsForAction( $this->gids, 'core.manage' ) ) 
														&& $_CB_framework->acl->authorizeGroupsForAction( $this->gids, 'core.edit', 'com_users' )
														&& $_CB_framework->acl->authorizeGroupsForAction( $this->gids, 'core.edit.state', 'com_users' );
									if ( ! $staysUserAdmin ) {
										$this->_error	=	'An users manager cannot be demoted by a non-administrator';
										return false;
									}
								}
							}
						}

					} else {

						if ( $this->gid != $oldUserComplete->gid ) {
							if ( $oldUserComplete->gid == $cms_super_admin ) {
								// count number of active super admins
								$query				=	'SELECT COUNT( id )'
													.	"\n FROM #__users"
													.	"\n WHERE gid = " . (int) $cms_super_admin
													.	"\n AND block = 0"
													;
								$_CB_database->setQuery( $query );
								$count				=	$_CB_database->loadResult();
	
								if ( $count <= 1 ) {
									// disallow change if only one Super Admin exists
									$this->_error	=	'You cannot change this users Group as it is the only active Super Administrator for your site';
									return false;
								}
							}
	
							$user_group				=	strtolower( $_CB_framework->acl->get_group_name( $oldUserComplete->gid, 'ARO' ) );
	
							if ( ( $user_group == 'super administrator' && ! $i_am_super_admin ) ) {
								// disallow change of super-Admin by non-super admin
								$this->_error		=	'You cannot change this users Group as you are not a Super Administrator for your site';
								return false;
							} elseif ( $this->id == $_CB_framework->myId() && $i_am_super_admin ) {
								// CB-specific: disallow change of own Super Admin group:
								$this->_error		=	'You cannot change your own Super Administrator status for your site';
								return false;
							} else if ( ( ! $i_am_super_admin ) && $i_am_admin && ( $oldUserComplete->gid == $cms_admin ) ) {
								// disallow change of super-Admin by non-super admin
								$this->_error		=	'You cannot change the Group of another Administrator as you are not a Super Administrator for your site';
								return false;
							} elseif ( in_array( $oldUserComplete->gid, $myGids ) && ! in_array( $this->gid, $myGids ) ) {
								// disallow change of group of user into a group that is not child of admin/superadmin:
								$this->_error		=	'You cannot change the Group of this user to a group that is not child of Registered or Manager as otherwise that user cannot login. If you really need to do that, you can do it in Joomla User Manager.';
								return false;
							}
						}
						// ensure user can't add group higher than themselves done below
					}

				}
				// Security check to avoid creating/editing user to higher level than himself: CB response to artf4529.
				if ( ( ! $i_am_super_admin ) && ( $this->gids != $oldUserComplete->gids ) ) {
					// Does user try to edit a user that has higher groups ?
					if ( count( array_diff( $this->gids, $myGids ) ) != 0 ) {
						$this->_error				=	'Unauthorized attempt to change an user at higher level than allowed !';
						return false;
					}
					// Does the user try to demote higher levels ?
					if ( array_diff( $this->gids, $myGids ) != array_diff( $oldUserComplete->gids, $myGids ) ) {
						$this->_error				=	'Unauthorized attempt to change higher groups of an user than allowed !';
						return false;
					}
				}
			}

		}

		if ( $reason == 'edit' ) {
			if ( $ui == 1 ) {
				$_PLUGINS->trigger( 'onBeforeUserUpdate', array( &$this, &$this, &$oldUserComplete, &$oldUserComplete ) );
			} elseif ( $ui == 2 ) {
				if ( $isNew || $newCBuser ) {
					$_PLUGINS->trigger( 'onBeforeNewUser', array( &$this, &$this, false ) );
				} else {
					$_PLUGINS->trigger( 'onBeforeUpdateUser', array( &$this, &$this, &$oldUserComplete ) );
				}
			}
		} elseif ( $reason == 'register' ) {
			$_PLUGINS->trigger( 'onBeforeUserRegistration', array( &$this, &$this ) );
		}
		$beforeResult							=	! $_PLUGINS->is_errors();
		if ( ! $beforeResult ) {
			$this->_error						=	$_PLUGINS->getErrorMSG( false );			// $_PLUGIN collects all error messages, incl. previous ones.
		}

		// Saves tab plugins:

		// on edits, user params and block/email/approved/confirmed are done in cb.core predefined fields.
		// So now calls this and more (CBtabs are already created in $this->bindSafely() ).
		$pluginTabsResult						=	true;
		if ( $reason == 'edit' ) {
			$this->_cbTabs->savePluginTabs( $this, $array );
			$pluginTabsResult					=	! $_PLUGINS->is_errors();
			if ( ! $pluginTabsResult ) {
				$this->_error					=	$_PLUGINS->getErrorMSG( false );			// $_PLUGIN collects all error messages, incl. previous ones.
			}
		}

		if ( $bindResults && $beforeResult && $pluginTabsResult ) {
			// Hashes password for CMS storage:

			$clearTextPassword					=	$this->password;
			if ( $clearTextPassword ) {
				$hashedPassword					=	$this->hashAndSaltPassword( $clearTextPassword );
				$this->password					=	$hashedPassword;
			}

			// Stores user if it's a new user:

			if ( $isNew ) {
				if ( ! $this->store() ) {
					return false;
				}
			}

			// Restores cleartext password for the saveRegistrationPluginTabs:

			$this->password						=	$clearTextPassword;

			if ( $isNew ) {
				// Sets the instance of user, to avoid reload from database, and loss of the cleartext password.
				CBuser::setUserGetCBUserInstance( $this );
			}
		}

		if ( $reason == 'register' ) {
			// call here since we got to have a user id:
			$registerResults					=	array();
			$registerResults['tabs']			=	$this->_cbTabs->saveRegistrationPluginTabs( $this, $array );
			if ( $_PLUGINS->is_errors() ) {

				if ( $bindResults && $beforeResult && $pluginTabsResult ) {
					$plugins_error				=	$_PLUGINS->getErrorMSG( false );			// $_PLUGIN collects all error messages, incl. previous ones.
					if ( $isNew ) {
						// if it was a new user, and plugin gave error, revert the creation:
						$this->delete();
					}
					$this->_error				=	$plugins_error;
				} else {
					$this->_error				=	$_PLUGINS->getErrorMSG( false );			// $_PLUGIN collects all error messages, incl. previous ones.
				}
				$pluginTabsResult				=	false;
			}
		}

		if ( $bindResults && $beforeResult && $pluginTabsResult ) {
			$this->_cbTabs->commitTabsContents( $this, $array, $reason );
			$commit_errors						=	$_PLUGINS->getErrorMSG( false );

			if ( count( $commit_errors ) > 0 ) {
				$this->_error					=	$commit_errors;
				$bindResults					=	false;
			}
		}

		if ( ! ( $bindResults && $beforeResult && $pluginTabsResult ) ) {
			$this->_cbTabs->rollbackTabsContents( $this, $array, $reason );
			// Normal error exit point:
			$_PLUGINS->trigger( 'onSaveUserError', array( &$this, $this->_error, $reason ) );
			if ( is_array( $this->_error ) ) {
				$this->_error						=	implode( '<br />', $this->_error );
			}
			return false;
		}

		// Stores the user (again if it's a new as the plugins might have changed the user record):
		if ( $clearTextPassword ) {
			$this->password						=	$hashedPassword;
		}
		if ( ! $this->store() ) {
			return false;
		}

		// Restores cleartext password for the onAfter and activation events:

		$this->password							=	$clearTextPassword;

		// Triggers onAfter and activateUser events:

		if ( $reason == 'edit' ) {
			if ( $ui == 1 ) {
				$_PLUGINS->trigger( 'onAfterUserUpdate', array( &$this, &$this, $oldUserComplete ) );
			} elseif ( $ui == 2 ) {
				if ( $isNew || $newCBuser ) {
					if ( $isNew ) {
						$ueConfig['emailpass']	=	1;		// set this global to 1 to force password to be sent to new users.
					}
					$_PLUGINS->trigger( 'onAfterNewUser', array( &$this, &$this, false, true ) );
					if ( $this->block == 0 && $this->approved == 1 && $this->confirmed ) {
						activateUser( $this, 2, 'NewUser', false, $isNew );
					}
				} else {
					if ( ( ! ( ( $oldUserComplete->approved == 1 || $oldUserComplete->approved == 2 ) && $oldUserComplete->confirmed ) )
						 && ($this->approved == 1 && $this->confirmed ) )
					{
						// first time a just registered and confirmed user got approved in backend through save user:
						if( isset( $ueConfig['emailpass'] ) && ( $ueConfig['emailpass'] == "1" ) && ( $this->password == '' ) ) {
							// generate the password is auto-generated and not set by the admin at this occasion:
							$this->setRandomPassword();
							$pwd			=	$this->hashAndSaltPassword( $this->password );
							$_CB_database->setQuery( "UPDATE #__users SET password=" . $_CB_database->Quote($pwd) . " WHERE id = " . (int) $this->id );
			    			$_CB_database->query();
						}
					}
					$_PLUGINS->trigger( 'onAfterUpdateUser', array( &$this, &$this, $oldUserComplete ) );
					if ( ( ! ( ( $oldUserComplete->approved == 1 || $oldUserComplete->approved == 2 ) && $oldUserComplete->confirmed ) )
						 && ($this->approved == 1 && $this->confirmed ) )
					{
						// first time a just registered and confirmed user got approved in backend through save user:
						activateUser( $this, 2, 'UpdateUser', false );
					}

				}
			}
		} elseif ( $reason == 'register' ) {
			$registerResults['after']			=	$_PLUGINS->trigger( 'onAfterUserRegistration', array( &$this, &$this, true ) );
			$registerResults['ok']				=	true;
			return $registerResults;
		}
		return true;
	}
	/**
	* Deletes this record (no checks)
	*
	* @param  int      $oid   Key id of row to delete (otherwise it's the one of $this)
	* @return boolean         TRUE if OK, FALSE if error
	*/
	function delete( $oid = null ) {
		$k								=	$this->_tbl_key;
		if ( $oid ) {
			$this->$k					=	(int) $oid;
		}
		$result							=	cbDeleteUser( $this->$k );
		if ( ! is_bool( result ) ) {
			$this->_error				=	$result;
			$result						=	false;
		}
		return $result;
	}

	function checkin( $oid = null ) {
		$this->_mapUsers();
		// Checks-in the row (on the CMSes where applicable):
		if ( is_callable( array( $this->_cmsUser, 'checkin' ) ) ) {
			return $this->_cmsUser->checkin();
		} else {
			return true;
		}

	}
	function _mapUsers() {
		global $_CB_framework;

		if ( $this->_cmsUser === null ) {
			$this->_cmsUser							=	$_CB_framework->_getCmsUserObject();
		}
		if ( $this->_comprofilerUser === null ) {
			$this->_comprofilerUser				=	new moscomprofiler( $this->_db );
		}

		//Note: Prior to PHP 4.2.0, Uninitialized class variables will not be reported by get_object_vars(), which is ok here
		foreach ( get_object_vars( $this ) as $name => $value ) {
			if ( $name[0] != '_' ) {
				if ( in_array( $name, $this->_nonComprofilerVars ) ) {
					$this->_cmsUser->$name			=	$value;
				} else {
					$this->_comprofilerUser->$name	=	$value;
				}
			}
		}

		$this->_cmsUser->id							=	$this->id;
		$this->_comprofilerUser->id				=	$this->id;
		$this->_comprofilerUser->user_id			=	$this->id;
	}
	/**
	 * Sets a random password in clear-text into $this->password
	 *
	 */
	function setRandomPassword( ) {
		$this->password			=	cbMakeRandomString( 8, true );
	}
	/**
	* Generate the hashed/salted/encoded password for the database
	* and to check the password at login:
	* if $row provided, it is checking the existing password (and update if needed)
	* if not provided, it will generate a new hashed password
	*
	* @param  string  $passwd  cleartext
	* @return string           salted/hashed password
	*/
	function hashAndSaltPassword( $passwd ) {
		return $this->_cbHashPassword( $passwd, false );
	}
	/**
	* Generate the hashed/salted/encoded password for the database
	* and to check the password at login:
	* if $row provided, it is checking the existing password (and update if needed)
	* if not provided, it will generate a new hashed password
	*
	* @param  string   $passwd  cleartext
	* @return boolean           TRUE/FALSE on password check
	*/
	function verifyPassword( $passwd ) {
		return $this->_cbHashPassword( $passwd, true );
	}
	/**
	* Generate the hashed/salted/encoded password for the database
	* and to check the password at login:
	* if $row provided, it is checking the existing password (and update if needed)
	* if not provided, it will generate a new hashed password
	*
	* @param  string              $passwd  cleartext
	* @return string|boolean      salted/hashed password if $row not provided, otherwise TRUE/FALSE on password check
	*/
	function _cbHashPassword( $passwd, $check ) {
		global $_CB_database;

		$version					=	checkJversion();
		$method						=	'md5';
		if ( $version == 0 ) {
			if ( function_exists( 'josHashPassword' ) ) {	// more reliable version-checking than the often hacked version.php file!
				// 1.0.13+ (in fact RC3+):
				$method				=	'md5salt';
				$saltLength			=	16;
			}
		} elseif ( $version >= 1 ) {
			// 1.5 (in fact RC1+):
			$method					=	'md5salt';
			$saltLength				=	32;
		}
		switch ( $method ) {
			case 'md5salt':
				if ( $check ) {
					$parts			=	explode( ':', $this->password );
					if ( count( $parts ) > 1 ) {
						$salt		=	$parts[1];
					} else {
						// check password, if ok, auto-upgrade database:
						$salt		=	cbMakeRandomString( $saltLength );
						$crypt		=	md5( $passwd . $salt );
						$hashedPwd	=	$crypt. ':' . $salt;
						if ( md5( $passwd ) === $this->password ) {
							$query	= "UPDATE #__users SET password = '"
									. $_CB_database->getEscaped( $hashedPwd ) . "'"
									. " WHERE id = " . (int) $this->id;
							$_CB_database->setQuery( $query );
							$_CB_database->query();
							$this->password	=	$hashedPwd;
						}
					}
				} else {
					$salt			=	cbMakeRandomString( $saltLength );
				}
				$crypt				=	md5( $passwd . $salt );
				$hashedPwd			=	$crypt. ':' . $salt;
				break;

			case 'md5':
			default:
				if ( $check ) {
					$parts			=	explode( ':', $this->password );
					if ( count( $parts ) > 1 ) {
						// check password, if ok, auto-downgrade database:
						$salt		=	$parts[2];
						$crypt		=	md5( $passwd . $salt );
						$hashedPwd	=	$crypt. ':' . $salt;
						if ( $hashedPwd === $this->password ) {
							$hashedPwd	=	md5( $passwd );
							$query	= "UPDATE #__users SET password = '"
									. $_CB_database->getEscaped( $hashedPwd ) . "'"
									. " WHERE id = " . (int) $this->id;
							$_CB_database->setQuery( $query );
							$_CB_database->query();
							$this->password	=	$hashedPwd;
						}
					}
				}
				$hashedPwd			=	md5( $passwd );
				break;
		}
		if ( $check ) {
			if ( $this->password ) {
				return ( $hashedPwd === $this->password );
			} else {
				return true;	// this allows cms authentication to do its job without interfering or lowering security
			}
		} else {
			return $hashedPwd;
		}
	}
	function _setActivationCode( ) {
		global $_CB_framework;

		$randomHash						=	md5( cbMakeRandomString() );
		$scrambleSeed					=	(int) hexdec(substr( md5 ( $_CB_framework->getCfg( 'secret' ) . $_CB_framework->getCfg( 'db' ) ), 0, 7));
		$scrambledId					=	$scrambleSeed ^ ( (int) $this->id );
		$this->cbactivation				=	'reg' . $randomHash . sprintf( '%08x', $scrambledId );
		// for CMS compatibility (and JFusion compatibility):
		$this->activation				=	$randomHash;
	}
	function checkActivationCode( $confirmcode ) {
		return ( $this->cbactivation === $confirmcode );
	}
	function removeActivationCode( ) {
		$query	=	'UPDATE '	. $this->_db->NameQuote( '#__comprofiler' )
				.	"\n SET "	. $this->_db->NameQuote( 'cbactivation' ) . ' = ' . $this->_db->Quote( '' )
				.	"\n WHERE "	. $this->_db->NameQuote( 'id' ) . ' = ' . (int) $this->id;
		$this->_db->setQuery( $query );
		if ( $this->_db->query() ) {
			$this->cbactivation			=	'';

			$query	=	'UPDATE '	. $this->_db->NameQuote( $this->_cmsUserTable )
					.	"\n SET "	. $this->_db->NameQuote( 'activation' ) . ' = ' . $this->_db->Quote( '' )
					.	"\n WHERE "	. $this->_db->NameQuote( 'id' ) . ' = ' . (int) $this->id;
			$this->_db->setQuery( $query );
			if ( $this->_db->query() ) {
				$this->activation		=	'';
			}
		} else {
			global $_CB_framework;
			if ( $_CB_framework->getUi() != 0 ) {
				trigger_error( 'SQL-unblock2 error: ' . $this->_db->stderr(true), E_USER_WARNING );
			}
		}
	}
	/**
	 * Gets user_id out of the activation code. WARNING: do not trust the user id until full activation code is checked.
	 *
	 * @static
	 * @param  string    $confirmcode
	 * @return int|null
	 */
	function getUserIdFromActivationCode( $confirmcode ) {
		global $_CB_framework;

		$lengthConfirmcode	=	strlen( $confirmcode );
		if ($lengthConfirmcode == ( 3+32+8 ) ) {
			$scrambleSeed	=	(int) hexdec(substr( md5 ( $_CB_framework->getCfg( 'secret' ) . $_CB_framework->getCfg( 'db' ) ), 0, 7));
			$unscrambledId	=	$scrambleSeed ^ ( (int) hexdec(substr( $confirmcode, 3+32 ) ) );
			return $unscrambledId;
		}
		return null;
	}
	/**
	 * confirms user to make $this->confirmed = 1 and stored in database.
	 *
	 * @param  array    $messagesToUser  RETURNS: array of messages to user.
	 * @return boolean                   TRUE: the user has been (or is already) confirmed, FALSE: wrong confirmation code or integrations do not agree
	 */
	function confirmUser( &$messagesToUser ) {
		global $ueConfig, $_PLUGINS;

		if ( $this->confirmed == 0 ) {
			if ( ( $ueConfig['emailpass'] == '1' ) && ( $this->approved == 1 ) ) {
				$this->setRandomPassword();
			}

			$_PLUGINS->loadPluginGroup('user');
			$_PLUGINS->trigger( 'onBeforeUserConfirm', array( $this ) );
			if($_PLUGINS->is_errors()) {
				$messagesToUser	=	$_PLUGINS->getErrorMSG( false );
				return false;
			}

			$this->confirmed	=	1;
			$this->storeConfirmed( false );

			if ( ( $ueConfig['emailpass'] == '1' ) && ( $this->approved == 1 ) ) {
				$this->storePassword( false );
			}

			$messagesToUser		=	activateUser( $this, 1, 'UserConfirmation' );

			$_PLUGINS->trigger( 'onAfterUserConfirm', array( $this, true ) );
		}
		return true;
	}
}
class moscomprofilerUserReport extends comprofilerDBTable {

   var $reportid			=	null;
   var $reporteduser		=	null;
   var $reportedbyuser		=	null;
   var $reportedondate		=	null;
   var $reportexplaination	=	null;
   var $reportedstatus		=	null;

	/**
	 * Constructor
	 *
	 * @param  CBdatabase  $db   A database connector object
	 */
   function moscomprofilerUserReport( &$db ) {

		$this->comprofilerDBTable( '#__comprofiler_userreports', 'reportid', $db );

	}
	/**
	 * Deletes all user reports from that user and for that user (called on user delete)
	 *
	 * @param int $userId
	 * @return boolean true if ok, false with warning on sql error
	 */
	function deleteUserReports( $userId ) {
		global $_CB_database;
		$sql='DELETE FROM #__comprofiler_userreports WHERE reporteduser = '.(int) $userId.' OR reportedbyuser = '.(int) $userId;
		$_CB_database->SetQuery($sql);
		if (!$_CB_database->query()) {
			echo 'SQL error' . $_CB_database->stderr(true);
			return false;
		}
		return true;
	}
} //end class
class moscomprofilerMember extends comprofilerDBTable {

   var $referenceid			=	null;
   var $memberid			=	null;
   var $accepted			=	null;
   var $pending				=	null;
   var $membersince			=	null;
   var $reason				=	null;
   var $description			=	null;
   var $type				=	null;

	/**
	 * Constructor
	 *
	 * @param  CBdatabase  $db   A database connector object
	 */
   function moscomprofilerMember( &$db ) {
		$this->comprofilerDBTable( '#__comprofiler_members', array( 'referenceid', 'memberid' ), $db );			//TBD: implement arrays for tablekeys.
	}
} //end class

?>
