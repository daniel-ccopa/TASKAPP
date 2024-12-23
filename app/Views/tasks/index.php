<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Panel de Tareas -->
            <div class="col-md-8">
                <h1>Task Dashboard</h1>
                <a href="/tasks/create" class="btn btn-primary mb-3">Add New Task</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?= esc($task['title']) ?></td>
                                <td><?= esc($task['description']) ?></td>
                                <td><?= esc($task['status']) ?></td>
                                <td>
                                    <a href="/tasks/edit/<?= $task['id'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="/tasks/delete/<?= $task['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- ChatGPT -->
            <div class="col-md-4">
                <h2>Chat Support</h2>
                <div id="chat-box" style="border: 1px solid #ccc; padding: 10px; height: 400px; overflow-y: scroll; margin-bottom: 10px;">
                    <!-- Mensajes del chat aparecerán aquí -->
                </div>
                <form id="chat-form">
                    <div class="mb-3">
                        <textarea id="user-message" name="message" class="form-control" placeholder="Escribe tu consulta..." rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Enviar</button>
                </form>
            </div>
            <div class="mt-5">
                <h2>Consulta de DNI</h2>
                <form id="dni-form">
                    <div class="mb-3">
                        <label for="dni-input" class="form-label">Número de DNI</label>
                        <input type="text" id="dni-input" class="form-control" maxlength="8" placeholder="Ingresa DNI" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Consultar</button>
                </form>
                <div id="dni-result" class="mt-4">
                    <!-- Los resultados aparecerán aquí -->
                </div>
            </div>
        </div>
    </div>

    <script>
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const userMessage = document.getElementById('user-message');

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const message = userMessage.value.trim();
            if (!message) {
                chatBox.innerHTML += `<div><strong>Error:</strong> El mensaje no puede estar vacío.</div>`;
                return;
            }

            // Mostrar el mensaje del usuario en el chat
            chatBox.innerHTML += `<div><strong>Usuario:</strong> ${message}</div>`;
            userMessage.value = ''; // Limpiar el área de texto

            try {
                // Enviar el mensaje al servidor
                const response = await axios.post('/chat/sendMessage', { message }, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (response.data.status === 'success') {
                    chatBox.innerHTML += `<div><strong>ChatGPT:</strong> ${response.data.message}</div>`;
                } else {
                    chatBox.innerHTML += `<div><strong>Error:</strong> ${response.data.message}</div>`;
                }
            } catch (error) {
                chatBox.innerHTML += `<div><strong>Error:</strong> No se pudo enviar el mensaje al servidor.</div>`;
            }

            // Hacer scroll automático hacia abajo
            chatBox.scrollTop = chatBox.scrollHeight;
        });
        const dniForm = document.getElementById('dni-form');
        const dniInput = document.getElementById('dni-input');
        const dniResult = document.getElementById('dni-result');

        dniForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const dni = dniInput.value.trim();

            if (!dni || dni.length !== 8) {
                dniResult.innerHTML = `<div class="alert alert-danger">Por favor, ingresa un DNI válido de 8 dígitos.</div>`;
                return;
            }

            dniResult.innerHTML = `<div>Cargando información...</div>`;

            try {
                const response = await fetch(`/api/dni/${dni}`);
                const result = await response.json();

                if (result.success) {
                    const { nombres, apellidoPaterno, apellidoMaterno } = result.data;
                    dniResult.innerHTML = `
                        <div class="alert alert-success">
                            <strong>Información del DNI:</strong><br>
                            <ul>
                                <li><strong>Nombres:</strong> ${nombres}</li>
                                <li><strong>Apellido Paterno:</strong> ${apellidoPaterno}</li>
                                <li><strong>Apellido Materno:</strong> ${apellidoMaterno}</li>
                            </ul>
                        </div>
                    `;
                } else {
                    dniResult.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
                }
            } catch (error) {
                dniResult.innerHTML = `<div class="alert alert-danger">Ocurrió un error al consultar la API. Intenta nuevamente.</div>`;
            }
        });
    </script>
</body>
</html>
