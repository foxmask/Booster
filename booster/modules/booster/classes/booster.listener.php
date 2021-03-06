<?php
/**
* @package   booster
* @subpackage boosteradmin
* @author    Olivier Demah
* @copyright 2011 olivier demah
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

class boosterListener extends jEventListener{

    function onBoosterTaskTodo ($event) {
        if ( jAcl2::check('booster.admin.index')) {
            // data that have been created
            $notify  = jDao::get('booster~boo_items','booster')->findAllNotModerated();
            $nbRec = $notify->rowCount();
            if ($nbRec > 0 ) {
                $link = '<a href="'.jUrl::get('boosteradmin~items:index').'">';
                if($nbRec == 1)
                    $link .= jLocale::get('boosteradmin~admin.new.item');
                else
                    $link .= jLocale::get('boosteradmin~admin.new.items',$nbRec);
                $link .= '</a>';
                $event->add( $link );
            }
            $notify  = jDao::get('booster~boo_versions','booster')->findAllNotModerated();
            $nbRec = $notify->rowCount();
            if ($nbRec > 0 ) {
                $link = '<a href="'.jUrl::get('boosteradmin~versions:index').'">';
                if($nbRec == 1)
                    $link .= jLocale::get('boosteradmin~admin.new.version');
                else
                    $link .= jLocale::get('boosteradmin~admin.new.versions',$nbRec);
                $link .= '</a>';
                $event->add( $link );
            }
            // data that have been modified
            $notify  = jDao::get('boosteradmin~boo_items_modifs','booster')->findGroupedByItemId();
            $nbRec = $notify->rowCount();
            if ($nbRec > 0 ) {
                $link = '<a href="'.jUrl::get('boosteradmin~items:index').'">';
                if($nbRec == 1)
                    $link .= jLocale::get('boosteradmin~admin.notification.item');
                else
                    $link .= jLocale::get('boosteradmin~admin.notification.items',$nbRec);
                $link .= '</a>';
                $event->add( $link );
            }
            $notify  = jDao::get('boosteradmin~boo_versions_modifs','booster')->findGroupedByVersionId();
            $nbRec = $notify->rowCount();
            if ($nbRec > 0 ) {
                $link = '<a href="'.jUrl::get('boosteradmin~versions:index').'">';
                if($nbRec == 1)
                    $link .= jLocale::get('boosteradmin~admin.notification.version');
                else
                    $link .= jLocale::get('boosteradmin~admin.notification.versions',$nbRec);
                $link .= '</a>';
                $event->add( $link );
            }
        }
    }
}
