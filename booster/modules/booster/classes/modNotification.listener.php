<?php
/**
* @package   booster
* @subpackage booster
* @author    Lonqueu-Brochard Florian
* @copyright 2011 Lonqueu-Brochard Florian
* @link      http://www.jelix.org
* @license   http://www.gnu.org/licenses/lgpl.html  GNU Lesser General Public Licence, see LICENCE file
*/

class modNotificationListener extends jEventListener{

    //Array of email adresses
    protected $emails;

    //Mail to send
    protected $mail;

    function __construct(){
        $this->emails = explode(',' , $GLOBALS['gJConfig']->booster['moderators_list']);
        $this->mail = new jMailer();
        $this->mail->isHTML(true);
    }


    function onnew_item_added($event) {
        //$item_id = $event->getParam('item_id');
        $this->mail->Subject = 'Un élément a été ajouté';
        $this->mail->Body = '<p>Il y a un nouvel élément a valider sur Booster (ajout).</p>';
        $this->mail->Body .= '<p><a href="'.jUrl::getFull('boosteradmin~items:index').'">Validation des nouveaux éléments</a></p>';

        $this->finishAndSend();
    }
    
    function onnew_version_added($event) {
        //$version_id = $event->getParam('version_id');
        $this->mail->Subject = 'Une version a été ajouté';
        $this->mail->Body = '<p>Il y a une nouvelle version a valider sur Booster (ajout).</p>';
        $this->mail->Body .= '<p><a href="'.jUrl::getFull('boosteradmin~versions:index').'">Validation des nouvelles versions</a></p>';

        $this->finishAndSend();
    }
    
    function onitem_edited($event) {
        //$item_id = $event->getParam('item_id');
        $this->mail->Subject = 'Un élément a été modifié';
        $this->mail->Body = '<p>Il y a un élément a valider sur Booster (modification).</p>';
        $this->mail->Body .= '<p><a href="'.jUrl::getFull('boosteradmin~items:index').'">Validation des éléments modifiés</a></p>';

        $this->finishAndSend();
    }
    
    function onversion_edited($event) {
        //$version_id = $event->getParam('version_id');
        $this->mail->Subject = 'Une version a été modifié';
        $this->mail->Body = '<p>Il y a une version a valider sur Booster (modification).</p>';
        $this->mail->Body .= '<p><a href="'.jUrl::getFull('boosteradmin~versions:index').'">Validation des versions modifiées</a></p>';

        $this->finishAndSend();
    }
    
    
    
    function finishAndSend(){
        if(!empty($this->emails)) {
            foreach($this->emails as $adr) {
                $this->mail->AddAddress($adr);
            }
        
            $this->mail->Send();
        }
    }
    
}
