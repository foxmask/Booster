            

<?php
class boosterModuleUpgrader_reco extends jInstallerModule {
 
    public $targetVersions = array('1.1pre.1');
    public $date = '2012-03-05';
 
    function install() {

		if($this->firstExec('acl2')){
			//error in previous version ... 
			jAcl2DbManager::removeRight('users', 'booster.edit.item');
			jAcl2DbManager::removeRight('users', 'booster.edit.versions');

			//Add recommendation rights
	    	jAcl2DbManager::addSubject('booster.recommendation', 'booster~booster.recommendation','booster.management');
	    	jAcl2DbManager::addRight('admins', 'booster.recommendation');
    	}

    	if($this->firstDbExec()){
			$this->execSQLScript('sql/upgrade_reco');
    	}

    }
 
} 