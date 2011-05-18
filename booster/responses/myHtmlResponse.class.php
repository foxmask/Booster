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
        global $gJConfig;
        $this->body->assignIfNone('MAIN','<p>no content</p>');
        $this->body->assignIfNone('MENU','');
        $title = $gJConfig->booster['title'];
        if ($this->title)
            $this->title = $title . ' - ' . $this->title;
        else
            $this->title = $title;
    }
}
