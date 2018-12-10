<?php

/**
 * Created by PhpStorm.
 * User: Tolya
 * Date: 20.03.2018
 * Time: 15:24
 */

class Informer {

    public  $username,$usermail,$usertel,$comment;
    private $sendto,$hasError,$orgName,$subject,$cc_sendto,$bcc_sendto;
    public  $sentStatusCode,$sentMsgStatus,$lang,$internalError,$encyFileName;

    // $sentStatusCode = [success|fail]
    // $sentMsgStatus accordingly taken from the lang([success|fail])
    const SENT_OK  = 'success';
    const SENT_BAD = 'mailSendFAIL';

    public function __construct($lang = 'ua') {

        $this->lang = $lang;

        $cfg = array_merge(
            require_once '../data/cfg/config.php'     // get main configuration
//          ,  require_once '../data/cfg/rnd_string.php'  // get the database configuration
        );

        $this->sendto     = $cfg['form']['to'];
        $this->cc_sendto  = $cfg['form']['cc'];
        $this->bcc_sendto = $cfg['form']['bcc'] or '';
        $this->subject    = $cfg['form']['subject'];
        $this->orgName    = $cfg['site']['orgName'];

        unset($cfg);

        if(trim($_POST['name']) == '')   { $this->hasError = true;   } else { $this->username = trim($_POST['name']);  }
        if(trim($_POST['email']) == '')  { $this->hasError = true;   } else { $this->usermail = trim($_POST['email']); }
        if(trim($_POST['phone']) == '')  { $this->usertel  = 'none'; } else { $this->usertel  = trim($_POST['phone']); }
        if(trim($_POST['message']) == ''){ $this->hasError = true;   } else {
            if(function_exists('stripslashes')) {
                $this->comment = stripslashes(trim($_POST['message']));
            } else {
                $this->comment = trim($_POST['message']);
            }
            $this->comment=preg_replace("/[\n\r]+/s","<br/>",$this->comment);
        }
    }

    public function informUs() {
        if(!isset($this->hasError)) {
            // creating headers
            $from_reply = $this->composeMAilAddr($this->username,$this->usermail);
            $headers  = 'From: '    . $from_reply;
            $headers .= 'Reply-To: '. $from_reply;
            if (!empty($this->cc_sendto)) {
                $headers .= 'Cc: '  . $this->composeMAilAddr($this->orgName.' copy',$this->cc_sendto);
            }

            $bcc = (empty($this->bcc_sendto)) ? '' : $this->bcc_sendto . ', ';
            $headers .= 'Bcc: ' . $bcc . $this->composeMAilAddr('WebMaster','a3three@gmail.com');
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html;charset=utf-8 \r\n";

            // creating the message body
            $msg  = "<html><body style='font-family:Arial,sans-serif;'>";
            $msg .= "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>"
                        .$this->subject. ' - '. $this->orgName .'</h2>';
            $msg .= '<p><strong>From:</strong> '        .$this->username .'</p>';
            $msg .= '<p><strong>E-mail:</strong> '      .$this->usermail .'</p>';
            $msg .= '<p><strong>Phone number:</strong> '.$this->usertel  .'</p><hr>';
            $msg .= $this->comment;
            $msg .= '<hr></body></html>';

            // sending the message
//            $success = mail($this->sendto, $this->subject, $msg, $headers);
            $success = 1;

            if ($success && $this->hasError != true ) {
//                $this->setSentMsgStatus($this::SENT_OK);

                $this->sentMsgStatus ='success';
                $this->internalError = '';

                $this->addToDB();
            } else {
//                $this->setSentMsgStatus($this::SENT_BAD);
                $success = error_get_last()['message'];
                $this->internalError = strip_tags($success);
                $this->sentMsgStatus ='fail';
            }

        }
        // else { $this->setSentMsgStatus($this::SENT_BAD); }

        return $this;
    }

    private function composeMAilAddr($Name, $address) {
        return sprintf("%s <%s>\r\n",strip_tags($Name),strip_tags($address));
    }

    private function addToDB() {
        require_once '../core/data_class.php';
        require_once '../core/querymap_class.php';
        // establish the db connection
        $cfg = require_once '../data/cfg/rnd_string.php';  // get the database configuration
        $d = new Data($cfg);
        $res = $d->add(QueryMap::INSERT_ORDER,array(
            $this->username,$this->usermail,$this->usertel,$this->comment
        ));
//        var_dump($res);
    }

}
