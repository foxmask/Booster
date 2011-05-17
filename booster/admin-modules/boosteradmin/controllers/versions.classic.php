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
        $tpl->assign('datas_new',jDao::get('boosteradmin~boo_items_versions')->findAllNotModerated());
        $rep->body->assign('MAIN',$tpl->fetch('versions_mod'));
        return $rep;
    }
    /**
     * Index page that list all the validated items
     */
    function indexAll() {
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('datas',jDao::get('boosteradmin~boo_items_versions')->findAllValidated());
        $rep->body->assign('MAIN',$tpl->fetch('versions_all'));
        return $rep;
    }
    /**
     * edit the new submitted versions
     */
    function editnew() {
        $form = jForms::create('boosteradmin~versions_mod',$this->intParam('id'));
        $form->initFromDao('boosteradmin~boo_versions');
        $form->setData('id',$this->intParam('id'));
        $rep = $this->getResponse('html');
        $tpl = new jTpl();
        $tpl->assign('title',jLocale::get('boosteradmin~admin.version.validation.or.modification'));
        $tpl->assign('form',$form);
        $tpl->assign('action','boosteradmin~versions:savenew');
        $rep->body->assign('MAIN',$tpl->fetch('edit'));
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
            if ($form->getData('status_version')==1) {
                jMessage::add(jLocale::get('boosteradmin~admin.version_validated'));
            }
            // we just edit the new content of the version
            // but we didnt validate it so :
            // save all the modification
            else {
                jMessage::add(jLocale::get('boosteradmin~admin.version_saved_but_not_validated_yet'));
            }
            $form->saveToDao('boosteradmin~boo_versions');
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
        $tpl->assign('title',jLocale::get('boosteradmin~admin.version.validation.or.modification'));
        $tpl->assign('form',$form);
        $tpl->assign('action','boosteradmin~versions:savemod');
        $rep->body->assign('MAIN',$tpl->fetch('edit'));
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
            if ($form->getData('status_version')==1) {
                $form->saveToDao('boosteradmin~boo_versions');
                //delete the moderated item from the "mirror" table
                jDao::get('boosteradmin~boo_versions_mod')->delete($form->getData('id'));
                //msg to the admin ;)
                jMessage::add(jLocale::get('boosteradmin~admin.version_validated'));
            }
            // we just edit the modified content of the version
            // but we didnt validate it so :
            // save all the modification
            else {
                jMessage::add(jLocale::get('boosteradmin~admin.version_saved_but_not_validated_yet'));
                $form->saveToDao('boosteradmin~boo_versions_mod');
            }
        }
        else {
            jMessage::add(jLocale::get('boosteradmin~admin.invalid.data'));
        }
        $rep = $this->getResponse('redirect');
        $rep->action = 'boosteradmin~versions:index';
        return $rep;
    }
}
