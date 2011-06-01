<?php
/**
* @package   booster
* @subpackage booster
* @author    laurentj
* @copyright 2011 laurent
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

class jelix_versionsZone extends jZone {
    protected $_tplname='zone.jelix_versions';

    protected function _prepareTpl(){
        
        $this->_tpl->assign('jelix_versions', jDao::get('boo_items_jelix_versions')->findByItem($this->param('id')));
    }
}
