<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';
    
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $user = $_POST['user'];
    $pwd = password_hash($_POST['pwd'], PASSWORD_ARGON2I); // Use Argon2i for hashing
    $type = $_POST['type'];

    $sql = "INSERT INTO user (FIRSTNAME, LASTNAME, PHONE, PASSWORD, USER, USER_TYPE)
            VALUES ('$fname', '$lname', '$phone', '$pwd', '$user', '$type')";

    if (mysqli_query($conn, $sql)) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  Swal.fire({
                      icon: 'success',
                      title: 'Account Created',
                      text: 'New account successfully recorded!',
                      confirmButtonText: 'OK'
                  }).then((result) => {
                      if (result.isConfirmed) {
                          location.href = 'rms.php?page=users';
                      }
                  });
              </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'There was an error creating the account: " . mysqli_error($conn) . "',
                      confirmButtonText: 'OK'
                  });
              </script>";
    }

    mysqli_close($conn);
}
?>