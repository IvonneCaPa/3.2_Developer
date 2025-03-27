<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <div class="container mx-auto px-4 py-8 flex-grow">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-blue-500 text-white p-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Mis Tareas</h1>
                <a href="index.php?action=create" class="bg-white text-blue-500 px-4 py-2 rounded hover:bg-blue-50 transition">
                    Nueva Tarea
                </a>
            </div>

            <?php if (empty($tasks)): ?>
                <div class="p-4 text-center text-gray-500">
                    No hay tareas pendientes.
                </div>
            <?php else: ?>
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-4 text-left text-gray-600">Título</th>
                            <th class="p-4 text-left text-gray-600 hidden md:table-cell">Descripción</th>
                            <th class="p-4 text-left text-gray-600 hidden sm:table-cell">Creada</th>
                            <th class="p-4 text-center text-gray-600">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-4 <?= $task['completed'] ? 'line-through text-gray-500' : '' ?>">
                                    <?= htmlspecialchars($task['title']) ?>
                                </td>
                                <td class="p-4 text-gray-600 hidden md:table-cell">
                                    <?= htmlspecialchars($task['description'] ?? '') ?>
                                </td>
                                <td class="p-4 text-gray-500 hidden sm:table-cell">
                                    <?= $task['created_at'] ?? '' ?>
                                </td>
                                <td class="p-4 text-center">
                                    <a href="index.php?action=delete&id=<?= $task['id'] ?>" 
                                       onclick="return confirm('¿Estás seguro?')"
                                       class="text-red-500 hover:text-red-700 transition">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>