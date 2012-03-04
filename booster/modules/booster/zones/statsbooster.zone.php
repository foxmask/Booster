<?php
/**
* @package   booster
* @subpackage booster
* @author    Florian Lonqueu-Brochard
* @copyright 2011 Florian Lonqueu-Brochard
* @link      http://www.jelix.org
* @license    All rights reserved
*/

class statsboosterZone extends jZone {
    protected $_tplname='zone.statsbooster';

    protected function _prepareTpl(){



    	

    	$nb_items = jCache::get('statsbooster_nbitems');
    	if($nb_items === false){
    		$cnx = jDb::getConnection();
			$sql = 'SELECT count(*) as count FROM ' . $cnx->prefixTable('boo_items') . ' WHERE status = 1';
    		$rs = $cnx->query($sql)->fetch();
    		$nb_items = $rs->count;
    		jCache::set('statsbooster_nbitems', $nb_items, 86400);//1jour
    	}
    	$this->_tpl->assign('nb_items',$nb_items);

    	$nb_versions = jCache::get('statsbooster_nbversions');
    	if($nb_versions === false){
    		$cnx = jDb::getConnection();
			$sql = 'SELECT count(*) as count FROM ' . $cnx->prefixTable('boo_versions') . ' WHERE status = 1';
    		$rs = $cnx->query($sql)->fetch();
    		$nb_versions = $rs->count;
    		jCache::set('statsbooster_nbversions', $nb_versions, 86400);//1jour
    	}
    	$this->_tpl->assign('nb_versions',$nb_versions);


    }
}
