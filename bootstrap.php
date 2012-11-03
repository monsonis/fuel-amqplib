<?php
Autoloader::add_core_namespace('Amqplib');
Autoloader::add_namespace("PhpAmqpLib", __DIR__.DS.'vendor'.DS.'php-amqplib'.DS.'PhpAmqpLib'.DS, true);
Autoloader::add_classes(array(
	'Amqplib\\Amqplib'  => __DIR__.'/classes/amqplib.php',
));