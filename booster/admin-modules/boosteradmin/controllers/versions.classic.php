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
                        'jacl2.right' =>'booster.admin.index'),
    );
    /**
     * Index page that list all the "waiting versions"
     */
    function index() {
        $tpl = new jTpl();
        $rep = $this->getResponse('html');

        $cnx = jDb::getConnection();
        $sql=" SELECT vm.date as date, i.name as item_name, v.id as version_id, v.version_name
            FROM boo_versions_modifs vm 
                LEFT JOIN boo_versions v ON vm.version_id = v.id
                LEFT JOIN boo_items i ON i.id = v.item_id 
            GROUP BY vm.version_id
            ORDER BY vm.date ASC";
        $res = $cnx->query($sql);
        $tpl->assign('datas_mod',$res);
        $tpl->assign('datas_new',jDao::get('boosteradmin~boo_items_versions','booster')->findAllNotModerated());
        $rep->body->assign('MAIN',$tpl->fetch('versions_mod'));
        return $rep;
    }
    /**
     * Index page that list all the validated items
     */
    function indexAll() {
        $tpl = new jTpl();
        $rep = $this->getResponse('html');
        $tpl->assign('datas',jDao::get('boosteradmin~boo_items_versions','booster')->findAllValidated());
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
        $tpl->assign('item_by',jDao::get('booster~boo_items','booster')->get($form->getData('item_id'))->item_by);
        $tpl->assign('action','boosteradmin~versions:savenew');
        $tpl->assign('id',$this->intParam('id'));
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
            //validator submit via the "Validate" button so we automaticaly validate the version
            elseif($form->getData('_validate')){
                $form->setData('status_version', 1);
                jMessage::add(jLocale::get('boosteradmin~admin.version_validated'));
            }
            // we just edit the new content of the version
            // but we didnt validate it so :
            // save all the modification
            else {
                jMessage::add(jLocale::get('boosteradmin~admin.version_saved_but_not_validated_yet'));
            }
            $form->saveToDao('boosteradmin~boo_versions');
            //update the date_version
            $daoItem = jDao::get('booster~boo_items');
            $rec = $daoItem->get($form->getData('item_id'));
            $rec->date_version = date("Y-m-d H:i:s");
            $daoItem->update($rec);

        }
        else {
            jMessage::add(jLocale::get('boosteradmin~admin.invalid.data'));
        }
        $rep = $this->getResponse('redirect');
        $rep->action = 'boosteradmin~versions:index';
        return $rep;
    }
    /**
     * Edit the Modified Version for modetation
     */
    function editmod() {
        $id = $this->intParam('id');
        $form = jForms::create('boosteradmin~versions_mod',$id);
        $form->initFromDao('boosteradmin~boo_versions');
        $form->setData('id',$id);

        $modified = jDao::get('boosteradmin~boo_versions_modifs')->findByVersionId($id);
        $modified_fields = array();
        foreach($modified as $m){
            $form->setData($m->field, $m->new_value);
            $modified_fields[] = $m;
        }

        $tpl = new jTpl();
        $rep = $this->getResponse('html');

        $item_by = 'undefined';
        $item = jDao::get('booster~boo_items','booster')->get($id);
        if ($item !== false){ jLog::dump(jDao::get('jcommunity~user','hfnu')->getById($item->item_by));
            $item_by = jDao::get('jcommunity~user','hfnu')->getById($item->item_by)->nickname;
            $tpl->assign('item_id', $item->id);
            $tpl->assign('item_name', $item->name);
        }
            

        $tpl->assign('item_by',$item_by);

        $tpl->assign('title',jLocale::get('boosteradmin~admin.version.validation.or.modification'));
        $tpl->assign('form',$form);
        $tpl->assign('id',$id);
        $tpl->assign('modified',$modified_fields);
        $tpl->assign('action','boosteradmin~versions:savemod');
        $rep->body->assign('MAIN',$tpl->fetch('edit_versions_modifs'));
        return $rep;
    }
    /**
     * Save the Modified Versions
     */
    function savemod() {
        $rep = $this->getResponse('redirect');
        $id = $this->intParam('id');
        $form = jForms::fill('boosteradmin~versions_mod', $id);
        if ($form->check()) {
            $form->saveToDao('boosteradmin~boo_versions');
            jDao::get('boosteradmin~boo_versions_modifs','booster')->deleteByVersionId($id);
            jMessage::add(jLocale::get('boosteradmin~admin.version_validated'));
            $rep->action = 'boosteradmin~versions:index';
        }
        else {
            jMessage::add(jLocale::get('boosteradmin~admin.invalid.data'));
            $rep->action = 'boosteradmin~versions:index';
            $rep->params = array('id' => $id);
        }
        return $rep;
    }
    
    function delete() {
        $rep = $this->getResponse('redirect');
        $rep->action = 'boosteradmin~versions:indexAll';
        $id = $this->intParam('id');
        if (jDao::get('booster~boo_versions')->delete($id)){
            jDao::get('boosteradmin~boo_versions_modifs')->deleteByVersionId($id);
            jMessage::add(jLocale::get('boosteradmin~admin.version.deleted'));
        }
        else
            jMessage::add(jLocale::get('boosteradmin~admin.version.not.deleted'));
        return $rep;
    }

}
