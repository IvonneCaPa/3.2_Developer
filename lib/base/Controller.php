<?php

	class Controller
	{
		// Declara una vista: Para gestionar la presentación de datos en la interfaz del usuario
		public $view = null;
		// Se utiliza para acceder a los datos de la solicitud HTTP (GET, POST)
		protected $_request = null;
		// Se declara el nombre de la accion que se esta ejecutando
		protected $_action = null;
		// Almacenara un array de parámetros con nombres obtenidos de la URL, Ej /user/:id donde
		// :id es un parámetro con nombre
		protected $_namedParameters = array();
		
		// Inicia el controlador
		public function init()
		{
			// crea una nueva instancia de la clase VIEW()
			$this->view = new View();
			// Establece la accion actual en la vista
			$this->view->settings->action = $this->_action;
			// Establece el nombre del controlador en la vista 
			// (eliminando "Controller" del nombre de la clase y convirtiéndolo a minúsculas)
			$this->view->settings->controller = strtolower(str_replace('Controller', '', get_class($this)));
		}
		
		public function beforeFilters()
		{ 	}
		
		public function afterFilters()
		{   }
		
		// Este método es el punto de entrada principal para ejecutar una acción del controlador.
		public function execute($action = 'index')
		{
			// Establece la acción actual
			$this->_action = $action;
			$this->init();
			$this->beforeFilters();
			// Construye el nombre del método de la acción (por ejemplo, indexAction).
			$actionToCall = $action.'Action';
			$this->$actionToCall();
			$this->afterFilters();
			// Llama al método render de la vista para mostrar la plantilla correspondiente a la acción.
			$this->view->render($this->_getViewScript($action));
		}
		
		// Este método genera la ruta al script de la vista (la plantilla).
		protected function _getViewScript($action)
		{
			// Obtiene el nombre de la clase del controlador.
			$controller = get_class($this);
			// Construye la ruta al script de la vista 
			// (por ejemplo, home/index.phtml para la acción index del controlador HomeController)
			$script = strtolower(substr($controller, 0, -10) . '/' . $action . '.phtml');
			//  Devuelve la ruta del script de la vista
			return $script;
		}
		//Este método devuelve la URL base de la aplicación, definida por la constante WEB_ROOT
		protected function _baseUrl()
		{
			return WEB_ROOT;
		}
		// Este método obtiene la instancia de la clase Request
		public function getRequest()
		{	
			// si es nula crea una nueva instancia
			if ($this->_request == null) {
				$this->_request = new Request();
			}
			
			return $this->_request;
		}
		// Este método obtiene un parámetro de la solicitud (GET, POST, o parámetros con nombre).
		protected function _getParam($key, $default = null)
		{
			// primero mira si e parámetro esta en el array si no lo busca en los parametros de la solicitud
			if (isset($this->_namedParameters[$key])) {
				return $this->_namedParameters[$key];
			}
			
			return $this->getRequest()->getParam($key, $default);
		}
		// Este método devuelve un array con todos los parámetros de la solicitud y los parámetros con nombre.
		protected function _getAllParams()
		{
			return array_merge($this->getRequest()->getAllParams(), $this->_namedParameters);
		}
		// Este método añade un parámetro con nombre al array $_namedParameters
		public function addNamedParameter($key, $value)
		{
			$this->_namedParameters[$key] = $value;
		}
	}
?>