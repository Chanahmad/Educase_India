<?php
include 'includes/db.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $current_image = $_POST['current_image'];

    if (empty($name)) {
        echo "Name is required.";
    } else {
        $image = $current_image;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileNameCmps = explode('.', $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $allowedExts = ['jpg', 'png'];

            if (in_array($fileExtension, $allowedExts)) {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $uploadFileDir = './uploads/';
                $dest_path = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $image = $newFileName;
                    // Delete the old image if a new one is uploaded
                    if ($current_image && file_exists('./uploads/' . $current_image)) {
                        unlink('./uploads/' . $current_image);
                    }
                } else {
                    echo "Error uploading the image.";
                }
            } else {
                echo "Invalid image format.";
            }
        }

        $stmt = $conn->prepare("UPDATE student SET name = ?, email = ?, address = ?, class_id = ?, image = ? WHERE id = ?");
        $stmt->bind_param('sssisi', $name, $email, $address, $class_id, $image, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php");
    }
}

$sql = "SELECT student.*, classes.name AS class_name FROM student
        JOIN classes ON student.class_id = classes.class_id
        WHERE student.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

$classes = $conn->query("SELECT * FROM classes");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Student</h1>
        <form action="edit.php?id=<?php echo $student['id']; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address"><?php echo htmlspecialchars($student['address']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="class_id">Class</label>
                <select class="form-control" id="class_id" name="class_id" required>
                    <?php while ($class = $classes->fetch_assoc()): ?>
                    <option value="<?php echo $class['class_id']; ?>" <?php echo ($class['class_id'] == $student['class_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($class['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($student['image']); ?>">
                <?php if ($student['image']): ?>
                <img src="uploads/<?php echo htmlspecialchars($student['image']); ?>" width="100" alt="Image">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
