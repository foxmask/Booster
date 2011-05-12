<?php
/**
* @package   booster
* @subpackage booster
* @author    Olivier Demah
* @copyright 2011 olivier demah
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/
/**
 * Class that handle the booster business stuff
 */
class booster {

    function saveItem() {
        $form = jForms::fill('booster~items');
        $dao = jDao::get('booster~boo_items');
        $record = jDao::createRecord('booster~boo_items');
        $record->name = $form->getData('name');
        $record->item_info_id = $form->getData('item_info_id');
        $record->short_desc = $form->getData('short_desc');
        $record->type_id = $form->getData('type_id');
        $record->url_website = $form->getData('url_website');
        $record->url_repo = $form->getData('url_repo');
        $record->author = $form->getData('author');
        $record->item_by = $form->getData('item_by');
        $dao->insert($record);
        $id_booster = $record->id;

        $tagStr ='';
        $tagStr = str_replace('.',' ',$form->getData("tags"));
        $tags = explode(",", $tagStr);

        jClasses::getService("jtags~tags")->saveTagsBySubject($tags, 'booscope', $id_booster);
    }

    function saveVersion() {

        $dao = jDao::get('booster~boo_version');
        $record = jDao::createRecord('booster~boo_version');
        $record->name = $form->getData('name');
        $record->item_info_id = $form->getData('item_info_id');
        $record->short_desc = $form->getData('short_desc');
        $record->type_id = $form->getData('type_id');
        $record->url_website = $form->getData('url_website');
        $record->url_repo = $form->getData('url_repo');
        $record->author = $form->getData('author');
        $record->item_by = $form->getData('item_by');
        $dao->insert($record);
        $id_booster = $record->id;
    }
}
