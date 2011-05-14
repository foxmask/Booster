<?php
/**
* @package   booster
* @subpackage boosteradmin
* @author    Olivier Demah
* @copyright 2011 olivier demah
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

class boosteradminmenuListener extends jEventListener{

    function onmasteradminGetMenuContent ($event) {
        global $gJConfig;
        $chemin = $gJConfig->urlengine['basePath'].'booster/admin/';
        if ( jAcl2::check('booster.admin.index')) {
            $event->add(new masterAdminMenuItem('booster','Booster', '', 20));

            $item = new masterAdminMenuItem('items',
                        jLocale::get('boosteradmin~admin.items'),
                        jUrl::get('boosteradmin~items:index'),
                        301,
                        'booster');
            $item->icon = $chemin . 'images/items.png';
            $event->add($item);

            $item = new masterAdminMenuItem('versions',
                        jLocale::get('boosteradmin~admin.versions'),
                        jUrl::get('boosteradmin~versions:index'),
                        302,
                        'booster');
            $item->icon = $chemin . 'images/versions.png';
            $event->add($item);
        }
    }

    function onmasterAdminGetDashboardWidget ($event) {
        if ( jAcl2::check('booster.admin.index')) {
            $box = new masterAdminDashboardWidget();
            $box->title = jLocale::get('boosteradmin~admin.task.todo');
            $box->content = jZone::get('boosteradmin~tasktodo');
            $event->add($box);
        }
    }

    function onmasteradminGetInfoBoxContent ($event) {
        if ( jAcl2::check('booster.admin.index')) {
            $event->add(new masterAdminMenuItem('portal',
                jLocale::get('boosteradmin~admin.back.to.website'),
                jUrl::get('booster~default:index'),
                100,
                'booster'));
        }
    }
}
