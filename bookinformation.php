<?php
$servername = "localhost";
$username = "hadila";
$password = "";
$database = "BOOKS";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $book_no = $_POST['book_no'];
    $title = $_POST['title'];
    $edition = $_POST['edition'];
    $publisher = $_POST['publisher'];

    // Check whether Book No already exists
    $check = $conn->query("SELECT * FROM book_details WHERE Book_no='$book_no'");

    if ($check->num_rows > 0) {
        echo "<p align='center' style='color:red;'>Book No already exists!</p>";
    } else {
        $sql = "INSERT INTO book_details (Book_no, Title, Edition, Publisher)
                VALUES ('$book_no', '$title', '$edition', '$publisher')";

        if ($conn->query($sql)) {
            echo "<p align='center' style='color:green;'>Book added successfully!</p>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Information</title>
</head>
<body>

<h2 align="center">BOOK INFORMATION</h2>

<form method="post">
    <table border="1" align="center" cellpadding="5">
        <tr>
            <td>Book No:</td>
            <td><input type="number" name="book_no" required></td>
        </tr>
        <tr>
            <td>Title:</td>
            <td><input type="text" name="title" required></td>
        </tr>
        <tr>
            <td>Edition:</td>
            <td><input type="text" name="edition" required></td>
        </tr>
        <tr>
            <td>Publisher:</td>
            <td><input type="text" name="publisher" required></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="submit" value="Add Book">
            </td>
        </tr>
    </table>
</form>

<br><hr><br>

<h3 align="center">All Book Details</h3>

<table border="1" align="center" cellpadding="5">
    <tr style="background-color:lightgray;">
        <th>Book No</th>
        <th>Title</th>
        <th>Edition</th>
        <th>Publisher</th>
    </tr>

    <?php
    $result = $conn->query("SELECT * FROM book_details");

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['Book_no']}</td>
                <td>{$row['Title']}</td>
                <td>{$row['Edition']}</td>
                <td>{$row['Publisher']}</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4' align='center'>No books found</td></tr>";
    }

    $conn->close();
    ?>
</table>

</body>
</html>
