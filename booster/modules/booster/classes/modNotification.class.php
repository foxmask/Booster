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
    }


    function onnew_item_added($event) {
        
        //TODO
        $this->mail->Subject = 'Sujet de l\'email';
        $this->mail->Body = 'Contenu du message texte';
        
        $this->finishAndSend();
    }
    
    function onnew_version_added($event) {

        //TODO
        $this->mail->Subject = 'Sujet de l\'email';
        $this->mail->Body = 'Contenu du message texte';
        
        $this->finishAndSend();
    }
    
    function onitem_edited($event) {

        //TODO
        $this->mail->Subject = 'Sujet de l\'email';
        $this->mail->Body = 'Contenu du message texte';
        
        $this->finishAndSend();
    }
    
    function onversion_edited($event) {
        
        //TODO
        $this->mail->Subject = 'Sujet de l\'email';
        $this->mail->Body = 'Contenu du message texte';
        
        $this->finishAndSend();
    }
    
    
    
    function finishAndSend(){

        foreach($emails as $adr) {
            $this->mail->AddAddress($adr);
        }
    
        $this->mail->Send();        
    }
    
}
