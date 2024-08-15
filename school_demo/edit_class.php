<?php
include 'includes/db.php';

$class_id = $_GET['class_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    if (!empty($name)) {
        $stmt = $conn->prepare("UPDATE classes SET name = ? WHERE class_id = ?");
        $stmt->bind_param('si', $name, $class_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: classes.php");
    exit();
}

// Fetch class details
$sql = "SELECT * FROM classes WHERE class_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $class_id);
$stmt->execute();
$result = $stmt->get_result();
$class = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Class</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Class</h1>
        <form action="edit_class.php?class_id=<?php echo $class['class_id']; ?>" method="POST">
            <div class="form-group">
                <label for="name">Class Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($class['name']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Class</button>
        </form>
    </div>
</body>
</html>
