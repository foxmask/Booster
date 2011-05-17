<?php
/**
* @package   booster
* @subpackage items
* @author    Olivier Demah
* @copyright 2011 olivier demah
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

class itemsCtrl extends jController {
    public $pluginParams = array(
        '*'     => array('auth.required'=>true,
                         'booster.admin.index'=>true),
    );
    /**
     * Index page that list all the "waiting items"
     */
    function index() {
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('datas_mod',jDao::get('boosteradmin~boo_items_mod')->findAll());
        $tpl->assign('datas_new',jDao::get('boosteradmin~boo_items')->findAllNotModerated());
        $rep->body->assign('MAIN',$tpl->fetch('items_mod'));
        return $rep;
    }
    /**
     * Index page that list all the validated items
     */
    function indexAll() {
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('datas',jDao::get('boosteradmin~boo_items')->findAllValidated());
        $rep->body->assign('MAIN',$tpl->fetch('items_all'));
        return $rep;
    }
    /**
     * edit the new submitted item
     */
    function editnew() {
        $form = jForms::create('boosteradmin~items_mod',$this->intParam('id'));
        $form->initFromDao('boosteradmin~boo_items');
        $form->setData('id',$this->intParam('id'));
        $rep = $this->getResponse('html');
        $tpl = new jTpl();
        $tpl->assign('title',jLocale::get('boosteradmin~admin.item.validation.or.modification'));
        $tpl->assign('form',$form);
        $tpl->assign('action','boosteradmin~items:savenew');
        $rep->body->assign('MAIN',$tpl->fetch('edit'));
        return $rep;
    }
    /**
     * Save the new submitted item
     */
    function savenew() {
        $form = jForms::fill('boosteradmin~items_mod',$this->intParam('id'));
        if ($form->check()) {
            // we validate the new item
            // then remove the data from the "waiting table" (items_mod)
            if ($form->getData('status')==1) {
                jMessage::add(jLocale::get('boosteradmin~admin.item_validated'));
            }
            // we just edit the new content of the item
            // but we didnt validate it so :
            // save all the modification
            else {
                jMessage::add(jLocale::get('boosteradmin~admin.item_saved_but_not_validated_yet'));
            }
            $form->saveToDao('boosteradmin~boo_items');
        }
        else {
            jMessage::add('boosteradmin~admin.invalid.data');
        }
        $rep = $this->getResponse('redirect');
        $rep->action = 'boosteradmin~items:index';
        return $rep;
    }
    /**
     * Edit the Modified Item for modetation
     */
    function editmod() {
        $form = jForms::create('boosteradmin~items_mod',$this->intParam('id'));
        $form->initFromDao('boosteradmin~boo_items_mod');
        $form->setData('id',$this->intParam('id'));
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('title',jLocale::get('boosteradmin~admin.item.validation.or.modification'));
        $tpl->assign('form',$form);
        $tpl->assign('action','boosteradmin~items:savemod');
        $rep->body->assign('MAIN',$tpl->fetch('edit'));
        return $rep;
    }
    /**
     * Save the Modified Item
     */
    function savemod() {
        $form = jForms::fill('boosteradmin~items_mod',$this->intParam('id'));
        if ($form->check()) {
            // we validate the modifications, so replace the old data
            // then remove the data from the "waiting table" (items_mod)
            if ($form->getData('status')==1) {
                $dao =  jDao::get('boosteradmin~boo_items');
                //get the Id of the Item we've validated
                $rec = $dao->get($form->getData('id'));
                //change the data for each column
                $rec->name          = $form->getData('name');
                $rec->item_info_id  = $form->getData('item_info_id');
                $rec->short_desc    = $form->getData('short_desc');
                $rec->type_id       = $form->getData('type_id');
                $rec->url_website   = $form->getData('url_website');
                $rec->url_repo      = $form->getData('url_repo');
                $rec->author        = $form->getData('author');
                $rec->status        = 1;
                $dt = new jDateTime();
                $rec->modified = $dt->now();
                //save
                $dao->save($rec);
                //delete the moderated item from the "mirror" table
                jDao::get('boosteradmin~boo_items_mod')->delete($form->getData('id'));
                //msg to the admin ;)
                jMessage::add(jLocale::get('boosteradmin~admin.item_validated'));
            }
            // we just edit the modified content of the item
            // but we didnt validate it so :
            // save all the modification
            else {
                jMessage::add(jLocale::get('boosteradmin~admin.item_saved_but_not_validated_yet'));
                $form->saveToDao('boosteradmin~boo_items_mod');
            }
        }
        else {
            jMessage::add(jLocale::get('boosteradmin~admin.invalid.data'));
        }
        $rep = $this->getResponse('redirect');
        $rep->action = 'boosteradmin~items:index';
        return $rep;
    }

}
