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
    /**
     * Index page that list all the "waiting versions"
     */
    function index() {
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('datas_mod',jDao::get('boosteradmin~boo_versions_mod')->findAll());
        $tpl->assign('datas_new',jDao::get('booster~boo_items_versions')->findAllNotModerated());
        $rep->body->assign('MAIN',$tpl->fetch('versions_mod'));
        return $rep;
    }
    /**
     * edit the new submitted versions
     */
    function editnew() {
        $form = jForms::create('boosteradmin~versions_mod',$this->intParam('id'));
        $form->initFromDao('booster~boo_versions');
        $form->setData('id',$this->intParam('id'));
        $rep = $this->getResponse('html');
        $tpl = new jTpl();
        $tpl->assign('form',$form);
        $tpl->assign('action','boosteradmin~versions:savenew');
        $rep->body->assign('MAIN',$tpl->fetch('versions_mod_edit'));
        return $rep;
    }
    /**
     * Save the new submitted version
     */
    function savenew() {
        $form = jForms::fill('boosteradmin~versions_mod',$this->intParam('id'));
        if ($form->check()) {
            // we validate the new item
            // then remove the data from the "waiting table" (items_mod)
            if ($form->getData('status')==1) {
                jMessage::add(jLocale::get('boosteradmin~admin.version_validated'));
            }
            // we just edit the new content of the version
            // but we didnt validate it so :
            // save all the modification
            else {
                jMessage::add(jLocale::get('boosteradmin~admin.versions_saved_but_not_validated_yet'));
            }
            $form->saveToDao('booster~boo_versions');
        }
        else {
            jMessage::add('boosteradmin~admin.invalid.data');
        }
        $rep = $this->getResponse('redirect');
        $rep->action = 'boosteradmin~versions:index';
        return $rep;
    }
    /**
     * Edit the Modified Version for modetation
     */
    function editmod() {
        $form = jForms::create('boosteradmin~versions_mod',$this->intParam('id'));
        $form->initFromDao('boosteradmin~boo_versions_mod');
        $form->setData('id',$this->intParam('id'));
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('form',$form);
        $tpl->assign('action','boosteradmin~versions:savemod');
        $rep->body->assign('MAIN',$tpl->fetch('versions_mod_edit'));
        return $rep;
    }
    /**
     * Save the Modified Versions
     */
    function savemod() {
        $form = jForms::fill('boosteradmin~versions_mod',$this->intParam('id'));
        if ($form->check()) {
            // we validate the modifications, so replace the old data
            // then remove the data from the "waiting table" (items_mod)
            if ($form->getData('status')==1) {
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
                jMessage::add(jLocale::get('boosteradmin~admin.version_validated'));
            }
            else {
                jMessage::add(jLocale::get('boosteradmin~admin.version_saved_but_not_validated_yet'));
                $form->saveToDao('boosteradmin~boo_versions_mod');
            }
        }
        else {
            jMessage::add('boosteradmin~admin.invalid.data');
        }
        $rep = $this->getResponse('redirect');
        $rep->action = 'boosteradmin~versions:index';
        return $rep;
    }
}
