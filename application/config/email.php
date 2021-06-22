<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.gmail.com';
$config['smtp_port']   = '465';
$config['smtp_crypto'] = 'ssl';
$config['smtp_user']   = 'no-reply@media-vista.com';
$config['smtp_pass']   = 'm3d14noreply';
$config['newline']     = "\r\n";
$config['mailtype']    = 'html';
$config['wordwrap']    = TRUE;
$config['validation']  = TRUE;

/*
if(ENVIRONMENT === 'production'){
    $config['protocol']       = 'mail';
    $config['smtp_host']      = 'localhost';
    $config['smtp_port']      = '25';

    $config['smtp_user']      = ''; // change it to yours
    $config['smtp_pass']      = ''; // change it to yours

    $config['smtp_crypto']    = '';
    $config['mailtype']       = 'html';
    $config['charset']        = 'iso-8859-1';
    $config['wordwrap']       = TRUE;
    $config['send_multipart'] = FALSE;
}else{
    $config['protocol']       = 'smtp';
    $config['smtp_host']      = 'smtp-pulse.com';
    $config['smtp_port']      = '465';

    $config['smtp_user']      = 'yusar.chavik@gmail.com'; // change it to yours
    $config['smtp_pass']      = 'erP68eZnqYKSYMq'; // change it to yours

    $config['smtp_crypto']    = 'ssl';
    $config['mailtype']       = 'html';
    $config['charset']        = 'iso-8859-1';
    $config['wordwrap']       = TRUE;
    $config['send_multipart'] = FALSE;
}*/


