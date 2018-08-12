<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_lib
{
    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
        require_once 'gmail_app/class.phpmailer.php';
    }
    function sendEmail($toMail, $CC, $BCC, $subject, $msgBody, $addAttachment = null){
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = "cloud2.eicra.com";
        $mail->Port = "465";
        $mail->SMTPAuth = true;
        $mail->Username = "eums@atilimited.net";
        $mail->Password = "ati@1234";
        $mail->SMTPSecure = 'ssl';
        $mail->From = "eums@atilimited.net";
        $mail->FromName = "Khwaja Yunus Ali University";
        $mail->AddAddress($toMail);
        //$mail->addCC($CC);
        $mail->addBCC($BCC);

        //$mail->addAttachment($addAttachment);
        $mail->AddReplyTo('eums@atilimited.net');
        $mail->WordWrap = 1000;
        $mail->IsHTML(TRUE);
        $mail->Subject = $subject;
        $mail->Body = $msgBody;
        $mail = $mail->Send();
        return $mail;
    }
}

/* End of file email_lib.php */
/* Location: ./application/libraries/email_lib.php */
