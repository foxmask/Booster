<?php
/**
* @package   booster
* @subpackage booster
* @author    Olivier Demah
* @contributor Florian Lonqueu-Brochard
* @copyright 2011 olivier demah
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/
/**
 *Main controler to handle add/edit of the public actions of the Booster
 */
class defaultCtrl extends jController {
    public $pluginParams = array(
        '*'     => array('auth.required'=>true),
        'index' => array('auth.required'=>false),
        'viewItem' => array('auth.required'=>false),
        'search' => array('auth.required'=>false),
        'cloud' => array('auth.required'=>false),
        'applis' => array('auth.required'=>false),
        'modules' => array('auth.required'=>false),
        'plugins' => array('auth.required'=>false),
        'packlang' => array('auth.required'=>false),
        'credits' => array('auth.required'=>false)
    );
    /**
     *Main Page
     */
    function index() {
        $rep = $this->getResponse('html');
        $tpl = new jTpl();
        if(jAuth::isConnected()) {
            $tpl->assign('current_user',jAuth::getUserSession ()->id);
        }
        else {
            $tpl->assign('current_user','');
        }

        if( $this->param('search')) {
            $form = jForms::fill('booster~search');
            if ($form->check()) {
                $results = jClasses::getService('booster~booster')->search();
                $tpl->assign('search_results', $results);
            }
        }
        else{
            $dao = jDao::get('booster~boo_items','booster');
            $tpl->assign('datas',$dao->findLastCreated($GLOBALS['gJConfig']->booster['last_items_created']));
        }
        $tpl->assign('item_not_moderated','');
        $rep->body->assign('MAIN',$tpl->fetch('index'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
    /**
     * View Item page
     */
    function viewItem() {
        $tpl = new jTpl();
        if(jAuth::isConnected()) {
            $tpl->assign('current_user',jAuth::getUserSession ()->id);
        }
        else {
            $tpl->assign('current_user','');
        }

        $data = jDao::get('booster~boo_items','booster')->get(
                                    $this->param('id') );
        // is the current user the author or the admin ?
        if (( jAuth::isConnected() and $data->item_by == jAuth::getUserSession ()->id) or
            jAcl2::check('booster.admin.index') ) {
            //so let's warn him if the item is moderated or not
            $tpl->assign('item_not_moderated',!$data->status);
        //if he is not ; and the status is "not moderated" we dont display the item => 404
        } else {
            if ($data->status == 0) {
                $rep = $this->getResponse('html',true);
                $rep->bodyTpl = 'jelix~404.html';
                $rep->setHttpStatus('404', 'Not Found');
                return $rep;
            }
            //we dont have to display the status of the item to somebody else.
            $tpl->assign('item_not_moderated','');
        }

        $rep = $this->getResponse('html');

        $tpl->assign('data',$data);
        $tpl->assign('is_admin', jAcl2::check('booster.admin.index'));
        $rep->title = $data->name;
        $rep->body->assign('MAIN',$tpl->fetch('view_item'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
    /**
     * Add an Item
     */
    function add() {
        $rep = $this->getResponse('html');
        $rep->title = jLocale::get('booster~main.add.an.item');
        $form = jForms::get('booster~items');
        if ($form === null)
            $form = jForms::create('booster~items');
        $form->setData('item_by',jAuth::getUserSession()->id);
        $tpl = new jTpl();
        $tpl->assign('form',$form);
        $rep->body->assign('MAIN',$tpl->fetch('add_item'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
    /**
     * Save an Item
     */
    function saveItem() {
        $rep = $this->getResponse('redirect');
        $form = jForms::fill('booster~items');
        if ($form->check()) {
            if ($form->getData('short_desc_fr') == ''  and
                $form->getData('short_desc') == '' ) {
                $form->setErrorOn('short_desc',jLocale::get('booster~main.desc.mandatory'));
                $form->setErrorOn('short_desc_fr',jLocale::get('booster~main.desc.mandatory'));
                $rep->action='add';
                return $rep;
            }
            $data = jClasses::getService('booster~booster')->saveItem();
            if (!empty($data)) {
                jMessage::add(jLocale::get('booster~main.item.saved'));
                $saved = true;
                
                jEvent::notify('new_item_added', array('item_id' => $data['id']));
                jForms::destroy('booster~items');
            }
            else {
                $saved = false;
                jMessage::add(jLocale::get('booster~main.item.saved.failed'));
            }
        } else {
            $saved = false;
            jMessage::add(jLocale::get('booster~main.item.check.failed'));
        }
        $rep->params = array('id'=>$data['id'],'name'=>$data['name']);
        $rep->action = ($saved) ? 'booster~addVersion' : 'booster~index';
        return $rep;
    }
    /**
     * Add a Version to the current Item
     */
    function addVersion() {
        $rep = $this->getResponse('html');
        $rep->title = jLocale::get('booster~main.add.a.version');
        $form = jForms::create('booster~version');
        $form->setData('item_by',jAuth::getUserSession()->id);
        $form->setData('item_id',$this->intParam('id'));

        $tpl = new jTpl();
        $tpl->assign('itemName',$this->param('name'));
        $tpl->assign('form',$form);
        $rep->body->assign('MAIN',$tpl->fetch('add_version'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
    /**
     * Save a Version
     */
    function saveVersion() {
        $rep = $this->getResponse('redirect');
        $form = jForms::fill('booster~version');
        if ($form->check()) {
            $data = jClasses::getService('booster~booster')->saveVersion($form);
            if ($data) {
                jMessage::add(jLocale::get('booster~main.version.saved'));
                jEvent::notify('new_version_added', array('version_id' => $data));
                jForms::destroy('booster~version');
                $saved = true;
                $item = jDao::get('booster~boo_items','booster')->get($form->getData('item_id'));
                if ($item->status == 1) {
                    $rep->action = 'viewItem';
                    $rep->params = array('id'=> $item->id,'name'=>$item->name);
                }
                else {
                    $rep->action = 'index';
                }
            }
            else {
                $saved = false;
                jMessage::add(jLocale::get('booster~main.version.saved.failed'));
                $rep->action = 'index';
            }
        } else {
            $saved = false;
            jMessage::add(jLocale::get('booster~main.version.check.failed'));
            $rep->action = 'index';
        }
        return $rep;
    }
    /**
     * EditItem
     */
    function editItem() {
        $id = $this->intParam('id');
        $data = jDao::get('booster~boo_items','booster')->get($id);

        if ($data->item_by != jAuth::getUserSession()->id  or
            ! jAcl2::check('booster.edit.item')) {
            $rep = $this->getResponse('html');
            $rep->bodyTpl = 'jelix~403.html';
            $rep->setHttpStatus('403', 'Permission denied');
            return $rep;
        }
        //if this item is not moderated
        //we'll just display a page with the item + a message to inform the user
        if ( jClasses::getService('booster~booster')->isModerated($id,'items') === false ) {
            $rep = $this->getResponse('html');
            $tpl = new jTpl();

            if(jAuth::isConnected()) {
                $tpl->assign('current_user',jAuth::getUserSession ()->id);
            }
            else {
                $tpl->assign('current_user','');
            }

            $tpl->assign('data',$data);
            $tpl->assign('item_not_moderated',1);
            $rep->body->assign('MAIN',$tpl->fetch('view_item'));
            $rep->body->assign('MENU',$tpl->fetch('menu'));
            return $rep;
        }
        $rec = jClasses::getService("jtags~tags")->getTagsBySubject('booscope', $data->id);

        $tags = implode(',', jClasses::getService("jtags~tags")->getTagsBySubject('booscope', $data->id) ) ;

        $form = jForms::create('booster~items',$data->id);
        $form->initFromDao('booster~boo_items',null, 'booster');
        //$form->initControlFromDao('jelix_versions', 'booster~boo_items_jelix_versions', null, array('id_item', 'id_version'));
        $form->setData('tags',$tags);
        $rep = $this->getResponse('html');
        $tpl = new jTpl();
        $tpl->assign('id',$data->id);
        $tpl->assign('form',$form);
        $tpl->assign('item_not_moderated',0);
        $tpl->assign('action','booster~saveEditItem');
        $rep->body->assign('MAIN',$tpl->fetch('edit_item'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
    /**
     * Save the Edited Item
     */
    function saveEditItem() {
        $id = $this->intParam('id');

        $form = jForms::fill('booster~items',$id);

        if ($form->check()) {
            if ($form->getData('item_by') != jAuth::getUserSession()->id  or
                ! jAcl2::check('booster.edit.item')) {
                $rep = $this->getResponse('html');
                $rep->bodyTpl = 'jelix~403.html';
                $rep->setHttpStatus('403', 'Permission denied');
                return $rep;
            }
            else {
                if ($form->getData('short_desc_fr') == ''  and
                    $form->getData('short_desc') == '' ) {
                    $form->setErrorOn('short_desc',jLocale::get('booster~main.desc.mandatory'));
                    $form->setErrorOn('short_desc_fr',jLocale::get('booster~main.desc.mandatory'));
                    $rep->action='add';
                    return $rep;
                }

                if (jClasses::getService('booster~booster')->saveEditItem($form)) {
                    jMessage::add(jLocale::get('booster~main.item.edit.success'));
                    jEvent::notify('item_edited', array('item_id' => $id));
                }
                else {
                    jMessage::add(jLocale::get('booster~main.item.edit.failed'));
                }
            }
        }
        $rep = $this->getResponse('redirect');
        $rep->action = 'booster~index';
        return $rep;
    }
    /**
     * EditVersion
     */
    function editVersion() {
        $id = $this->intParam('id');
        $data = jDao::get('booster~boo_versions','booster')->get($id);
        $user_id = jDao::get('booster~boo_items','booster')->get($data->item_id)->item_by;

        if ($user_id != jAuth::getUserSession()->id  and
            ! jAcl2::check('booster.edit.version')) {
            $rep = $this->getResponse('html');
            $rep->bodyTpl = 'jelix~403.html';
            $rep->setHttpStatus('403', 'Permission denied');
            return $rep;
        }
        //if this item is not moderated
        //we'll just display a page with the item + a message to inform the user
        if ( jClasses::getService('booster~booster')->isModerated($id,'versions') === false ) {
            $rep = $this->getResponse('html');
            $tpl = new jTpl();

            if(jAuth::isConnected()) {
                $tpl->assign('current_user',jAuth::getUserSession ()->id);
            }
            else {
                $tpl->assign('current_user','');
            }
            $data = jDao::get('booster~boo_items','booster')->get($data->item_id);
            $tpl->assign('data',$data);
            $tpl->assign('item_not_moderated',1);
            $rep->body->assign('MAIN',$tpl->fetch('view_item'));
            $rep->body->assign('MENU',$tpl->fetch('menu'));
            return $rep;
        }

        $form = jForms::create('booster~version',$data->id);
        $form->initFromDao('booster~boo_versions');

        $rep = $this->getResponse('html');
        $tpl = new jTpl();
        $tpl->assign('id',$data->id);
        $tpl->assign('form',$form);
        $tpl->assign('action','booster~saveEditVersion');
        $rep->body->assign('MAIN',$tpl->fetch('edit_version'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;

    }
    /**
     * Save the Edited Version
     */
    function saveEditVersion() {
        $id = $this->intParam('id');
        $form = jForms::fill('booster~version',$id);

        if ($form->check()) {
            $user_id = jDao::get('booster~boo_items','booster')->get($form->getData('item_id'))->item_by;
            if ($user_id != jAuth::getUserSession()->id  and
                ! jAcl2::check('booster.edit.version')) {
                $rep = $this->getResponse('html');
                $rep->bodyTpl = 'jelix~403.html';
                $rep->setHttpStatus('403', 'Permission denied');
                return $rep;
            }
            else {
                if (jClasses::getService('booster~booster')->saveEditVersion($form)) {
                    jMessage::add(jLocale::get('booster~main.version.edit.success'));
                    jEvent::notify('version_edited', array('version_id' => $id));
                }
                else {
                    jMessage::add(jLocale::get('booster~main.version.edit.failed'));
                }
            }
        }
        $rep = $this->getResponse('redirect');
        $rep->action = 'booster~index';
        return $rep;
    }
    /**
     * Cloud
     */
    function cloud () {
        $rep = $this->getResponse('html');

        $tag = $this->param('tag');
        $tag = str_replace(' ', '-', $tag);

        $srvTags = jClasses::getService("jtags~tags");
        $tags = $srvTags->getSubjectsByTags($tag, "booscope");

        $items = array();
        //get factory of the moderated item
        $dao = jDao::get('boo_items','booster');
        // get factory of the item which are waiting for moderation
        $daoMod = jDao::get('boosteradmin~boo_items_mod','booster');
        foreach ($tags as $subj_id) {
            //get record not yet validated
            $rec = $daoMod->get($subj_id);
            //no record found so we can get the still moderated one
            if ( $rec === false )
                $rec = $dao->get($subj_id);
            //status ok ?
            if ($rec->status == 1)
                $items[] = $rec;
        }

        $tpl = new jTpl();
        if(jAuth::isConnected()) {
            $tpl->assign('current_user',jAuth::getUserSession ()->id);
        }
        else {
            $tpl->assign('current_user','');
        }
        $tpl->assign('items',$items);
        $tpl->assign('tag',$tag);
        $tpl->assign('item_not_moderated',0);
        $rep->body->assign('MAIN', $tpl->fetch('tag'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
    /**
     * Display the list of type of ...
     */

    /**
     * ... applications
     */
    function applis () {
        $rep = $this->getResponse('html');
        $rep->title = jLocale::get('booster~main.applis.list');
        $datas = jDao::get('booster~boo_items','booster')->findByTypeId(1);
        $tpl = new jTpl();
        if(jAuth::isConnected()) {
            $tpl->assign('current_user',jAuth::getUserSession ()->id);
        }
        else {
            $tpl->assign('current_user','');
        }
        $tpl->assign('datas', $datas);
        $tpl->assign('item_not_moderated','');
        $rep->body->assign('MAIN',$tpl->fetch('list'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
    /**
     * ... modules
     */
    function modules () {
        $rep = $this->getResponse('html');
        $rep->title = jLocale::get('booster~main.modules.list');
        $datas = jDao::get('booster~boo_items','booster')->findByTypeId(2);
        $tpl = new jTpl();
        if(jAuth::isConnected()) {
            $tpl->assign('current_user',jAuth::getUserSession ()->id);
        }
        else {
            $tpl->assign('current_user','');
        }
        $tpl->assign('datas', $datas);
        $tpl->assign('item_not_moderated','');
        $rep->body->assign('MAIN',$tpl->fetch('list'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
    /**
     * ... plugins
     */
    function plugins () {
        $rep = $this->getResponse('html');
        $rep->title = jLocale::get('booster~main.plugins.list');
        $datas = jDao::get('booster~boo_items','booster')->findByTypeId(3);
        $tpl = new jTpl();
        if(jAuth::isConnected()) {
            $tpl->assign('current_user',jAuth::getUserSession ()->id);
        }
        else {
            $tpl->assign('current_user','');
        }
        $tpl->assign('datas', $datas);
        $tpl->assign('item_not_moderated','');
        $rep->body->assign('MAIN',$tpl->fetch('list'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
    /**
     * ... packlang
     */
    function packlang () {
        $rep = $this->getResponse('html');
        $rep->title = jLocale::get('booster~main.packlang.list');
        $datas = jDao::get('booster~boo_items','booster')->findByTypeId(4);
        $tpl = new jTpl();
        if(jAuth::isConnected()) {
            $tpl->assign('current_user',jAuth::getUserSession ()->id);
        }
        else {
            $tpl->assign('current_user','');
        }
        $tpl->assign('datas', $datas);
        $tpl->assign('item_not_moderated','');
        $rep->body->assign('MAIN',$tpl->fetch('list'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
    /**
     * Display the resources of the current user
     */
    function yourressources () {
        $rep = $this->getResponse('html');
        $rep->title = jLocale::get('booster~main.your.ressources');
        $datas = jDao::get('booster~boo_items','booster')->findAllReportedBy(jAuth::getUserSession ()->id);
        $tpl = new jTpl();
        if(jAuth::isConnected()) {
            $tpl->assign('current_user',jAuth::getUserSession ()->id);
        }
        else {
            $tpl->assign('current_user','');
        }
        $tpl->assign('datas', $datas);
        $rep->body->assign('MAIN',$tpl->fetch('your_ressources'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }

    public function validNewItem(){

        // is the current user is an admin ?
        if (jAuth::isConnected() and jAcl2::check('booster.admin.index') ) {

            $id = $this->param('id');
            jDao::get('booster~boo_items','booster')->setToValidated($id);

        }
        else {
                $rep = $this->getResponse('html');
                $rep->bodyTpl = 'jelix~403.html';
                $rep->setHttpStatus('403', 'Permission denied');
                return $rep;
        }

        $rep = $this->getResponse('redirect');
        $rep->action = 'booster~default:viewItem';
        $rep->params = array('id' => $id, 'name' => $this->param('name'));
        return $rep;
    }

    function credits() {
        $rep = $this->getResponse('html');
        $tpl = new jTpl;
        $rep->body->assign('MAIN',$tpl->fetch('credits'));
        return $rep;
    }

}
