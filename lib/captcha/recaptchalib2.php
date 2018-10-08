<?php


function recaptcha_verify($secret, $remoteIp, $gRecaptchaResponse){
    $recaptcha = new \ReCaptcha\ReCaptcha($secret);
    $resp = $recaptcha->setExpectedHostname('raks.com.ua')
        ->verify($gRecaptchaResponse, $remoteIp);
    if ($resp->isSuccess()) {
        return true;
    }
    $errors = $resp->getErrorCodes();
    return false;

}

