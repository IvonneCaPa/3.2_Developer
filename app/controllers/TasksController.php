<?php
    class TasksController extends Controller
    {
        public function indexAction()
        {
            // Create a model instance
            $taskModel = new Task();
            
            // Get all tasks
            $tasks = $taskModel->fetchAll();
            
            // Pass tasks to the view
            $this->view->tasks = $tasks;
        }
        
        public function viewAction()
        {
            // Get the task ID from the URL
            $id = $this->_getParam('id');
            
            // Create a model instance
            $taskModel = new Task();
            
            // Get specific task
            $task = $taskModel->fetchOne($id);
            
            // Pass task to the view
            $this->view->task = $task;
        }
        
        public function createAction()
        {
            // Check if the form was submitted
            if ($this->getRequest()->isPost()) {
                // Get form data
                $data = array(
                    'title' => $this->_getParam('title'),
                    'description' => $this->_getParam('description'),
                    'user' => $this->_getParam('user'),
                    'status' => $this->_getParam('status')
                );
                
                // Create a model instance
                $taskModel = new Task();
                
                // Create the task
                $taskId = $taskModel->create($data);
                
                // Redirect to the task view page
                header('Location: ' . $this->_baseUrl() . '/tasks/view/id/' . $taskId);
                exit;
            }
            
            // Display the create form
        }
        
        public function editAction()
        {
            // Get the task ID from the URL
            $id = $this->_getParam('id');
            
            // Create a model instance
            $taskModel = new Task();
            
            // Get the task to edit
            $task = $taskModel->fetchOne($id);
            
            // Pass task to the view
            $this->view->task = $task;
            
            // Check if the form was submitted
            if ($this->getRequest()->isPost()) {
                // Get form data
                $data = array(
                    'title' => $this->_getParam('title'),
                    'description' => $this->_getParam('description'),
                    'user' => $this->_getParam('user'),
                    'status' => $this->_getParam('status')
                );
                
                // Update the task
                $taskModel->update($id, $data);
                
                // Redirect to the task view page
                header('Location: ' . $this->_baseUrl() . '/tasks/view/id/' . $id);
                exit;
            }
        }
        
        public function deleteAction()
        {
            // Get the task ID from the URL
            $id = $this->_getParam('id');
            
            // Create a model instance
            $taskModel = new Task();
            
            // Delete the task
            $taskModel->delete($id);
            
            // Redirect to the tasks list
            header('Location: ' . $this->_baseUrl() . '/tasks');
            exit;
        }
    }
?>