<?php
include 'includes/db.php';

$id = $_GET['id'];
$sql = "SELECT student.*, classes.name AS class_name FROM student
        JOIN classes ON student.class_id = classes.class_id
        WHERE student.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Student</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Student Details</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($student['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($student['address']); ?></p>
        <p><strong>Class:</strong> <?php echo htmlspecialchars($student['class_name']); ?></p>
        <p><strong>Created At:</strong> <?php echo htmlspecialchars($student['created_at']); ?></p>
        <img src="uploads/<?php echo htmlspecialchars($student['image']); ?>" width="150" alt="Image">
    </div>
</body>
</html>
