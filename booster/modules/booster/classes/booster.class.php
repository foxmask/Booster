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
    /**
     * fonction to save one Item
     */
    function saveItem() {
        $data = array();
        $id_booster = 0;

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
        $record->status = 0; //will need moderation

        if ($dao->insert($record)) {
            $id_booster = $record->id;
            $data['id']=$id_booster;
            $data['name'] = $form->getData('name');
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
     * fonction to save one Version
     * @param object $form
     * @return boolean
     */
    function saveVersion($form) {
        $dao = jDao::get('booster~boo_versions');
        $record = jDao::createRecord('booster~boo_versions');
        $record->version_name = $form->getData('version_name');
        $record->status = 0; //will need moderation
        $record->item_id = $form->getData('item_id');
        $record->last_changes = $form->getData('last_changes');
        $record->stability = $form->getData('stability');
        $record->filename = $form->getData('filename');
        $record->download_url = $form->getData('download_url');
        return ($dao->insert($record)) ? true : false;
    }
    /**
     * fonction to save one Editing Item
     * to the dedicated waiting table
     */
    function saveEditItem($form) {
        $data = array();

        $form = jForms::fill('booster~items');
        $dao = jDao::get('boosteradmin~boo_items_mod');
        $record = jDao::createRecord('boosteradmin~boo_items');
        $record->name = $form->getData('name');
        $record->item_info_id = $form->getData('item_info_id');
        $record->short_desc = $form->getData('short_desc');
        $record->type_id = $form->getData('type_id');
        $record->url_website = $form->getData('url_website');
        $record->url_repo = $form->getData('url_repo');
        $record->author = $form->getData('author');
        $record->item_by = $form->getData('item_by');
        $record->status = 0; //will need moderation
        $return = ($dao->insert($record)) ? true : false;
        $id_booster = $form->getData('id');

        $tagStr ='';
        $tagStr = str_replace('.',' ',$form->getData("tags"));
        $tags = explode(",", $tagStr);

        jClasses::getService("jtags~tags")->saveTagsBySubject($tags, 'booscope', $id_booster);

        return $return;
    }
    /**
     * fonction to save one Editing Item
     * to the dedicated waiting table
     * @param object $form
     * @return boolean 
     */
    function saveEditVersion($form) {
        $dao = jDao::get('boosteradmin~boo_versions_mod');
        $record = jDao::createRecord('boosteradmin~boo_versions_mod');
        $record->version_name = $form->getData('version_name');
        $record->status = 0; //will need moderation
        $record->item_id = $form->getData('item_id');
        $record->last_changes = $form->getData('last_changes');
        $record->stability = $form->getData('stability');
        $record->filename = $form->getData('filename');
        $record->download_url = $form->getData('download_url');
        $record->id =  $form->getData('id');
        return ($dao->insert($record)) ? true : false;
    }
    

    /**
     * function that search items according to criteria in the form
     * @return array    items corresponding to the search
     */
    function search() {
        
        $form = jForms::fill('booster~search');
        
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
    
    
}
