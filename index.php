<?php 
include('request.php');

$instance = new Request();
$instance->setUrl('http://google.ua');
$d = $instance->post(array('username'=> 'test', 'password'=>'123'), array(
    'Content-type: text/html',
));

$d->code();
$d->content(); 
$d->headers();
?>