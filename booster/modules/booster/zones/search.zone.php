<?php
/**
* @package   booster
* @subpackage booster
* @author    laurentj
* @copyright 2011 laurent
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

class searchZone extends jZone {
    protected $_tplname='search';

    protected function _prepareTpl(){
        
        $form = jForms::get('booster~search');
        if(!$form)
            $form = jForms::create('booster~search');
        
        $this->_tpl->assign('form', $form);
        $this->_tpl->assign('submitAction', 'booster~default:index');
    }
}
