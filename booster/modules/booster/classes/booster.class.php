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
        $dao = jDao::get('booster~boo_items','booster');
        $record = jDao::createRecord('booster~boo_items','booster');
        $record->name           = $form->getData('name');
        $record->item_info_id   = $form->getData('item_info_id');
        $record->short_desc     = $form->getData('short_desc');
        $record->short_desc_fr  = $form->getData('short_desc_fr');
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
        $dao = jDao::get('booster~boo_versions','booster');
        $record = jDao::createRecord('booster~boo_versions','booster');
        $record->version_name   = $form->getData('version_name');
        $record->status         = 0; //will need moderation
        $record->id_jelix_version = $form->getData('id_jelix_version');
        $record->item_id        = $form->getData('item_id');
        $record->last_changes   = $form->getData('last_changes');
        $record->stability      = $form->getData('stability');
        $record->filename       = $form->getData('filename');
        $record->download_url   = $form->getData('download_url');
        return ($dao->insert($record)) ? $record->id : false;
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

        $dao = jDao::get('boosteradmin~boo_items_mod','booster');
        $record = jDao::createRecord('booster~boo_items','booster');
        $record->id             = $id_booster;
        $record->name           = $form->getData('name');
        $record->item_info_id   = $form->getData('item_info_id');
        $record->short_desc     = $form->getData('short_desc');
        $record->short_desc_fr  = $form->getData('short_desc_fr');        
        $record->type_id        = $form->getData('type_id');
        $record->url_website    = $form->getData('url_website');
        $record->url_repo       = $form->getData('url_repo');
        $record->author         = $form->getData('author');
        $record->item_by        = $form->getData('item_by');
        $record->tags           = $form->getData("tags");
        $record->status         = 0; //will need moderation
        $record->created        = jDao::get('booster~boo_items','booster')->get($id_booster)->created;
        $record->modified       = $dt->toString(jDateTime::DB_DTFORMAT);

        $return = ($dao->insert($record)) ? true : false;

        //$form->saveControlToDao('jelix_versions', 'booster~boo_items_jelix_versions', null, array('id_item', 'id_version'));

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

        $dao = jDao::get('boosteradmin~boo_versions_mod','booster');
        $record = jDao::createRecord('boosteradmin~boo_versions_mod','booster');
        $record->version_name   = $form->getData('version_name');
        $record->status_version = 0; //will need moderation
        $record->item_id        = $form->getData('item_id');
        $record->id_jelix_version = $form->getData('id_jelix_version');
        $record->last_changes   = $form->getData('last_changes');
        $record->stability      = $form->getData('stability');
        $record->filename       = $form->getData('filename');
        $record->download_url   = $form->getData('download_url');
        $record->created        = jDao::get('booster~boo_versions','booster')->get($form->getData('id'))->created;
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
            return jDao::get('booster~boo_items','booster')->findAllValidated();

        $name           = $form->getData('name');
        $types          = $form->getData('types');
        $author         = $form->getData('author_by');
        $jelix_versions = $form->getData('jelix_versions');
        $tags           = $form->getData('tags');

        $q      = '';
        $from   = '';
        $where  = '';
        $orderby = '';
        $cond   = '';

        $c = jDb::getConnection('booster');
        //columns
        $q = 'SELECT items.id,
                    items.status as status,
                    items.name,
                    items.item_info_id,
                    items.short_desc,
                    items.short_desc_fr,
                    type.id AS type_id,
                    items.url_website,
                    items.url_repo,
                    items.author,
                    items.item_by,
                    type.type_name,
                    versions.id AS version_id,
                    versions.version_name,
                    versions.last_changes,
                    versions.stability,
                    versions.filename,
                    versions.download_url,
                    versions.status AS status_version,
                    versions.created,
                    versions.edited,
                    versions.modified,
                    versions.id_jelix_version';

        //tables
        $from = '
                FROM '.
                $c->prefixTable('boo_items').' AS items
                 LEFT JOIN ' .$c->prefixTable('boo_versions').' AS versions ON ( items.id=versions.item_id )
                 LEFT JOIN ' . $c->prefixTable('boo_jelix_versions'). ' AS jelix_versions ON (versions.id_jelix_version=jelix_versions.id ), '.
                $c->prefixTable('boo_type').' AS type ';
                //.', '.$c->prefixTable('community_users'). ' AS usr ';
        //where conditions
        $where = "
                WHERE items.type_id=type.id
                    AND items.status = 1
                    AND (versions.status = 1 OR versions.status IS NULL)" ;
        //Types
        if(!empty($types)) {
            $cond .= $this->buildCond($types,'type_id');
        }
        //Name
        if($name != '') {
            $cond .= "
                    AND name LIKE '%$name%' ";
        }
        //Author
        if($author != '') {
            $cond .= "
                    AND ( author LIKE '%$author%' ) ";
                    //AND ( author ='$author' ) OR nickname ='$author' ) ";
        }
        //version
        if(!empty($jelix_versions)) {
            $cond .= $this->buildCond($jelix_versions,'id_jelix_version');
        }

        $orderby = '
                    ORDER BY versions.created desc';

        $sql = $q.$from.$where.$cond.$orderby;
        //get the datas
        $datas = $c->query($sql);

        $items = $results = array();
        foreach($datas as $item) {jLog::dump($item);
            $items[$item->id] = $item;
        }

        // tags ?
        if( !empty($tags)) {
            //get tags
            $srvTags = jClasses::getService("jtags~tags");
            $subjects = $srvTags->getSubjectsByTags($tags, "booscope");
            foreach($subjects as $id){
                // get records of this tags
                if(isset($items[$id]) OR empty($items))
                    $results[$id] = $items[$id];
            }
        }
        // no tag !
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

        $rec = jDao::get('boosteradmin~boo_'.$source.'_mod','booster')->get($id);
        if ($rec !== false)
            return ( $rec->status == 0) ? false : true;
        else
            return true;
    }

    /**
     * build the Where conditions from :
     * @params $vars array to read to build the condition
     * @param $column name of the column for the where condition
     * @return string $cond return the built condition
     */
    private function buildCond($vars,$column) {
        $i = 0;
        $cond = "";
        if (count($vars) == 1)
            $cond .= "
                    AND  ";
        else
            $cond .= "
                    AND  ( ";

        foreach($vars as $str) {
            $i++;
            $cond .= $column ." = '".$str."' ";
            if (count($vars) > 1 and count($vars) > $i )
                $cond .= " OR ";
        }

        if (count($vars) > 1)
            $cond .= " ) ";

        return $cond;
    }
}
