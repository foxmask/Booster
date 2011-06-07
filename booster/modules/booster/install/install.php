<?php
/**
* @package   booster
* @subpackage booster
* @author    laurentj
* @copyright 2011 laurent
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/


class boosterModuleInstaller extends jInstallerModule {

    function install() {
        if ($this->firstDbExec())
            $this->execSQLScript('sql/install');

        if ($this->firstExec('acl2')) {
            jAcl2DbManager::addSubject('booster.edit.item', 'booster~booster.edit.item');
            jAcl2DbManager::addRight('users', 'booster.edit.item'); // for users group
            jAcl2DbManager::addRight('admins', 'booster.edit.item'); // for admins group
            jAcl2DbManager::addSubject('booster.edit.version', 'booster~booster.edit.version');
            jAcl2DbManager::addRight('users', 'booster.edit.version'); // for users group
            jAcl2DbManager::addRight('admins', 'booster.edit.version'); // for admins group
        }

    }
}
