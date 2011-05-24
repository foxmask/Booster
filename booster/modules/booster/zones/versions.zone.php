<?php
/**
* @package   booster
* @subpackage booster
* @author    Olivier Demah
* @copyright 2011 Olivier Demah
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

class versionsZone extends jZone {
    protected $_tplname='zone.versions';

    protected function _prepareTpl(){
        $item_id = (int) $this->getParam('id');
        $ctrl=''; $method = '';
        //check which method and controller do the call of this zone
        if ( array_key_exists('action',$GLOBALS['gJCoord']->request->params) )
            list($ctrl,$method) = preg_split('/:/',$GLOBALS['gJCoord']->request->params['action']);
        $nbRec= 0;
        if (($ctrl == 'default' and $method !== 'viewItem') OR ( empty($ctrl) and empty($method))) {
            $datas = jDao::get('booster~boo_versions')->findLastValidated($item_id);
        } elseif ($ctrl == 'default' and $method == 'viewItem')  {
            $datas = jDao::get('booster~boo_versions')->findAllValidated($item_id);
        }
        $this->_tpl->assign('versions',$datas);
    }
}
