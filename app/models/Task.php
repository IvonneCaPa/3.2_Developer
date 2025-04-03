<?php
    class Task extends Model
    {
        public function fetchAll()
        {
            $taskObjects = [];
            foreach ($this->_data as $task) {
                $taskObjects[] = (object) $task;
            }
            return $taskObjects;
        }
        
        public function create($data)
        {
            if (!isset($data['startTime'])) {
                $data['startTime'] = date('Y-m-d H:i:s');
            }

            if ($data['title'] === null) {
                throw new Exception("El título no puede ser null");
            }
            
            if (!isset($data['status'])) {
                $data['status'] = 'pending';
            }
            
            $data['endTime'] = null;
            
            return $this->save($data);
        }
        
        public function update($id, $data)
        {
            $data['id'] = $id;
            
            if (isset($data['status']) && $data['status'] == 'done' && !isset($data['endTime'])) {
                $data['endTime'] = date('Y-m-d H:i:s');
            }
            
            return $this->save($data);
        }
    }
?>