<?php

class index implements IController
{
	public function index()
	{
		$view = new View();
		$view->name = 'Kevin';
		$result = $view->render('index.php');

		$fc = FrontController::getInstance();
		$fc->setBody($result);
	}
}
