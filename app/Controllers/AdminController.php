<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminController extends BaseController
{
    /**
     * Mostrar la lista de usuarios registrados.
     */
    public function index()
    {
        $userModel = new UserModel();

        // Obtener todos los usuarios con rol 'user' (clientes)
        $data['users'] = $userModel->where('role', 'user')->findAll();
        $data['title'] = 'Estás en el panel del administrador';

        return view('admin/index', $data);
    }

    /**
     * Mostrar el formulario para editar un usuario.
     * 
     * @param int $id El ID del usuario a editar.
     */
    public function edit($id)
    {
        $userModel = new UserModel();

        // Buscar el usuario por ID
        $data['user'] = $userModel->find($id);

        if (!$data['user']) {
            // Redirigir si el usuario no existe
            return redirect()->to('/admin/users')->with('error', 'Usuario no encontrado.');
        }

        return view('admin/edit', $data);
    }

    /**
     * Manejar la actualización de un usuario.
     * 
     * @param int $id El ID del usuario a actualizar.
     */
    public function update($id)
    {
        $userModel = new UserModel();

        // Verificar si el usuario existe
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Usuario no encontrado.');
        }

        // Actualizar los datos del usuario
        $userModel->update($id, [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ]);

        return redirect()->to('/admin/users')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Manejar la eliminación de un usuario.
     * 
     * @param int $id El ID del usuario a eliminar.
     */
    public function delete($id)
    {
        $userModel = new UserModel();

        // Verificar si el usuario existe
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Usuario no encontrado.');
        }

        // Eliminar el usuario
        $userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'Usuario eliminado correctamente.');
    }
}
