<?php
include "koneksi.php";


$sql_article = "SELECT * FROM article";
$result_article = $conn->query($sql_article);
$total_article = $result_article ? $result_article->num_rows : 0;


$sql_gallery = "SELECT * FROM gallery";
$result_gallery = $conn->query($sql_gallery);
$total_gallery = $result_gallery ? $result_gallery->num_rows : 0;


$username = $_SESSION['username'];
$sql_user = "SELECT foto FROM user WHERE username = '$username'";
$result_user = $conn->query($sql_user);
$user_data = $result_user->fetch_assoc();
?>

<div class="container mt-2">
    <hr class="mb-5">

    <div class="text-center">
        <p class="h4 text-muted mb-1">Selamat Datang,</p>
        <h2 class="fw-bold text-danger mb-4"><?= $_SESSION['username'] ?></h2>
        
        <div class="mb-5">
            <?php
            // Cek foto di folder img/ sesuai settingan profile.php
            if (!empty($user_data['foto']) && file_exists('image/' . $user_data['foto'])) {
                echo '<img src="image/' . $user_data['foto'] . '" class="rounded-circle shadow" width="250" height="250" style="object-fit: cover; border: 5px solid #fff;">';
            } else {
                echo '<img src="https://via.placeholder.com/250" class="rounded-circle shadow" width="250" alt="No Profile">';
            }
            ?>
        </div>

        <div class="row justify-content-center g-4">
            <div class="col-md-4 col-lg-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="text-start">
                            <h5 class="card-title text-secondary mb-0">
                                <i class="bi bi-newspaper me-2"></i> Article
                            </h5>
                        </div>
                        <span class="badge rounded-pill bg-danger fs-3 px-3 py-2">
                            <?= $total_article ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="text-start">
                            <h5 class="card-title text-secondary mb-0">
                                <i class="bi bi-camera me-2"></i> Gallery
                            </h5>
                        </div>
                        <span class="badge rounded-pill bg-danger fs-3 px-3 py-2">
                            <?= $total_gallery ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
