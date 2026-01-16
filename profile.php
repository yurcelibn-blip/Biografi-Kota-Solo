<?php
include "koneksi.php";
include "upload_foto.php";


$username = $_SESSION['username'];
$sql = "SELECT * FROM user WHERE username = '$username'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();


if (isset($_POST['simpan'])) {
    $password_baru = $_POST['password'];
    $foto_baru = $_FILES['foto']['name'];
    $id_user = $_POST['id'];
    $foto_lama = $_POST['foto_lama'];
    
    
    if (!empty($password_baru)) {
        
        $password_final = md5($password_baru); 
    } else {
        $password_final = $data['password'];
    }

    
    if ($foto_baru != '') {
        $cek_upload = upload_foto($_FILES["foto"]);
        if ($cek_upload['status']) {
            $foto_final = $cek_upload['message'];
            
            
            if (file_exists("img/" . $foto_lama) && $foto_lama != '') {
                unlink("img/" . $foto_lama);
            }
        } else {
            echo "<script>alert('" . $cek_upload['message'] . "');</script>";
            die;
        }
    } else {
        $foto_final = $foto_lama; 
    }

   
    $stmt = $conn->prepare("UPDATE user SET password = ?, foto = ? WHERE id = ?");
    $stmt->bind_param("ssi", $password_final, $foto_final, $id_user);
    $simpan = $stmt->execute();

    if ($simpan) {
        echo "<script>alert('Data Profile Berhasil Diperbarui'); document.location='admin.php?page=profile';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data'); document.location='admin.php?page=profile';</script>";
    }
}
?>

<div class="card shadow-sm mt-4">
    <div class="card-header bg-primary-subtle">
        <h5 class="card-title mb-0">Pengaturan Profil</h5>
    </div>
    <div class="card-body">
        <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">
            <input type="hidden" name="foto_lama" value="<?= $data['foto'] ?>">

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $data['username'] ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Ganti Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Tuliskan Password Baru Jika Ingin Mengganti Password Saja">
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Ganti Foto Profil</label>
                <input type="file" class="form-control" id="foto" name="foto">
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Profil Saat Ini</label><br>
                <?php
                if ($data['foto'] != '') {
                    if (file_exists('img/' . $data['foto'])) {
                        echo '<img src="img/' . $data['foto'] . '" class="img-thumbnail" width="150" alt="Foto Profil">';
                    } else {
                        echo '<img src="https://via.placeholder.com/150" class="img-thumbnail" alt="Foto Hilang">';
                    }
                } else {
                    echo '<img src="https://via.placeholder.com/150" class="img-thumbnail" alt="Belum Ada Foto">';
                }
                ?>
            </div>

            <div class="mb-3 text-end">
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>