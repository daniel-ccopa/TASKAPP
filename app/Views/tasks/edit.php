<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Task</h1>
        <form action="/tasks/update/<?= $task['id'] ?>" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Task Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= esc($task['title']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Task Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= esc($task['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="pending" <?= $task['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="completed" <?= $task['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update Task</button>
            <a href="/dashboard" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
