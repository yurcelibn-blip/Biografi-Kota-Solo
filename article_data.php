<?php
include "koneksi.php";
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";

$sql = "SELECT * FROM article WHERE judul LIKE '%$keyword%' OR isi LIKE '%$keyword%' ORDER BY tanggal DESC";
$hasil = $conn->query($sql);
$no = 1;

while ($row = $hasil->fetch_assoc()) {
?>
    <tr>
        <td><?= $no++ ?></td>
        <td>
            <strong><?= $row["judul"] ?></strong>
            <br>
            <small>
                pada : <?= $row["tanggal"] ?> <br>
                oleh : <?= $row["username"] ?>
            </small>
        </td>
        <td>
            <?= $row["isi"] ?> 
            </td>
        <td>
            <?php if ($row["gambar"] != "" && file_exists('image/' . $row["gambar"])) : ?>
                <img src="image/<?= $row["gambar"] ?>" width="100"> <?php endif; ?>
        </td>
        <td>
            <a href="#" title="edit" class="btn btn-success btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>">
                <i class="bi bi-pencil"></i>
            </a>
            <a href="#" title="delete" class="btn btn-danger btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id'] ?>">
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
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control" name="judul" value="<?= $row["judul"] ?>" placeholder="Tuliskan Judul" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi Artikel</label>
                            <textarea class="form-control" name="isi" rows="5" placeholder="Tuliskan isi artikel" required><?= $row["isi"] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ganti Gambar</label>
                            <input type="file" class="form-control" name="gambar">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Lama</label><br>
                            <?php if ($row["gambar"] != "" && file_exists('image/' . $row["gambar"])) : ?>
                                <img src="image/<?= $row["gambar"] ?>" width="100">
                            <?php endif; ?>
                            <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" value="ubah" name="ubah" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHapus<?= $row['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Article</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Yakin akan menghapus artikel "<strong><?= $row["judul"] ?></strong>"?</label>
                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                            <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" value="hapus" name="hapus" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php } ?>