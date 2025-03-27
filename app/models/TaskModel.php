<?php
    class TaskModel {
        private $filePath;

        public function __construct() {
            $this->filePath = dirname(__DIR__, 2) . '/data/tasks.json';
        }

        public function getTasks() {
            // Crear archivo si no existe
            if (!file_exists($this->filePath)) {
                file_put_contents($this->filePath, json_encode([]));
            }

            // Leer tareas
            $tasksJson = file_get_contents($this->filePath);
            return json_decode($tasksJson, true) ?: [];
        }

        public function addTask($task) {
            $tasks = $this->getTasks();
            $task['id'] = uniqid();
            $task['created_at'] = date('Y-m-d H:i:s');
            $tasks[] = $task;
            file_put_contents($this->filePath, json_encode($tasks));
            return $task;
        }

        public function deleteTask($taskId) {
            $tasks = $this->getTasks();
            $tasks = array_filter($tasks, function($task) use ($taskId) {
                return $task['id'] !== $taskId;
            });
            file_put_contents($this->filePath, json_encode(array_values($tasks)));
        }
    }
    
?>