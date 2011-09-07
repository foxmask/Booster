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
        if ($this->firstDbExec()) {
            $this->execSQLScript('sql/install');
            $this->execSQLScript('sql/data');
        }

        if ($this->firstExec('acl2')) {
            //subjects
            jAcl2DbManager::addSubject('booster.edit.item', 'booster~booster.edit.item','booster.management');
            jAcl2DbManager::addSubject('booster.edit.version', 'booster~booster.edit.version','booster.management');
            jAcl2DbManager::addSubject('booster.admin.index', 'booster~booster.edit.version','booster.management');
            //rights
            jAcl2DbManager::addRight('users', 'booster.edit.item'); // for users group
            jAcl2DbManager::addRight('admins', 'booster.edit.item'); // for admins group
            jAcl2DbManager::addRight('users', 'booster.edit.version'); // for users group
            jAcl2DbManager::addRight('admins', 'booster.edit.version'); // for admins group
            jAcl2DbManager::addRight('admins', 'booster.admin.index'); // for admins group
                       
            // fill the jacl2 tables for the right management,
            // from the 'users' table
            // thus we share the same user database
            // and use different acl.
            $recs = jDao::get('jcommunity~user','hfnu')->findAll();
            foreach ($recs as $rec) {
                //admin
                if ($rec->login == 'foxmask' or $rec->login =='laurentj')
                    jAcl2DbUserGroup::addUserToGroup($rec->login,'admins');
                //users
                else
                    jAcl2DbUserGroup::addUserToGroup($rec->login,'users');
            }
        }

    }
}
