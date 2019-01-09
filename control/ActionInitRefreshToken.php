<?php
var_dump(array(
        "access_token"=>$_POST['access_token'],
        "refresh_token"=>$_POST['refresh_token'],
        "expires_in"=>$_POST['expires_in'],

    ));
include_once(dirname(__FILE__).'/../../lib/rest/PxpRestClient2.php');

//Generamos el documento con REST

$pxpRestClient = PxpRestClient2::connect('192.168.11.130', 'kerp/pxp/lib/rest/')->setCredentialsPxp('admin','admin');



$pxpRestClient->doPost('sigep/UserMapping/initRefreshToken',
    array(
        "access_token"=>$_POST['access_token'],
        "refresh_token"=>$_POST['refresh_token'],
        "expires_in"=>$_POST['expires_in'],

    ));