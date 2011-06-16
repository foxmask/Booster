<?php
/**
* @package   booster
* @subpackage booster
* @author    Olivier Demah, Florian Lonqueu-Brochard
* @copyright 2011 Olivier Demah, Florian Lonqueu-Brochard
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/
/**
 * Class that handle the booster business stuff
 */
class booster {
    /**
     * function to save one Item
     */
    function saveItem() {
        $data = array();
        $id_booster = 0;

        $form = jForms::fill('booster~items');
        $dao = jDao::get('booster~boo_items');
        $record = jDao::createRecord('booster~boo_items');
        $record->name           = $form->getData('name');
        $record->item_info_id   = $form->getData('item_info_id');
        $record->short_desc     = $form->getData('short_desc');
        $record->type_id        = $form->getData('type_id');
        $record->url_website    = $form->getData('url_website');
        $record->url_repo       = $form->getData('url_repo');
        $record->author         = $form->getData('author');
        $record->item_by        = $form->getData('item_by');
        $record->status         = 0; //will need moderation

        if ($dao->insert($record)) {
            $id_booster = $record->id;
            $data['id']     = $id_booster;
            $data['name']   = $form->getData('name');
        }

        if ($id_booster != 0) {
            $tagStr ='';
            $tagStr = str_replace('.',' ',$form->getData("tags"));
            $tags = explode(",", $tagStr);

            jClasses::getService("jtags~tags")->saveTagsBySubject($tags, 'booscope', $id_booster);
        }

        return $data;
    }
    /**
     * function to save one Version
     * @param object $form
     * @return boolean
     */
    function saveVersion($form) {
        $dao = jDao::get('booster~boo_versions');
        $record = jDao::createRecord('booster~boo_versions');
        $record->version_name   = $form->getData('version_name');
        $record->status         = 0; //will need moderation
        $record->item_id        = $form->getData('item_id');
        $record->last_changes   = $form->getData('last_changes');
        $record->stability      = $form->getData('stability');
        $record->filename       = $form->getData('filename');
        $record->download_url   = $form->getData('download_url');
        return ($dao->insert($record)) ? true : false;
    }
    /**
     * function to save one Editing Item
     * to the dedicated "waiting table"
     */
    function saveEditItem($form) {
        $data = array();
        $id_booster = $form->getData('id');
        $dt = new jDateTime();
        $dt->now();

        $dao = jDao::get('boosteradmin~boo_items_mod');
        $record = jDao::createRecord('boosteradmin~boo_items');
        $record->id             = $id_booster;
        $record->name           = $form->getData('name');
        $record->item_info_id   = $form->getData('item_info_id');
        $record->short_desc     = $form->getData('short_desc');
        $record->type_id        = $form->getData('type_id');
        $record->url_website    = $form->getData('url_website');
        $record->url_repo       = $form->getData('url_repo');
        $record->author         = $form->getData('author');
        $record->item_by        = $form->getData('item_by');
        $record->tags           = $form->getData("tags");
        $record->status         = 0; //will need moderation
        $record->created        = jDao::get('booster~boo_items')->get($id_booster)->created;
        $record->modified       = $dt->toString(jDateTime::DB_DTFORMAT);

        $return = ($dao->insert($record)) ? true : false;

        $form->saveControlToDao('jelix_versions', 'booster~boo_items_jelix_versions', null, array('id_item', 'id_version'));

        return $return;
    }
    /**
     * function to save one Editing Item
     * to the dedicated waiting table
     * @param object $form
     * @return boolean
     */
    function saveEditVersion($form) {
        $dt = new jDateTime();
        $dt->now();

        $dao = jDao::get('boosteradmin~boo_versions_mod');
        $record = jDao::createRecord('boosteradmin~boo_versions_mod');
        $record->version_name   = $form->getData('version_name');
        $record->status_version = 0; //will need moderation
        $record->item_id        = $form->getData('item_id');
        $record->last_changes   = $form->getData('last_changes');
        $record->stability      = $form->getData('stability');
        $record->filename       = $form->getData('filename');
        $record->download_url   = $form->getData('download_url');
        $record->created        = jDao::get('booster~boo_versions')->get($form->getData('id'))->created;
        $record->modified       = $dt->toString(jDateTime::DB_DTFORMAT);
        $record->version_id     = $form->getData('id');
        return ($dao->insert($record)) ? true : false;
    }
    /**
     * function that search items according to criteria in the form
     * @return array    items corresponding to the search
     * @TODO search with/by JelixVersions
     */
    function search() {

        $form = jForms::fill('booster~search');

        // we have uncheck every checkboxes and empty every fields
        // so let's get all the records
        if ($form->getData('name') == '' and
            $form->getData('types') == '' and
            $form->getData('author_by') == '' and
            $form->getData('jelix_versions') == '' and
            $form->getData('tags') == ''
            )
            return jDao::get('booster~boo_items')->findAll();

        $conditions = jDao::createConditions();
        //Types
        $conditions->startGroup('OR');
        $types = $form->getData('types');
        if(!empty($types)) {
            foreach($types as $type)
                $conditions->addCondition('type_id', '=', $type);
        }
        $conditions->endGroup();
        //Name
        $conditions->startGroup('OR');
        $name = $form->getData('name');
        if(!empty($name)) {
            $conditions->addCondition('name', '=', $name);
        }
        $conditions->endGroup();
        //Author_by
        $conditions->startGroup('OR');
        $author_by = $form->getData('author_by');
        if(!empty($author_by)) {
            $conditions->addCondition('author', '=', $author_by);
            $conditions->addCondition('nickname', '=', $author_by);
        }
        $conditions->endGroup();

        //we only retrieve the Validated Items
        $conditions->addCondition('status','=','1');

        //Results
        $dao_items = jDao::get('booster~boo_items');
        $items = $results = array();

        if(!empty($name) OR !empty($types) OR !empty($author_by)) {
            foreach($dao_items->findBy($conditions) as $item) {
                $items[$item->id] = $item;
            }
        }

        $tags = $form->getData('tags');
        if( !empty($tags)) {
            $srvTags = jClasses::getService("jtags~tags");
            $subjects = $srvTags->getSubjectsByTags($tags, "booscope");
            foreach($subjects as $id){
                if(isset($items[$id]) OR empty($items))
                    $results[$id] = $dao_items->get($id);
            }
        }
        else
            $results = $items;

        return $results;
    }
    /**
     * Check if a given item is moderated or waiting for validation
     * @param int $id the id of the Item
     * @return boolean
     */
    function isModerated($id,$source) {
        if ($source != 'items' and $source != 'versions') return false;

        $rec = jDao::get('boosteradmin~boo_'.$source.'_mod')->get($id);
        if ($rec !== false)
            return ( $rec->status == 0) ? false : true;
        else
            return true;
    }
}
