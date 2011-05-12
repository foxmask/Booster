<?php
/**
* @package     jelix-scripts
* @author      Laurent Jouanneau
* @contributor Loic Mathaud
* @copyright   2005-2008 Laurent Jouanneau
* @link        http://jelix.org
* @licence     GNU General Public Licence see LICENCE file or http://www.gnu.org/licenses/gpl.html
*/

// paths of all directories for an application

/*
// related path given to GetAppsRepository function should be related to the jelix.php script.
define('JELIXS_APPS_BASEPATH', GetAppsRepository('../../'));
define ('JELIXS_APPTPL_PATH'        , JELIXS_APPS_BASEPATH."/$APPNAME/");
define ('JELIXS_APPTPL_TEMP_PATH'   , JELIXS_APPS_BASEPATH."/temp/$APPNAME/");
define ('JELIXS_APPTPL_WWW_PATH'    , JELIXS_APPS_BASEPATH."/$APPNAME/www/");
define ('JELIXS_APPTPL_VAR_PATH'    , JELIXS_APPS_BASEPATH."/$APPNAME/var/");
define ('JELIXS_APPTPL_LOG_PATH'    , JELIXS_APPS_BASEPATH."/$APPNAME/var/log/");
define ('JELIXS_APPTPL_CONFIG_PATH' , JELIXS_APPS_BASEPATH."/$APPNAME/var/config/");
define ('JELIXS_APPTPL_CMD_PATH'    , JELIXS_APPS_BASEPATH."/$APPNAME/scripts/");
define ('JELIXS_LIB_PATH'          , JELIXS_APPS_BASEPATH.'/lib/');
define ('JELIXS_INIT_PATH'          , JELIXS_LIB_PATH.'jelix/init.php');
*/

// an other example for a linux server:
/*
define ('JELIXS_APPS_BASEPATH'      , '/usr/local/lib/jelix-apps/');
define ('JELIXS_APPTPL_PATH'        , JELIXS_APPS_BASEPATH.$APPNAME.'/");
define ('JELIXS_APPTPL_TEMP_PATH'   , "/var/tmp/jelix-apps/$APPNAME/");
define ('JELIXS_APPTPL_WWW_PATH'    , "/var/www/jelix-apps/$APPNAME/");
define ('JELIXS_APPTPL_VAR_PATH'    , "/var/lib/jelix-apps/$APPNAME/var/");
define ('JELIXS_APPTPL_LOG_PATH'    , "/var/log/jelix-apps/$APPNAME/");
define ('JELIXS_APPTPL_CONFIG_PATH' , "/var/lib/jelix-apps/$APPNAME/config/");
define ('JELIXS_LIB_PATH'           , '/usr/local/lib/jelix-1.1/');
define ('JELIXS_INIT_PATH'          , JELIXS_LIB_PATH.'jelix/init.php');
*/

//--- informations which will stored into generated files, mainly in
//--- documentation comments. Values indicated in the example are
//--- default values which will be used if you don't uncomment this constants.

// The default suffix of id of your all modules/plugins etc..
define('JELIXS_INFO_DEFAULT_IDSUFFIX','@jelix.org');

// Your website, or the domain name of your application
define('JELIXS_INFO_DEFAULT_WEBSITE','http://www.jelix.org');

// label of the license of your files. ex: GPL, Gnu Public License
define('JELIXS_INFO_DEFAULT_LICENSE',' GNU Lesser General Public Licence, see LICENCE file');

// the URL where we can read the license you choose
define('JELIXS_INFO_DEFAULT_LICENSE_URL','http://www.gnu.org/licenses/lgpl.html');

// the default creator name (your name for example..)
define('JELIXS_INFO_DEFAULT_CREATOR_NAME','laurentj');

// the email of the creator
define('JELIXS_INFO_DEFAULT_CREATOR_EMAIL','laurent@jelix.org');

// Copyright informations
define('JELIXS_INFO_DEFAULT_COPYRIGHT','2011 laurent');

// default timezone of your application, which will be used in the configuration
// of your application
define('JELIXS_INFO_DEFAULT_TIMEZONE','Europe/Paris');

//default language used in your application
define('JELIXS_INFO_DEFAULT_LOCALE','fr_FR');

// indicates if a chmod should be done on new files/dir
//define('DO_CHMOD',false);

// indicated the chmod value for new files (used if DO_CHMOD=true)
//define('CHMOD_FILE_VALUE',0644);

// indicated the chmod value for new directories (used if DO_CHMOD=true)
//define('CHMOD_DIR_VALUE',0755);

// indicates if a chown should be done on new files/dirs created by jelix.php
//define('DO_CHOWN',false);

// indicates the user which will be the owner of the new files/dirs created by jelix.php
//define('CHOWN_USER','');

// indicates the group which will be the owner of the new files/dirs created by jelix.php
//define('CHOWN_GROUP','');

// indicates if help of jelix.php is displayed in UTF-8 
//define('DISPLAY_HELP_UTF_8', true);

// the language used for messages and help displayed by jelix.php
define('MESSAGE_LANG','fr');
