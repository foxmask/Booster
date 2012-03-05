<?php
/**
* @package   booster
* @subpackage booster
* @author    Florian Lonqueu-Brochard
* @copyright 2011 Florian Lonqueu-Brochard
* @link      http://www.jelix.org
* @license    All rights reserved
*/

class item_githubZone extends jZone {
    protected $_tplname='zone.item_github';

    protected $_useCache = true;
    protected $_cacheTimeout = 3600;//1 heure


    protected function _prepareTpl(){

    	jClasses::inc('booster~boosterGithub');

		$url_repo = $this->param('url_repo');

		$m = array();
		preg_match('#https?://github.com/([^/]*)/([^/]*)/?(.+)#', $url_repo, $m);

        if(empty($m[1]) OR empty($m[2]) OR !empty($m[3])){//invalid github repo url
            $this->_tpl->assign('not_ok', true); 
            return;
        }

        $user = $m[1];
        $repo = $m[2];

        $filtered = preg_replace('@[^a-zA-Z0-9_]@', '_', array($repo, $user));
		$key = 'github_'.$filtered[0].'_'.$filtered[1].'_';

    	//$last_commit = boosterGithub::getLastCommit($user, $repo);
    	//jLog::dump($last_commit, 'last_commit');

    	
    	$forks = jCache::get($key.'forks');
    	$watchers = jCache::get($key.'watchers');
    	$update = jCache::get($key.'update');
    	if($forks === false || $watchers === false || $update === false){
			$infos = boosterGithub::getRepoInfos($user, $repo);
			$forks = $infos->forks;
			$watchers = $infos->watchers;
			$update = $infos->updated_at;
			jCache::set($key.'forks', $forks, 86400);//1jour
			jCache::set($key.'watchers', $watchers, 86400);//1jour
			jCache::set($key.'update', $update, 86400);//1jour
    	}
    	$this->_tpl->assign('forks', $forks);
    	$this->_tpl->assign('watchers', $watchers); 
    	$this->_tpl->assign('update', $update); 


    	$activity = jCache::get($key.'activity');
    	if($activity === false){
    		$activity = boosterGithub::getRepositoryActivity($user, $repo);
    		jCache::set($key.'activity', $activity, 129600);//1jour et demi
    	}
    	$this->_tpl->assign('activity',$activity);


    }
}
