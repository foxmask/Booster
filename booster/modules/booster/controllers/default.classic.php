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
                $rep->body->assign('is_search', true);
            }
        }
        $rep->body->assign('MAIN',$tpl->fetch('index'));
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

        $data = jDao::get('booster~boo_items','booster')->get($this->intParam('id', 0));
        // is the current user the author or the admin ?
        if ($this->userIsAdminOrAuthor($data->item_by)) {
            //so let's warn him if the item is moderated or not
            $tpl->assign('item_not_moderated',!$data->status);
        //the status is "not moderated" we dont display the item => 404
        } elseif (!$data || $data->status == 0) {
            return $this->get404();
        }

        $rep = $this->getResponse('html');
        $tpl->assign('data',$data);
        $tpl->assign('is_admin', jAcl2::check('booster.admin.index'));
        $rep->title = $data->name;
        $rep->body->assign('MAIN',$tpl->fetch('view_item'));
        return $rep;
    }


    /**
     * Initialisation de l'ajout d'un item
     */
    function _add() {
        $rep = $this->getResponse('redirect');
        $rep->action = 'booster~default:add';
        jForms::create('booster~items');
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
                $rep->action='booster~default:add';
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
        }
        $rep->params = array('id'=>$data['id'],'name'=>$data['name']);
        $rep->action = ($saved) ? 'booster~default:addVersion' : 'booster~default:add';
        return $rep;
    }


    /**
     * Initialisation de l'ajout d'une version
     */
    function _addVersion() {
        $rep = $this->getResponse('redirect');
        $rep->action = 'booster~default:addVersion';
        $rep->params = array('id' => $this->intParam('id', 0), 'name' => $this->param('name', ''));
        jForms::create('booster~version');
        return $rep;
    }


    /**
     * Add a Version to the current Item
     */
    function addVersion() {
        $rep = $this->getResponse('html');
        $rep->title = jLocale::get('booster~main.add.a.version');

        $form = jForms::get('booster~version');
        if ($form === null)
            $form = jForms::create('booster~version');

        $form->setData('item_by',jAuth::getUserSession()->id);
        $form->setData('item_id',$this->intParam('id'));

        $tpl = new jTpl();
        $tpl->assign('itemName',$this->param('name'));
        $tpl->assign('itemId',$this->intParam('id'));
        $tpl->assign('form',$form);
        $rep->body->assign('MAIN',$tpl->fetch('add_version'));
        return $rep;
    }


    /**
     * Save a Version
     */
    function saveVersion() {
        $rep = $this->getResponse('redirect');
        $form = jForms::fill('booster~version');
        if ($form->check()) {
            // let's clean the filename
            // remove slashes
            $fileName = stripslashes($form->getData('filename'));
            // remove special chars
            // see http://php.net/filter_var
            // http://www.phpro.org/tutorials/Filtering-Data-with-PHP.html
            $fileName = filter_var($fileName, FILTER_SANITIZE_SPECIAL_CHARS ,
                                array('flags' => FILTER_FLAG_STRIP_HIGH|FILTER_FLAG_STRIP_LOW)
                    );
            // a filename dont have to have a slash in its name
            if ( strpos($fileName,'/') > 0  or strpos($fileName,'\\') > 0 ) {
                $form->setErrorOn('filename', jLocale::get('booster~main.invalid.filename'));
                $saved= false;
            }
            else{
                $form->setData('filename',$fileName);
                $data = jClasses::getService('booster~booster')->saveVersion($form);
                if ($data) {
                    jMessage::add(jLocale::get('booster~main.version.saved'));
                    jEvent::notify('new_version_added', array('version_id' => $data));
                    jForms::destroy('booster~version');
                    $saved = true;
                    $item = jDao::get('booster~boo_items','booster')->get($form->getData('item_id'));
                    $rep->params = array('id'=> $item->id,'name'=>$item->name);
                }
                else {
                    $saved = false;
                    jMessage::add(jLocale::get('booster~main.version.saved.failed'));
                }
            }
        } else {
            $saved = false;
            jMessage::add(jLocale::get('booster~main.version.check.failed'));
        }
        $rep->params=array(
                   'id'=>$this->param('itemId'),
                   'name'=>$this->param('itemName')
                   );
        $rep->action = $saved ? 'booster~default:viewItem' : 'booster~default:addVersion';
        return $rep;
    }


    /**
     * EditItem
     */
    function editItem() {
        $id = $this->intParam('id');
        $data = jDao::get('booster~boo_items','booster')->get($id);

        if (!$this->userCanEditOrIsAuthor($data->item_by, 'item')) {
            return $this->get403();
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
        return $rep;
    }


    /**
     * Save the Edited Item
     */
    function saveEditItem() {
        $id = $this->intParam('id');

        $form = jForms::fill('booster~items',$id);

        if ($form->check()) {
            if (!$this->userCanEditOrIsAuthor($form->getData('item_by'), 'item')) {
                return $this->get403();
            }
            else {
                if ($form->getData('short_desc_fr') == ''  and
                    $form->getData('short_desc') == '' ) {
                    $form->setErrorOn('short_desc',jLocale::get('booster~main.desc.mandatory'));
                    $form->setErrorOn('short_desc_fr',jLocale::get('booster~main.desc.mandatory'));
                    $saved=false;
                }

                if (jClasses::getService('booster~booster')->saveEditItem($form)) {
                    jMessage::add(jLocale::get('booster~main.item.edit.success'));
                    jEvent::notify('item_edited', array('item_id' => $id));
                    $saved = true;
                }
                else {
                    jMessage::add(jLocale::get('booster~main.item.edit.failed'));
                    $saved = false;
                }
            }
        }
        else{
            $saved = false;
        }

        $rep = $this->getResponse('redirect');
        $rep->action = $saved ? 'booster~default:viewItem' : 'booster~default:editItem';
        return $rep;
    }


    /**
     * EditVersion
     */
    function editVersion() {
        $id = $this->intParam('id');
        $data = jDao::get('booster~boo_versions','booster')->get($id);
        $user_id = jDao::get('booster~boo_items','booster')->get($data->item_id)->item_by;

        if (!$this->userCanEditOrIsAuthor($user_id, 'version')) {
            return $this->get403();
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
            return $rep;
        }

        $form = jForms::get('booster~version',$data->id);
        // if not
        if ($form === null) {
        // ... create it
            $form = jForms::create('booster~version',$data->id);
            $form->initFromDao('booster~boo_versions');
        }
        $rep = $this->getResponse('html');
        $tpl = new jTpl();
        $tpl->assign('id',$data->id);
        $tpl->assign('form',$form);
        $tpl->assign('action','booster~saveEditVersion');
        $rep->body->assign('MAIN',$tpl->fetch('edit_version'));
        return $rep;

    }
    /**
     * Save the Edited Version
     */
    function saveEditVersion() {
        $id = $this->intParam('id');
        $form = jForms::fill('booster~version',$id);

        if ($form->check()) {
            // let's clean the filename
            // remove slashes
            $fileName = stripslashes($form->getData('filename'));
            // remove special chars
            // see http://php.net/filter_var
            // http://www.phpro.org/tutorials/Filtering-Data-with-PHP.html
            $fileName = filter_var($fileName, FILTER_SANITIZE_SPECIAL_CHARS ,
                                array('flags' => FILTER_FLAG_STRIP_HIGH|FILTER_FLAG_STRIP_LOW)
                    );
            // a filename dont have to have a slash in its name
            if ( strpos($fileName,'/') > 0  or strpos($fileName,'\\') > 0 ) {
                $form->setErrorOn('filename', jLocale::get('booster~main.invalid.filename'));
                $saved = false;
            }
            $form->setData('filename',$fileName);
            $user_id = jDao::get('booster~boo_items','booster')->get($form->getData('item_id'))->item_by;
            if (!$this->userCanEditOrIsAuthor($user_id, 'version')) {
                return $this->get403();
            }
            else {
                if (jClasses::getService('booster~booster')->saveEditVersion($form)) {
                    jMessage::add(jLocale::get('booster~main.version.edit.success'));
                    jEvent::notify('version_edited', array('version_id' => $id));
                    jForms::destroy('booster~version');
                    $saved = true;
                }
                else {
                    jMessage::add(jLocale::get('booster~main.version.edit.failed'));
                    $saved = false;
                }
            }
        }
        else{
            $saved = false;
        }
        $rep = $this->getResponse('redirect');
        $rep->params= $saved ? array('id' => $form->getData('item_id')) : array('id'=>$id);
        $rep->action = $saved ? 'booster~default:viewItem': 'booster~default:editVersion';
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
        $rep->body->assign('MAIN', $tpl->fetch('tag'));
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
        $rep->body->assign('MAIN',$tpl->fetch('list'));
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
        $rep->body->assign('MAIN',$tpl->fetch('list'));
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



    // REFACTORING

    protected function get404(){
        $rep = $this->getResponse('html',true);
        $rep->bodyTpl = 'jelix~404.html';
        $rep->setHttpStatus('404', 'Not Found');
        return $rep;
    }

    protected function get403(){
        $rep = $this->getResponse('html');
        $rep->bodyTpl = 'jelix~403.html';
        $rep->setHttpStatus('403', 'Permission denied');
        return $rep;
    }

    protected function userIsAdminOrAuthor($user_id){
        if(!jAuth::isConnected())
            return false;

        return ($user_id == jAuth::getUserSession()->id) OR jAcl2::check('booster.admin.index');
    }

    protected function userCanEditOrIsAuthor($user_id, $type = 'item'){
        if(!jAuth::isConnected())
            return false;

        return ($user_id == jAuth::getUserSession()->id) OR jAcl2::check('booster.edit.' . $type);
    }


}
