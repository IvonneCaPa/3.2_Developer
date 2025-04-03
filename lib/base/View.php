<?php

	class View
	{
		protected $_content = "";		
		protected $_layout = 'layout';	
		protected $_viewEnabled = true; 
		protected $_layoutEnabled = true; 
		protected $_data = array(); 	
		protected $_javascripts = '';	
	
		public $settings = null;	
		
		public function __construct()
		
		{
			$this->settings = new stdClass();
		}
		
		protected function _renderViewScript($viewScript)
		{	
			ob_start(); 	
		
			include(ROOT_PATH . '/app/views/scripts/' . $viewScript); 
			
			$this->_content = ob_get_clean();
		}

		public function content()
		{
			return $this->_content;
		}
		
		public function render($viewScript)
		{
			if ($viewScript && $this->_viewEnabled) {
				$this->_renderViewScript($viewScript);
			}
				
			if ($this->_isLayoutDisabled()) {
				echo $this->_content;
			}
			else {
				include(ROOT_PATH . '/app/views/layouts/' . $this->_getLayout() . '.phtml');
			}
		}
		
		public function renderJson($data)
		{
			$this->disableView();
			$this->disableLayout();
			
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');
			
			echo json_encode($data);
		}
	
		protected function _getLayout()
		{
			return $this->_layout;
		}
	
		public function setLayout($layout)
		{
			$this->_layout = $layout;
			
			if ($layout) {
			$this->_enableLayout();
			}
		}
		
		public function disableLayout()
		{
			$this->_layoutEnabled = false;
		}
	
		public function disableView()
		{
			$this->_viewEnabled = false;
		}
		
		public function __set($key, $value)
		{
			$this->_data[$key] = $value;
		}
	
		public function __get($key)
		{
			if (array_key_exists($key, $this->_data)) {
				return $this->_data[$key];
			}
			
			return null;
		}
		
		public function baseUrl()
		{
			return WEB_ROOT;
		}
	
		public function appendScript($script)
		{
			$this->_javascripts .= '<script type="text/javascript" src="'.$script.'"></script>' ."\n";
		}
		
		public function printScripts()
		{
			echo $this->_javascripts;
		}
	
		protected function _enableLayout()
		{
			$this->_layoutEnabled = true;
		}
		
		protected function _isLayoutDisabled()
		{
			return !$this->_layoutEnabled;
		}
	}
?>
