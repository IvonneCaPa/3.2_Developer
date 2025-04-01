<?php

	class Router
	{
		public function execute($routes)
		{
			try {
				$controller = null;
				$action = null;
				//busca una ruta simple
				$routeFound = $this->_getSimpleRoute($routes, $controller, $action);
				// si no encuentra la ruta simple la busca por parametro
				if (!$routeFound) {
					$routeFound = $this->_getParameterRoute($routes, $controller, $action);
				}
				// Si no se encuentra lanza una excepcion avisando
				if (!$routeFound || $controller == null || $action == null) {
					throw new Exception('no route added for ' . $_SERVER['REQUEST_URI']);
				}
				// si se encuentra se llama al metodo execute
				else {
					$controller->execute($action);
				}
			}
			// si no se encuentra ninguna ruta, llama al error
			catch(Exception $exception) {
				$controller = new ErrorController();
				$controller->setException($exception);
				$controller->execute('error');
			}
		}
		// confirma si la ruta tiene parametros dinámicos
		public function hasParameters($route)
		{
			return preg_match('/(\/:[a-z]+)/', $route);
		}
		// Obtiene la URL eliminando la base y los parámetros de consulta
		protected function _getUri()
		{
			$uri = explode('?',$_SERVER['REQUEST_URI']);
			$uri = $uri[0];
			$uri = substr($uri, strlen(WEB_ROOT));
			
			return $uri;
		}
		// Busca una ruta simple sin parametros
		protected function _getSimpleRoute($routes, &$controller, &$action)
		{
			$uri = $this->_getUri();
			
			if (isset($routes[$uri])) {
				$routeFound = $routes[$uri];
			}
			else if(isset($routes[$uri . '/'])) {
				$routeFound = $routes[$uri . '/'];
			}
			else {
				$uri = substr($uri, 0, -1);
				$routeFound = isset($routes[$uri]) ? $routes[$uri] : false;
			}
			
			if ($routeFound) {
				list($name, $action) = explode('#', $routeFound);
				$controller = $this->_initializeController($name);
				return true;
			}
			// Si encuentra la ruta, divide la ruta en el controlador y la acción
			return false;
		}
		// Busca una ruta con parametros
		protected function _getParameterRoute($routes, &$controller, &$action)
		{
			$uri = $this->_getUri();
			// itera sobre el las rutas en el array config/routes.php
			foreach ($routes as $route => $path) {
				//verifica si la ruta tiene parametros 
				if ($this->hasParameters($route)) {
					// divide la ruta en partes separadas por /:
					$uriParts = explode('/:', $route);
					$pattern = '/^';
					if ($uriParts[0] == '') {
						$pattern .= '\\/';
					}
					else {
						$pattern .= str_replace('/', '\\/', $uriParts[0]);
					}
						
					foreach (range(1, count($uriParts)-1) as $index) {
						$pattern .= '\/([a-zA-Z0-9]+)';
					}
					
					$pattern .= '[\/]{0,1}$/';
					//  Construye una expresión regular para comparar la URI con la ruta parametrizada.	
					$namedParameters = array();
					//Si coincide con la ruta parametrizada, divide la cadena del path en el nombre del controlador y la acción, crea una instancia del controlador y añade los parametros dinamicos al controlador
					$match = preg_match($pattern, $uri, $namedParameters);
					if ($match) {
						list($name, $action) = explode('#', $path);
						$controller = $this->_initializeController($name);
						foreach (range(1, count($namedParameters)-1) as $index) {
							$controller->addNamedParameter(
									$uriParts[$index],
									$namedParameters[$index]
							);
						}
						return true;
					}
				}
			}
			
			return false;
		}

		protected function _initializeController($name)
		{
			$controller = ucfirst($name) . 'Controller';
			return new $controller();
		}
	}
?>