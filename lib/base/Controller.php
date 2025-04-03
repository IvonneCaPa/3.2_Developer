<?php
	class Controller
	{
		public $view = null;
		protected $_request = null;
		protected $_action = null;
		protected $_namedParameters = array();
		
		public function init()
		{
			$this->view = new View();
			$this->view->settings->action = $this->_action;
			$this->view->settings->controller = strtolower(str_replace('Controller', '', get_class($this)));
		}
		
		public function beforeFilters()
		{ 	}
		
		public function afterFilters()
		{   }
		
		public function execute($action = 'index')
		{
			$this->_action = $action;
			$this->init();
			$this->beforeFilters();

			$actionToCall = $action.'Action';
			$this->$actionToCall();
			$this->afterFilters();
			$this->view->render($this->_getViewScript($action));
		}

		protected function _getViewScript($action)
		{
			$controller = get_class($this);
			$script = strtolower(substr($controller, 0, -10) . '/' . $action . '.phtml');
	
			return $script;
		}

		protected function _baseUrl()
		{
			return WEB_ROOT;
		}
		public function getRequest()
		{	
			if ($this->_request == null) {
				$this->_request = new Request();
			}
			
			return $this->_request;
		}
		
		protected function _getParam($key, $default = null)
		{
			if (isset($this->_namedParameters[$key])) {
				return $this->_namedParameters[$key];
			}
			
			return $this->getRequest()->getParam($key, $default);
		}

		protected function _getAllParams()
		{
			return array_merge($this->getRequest()->getAllParams(), $this->_namedParameters);
		}

		public function addNamedParameter($key, $value)
		{
			$this->_namedParameters[$key] = $value;
		}
	}
?>