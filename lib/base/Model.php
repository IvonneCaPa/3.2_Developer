<?php
	class Model
	{
		protected $_filePath = '';
		protected $_data = [];

		public function __construct()
		{
			$this->_filePath = ROOT_PATH . '/data/tasks.json';
			$this->loadData();
		}

		protected function loadData()
		{
			if (file_exists($this->_filePath)) {
				$jsonData = file_get_contents($this->_filePath);
				$this->_data = json_decode($jsonData, true);
			} else {
				$this->_data = [];
			}
		}

		public function fetchOne($id)
		{
			foreach ($this->_data as $task) {
				if ($task['id'] == $id) {
					return (object) $task; // Convertir a objeto
				}
			}
			return null; // Retornar null si no se encuentra
		}

		public function save($data = array())
		{
			$this->loadData(); // Recargar los datos

			if (array_key_exists('id', $data)) {
				// Actualizar
				foreach ($this->_data as &$task) {
					if ($task['id'] == $data['id']) {
						$task = array_merge($task, $data);
						$this->writeData();
						return true;
					}
				}
			} else {
				// Insertar
				$data['id'] = strval(count($this->_data) + 1); // Asignar nuevo ID
				$this->_data[] = $data;
				$this->writeData();
				return $data['id'];
			}

			return false; // Retornar false si no se pudo guardar
		}

		public function delete($id)
		{
			$this->loadData(); // Recargar los datos
			foreach ($this->_data as $key => $task) {
				if ($task['id'] == $id) {
					unset($this->_data[$key]);
					$this->writeData();
					return true;
				}
			}
			return false; // Retornar false si no se encontró el ID
		}

		protected function writeData()
		{
			file_put_contents($this->_filePath, json_encode(array_values($this->_data), JSON_PRETTY_PRINT));
		}
	}
?>
