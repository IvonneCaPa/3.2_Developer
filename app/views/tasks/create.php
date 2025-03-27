<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Tarea</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-blue-500">Crear Nueva Tarea</h1>
        <form action="index.php?action=create" method="POST" class="space-y-4">
            <div>
                <label for="title" class="block text-gray-700 font-bold mb-2">Título</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
            <div>
                <label for="description" class="block text-gray-700 font-bold mb-2">Descripción</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
            </div>
            <div class="flex space-x-4">
                <button 
                    type="submit" 
                    class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition"
                >
                    Guardar Tarea
                </button>
                <a 
                    href="index.php?action=index" 
                    class="w-full text-center bg-gray-200 text-gray-700 py-2 rounded-md hover:bg-gray-300 transition"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>
