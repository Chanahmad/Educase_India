# Educase_India
The School Demo project is a PHP-based application designed to manage student information and classes. This project includes functionality for creating, viewing, editing, and deleting student records, as well as managing classes. It also features image upload and validation to ensure proper file formats.

**Project Setup**

**1. Basic Setup**
Create a new PHP project named school_demo.

**2. Database Setup**
Create a MySQL database named school_db and set up the following tables:

**student**
id (int, primary key, auto-increment)
name (varchar, 255)
email (varchar, 255)
address (text)
created_at (timestamp, default current_timestamp)
class_id (int)
image (varchar, 255) — for storing image file path
created_at (datetime)

**classes**
class_id (int, primary key, auto-increment)
name (varchar, 255)
created_at (datetime)

**3. Functionality**

*Home Page (index.php)*
Display a list of all students.
Each student should show the name, email, creation date, class name, and image (thumbnail).
Include links to view, edit, and delete each student.
Use a JOIN query to fetch the class name associated with each student.

*Create Student (create.php)*
Form to input name, email, address, class (dropdown), and image upload.
Validate that the name is not empty and the image is of valid format (jpg, png).
On submission, upload the image to the server, insert the new student into the database, and redirect to the home page.
Use a JOIN query to fetch classes for the dropdown.

*View Student (view.php)*
Display the student's full name, email, address, class name, and image.
Show the creation date.
Use a JOIN query to fetch the class name.

*Edit Student (edit.php)*
Form pre-filled with the current name, email, address, class of the student (dropdown), and image upload option.
Validate that the name is not empty and the image is of valid format (jpg, png) if a new image is uploaded.
On submission, update the student in the database and redirect to the home page.
Use a JOIN query to fetch classes for the dropdown.

*Delete Student (delete.php)*
Confirm the deletion of the student.
On confirmation, delete the student (and its image from the server) from the database and redirect to the home page.

*Manage Classes (classes.php)*
Display a list of all classes with options to add, edit, and delete classes.
Form to add a new class.
Edit and delete functionalities for classes.
