<?php
/**
* @package   booster
* @subpackage booster
* @author    Florian Lonqueu-Brochard
* @copyright 2012 Florian Lonqueu-Brochard
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/
/**
 * Class that handle the booster business stuff
 */
class boosterGithub {

    protected static function getOnGitub($url){
        $ch = curl_init($url);
        curl_setopt_array ($ch, array(CURLOPT_RETURNTRANSFER => true, CURLOPT_SSL_VERIFYPEER => false, CURLINFO_HEADER_OUT => true));
        $res = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        
        if($err)
            return false;
        return $res;
    }




    public function getRepoInfos($user, $repository){
  
        $url = 'https://api.github.com/repos/'.$user.'/'.$repository.'?per_page=1';
        $res = self::getOnGitub($url);
        
        if(!$res){
            jLog::log('error with github.com loading data', 'error');
            return false;
        }
            
        $res= json_decode($res);
        return $res;
    }


    public function getLastCommit($user, $repository){
  
        $url = 'https://api.github.com/repos/'.$user.'/'.$repository.'/commits?per_page=1';
        $res = self::getOnGitub($url);
        
        if(!$res){
            jLog::log('error with github.com loading data', 'error');
            return false;
        }
            
        $res= json_decode($res);
        return $res[0]->commit;
    }

    /**
     * Get the activity of a repository
     *
     * 
     * @return int A number corresponding to the activity of the repository 
     */
    public function getRepositoryActivity($user, $repository, $options = array()){
        
        $default_options = array(
            'nb_commit' => 20
        );
        $settings = array_merge($default_options, $options);

        $url = 'https://api.github.com/repos/'.$user.'/'.$repository.'/commits?per_page='.$settings['nb_commit'];
        $res = self::getOnGitub($url);
        
        if(!$res){
            jLog::log('error with github.com loading data', 'error');
            return false;
        }
            
        $res= json_decode($res);

        $moyenne = 0; $counter = 0;
        $date = new jDateTime();
        foreach($res as $item){
            $date->setFromString($item->commit->committer->date, jDateTime::ISO8601_FORMAT);
            $moyenne += $date->toString(jDateTime::TIMESTAMP_FORMAT);
            $counter++;
        }
        $moyenne = $moyenne/$counter;

        $now = time();
        $diff = $now - $moyenne;
        $activity = 0;
        if($diff < 604800){ //1semaine
            $activity = 3;
        }
        elseif ($diff < 2628000) { //1mois
            $activity = 2;
        }
        elseif ($diff < 31536000) { //1année
            $activity = 1;
        }

        return $activity;
    }

}