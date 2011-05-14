<?php
/**
* @package   booster
* @subpackage boosteradmin
* @author    Olivier Demah
* @copyright 2011 olivier demah
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

class tasktodoZone extends jZone {
    protected $_tplname='zone.tasktodo';

    protected function _prepareTpl(){
        $ev = jEvent::notify('BoosterTaskTodo');
        $tasks = $ev->getResponse();
        $this->_tpl->assign('tasks',$tasks);
    }
}
