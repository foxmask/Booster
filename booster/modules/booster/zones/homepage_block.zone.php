<?php
/**
* @package   booster
* @subpackage booster
* @author    Florian Lonqueu-Brochard
* @copyright 2011 Florian Lonqueu-Brochard
* @link      http://www.jelix.org
* @license    All rights reserved
*/

class homepage_blockZone extends jZone {
    protected $_tplname='zone.homepage_block';

    public static $nb_to_display = 5;

    protected function _prepareTpl(){
        
        $type= $this->param('type');
        
        $dao = jDao::get('boo_items');
        $this->_tpl->assign('results', $dao->findLastCreatedByTypeId($type, self::$nb_to_display));
        
        $this->_tpl->assign('nb_to_display', self::$nb_to_display);
    }
}
