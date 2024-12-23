<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function register()
    {
        return view('auth/register');
    }

    public function store()
    {
        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'user' // Por defecto, el usuario será un cliente
        ];

        $userModel->save($data);

        return redirect()->to('/login')->with('success', 'Registration successful. Please log in.');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function authenticate()
    {
        $userModel = new \App\Models\UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Crear la sesión del usuario
            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'isLoggedIn' => true,
            ]);

            // Redirigir según el rol
            if ($user['role'] === 'admin') {
                return redirect()->to('/admin');
            } else {
                return redirect()->to('/dashboard');
            }
        }

        return redirect()->back()->with('error', 'Invalid login credentials.');
    }

    public function logout()
    {
        session()->destroy(); // Destruir la sesión
        return redirect()->to('/login'); // Redirigir al formulario de inicio de sesión
    }
}
