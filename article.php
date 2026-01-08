<?php
include "koneksi.php";
include "upload_foto.php";

// --- Bagian Logika Simpan, Update, Hapus (TETAP SAMA SEPERTI ASLINYA) ---
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES['gambar']);
        if ($cek_upload['status']) {
            $gambar = $cek_upload['message'];
        } else {
            echo "<script>alert('" . $cek_upload['message'] . "'); document.location='admin.php?page=article';</script>";
            die;
        }
    }

    $stmt = $conn->prepare("INSERT INTO article (judul, isi, gambar, tanggal, username) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $judul, $isi, $gambar, $tanggal, $username);
    $simpan = $stmt->execute();

    if ($simpan) {
        echo "<script>alert('Simpan data sukses'); document.location='admin.php?page=article';</script>";
    } else {
        echo "<script>alert('Simpan data gagal'); document.location='admin.php?page=article';</script>";
    }
    $stmt->close();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $gambar_lama = $_POST['gambar_lama'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES['gambar']);
        if ($cek_upload['status']) {
            $gambar = $cek_upload['message'];
            if (file_exists("image/" . $gambar_lama) && $gambar_lama != '') {
                unlink("image/" . $gambar_lama);
            }
        } else {
            echo "<script>alert('" . $cek_upload['message'] . "'); document.location='admin.php?page=article';</script>";
            die;
        }
    } else {
        $gambar = $gambar_lama;
    }

    $stmt = $conn->prepare("UPDATE article SET judul=?, isi=?, gambar=?, tanggal=?, username=? WHERE id=?");
    $stmt->bind_param("sssssi", $judul, $isi, $gambar, $tanggal, $username, $id);
    $simpan = $stmt->execute();

    if ($simpan) {
        echo "<script>alert('Ubah data sukses'); document.location='admin.php?page=article';</script>";
    } else {
        echo "<script>alert('Ubah data gagal'); document.location='admin.php?page=article';</script>";
    }
    $stmt->close();
}

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        if (file_exists("image/" . $gambar)) {
            unlink("image/" . $gambar);
        }
    }

    $stmt = $conn->prepare("DELETE FROM article WHERE id =?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>alert('Hapus data sukses'); document.location='admin.php?page=article';</script>";
    } else {
        echo "<script>alert('Hapus data gagal'); document.location='admin.php?page=article';</script>";
    }
    $stmt->close();
}
?>

<div class="container">
    <div class="row mb-2">
        <div class="col-md-6">
            <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg"></i> Tambah Article
            </button>
        </div>
        <div class="col-md-6 text-end">
             <input type="text" name="search" id="search" class="form-control" placeholder="ketikan minimal 3 karakter untuk pencarian...">
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th class="w-25">Judul</th>
                    <th class="w-75">Isi</th>
                    <th class="w-25">Gambar</th>
                    <th class="w-25">Aksi</th>
                </tr>
            </thead>
            <tbody id="result"> 
                <?php
                $sql = "SELECT * FROM article ORDER BY tanggal DESC";
                $hasil = $conn->query($sql);

                $no = 1;
                while ($row = $hasil->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <strong><?= $row["judul"] ?></strong>
                            <br>
                            <small>pada: <?= $row["tanggal"] ?></small>
                            <br>
                            <small>oleh: <?= $row["username"] ?></small>
                        </td>
                        <td><?= $row["isi"] ?></td>
                        <td>
                            <?php
                            if ($row["gambar"] != "") {
                                if (file_exists('image/' . $row["gambar"] . '')) {
                            ?>
                                    <img src="image/<?= $row["gambar"] ?>" width="100">
                            <?php
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <a href="#" title="edit" class="badge rounded-pill text-bg-warning text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="#" title="delete" class="badge rounded-pill text-bg-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id'] ?>">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit<?= $row['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Article</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <input type="hidden" name="gambar_lama" value="<?= $row['gambar'] ?>">
                                        <div class="mb-3">
                                            <label for="judul" class="form-label">Judul</label>
                                            <input type="text" class="form-control" name="judul" value="<?= $row['judul'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="isi" class="form-label">Isi</label>
                                            <textarea class="form-control" name="isi" required><?= $row['isi'] ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="gambar" class="form-label">Ganti Gambar</label>
                                            <input type="file" class="form-control" name="gambar">
                                        </div>
                                        <div class="mb-3">
                                            <label for="gambar" class="form-label">Gambar Lama</label><br>
                                            <?php
                                            if ($row["gambar"] != "") {
                                                if (file_exists('image/' . $row["gambar"] . '')) {
                                            ?>
                                                    <img src="image/<?= $row["gambar"] ?>" width="100">
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" value="update" name="update" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalHapus<?= $row['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="formGroupExampleInput" class="form-label">Yakin akan menghapus artikel "<strong><?= $row['judul'] ?></strong>"?</label>
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="gambar" value="<?= $row['gambar'] ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" value="hapus" name="hapus" class="btn btn-primary">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Article</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" name="judul" placeholder="Tuliskan Judul Artikel" required>
                        </div>
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi</label>
                            <textarea class="form-control" name="isi" placeholder="Tuliskan Isi Artikel" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" name="gambar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" value="simpan" name="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    loadData();

    function loadData(keyword){
        $.ajax({
            method: "POST",
            url: "article_data.php",
            data: { keyword: keyword },
            success: function(hasil){
                $('#result').html(hasil);
            }
        });
    }

    $('#search').on('keyup', function(){
        var keyword = $(this).val();
        loadData(keyword);
    });
});
</script>