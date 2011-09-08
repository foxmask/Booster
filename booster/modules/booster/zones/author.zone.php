<?php
/**
* @package   booster
* @subpackage booster
* @author    Olivier Demah
* @copyright 2011 Olivier Demah
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

class authorZone extends jZone {
    
    protected $_useCache = true;
    
    protected function _createContent(){
        return htmlspecialchars(jDao::get('jcommunity~user', 'hfnu')->getById((int) $this->getParam('id'))->nickname);
    }
}
