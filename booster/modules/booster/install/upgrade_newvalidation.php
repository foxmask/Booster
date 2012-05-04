<?php
class boosterModuleUpgrader_newvalidation extends jInstallerModule {
 
    public $targetVersions = array('1.1pre.2');
    public $date = '2012-05-04';
 
    function install() {

        if($this->firstDbExec()){
            $this->execSQLScript('sql/upgrade_newvalidation');
        }

    }
 
} 