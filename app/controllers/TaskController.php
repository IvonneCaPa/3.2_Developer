<?php
    class TaskController {
        private $model;

        public function __construct() {
            $this->model = new TaskModel();
        }

        public function index() {
            $tasks = $this->model->getTasks();
            require dirname(__DIR__) . '/views/tasks/index.php';
        }

        public function create() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $task = [
                    'title' => $_POST['title'] ?? '',
                    'description' => $_POST['description'] ?? '',
                    'completed' => false
                ];
                $this->model->addTask($task);
                header('Location: index.php?action=index');
                exit;
            }
            require dirname(__DIR__) . '/views/tasks/create.php';
        }

        public function delete() {
            if (isset($_GET['id'])) {
                $this->model->deleteTask($_GET['id']);
                header('Location: index.php?action=index');
                exit;
            }
        }
    }