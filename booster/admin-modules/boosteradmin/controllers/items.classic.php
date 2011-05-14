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

    function index() {
        $dao = jDao::get('boosteradmin~boo_items_mod');
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('datas',$dao->findAll());
        $rep->body->assign('MAIN',$tpl->fetch('items_mod'));
        return $rep;
    }

    function edit() {
        $form = jForms::create('boosteradmin~items_mod',$this->intParam('id'));
        $form->initFormDao('boosteradmin~boo_items_mod');
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('form',$form);
        $rep->body->assign('MAIN',$tpl->fetch('items_mod_edit'));
        return $rep;
    }

    function save() {
        $form = jForms::fill('boosteradmin~items_mod');
        if ($form->check()) {
            $dao =  jDao::get('booster~boo_items');
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
            jMessage::add('boosteradmin~admin.item_validated');
        }
        else {
            jMessage::add('boosteradmin~admin.invalid.data');
        }
        $rep = $this->getResponse('redirect');
        $rep->action = 'boosteradmin~items:index';
        return $rep;
    }
}
