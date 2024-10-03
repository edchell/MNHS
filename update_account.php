<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'boxes.php'; // Assuming this includes your database connection

    // Get and sanitize input
    $id = $_POST['id'];
    $fname = htmlspecialchars($_POST['fname'], ENT_QUOTES, 'UTF-8');
    $lname = htmlspecialchars($_POST['lname'], ENT_QUOTES, 'UTF-8');
    $user = htmlspecialchars($_POST['user'], ENT_QUOTES, 'UTF-8');
    $pwd = $_POST['pwd'];
    $type = $_POST['type'];
    $current = $_POST['admin'];

    // Use prepared statements for security
    $stmt = $conn->prepare("SELECT PASSWORD FROM user WHERE USER_ID = ?");
    $stmt->bind_param("i", $id); // 'i' indicates the variable type is integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the current password
        if (password_verify($current, $row['PASSWORD'])) {
            // Hash the new password if it's provided
            if (!empty($pwd)) {
                $hashed_password = password_hash($pwd, PASSWORD_BCRYPT);
            } else {
                // Use the existing password if no new password is provided
                $hashed_password = $row['PASSWORD'];
            }

            // Update user information
            $update_stmt = $conn->prepare("UPDATE user SET FIRSTNAME = ?, LASTNAME = ?, USER = ?, PASSWORD = ?, USER_TYPE = ? WHERE USER_ID = ?");
            $update_stmt->bind_param("sssssi", $fname, $lname, $user, $hashed_password, $type, $id); // 's' for string, 'i' for integer

            if ($update_stmt->execute()) {
                echo "<script>
                    alert('Account updated successfully');
                    location.replace(document.referrer);
                </script>";
            } else {
                echo "<script>
                    alert('Failed to update account. Please try again.');
                    location.replace(document.referrer);
                </script>";
            }
        } else {
            echo "<script>
                alert('Current password is incorrect.');
                location.replace(document.referrer);
            </script>";
        }
    } else {
        echo "<script>
            alert('User not found.');
            location.replace(document.referrer);
        </script>";
    }

    $stmt->close();
    $update_stmt->close();
    mysqli_close($conn);
}
?>
