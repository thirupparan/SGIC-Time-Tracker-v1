<?php

function printJsonMsg($message,$type){
    $msg=array('msg'=>'','type'=>'');
    $msg['msg']=$message;
    $msg['type']=$type;
    return $msg;
}
?>
