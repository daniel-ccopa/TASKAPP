<?php

namespace App\Controllers;

use App\Models\TaskModel;

class TaskController extends BaseController
{
    public function index()
    {
        $taskModel = new TaskModel();
        $data['tasks'] = $taskModel->findAll();

        return view('tasks/index', $data);
    }

    public function create()
    {
        return view('tasks/create');
    }

    public function store()
    {
        $taskModel = new TaskModel();

        $taskModel->save([
            'user_id' => session()->get('user_id'), // Captura el usuario actual
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/dashboard');
    }

    public function edit($id)
    {
        $taskModel = new TaskModel();
        $data['task'] = $taskModel->find($id);

        return view('tasks/edit', $data);
    }

    public function update($id)
    {
        $taskModel = new TaskModel();

        $taskModel->update($id, [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/dashboard');
    }

    public function delete($id)
    {
        $taskModel = new TaskModel();
        $taskModel->delete($id);

        return redirect()->to('/dashboard');
    }
}
