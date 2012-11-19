<?php
//include models
require_once '../application/models/front.php';
require_once '../application/models/icontroller.php';
require_once '../application/models/view.php';

//include controllers
require_once '../application/controllers/index.php';

//intialize front controller
$front = FrontController::getInstance();
$front->route();

echo $front->getBody();