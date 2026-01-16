<?php
include "koneksi.php";

$keyword = "";
if (isset($_POST['keyword'])) { $keyword = $_POST['keyword']; }

$sql = "SELECT * FROM gallery WHERE deskripsi LIKE '%$keyword%' ORDER BY tanggal DESC";
$hasil = $conn->query($sql);

$no = 1;
while ($row = $hasil->fetch_assoc()) {
?>
    <tr>
        <td><?= $no++ ?></td>
        <td>
            <div class="mb-1"><?= $row["deskripsi"] ?></div>
            <div style="color: #0b0b08; font-size: 0.85rem;">
                pada : <?= $row["tanggal"] ?><br>
                oleh : <?= $row["username"] ?>
            </div>
        </td>
        <td class="text-center">
            <?php
            if ($row["gambar"] != "" && file_exists('image/' . $row["gambar"])) {
                echo '<img src="image/' . $row["gambar"] . '" width="350" class="img-fluid rounded shadow-sm">';
            }
            ?>
        </td>
        <td class="text-center">
            <a href="#" class="badge rounded-pill text-bg-success mb-1 d-inline-block" data-bs-toggle="modal" data-bs-target="#modalEditGallery<?= $row['id'] ?>">
                <i class="bi bi-pencil"></i>
            </a>
            <br>
            <a href="#" class="badge rounded-pill text-bg-danger d-inline-block" data-bs-toggle="modal" data-bs-target="#modalHapusGallery<?= $row['id'] ?>">
                <i class="bi bi-x-circle"></i>
            </a>
        </td>
    </tr>

    <?php
}
?>