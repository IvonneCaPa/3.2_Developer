<?php
    // Estructura de directorios actualizada
    // Autoload manual simple
    function customAutoload($className) {
        $baseDir = dirname(__DIR__) . '/app';
        $className = str_replace('\\', '/', $className);
        
        $possiblePaths = [
            $baseDir . '/models/' . $className . '.php',
            $baseDir . '/controllers/' . $className . '.php'
        ];
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                require_once $path;
                return;
            }
        }
    }

    // Registrar autoload
    spl_autoload_register('customAutoload');

    // Controlador de enrutamiento
    $controller = new TaskController();

    $action = $_GET['action'] ?? 'index';

    switch ($action) {
        case 'index':
            $controller->index();
            break;
        case 'create':
            $controller->create();
            break;
        case 'delete':
            $controller->delete();
            break;
        default:
            http_response_code(404);
            echo "Página no encontrada";
            break;
    }
?>