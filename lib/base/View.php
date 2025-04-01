<?php
	// clase que encapsula la lógica para renderizar vistas y layouts.
	class View
	{
		protected $_content = "";		//Almacena el contenido generado por el script de la vista.
		protected $_layout = 'layout';	//Almacena el nombre del layout por defecto.
		protected $_viewEnabled = true; //Indica si la renderización de la vista está habilitada.
		protected $_layoutEnabled = true; //Indica si la renderización del layout está habilitada.
		protected $_data = array(); 	//Almacena los datos que se pasan a la vista.
		protected $_javascripts = '';	//Almacena los scripts JavaScript que se añaden a la vista.
	
		public $settings = null;	//Almacena configuraciones adicionales para la vista
		
		public function __construct()
		// Crea un objeto stdClass para almacenar configuraciones adicionales.
		{
			$this->settings = new stdClass();
		}
		// Este método protegido renderiza el script de la vista.
		protected function _renderViewScript($viewScript)
		{	
			ob_start(); 	//Inicia el almacenamiento en búfer de salida.
			//Incluye el script de la vista, que genera el contenido.
			include(ROOT_PATH . '/app/views/scripts/' . $viewScript); 
			//Obtiene el contenido del búfer de salida y lo almacena en $_content.
			$this->_content = ob_get_clean();
		}

		//Este método público devuelve el contenido generado por el script de la vista.
		public function content()
		{
			return $this->_content;
		}
		// Este método público renderiza la vista y el layout
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
		// Este método público renderiza los datos como JSON.
		public function renderJson($data)
		{
			$this->disableView();
			$this->disableLayout();
			
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');
			
			echo json_encode($data);
		}
		// Este método protegido devuelve el nombre del layout actual.
		protected function _getLayout()
		{
			return $this->_layout;
		}
		// Este método público establece el nombre del layout.
		public function setLayout($layout)
		{
			$this->_layout = $layout;
			
			if ($layout) {
			$this->_enableLayout();
			}
		}
		//  Este método público deshabilita la renderización del layout.
		public function disableLayout()
		{
			$this->_layoutEnabled = false;
		}
		//Este método público deshabilita la renderización de la vista.
		public function disableView()
		{
			$this->_viewEnabled = false;
		}
		// Este método mágico se llama cuando se asigna un valor a una propiedad inexistente.
		public function __set($key, $value)
		{
			$this->_data[$key] = $value;
		}
		// Este método mágico se llama cuando se accede a una propiedad inexistente.
		public function __get($key)
		{
			if (array_key_exists($key, $this->_data)) {
				return $this->_data[$key];
			}
			
			return null;
		}
		// Este método público devuelve la URL base de la aplicación.
		public function baseUrl()
		{
			return WEB_ROOT;
		}
		// Este método público añade un script JavaScript a la vista.
		public function appendScript($script)
		{
			$this->_javascripts .= '<script type="text/javascript" src="'.$script.'"></script>' ."\n";
		}
		// Este método público imprime los scripts JavaScript añadidos.
		public function printScripts()
		{
			echo $this->_javascripts;
		}
		// Este método protegido habilita la renderización del layout.
		protected function _enableLayout()
		{
			$this->_layoutEnabled = true;
		}
		//Este método protegido verifica si la renderización del layout está deshabilitada.
		protected function _isLayoutDisabled()
		{
			return !$this->_layoutEnabled;
		}
	}
?>
