<?php
include 'includes/db.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_POST['image'];
    if ($image && file_exists('./uploads/' . $image)) {
        unlink('./uploads/' . $image);
    }

    $stmt = $conn->prepare("DELETE FROM student WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
} else {
    $sql = "SELECT image FROM student WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $image = $student['image'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Student</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Delete Student</h1>
        <p>Are you sure you want to delete this student?</p>
        <form action="delete.php?id=<?php echo $id; ?>" method="POST">
            <?php if ($image): ?>
            <input type="hidden" name="image" value="<?php echo htmlspecialchars($image); ?>">
            <?php endif; ?>
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
