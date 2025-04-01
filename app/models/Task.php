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
        
        // Create a new task
        public function create($data)
        {
            // Get current timestamp for startTime if not provided
            if (!isset($data['startTime'])) {
                $data['startTime'] = date('Y-m-d H:i:s');
            }
            
            // Set default status if not provided
            if (!isset($data['status'])) {
                $data['status'] = 'pending';
            }
            
            // Set endTime to null for new tasks
            $data['endTime'] = null;
            
            // Save and return the new task ID
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