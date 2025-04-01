<?php
	// esta clase encapsula la lógica para acceder a los datos de la solicitud HTTP.
	class Request
	{
		//  Este método público verifica si la solicitud actual es de tipo POST.
		public function isPost()
		{
			return ($_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);
		}
		// Este método protegido verifica si la solicitud actual es de tipo GET.
		protected function _isGet()
		{
			return ($_SERVER['REQUEST_METHOD'] == 'GET' ? true : false);
		}
		// Este método público obtiene el valor de un parámetro de la solicitud.
		public function getParam($key, $default = null)
		{
			if ($this->isPost()) {
				if(isset($_POST[$key])) {
					return $_POST[$key];
				}
			}
			else if ($this->_isGet()) {
				if(isset($_GET[$key])) {
					return $_GET[$key];
				}
			}
				
			return $default;
		}
		
		// Este método público obtiene todos los parámetros de la solicitud.
		public function getAllParams()
		{
			if ($this->isPost()) {
				return $_POST;
			}
			else if ($this->_isGet()) {
				return $_GET;
			}
		}
	}
