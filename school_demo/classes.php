<?php
include 'includes/db.php';

// Handle Add Class
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_class'])) {
    $name = $_POST['name'];
    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO classes (name) VALUES (?)");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: classes.php");
    exit();
}

// Handle Delete Class
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_class'])) {
    $class_id = $_POST['class_id'];
    $stmt = $conn->prepare("DELETE FROM classes WHERE class_id = ?");
    $stmt->bind_param('i', $class_id);
    $stmt->execute();
    $stmt->close();
    header("Location: classes.php");
    exit();
}

// Fetch existing classes
$classes = $conn->query("SELECT * FROM classes");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Classes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Manage Classes</h1>
        <form action="classes.php" method="POST">
            <div class="form-group">
                <label for="name">Class Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" name="add_class" class="btn btn-primary">Add Class</button>
        </form>
        <h2 class="mt-5">Existing Classes</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Class Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($class = $classes->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($class['name']); ?></td>
                    <td>
                        <form action="edit_class.php" method="GET" style="display:inline;">
                            <input type="hidden" name="class_id" value="<?php echo $class['class_id']; ?>">
                            <button type="submit" class="btn btn-warning">Edit</button>
                        </form>
                        <form action="classes.php" method="POST" style="display:inline;">
                            <input type="hidden" name="class_id" value="<?php echo $class['class_id']; ?>">
                            <button type="submit" name="delete_class" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
