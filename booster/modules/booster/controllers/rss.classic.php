<?php
/**
* @package   booster
* @subpackage booster
* @author    Florian Lonqueu-Brochard
* @copyright 2011 Florian Lonqueu-Brochard
* @link      http://www.jelix.org
* @license    All rights reserved
*/

class rssCtrl extends jController {

    /**
    * renvoit un flux contenant les 20 derniers elements validés
    */
    function index() {
        $rep = $this->getResponse('rss2.0');

        $lang = $GLOBALS['gJConfig']->locale;

        $rep->infos->title = 'Booster.jelix.org';
        $rep->infos->webSiteUrl= 'http://booster.jelix.org';
        $rep->infos->copyright = 'Copyright 2011-'.date('Y').' booster.jelix.org';
        $rep->infos->description = jLocale::get('booster~main.feed.last.items');
        $rep->infos->ttl=120;


        $items = jDao::get('boo_items')->findLastCreated(20);
        $first = true;
        foreach($items as $data){
            if($first){
                $rep->infos->updated = $data->date_version;
                $rep->infos->published = $data->date_version;
                $first=false;
            }

            $url = jUrl::getFull('booster~default:viewItem', array('id'=>$data->id, 'name'=>$data->name));

            $item = $rep->createItem($data->name, $url, $data->date_version);

            $item->authorName = $data->author;


            if(($lang == 'fr_FR' && $data->short_desc_fr != '') || $data->short_desc == '')
                $item->content =  $data->short_desc_fr;
            else
                $item->content = $data->short_desc;
            $renderer = new jWiki();
            $item->content = $renderer->render($item->content);

            $item->contentType='html';

            $item->idIsPermalink = true;
            $rep->addItem($item);
        }

        return $rep;
    }
}

