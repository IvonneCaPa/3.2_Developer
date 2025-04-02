<?php
    class Task extends Model
    {
        public function fetchAll()
        {
            // Convert the array of tasks to an array of objects
            $taskObjects = [];
            foreach ($this->_data as $task) {
                $taskObjects[] = (object) $task;
            }
            return $taskObjects;
        }
        
        // Crea nueva tarea
        public function create($data)
        {
            // Obtiene la fecha y hora de creación
            if (!isset($data['startTime'])) {
                $data['startTime'] = date('Y-m-d H:i:s');
            }
            
            // Si no se establece status, por defecto pone pendiente
            if (!isset($data['status'])) {
                $data['status'] = 'pending';
            }
            
            // Como es nueva tarea la define como null el fin de la tarea
            $data['endTime'] = null;
            
            // Guardar y devolver el nuevo ID de tarea
            return $this->save($data);
        }
        
        // Update an existing task
        public function update($id, $data)
        {
            // Make sure ID is included
            $data['id'] = $id;
            
            // If status changed to 'done', set endTime if not already set
            if (isset($data['status']) && $data['status'] == 'done' && !isset($data['endTime'])) {
                $data['endTime'] = date('Y-m-d H:i:s');
            }
            
            // Save the updated task
            return $this->save($data);
        }
    }
?>