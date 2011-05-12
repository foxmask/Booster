<?php
/**
* @package   booster
* @subpackage booster
* @author    Olivier Demah
* @copyright 2011 olivier demah
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

class defaultCtrl extends jController {
    public $pluginParams = array(
        '*'     => array('auth.required'=>true,),
        'index' => array('auth.required'=>false,),
        'viewItem' => array('auth.required'=>false,),

    );
    function index() {
        $rep = $this->getResponse('html');
        $dao = jDao::get('booster~boo_items');
        $tpl = new jTpl();
        $tpl->assign('datas',$dao->findAll());
        $rep->body->assign('PAGE','home');
        $rep->body->assign('MAIN',$tpl->fetch('index'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
    function viewItem() {
        $rep = $this->getResponse('html');
        $data = jDao::get('booster~boo_items')->get( $this->param('id') );
        $tpl = new jTpl();
        $tpl->assign('data',$data);
        $rep->body->assign('PAGE','view');
        $rep->body->assign('MAIN',$tpl->fetch('view_item'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
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
    function saveItem() {
        $rep = $this->getResponse('redirect');
        $form = jForms::fill('booster~items');
        if ($form->check()) {
            if (jClasses::getService('booster~booster')->saveItem()) {
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

        $rep->action = ($saved) ? 'booster~addVersion' : 'booster~index';
        return $rep;
    }

    function addVersion() {
        $rep = $this->getResponse('html');
        $rep->title .= jLocale::get('booster~main.add.a.version');
        $form = jForms::create('booster~versions');
        $form->setData('item_by',jAuth::getUserSession()->id);
        $tpl = new jTpl();
        $tpl->assign('form',$form);
        $rep->body->assign('MAIN',$tpl->fetch('add_version'));
        $rep->body->assign('MENU',$tpl->fetch('menu'));
        return $rep;
    }
    function saveVersion() {
        $rep = $this->getResponse('redirect');
        $form = jForms::fill('booster~version');
        if ($form->check()) {
            if ($form->saveToDao('booster~boo_versions')) {
                jMessage::add('booster~main.version.saved');
                $saved = true;
                $rep->action = 'viewItem';
                $rep->param = array('id'=>jDao::get('booster~boo_items')->get($this->param('item_id'))->id);
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
}
