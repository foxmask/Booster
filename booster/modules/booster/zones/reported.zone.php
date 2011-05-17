<?php
/**
* @package   booster
* @subpackage booster
* @author    laurentj
* @copyright 2011 laurent
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

class reportedZone extends jZone {
    protected $_tplname='zone.reported';

    protected function _prepareTpl(){
        $this->_tpl->assign('items', jDao::get('boo_items')->findAllReportedBy(jAuth::getUserSession ()->id));
    }
}
