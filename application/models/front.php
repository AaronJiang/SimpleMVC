<?php

class FrontController
{
	protected $_controller, $_action, $_params, $_body;
	static $_instance; 

	public static function getInstance()
	{
		if(!(self::$_instance instanceof self))
		{
			self::$_instance = new self();
		}	
		return self::$_instance;
	}

	public function __construct()
	{
		$request = $_SERVER['REQUEST_URI'];

		//assign url params into controller & action
		$splits = explode('/', trim($request,'/'));
		$this->_controller = !empty($splits[0])?$splits[0]:'index';
		$this->_action = !empty($splits[1])?$splits[1]:'index';
		
		//assign action key-value
		if(!empty($splits[2]))
		{
			$keys = $values = array();
			for($idx = 2, $cnt = count($splits); $idx<$cnt; $idx++)
			{
				if($idx%2 == 0)
				{
					$keys[] = $splits[$idx];
				}	
				else
				{
					$values[] = $splits[$idx];
				}	
			}	
			$this->_params = array_combine($keys, $values);
		}	
	}

	public function route()
	{
		if(class_exists($this->getController()))
		{
			$rc = new ReflectionClass($this->getController());
			if($rc->implementsInterface('IController'))
			{
				if($rc->hasMethod($this->getAction()))
				{
					$controller = $rc->newInstance();
					$method = $rc->getMethod($this->getAction());
					$method->invoke($controller);
				}
				else
				{
					throw new Exception("action");
				}
			}
			else
			{
				throw new Exception("interface");
			}	
		}
		else
		{
			throw new Exception("controller");
		}
	}

	public function getParams()
	{
		return $this->_params;
	}

	public function getController()
	{
		return $this->_controller;
	}

	public function getAction()
	{
		return $this->_action;
	}

	public function setBody()
	{
		return $this->_body;
	}
}