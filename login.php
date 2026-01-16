<?php

session_start();


include "koneksi.php";


if (isset($_SESSION['username'])) {
    header("location:admin.php");
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user'];
   
    $password = md5($_POST['pass']);

   
    $stmt = $conn->prepare("SELECT username FROM user WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password); 
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!empty($row)) {
        
        $_SESSION['username'] = $row['username'];
        
       
        header("location:admin.php");
    } else {
      
        header("location:login.php?error=1");
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Kota Solo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-primary-subtle"> 
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 m-auto">
                <div class="card border-0 shadow rounded-5">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <i class="bi bi-person-circle display-1 text-danger"></i>
                        </div>
                        <h2 class="fw-bold mb-4">Kota Solo</h2>

                        <?php if(isset($_GET['error'])): ?>
                            <div class="alert alert-danger">Username atau Password Salah!</div>
                        <?php endif; ?>

                        <form action="" method="post">
                            <div class="mb-3 mt-3 text-start">
                                <input type="text" class="form-control rounded-4" name="user" placeholder="Username" required>
                            </div>
                            <div class="mb-3 text-start">
                                <input type="password" class="form-control rounded-4" name="pass" placeholder="Password" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-danger rounded-4">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p>Kembali ke <a href="index.html" class="text-decoration-none text-danger">Beranda</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 