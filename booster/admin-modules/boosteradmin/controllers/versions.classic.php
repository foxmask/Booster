<?php
/**
* @package   booster
* @subpackage versions
* @author    Olivier Demah
* @copyright 2011 olivier demah
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

class versionsCtrl extends jController {
    public $pluginParams = array(
        '*'     => array('auth.required'=>true,
                         'booster.admin.index'=>true),
    );


    function index() {
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('datas_new',jDao::get('boosteradmin~boo_versions_mod')->findAll());
        $tpl->assign('datas_mod',jDao::get('booster~boo_items_versions')->findAllNotModerated());
        $rep->body->assign('MAIN',$tpl->fetch('versions_mod'));
        return $rep;
    }

    function editnew() {
        $form = jForms::create('boosteradmin~versions_mod',$this->intParam('id'));
        $form->initFromDao('boosteradmin~boo_versions');
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('form',$form);
        $rep->body->assign('MAIN',$tpl->fetch('versions_mod_edit'));
        return $rep;
    }
    function savenew() {
        $form = jForms::fill('boosteradmin~versions_mod');
        if ($form->check()) {
            $dao =  jDao::get('booster~boo_versions');
            //get the Id of the Item we've validated
            $rec = $dao->get($form->getData('id'));
            //change the data for each column
            $rec->version_name  = $form->getData('version_name');
            $rec->last_changes  = $form->getData('last_changes');
            $rec->stability     = $form->getData('stability');
            $rec->filename      = $form->getData('filename');
            $rec->download_url  = $form->getData('download_url');
            $rec->status        = 1;
            $dt = new jDateTime();
            $rec->modified = $dt->now();
            //save
            $dao->save($rec);
            //msg to the admin ;)
            jMessage::add('boosteradmin~admin.version_validated');
        }
        else {
            jMessage::add('boosteradmin~admin.invalid.data');
        }
        $rep = $this->getResponse('redirect');
        $rep->action = 'boosteradmin~versions:index';
        return $rep;
    }

    function editmod() {
        $form = jForms::create('boosteradmin~versions_mod',$this->intParam('id'));
        $form->initFromDao('boosteradmin~boo_versions_mod');
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('form',$form);
        $rep->body->assign('MAIN',$tpl->fetch('versions_mod_edit'));
        return $rep;
    }

    function savemod() {
        $form = jForms::fill('boosteradmin~versions_mod');
        if ($form->check()) {
            $dao =  jDao::get('booster~boo_versions');
            //get the Id of the Item we've validated
            $rec = $dao->get($form->getData('id'));
            //change the data for each column
            $rec->version_name  = $form->getData('version_name');
            $rec->last_changes  = $form->getData('last_changes');
            $rec->stability     = $form->getData('stability');
            $rec->filename      = $form->getData('filename');
            $rec->download_url  = $form->getData('download_url');
            $rec->status        = 1;
            $dt = new jDateTime();
            $rec->modified = $dt->now();
            //save
            $dao->save($rec);
            //delete the moderated item from the "mirror" table
            jDao::get('boosteradmin~boo_versions_mod')->delete($form->getData('id'));
            //msg to the admin ;)
            jMessage::add('boosteradmin~admin.version_validated');
        }
        else {
            jMessage::add('boosteradmin~admin.invalid.data');
        }
        $rep = $this->getResponse('redirect');
        $rep->action = 'boosteradmin~versions:index';
        return $rep;
    }
}
