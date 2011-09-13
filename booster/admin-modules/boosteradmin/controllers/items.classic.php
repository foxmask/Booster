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
                         'jacl2.right' =>'booster.admin.index'),
    );
    /**
     * Index page that list all the "waiting items"
     */
    function index() {
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('datas_mod',jDao::get('boosteradmin~boo_items_mod','booster')->findAll());
        $tpl->assign('datas_new',jDao::get('booster~boo_items','booster')->findAllNotModerated());
        $rep->body->assign('MAIN',$tpl->fetch('items_mod'));
        return $rep;
    }
    /**
     * Index page that list all the validated items
     */
    function indexAll() {
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('datas',jDao::get('booster~boo_items','booster')->findAllValidated());
        $rep->body->assign('MAIN',$tpl->fetch('items_all'));
        return $rep;
    }
    /**
     * edit the new submitted item
     */
    function editnew() {
        $id = $this->intParam('id');
        $form = jForms::create('boosteradmin~items_mod', $id);
        $form->initFromDao('booster~boo_items');
        $form->setData('id',$id);
        
        $tags = implode(',', jClasses::getService("jtags~tags")->getTagsBySubject('booscope', $id) ) ;
        $form->setData('tags', $tags);
        $rep = $this->getResponse('html');
        $tpl = new jTpl();
        $tpl->assign('id',$id);
        $tpl->assign('title',jLocale::get('boosteradmin~admin.item.validation.or.modification'));
        $tpl->assign('form',$form);
        $tpl->assign('item_by',jDao::get('booster~boo_items','booster')->get($id)->item_by);
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
            //validator submit via the "Validate" button so we automaticaly validate the item
            elseif($form->getData('_validate')){
                $form->setData('status', 1);
                jMessage::add(jLocale::get('boosteradmin~admin.item_validated'));
            }
            // we just edit the new content of the item
            // but we didnt validate it so :
            // save all the modification
            else {
                jMessage::add(jLocale::get('boosteradmin~admin.item_saved_but_not_validated_yet'));
            }
            $form->saveToDao('booster~boo_items');
            jClasses::getService("jtags~tags")->saveTagsBySubject(explode(',', $form->getData('tags')), 'booscope', $this->intParam('id'));
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
        $tpl->assign('item_by',jDao::get('jcommunity~user','hfnu')->getById(jDao::get('boosteradmin~boo_items_mod','booster')->get($this->intParam('id'))->item_by)->nickname);
        $tpl->assign('id',$this->intParam('id'));
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
            if ($form->getData('status') == 1 OR $form->getData('_validate')) {
                //in case, direct click on validate
                $form->setData('status', 1);

                $tagStr ='';
                $tagStr = str_replace('.',' ',$form->getData("tags"));
                $tags = explode(",", $tagStr);
                jClasses::getService("jtags~tags")->saveTagsBySubject($tags, 'booscope', $this->intParam('id'));

                $form->saveToDao('booster~boo_items');

                //delete the moderated item from the "mirror" table
                jDao::get('boosteradmin~boo_items_mod','booster')->delete($form->getData('id'));
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
