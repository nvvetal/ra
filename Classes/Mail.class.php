<?php

require_once($GLOBALS['MODULES_DIR'].'mailer/class.phpmailer.php');

class Mail
{
    /**
     * @var $mailer PHPMailer
     */
    protected $mailer;

    public function __construct($params)
    {
        $this->mailer = new PHPMailer();
        $this->mailer->IsSMTP();
        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->Host       = $params['host']; // SMTP server example
        $this->mailer->SMTPDebug  = 3;                     // enables SMTP debug information (for testing)
        $this->mailer->SMTPAuth   = true;                  // enable SMTP authentication
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->Port       = $params['port'];                    // set the SMTP port for the GMAIL server
        $this->mailer->Username   = $params['username']; // SMTP account username example
        $this->mailer->Password   = $params['password'];        // SMTP account password example
    }

    /**
     * @param $params
     */
    public function sendMail($params)
    {
        $mailer = $this->mailer;
        $mailer->From = $params['from'];
        $mailer->FromName = $params['fromName'];
        $mailer->Host = 'email-smtp.us-east-1.amazonaws.com';

        $this->setTo($mailer, $params);
        $this->setReplyTo($mailer, $params);
        $this->setCC($mailer, $params);
        $this->setBCC($mailer, $params);
        $this->setAttachments($mailer, $params);
        $mailer->WordWrap = isset($params['wordWrap']) ? $params['wordWrap'] : 50;// Set word wrap to 50 characters
        $mailer->isHTML(true); // Set email format to HTML
        $mailer->Subject = $params['subject'];
        $mailer->Body    = $params['body'];
        $mailer->AltBody = isset($params['altBody']) ? $params['altBody'] : '';
        $mailer->setFrom($params['from'], $params['fromName']);
        try {
            if(!$mailer->send()) throw new \Exception($mailer->ErrorInfo);
            //$mailer->send();
        }catch(\Exception $e){
            add_to_log('[error '.$e->getMessage().'][mail  '+$mailer->ErrorInfo+'][subject '.$mailer->Subject.'][params '.json_encode($mailer).']', 'error_mail');
        }
    }

    private function setTo(&$mailer, $params)
    {
        if(!isset($params['to'])) return false;
        foreach($params['to'] as $to){
            if(!isset($name)){
                $mailer->addAddress($to['email']);
            }else{
                $mailer->addAddress($to['email'], $to['name']);
            }
        }
        return true;
    }

    private function setReplyTo(&$mailer, $params)
    {
        if(!isset($params['replyTo'])) return false;
        foreach($params['replyTo'] as $replyTo){
            if(!isset($name)){
                $mailer->addReplyTo($replyTo['email']);
            }else{
                $mailer->addReplyTo($replyTo['email'], $replyTo['name']);
            }
        }
        return true;
    }

    private function setCC(&$mailer, $params)
    {
        if(!isset($params['cc'])) return false;
        foreach($params['cc'] as $cc){
            if(!isset($name)){
                $mailer->addCC($cc['email']);
            }else{
                $mailer->addCC($cc['email'], $cc['name']);
            }
        }
        return true;
    }

    private function setBCC(&$mailer, $params)
    {
        if(!isset($params['bcc'])) return false;
        foreach($params['bcc'] as $bcc){
            if(!isset($name)){
                $mailer->addBCC($bcc['email']);
            }else{
                $mailer->addBCC($bcc['email'], $bcc['name']);
            }
        }
        return true;
    }

    private function setAttachments(&$mailer, $params)
    {
        if(!isset($params['attachments'])) return false;
        foreach($params['attachments'] as $attachment){
            if(!isset($name)){
                $mailer->addAttachment($attachment['file']);
            }else{
                $mailer->addAttachment($attachment['file'], $attachment['name']);
            }
        }
        return true;
    }

}