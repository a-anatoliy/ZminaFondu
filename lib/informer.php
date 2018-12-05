<?php

/**
 * Created by PhpStorm.
 * User: Tolya
 * Date: 20.03.2018
 * Time: 15:24
 */

class Informer {

    public  $username,$usermail,$usertel,$comment;
    private $sendto,$hasError;
    public  $sentStatusCode,$sentMsgStatus,$lang,$internalError,$encyFileName;

    // $sentStatusCode = [success|fail]
    // $sentMsgStatus accordingly taken from the lang([success|fail])
    const SENT_OK  = 'success';
    const SENT_BAD = 'mailSendFAIL';

    public function __construct($lang) {

        $cfg = require_once CONFIG;
        $this->sendto     = $cfg["form"]["to"];
        $this->Cc_sendto  = $cfg["form"]["cc"];
        $this->Bcc_sendto = $cfg["form"]["bcc"];
        $this->sendFrom   = $cfg["form"]["from"];

        $this->encyOK   = ROOT_DIR . $cfg["stat"]["OK_mail"];
        $this->encyFAIL = ROOT_DIR . $cfg["stat"]["FAIL_mail"];

        unset($cfg);
        $this->lang = $lang;

        if(trim($_POST['name']) == '')   { $this->hasError = true;   } else { $this->username = trim($_POST['name']);  }
        if(trim($_POST['email']) == '')  { $this->hasError = true;   } else { $this->usermail = trim($_POST['email']); }
        if(trim($_POST['phone']) == '')  { $this->usertel  = 'none'; } else { $this->usertel  = trim($_POST['phone']); }
        if(trim($_POST['message']) == ''){ $this->hasError = true;   } else {
            if(function_exists('stripslashes')) {
                $this->comment = stripslashes(trim($_POST['message']));
            } else {
                $this->comment = trim($_POST['message']);
            }
//            $this->comment = nl2br($this->comment);
            $this->comment=preg_replace("/[\n\r]+/s","<br/>",$this->comment);
        }
    }

    public function informUs() {
        if(!isset($this->hasError)) {
            // creating headers
            $headers  = "From: "    . $this->composeMAilAddr("Lucky Dress",$this->sendFrom);
            $headers .= "Reply-To: ". $this->composeMAilAddr($this->username,$this->usermail);
            if (!empty($this->Cc_sendto)) {
                $headers .= 'Cc: '  . $this->composeMAilAddr("Lucky DRESS copy",$this->Cc_sendto);
            }

            $bcc = (empty($this->Bcc_sendto)) ? "" : $this->Bcc_sendto . ', ';
            $headers .= 'Bcc: ' . $bcc . $this->composeMAilAddr("WebMaster","a3three@gmail.com");
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html;charset=utf-8 \r\n";

            // creating the message body
            $msg  = "<html><body style='font-family:Arial,sans-serif;'>";
            $msg .= "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>Cообщение с сайта</h2>";
            $msg .= "<p><strong>From:</strong> "        .$this->username ."</p>";
            $msg .= "<p><strong>E-mail:</strong> "      .$this->usermail ."</p>";
            $msg .= "<p><strong>Phone number:</strong> ".$this->usertel  ."</p><hr>";
            $msg .= $this->comment;
            $msg .= "<hr></body></html>";

            // sending the message
            $success = mail($this->sendto, $this->lang["subject"], $msg, $headers);

            if ($success && $this->hasError != true ) {
                $this->setSentMsgStatus($this::SENT_OK);
            } else {
                $this->setSentMsgStatus($this::SENT_BAD);
                $success = error_get_last()['message'];
                $this->internalError = strip_tags($success);
            }

        } else { $this->setSentMsgStatus($this::SENT_BAD); }

        return $this;
    }

    private function composeMAilAddr($Name, $address) {
        return sprintf("%s <%s>\r\n",strip_tags($Name),strip_tags($address));
    }

    private function setSentMsgStatus($code) {
        $this->sentStatusCode = $code;
        $this->sentMsgStatus  = $this->lang[ $this->sentStatusCode ];
        if ($code === $this::SENT_OK) { $this->encyFileName = $this->encyOK; }
        elseif ($code === $this::SENT_BAD) { $this->encyFileName = $this->encyFAIL; }
        else { $this->encyFileName = $this->encyOK; }
    }
}
