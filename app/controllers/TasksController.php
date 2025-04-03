<?php
    class TasksController extends Controller
    {
        public function indexAction()
        {
            $taskModel = new Task();
            $tasks = $taskModel->fetchAll();          
            $this->view->tasks = $tasks;
        }
        
        public function viewAction()
        {
            $id = $this->_getParam('id');            
            $taskModel = new Task();
            $task = $taskModel->fetchOne($id);            
            $this->view->task = $task;
        }
        
        public function createAction()
        {

            if ($this->getRequest()->isPost()) {
                $data = array(
                    'title' => $this->_getParam('title'),
                    'description' => $this->_getParam('description'),
                    'user' => $this->_getParam('user'),
                    'status' => $this->_getParam('status')
                );

                $taskModel = new Task();
                $taskId = $taskModel->create($data);
                
                header('Location: ' . $this->_baseUrl() . '/tasks/view/id/' . $taskId);
                exit;
            }
        }
        
        public function editAction()
        {
            $id = $this->_getParam('id');
            $taskModel = new Task();
            $task = $taskModel->fetchOne($id);
            $this->view->task = $task;
            
            if ($this->getRequest()->isPost()) {
                $data = array(
                    'title' => $this->_getParam('title'),
                    'description' => $this->_getParam('description'),
                    'user' => $this->_getParam('user'),
                    'status' => $this->_getParam('status')
                );
                
                $taskModel->update($id, $data);
                
                header('Location: ' . $this->_baseUrl() . '/tasks/view/id/' . $id);
                exit;
            }
        }
        
        public function deleteAction()
        {
            $id = $this->_getParam('id');
            
            $taskModel = new Task();

            $taskModel->delete($id);
            
            header('Location: ' . $this->_baseUrl() . '/tasks');
            exit;
        }
    }
?>