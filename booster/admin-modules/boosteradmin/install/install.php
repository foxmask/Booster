<?php
/**
* @package   booster
* @subpackage boosteradmin
* @author    laurentj
* @copyright 2011 laurent
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/


class boosteradminModuleInstaller extends jInstallerModule {

    function install() {
        if ($this->firstDbExec())
            $this->execSQLScript('sql/install');

        if ($this->firstExec('acl2')) {
            jAcl2DbManager::addSubject('booster.admin.index', 'booster~booster.admin.index');
            jAcl2DbManager::addRight('admins', 'booster.admin.index'); // for admin group
        }

    }
}
