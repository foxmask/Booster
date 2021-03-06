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
        $tpl->assign('datas_mod',jDao::get('boosteradmin~boo_items_modifs','booster')->findGroupedByItemId());
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
        $id = $this->intParam('id');
        $form = jForms::fill('boosteradmin~items_mod',$id);
        if ($form->check()) {
            if ($form->getData('short_desc_fr') == ''  and
                $form->getData('short_desc') == '' ) {
                $form->setErrorOn('short_desc',jLocale::get('booster~main.desc.mandatory'));
                $form->setErrorOn('short_desc_fr',jLocale::get('booster~main.desc.mandatory'));
                $rep->action='add';
                return $rep;                
            }        
            
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
            jClasses::getService("jtags~tags")->saveTagsBySubject(explode(',', $form->getData('tags')), 'booscope', $id);
            jClasses::getService("booster~booster")->saveImage($id, $form);
            jForms::destroy('boosteradmin~items_mod',$id);
        }
        else {
            jMessage::add(jLocale::get('boosteradmin~admin.invalid.data'));
        }
        $rep = $this->getResponse('redirect');
        $rep->action = 'boosteradmin~items:index';
        return $rep;
    }
    /**
     * Edit the Modified Item for modetation
     */
    function editmod() {
        /*
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
        */
        $id = $this->intParam('id');
        $form = jForms::create('boosteradmin~items_mod',$id);
        $form->initFromDao('booster~boo_items');
        $form->setData('id', $id);
        $tags = implode(',', jClasses::getService("jtags~tags")->getTagsBySubject('booscope', $id) ) ;
        $form->setData('tags', $tags);
        $name = $form->getData('name');

        $modified = jDao::get('boosteradmin~boo_items_modifs')->findByItemId($id);
        $modified_fields = array();
        foreach($modified as $m){
            $form->setData($m->field, $m->new_value);

            if($m->field == 'type_id') {
                $dao_type = jDao::get('booster~boo_type');
                $m->new_value = $dao_type->get($m->new_value)->type_name;
                $m->old_value = $dao_type->get($m->old_value)->type_name;
            }

            $modified_fields[] = $m;
        }


        $tpl = new jTpl();
        $tpl->assign('id',$id);
        $tpl->assign('name',$name);
        $tpl->assign('modified',$modified_fields);
        $tpl->assign('title',jLocale::get('boosteradmin~admin.item.validation.or.modification'));
        $tpl->assign('form',$form);
        $tpl->assign('action','boosteradmin~items:savemod');

        $rep = $this->getResponse('html');
        $rep->body->assign('MAIN',$tpl->fetch('edit_items_modifs'));
        return $rep;
    }
    /**
     * Save the Modified Item
     */
    function savemod() {
        $rep = $this->getResponse('redirect');
        $id = $this->intParam('id');
        $form = jForms::fill('boosteradmin~items_mod',$id);
        if ($form->check()) {
            if ($form->getData('short_desc_fr') == ''  and $form->getData('short_desc') == '' ) {
                $form->setErrorOn('short_desc',jLocale::get('booster~main.desc.mandatory'));
                $form->setErrorOn('short_desc_fr',jLocale::get('booster~main.desc.mandatory'));
                $rep->action='add';
                return $rep;                
            }        
            
            $tagStr ='';
            $tagStr = str_replace('.',' ',$form->getData("tags"));
            $tags = explode(",", $tagStr);
            jClasses::getService("jtags~tags")->saveTagsBySubject($tags, 'booscope', $id);

            $form->saveToDao('booster~boo_items');


            jDao::get('boosteradmin~boo_items_modifs','booster')->deleteByItemId($id);
            jMessage::add(jLocale::get('boosteradmin~admin.item_validated'));

            if($form->getData('image') != '')
                jClasses::getService("booster~booster")->saveImage($id, $form);

            jForms::destroy('boosteradmin~items_mod',$id);
            $rep->action = 'boosteradmin~items:index';
        }
        else {
            jMessage::add(jLocale::get('boosteradmin~admin.invalid.data'));
            $rep->action = 'boosteradmin~items:editmod';
            $rep->params = array('id' => $id);
        }
        return $rep;
    }
    
    function delete() {
        $rep = $this->getResponse('redirect');
        $rep->action = 'boosteradmin~items:indexAll';
        $id = $this->intParam('id');
        if (jDao::get('booster~boo_items')->delete($id)){
            jMessage::add(jLocale::get('boosteradmin~admin.item.deleted'));
            jDao::get('boosteradmin~boo_items_modifs')->deleteByItemId($id);
            jDao::get('boosteradmin~boo_versions')->deleteByItem($id);
            //TODO versions modifs
        }
        else
            jMessage::add(jLocale::get('boosteradmin~admin.item.not.deleted'));
        return $rep;
    }

    function deleteImage() {
        $rep = $this->getResponse('redirect');
        $id = $this->intParam('id');

        @unlink(jApp::wwwPath('images-items/'.md5('id:'.$id).'.png'));

        $rep->action = strpos($this->param('submitAction'), 'savenew') !== false ? 'boosteradmin~items:editnew' : 'boosteradmin~items:editmod';
        $rep->params = array('id' => $id);
        return $rep;
    }


}
