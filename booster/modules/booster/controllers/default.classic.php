<?php
/**
* @package   booster
* @subpackage booster
* @author    Olivier Demah
* @copyright 2011 olivier demah
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/
/**
 *Main controler to handle add/edit of the public actions of the Booster
 */
class defaultCtrl extends jController {
    public $pluginParams = array(
        '*'     => array('auth.required'=>true,),
        'index' => array('auth.required'=>false,),
        'viewItem' => array('auth.required'=>false,),
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

        $dao = jDao::get('booster~boo_items');
        $tpl->assign('datas',$dao->findAll());
        $rep->body->assign('PAGE','home');
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

        $data = jDao::get('booster~boo_items')->get( $this->param('id') );

        if ($data->status == 0) {
            $rep = $this->getResponse('html',true);
            $rep->bodyTpl = 'jelix~404.html';
            $rep->setHttpStatus('404', 'Not Found');
            return $rep;
        }

        $rep = $this->getResponse('html');
        $rep->addJSLink($GLOBALS['gJConfig']->urlengine['basePath'].'jelix/jquery/jquery.js');
        $tpl->assign('data',$data);
        $rep->body->assign('PAGE','view');
        $rep->body->assign('MAIN',$tpl->fetch('view_item'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
    /**
     * Add an Item
     */
    function add() {
        $rep = $this->getResponse('html');
        $rep->title .= jLocale::get('booster~main.add.an.item');
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
            if ($data = jClasses::getService('booster~booster')->saveItem()) {
                jMessage::add('booster~main.item.saved');
                $saved = true;
            }
            else {
                $saved = false;
                jMessage::add('booster~main.item.saved.failed');
            }
        } else {
            $saved = false;
            jMessage::add('booster~main.item.check.failed');
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
        $rep->title .= jLocale::get('booster~main.add.a.version');
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
            if (jClasses::getService('booster~booster')->saveVersion($form)) {
                jMessage::add('booster~main.version.saved');
                $saved = true;
                $item = jDao::get('booster~boo_items')->get($form->getData('item_id'));
                if ($item->status = 1) {
                    $rep->action = 'viewItem';
                    $rep->params = array('id'=> $item->id,'name'=>$item->name);
                }
                else {
                    $rep->action = 'index';
                }
            }
            else {
                $saved = false;
                jMessage::add('booster~main.version.saved.failed');
                $rep->action = 'index';
            }
        } else {
            $saved = false;
            jMessage::add('booster~main.version.check.failed');
            $rep->action = 'index';
        }
        return $rep;
    }
    /**
     * EditItem
     */
    function editItem() {
        //@TODO
        $rep = $this->getResponse('html');
        $rep->body->assign('MAIN',' come here and complete the code;) =>'.__FILE__ . ' '. __LINE__ );
        return $rep;
    }
    /**
     * Save the Edited Item
     */
    function saveEditItem() {
        //@TODO
        // using // using jClasses::getService('booster~booster')->saveEditItem($form)
    }
    /**
     * EditItem
     */
    function editVersion() {
        //@TODO
        $rep = $this->getResponse('html');
        $rep->body->assign('MAIN',' come here and complete the code;) =>'.__FILE__ . ' '. __LINE__ );
        return $rep;

    }
    /**
     * Save the Edited Version
     */
    function saveEditVersion() {
        //@TODO
        // using jClasses::getService('booster~booster')->saveEditVersion($form)
    }
}
