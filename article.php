<?php
include "koneksi.php";
if (!function_exists('upload_foto')) {
    include "upload_foto.php";
}


?>

<div class="container">
    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg"></i> Tambah Article
            </button>
        </div>
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="text" id="search" class="form-control" placeholder="Cari Article...">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
           <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th class="w-25">Judul</th>
                    <th class="w-25">Isi</th>
                    <th class="w-25">Gambar</th>
                    <th class="w-25">Aksi</th>
                </tr>
            </thead>
            <tbody id="result">
                </tbody>
        </table>
    </div>

    <div class="modal fade" id="modalTambah" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Article</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul</label>
                            <input type="text" class="form-control" name="judul" placeholder="Tuliskan Judul" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Artikel</label>
                            <textarea class="form-control" name="isi" rows="5" placeholder="Tuliskan isi artikel" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Gambar</label>
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