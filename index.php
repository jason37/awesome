<?php

require 'vendor/autoload.php';
require 'Config.php';
require 'Room.php';
require 'Storage.php';

use Awesome\Room;
use Awesome\Storage;

$store = new Storage;
$room = new Room($store->loadRoom());
var_dump($room);

$templater = new Smarty;
$templater->assign('room', $room);
$templater->display('room.tpl');
