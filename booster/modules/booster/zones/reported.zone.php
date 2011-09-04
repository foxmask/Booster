<?php
/**
* @package   booster
* @subpackage booster
* @author    Florian Lonqueu-Brochard
* @copyright 2011 Florian Lonqueu-Brochard
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

class reportedZone extends jZone {
    protected $_tplname='zone.reported';

    protected $number_to_display = 5;

    protected function _prepareTpl(){

        $datas = jDao::get('boo_items','booster')->findAllReportedBy(jAuth::getUserSession ()->id);

        $items= array(); $i = 0;
        foreach($datas as $data){
            if($i >= $this->number_to_display)
                break;
            $items[] = $data;
            $i++;
        }

        $this->_tpl->assign('more', $i == $this->number_to_display);
        $this->_tpl->assign('selected', $this->param('selected', false));
        $this->_tpl->assign('items', $items);
    }
}
