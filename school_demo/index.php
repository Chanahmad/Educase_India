<?php
include 'includes/db.php';

$sql = "SELECT student.id, student.name, student.email, student.created_at, student.image, classes.name AS class_name
        FROM student
        JOIN classes ON student.class_id = classes.class_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Student List</h1>
        <a href="create.php" class="btn btn-primary mb-3">Add New Student</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Creation Date</th>
                    <th>Class</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                    <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="50" alt="Image"></td>
                    <td>
                        <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-info">View</a>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
