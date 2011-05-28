<?php
/**
* @package   booster
* @subpackage
* @author    laurentj
* @copyright 2011 laurent
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/


require_once (JELIX_LIB_CORE_PATH.'response/jResponseHtml.class.php');

class myHtmlResponse extends jResponseHtml {

    public $bodyTpl = 'booster~main';

    function __construct() {
        parent::__construct();
    }

    protected function doAfterActions() {
        global $gJConfig, $gJCoord;
        $this->body->assignIfNone('MAIN','<p>no content</p>');
        $this->body->assignIfNone('MENU','');
        $title = $gJConfig->booster['title'];
        if ($this->title)
            $this->title = $this->title .' | '. $title;
        else
            $this->title = $title;

        $this->body->assign('is_home', false);
        $this->body->assign('tout', false);
        $this->body->assign('applis', false);
        $this->body->assign('modules', false);
        $this->body->assign('plugins', false);
        $this->body->assign('packlang', false);
         $this->body->assign('your_ressources', false);

        if ( array_key_exists('module', $gJCoord->request->params) ) {
            if ( $gJCoord->request->params['module'] == 'booster' ) {
                if (array_key_exists('action',$gJCoord->request->params)) {
                    if ($gJCoord->request->params['action'] == 'default:index' ) {
                        $this->body->assign('is_home'   ,true);
                        $this->body->assign('tout'      ,true);
                    } elseif($gJCoord->request->params['action'] == 'default:applis' ) {
                        $this->body->assign('applis'    ,true);
                    } elseif($gJCoord->request->params['action'] == 'default:modules' ) {
                        $this->body->assign('modules'   ,true);
                    } elseif($gJCoord->request->params['action'] == 'default:plugins' ) {
                        $this->body->assign('plugins'   ,true);
                    } elseif($gJCoord->request->params['action'] == 'default:packlang' ) {
                        $this->body->assign('packlang'  ,true);
                    } elseif($gJCoord->request->params['action'] == 'default:yourressources' ) {
                        $this->body->assign('your_ressources'  ,true);
                    }
                }
            }
            elseif ( $gJCoord->request->params['module'] == 'jcommunity' ) {
                $this->body->assign('is_home'   ,false);
                $this->body->assign('tout'      ,false);
            }
        }
        else {
            $this->body->assign('is_home'   ,true);
            $this->body->assign('tout'      ,true);
        }

    }
}
