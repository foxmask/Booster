<?php
/**
* @package   booster
* @subpackage booster
* @author    Florian Lonqueu-Brochard
* @copyright 2011 Florian Lonqueu-Brochard
* @link      http://www.jelix.org
* @license    All rights reserved
*/

class itemimageZone extends jZone {

    protected function _createContent(){
    	$image_name = md5('id:'.$this->param('id',0)).'.png';
		$path = jApp::wwwpath('images-items/'.$image_name);
		if(!file_exists($path)){
			$image_name = 'default.png';
		}

		return '<img src="'.$GLOBALS['gJConfig']->urlengine['basePath'].'images-items/'.$image_name.'"/>';
    }
}
