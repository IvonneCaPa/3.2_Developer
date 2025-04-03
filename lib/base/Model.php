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
					return (object) $task; 
				}
			}
			return null; 
		}

			public function save($data = array())
		{
			$this->loadData();

			// if (empty($data['titulo'])) {
			// 	return "Error: El campo 'titulo' no puede estar vacío.";
			// }

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
			
				$data['id'] = uniqid(); 
				$this->_data[] = $data;
				$this->writeData();
				return $data['id'];
			}

			return false; 
		}

		public function delete($id)
		{
			$this->loadData(); 
			foreach ($this->_data as $key => $task) {
				if ($task['id'] == $id) {
					unset($this->_data[$key]);
					$this->writeData();
					return true;
				}
			}
			return false; 
		}

		protected function writeData()
		{
			file_put_contents($this->_filePath, json_encode(array_values($this->_data), JSON_PRETTY_PRINT));
		}
	}
?>
