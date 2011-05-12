<?php
/**
* @package   booster
* @subpackage 
* @author    laurentj
* @copyright 2011 laurent
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

require ('../application.init.php');
require (JELIX_LIB_CORE_PATH.'request/jClassicRequest.class.php');

checkAppOpened();

$config_file = 'adminboost/config.ini.php';

$jelix = new jCoordinator($config_file);
$jelix->process(new jClassicRequest());


