<?php
include('connect/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_tasks'])) {
        $selectedTasks = $_POST['selected_tasks'];

        foreach ($selectedTasks as $taskId) {
            $sql = "DELETE FROM tasks WHERE id=$taskId";
            $conn->query($sql);
        }


        header("Location: index.php");
        exit();
    } elseif (isset($_POST['create_task'])) {
        $taskName = $_POST['task_name'];
        $taskDescription = $_POST['task_description'];

        $sql = "INSERT INTO tasks (task_name, task_description) VALUES ('$taskName', '$taskDescription')";

        if ($conn->query($sql) === TRUE) {

            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ToDo App</title>
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <div class="container">
        <h1>ToDo App</h1>
        <h2>Create Task</h2>
        <form method="post" action="">
            <label for="task_name">Task Name:</label>
            <input type="text" name="task_name" required>
            
            <label for="task_description">Description:</label>
            <textarea name="task_description"></textarea>
            
            <button type="submit" name="create_task">Create Task</button>
        </form>

        <h2>All Tasks</h2>
        <form method="post" action="">
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li>
                        <input type="checkbox" name="selected_tasks[]" value="<?php echo $row['id']; ?>">
                        <strong><?php echo $row['task_name']; ?></strong>
                        - <?php echo $row['task_description']; ?>
                        <a class="update-link" href="update.php?id=<?php echo $row['id']; ?>">Edit</a>
                    </li>
                <?php endwhile; ?>
            </ul>

            <button type="submit" name="delete_tasks">Delete Tasks</button>
        </form>
    </div>
</body>
</html>
