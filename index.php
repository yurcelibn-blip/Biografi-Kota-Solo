<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biografi Kota Solo - The Spirit of Java</title>
    <link rel="icon" href="image/KOTA SOLO.jpg" />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#hero">Kota Solo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-dark">
                    <li class="nav-item">
                        <a class="nav-link" href="#hero">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#article">Kuliner</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">Galeri</a>
                    </li>

                    <li class="nav-item">
                         <a class="nav-link" href="#schedule">Schedule</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#aboutme">About Me</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>

                     <li class="nav-item">
                         <a class="nav-link" href="login.php" target="_blank">Login</a>
                    </li>

                  <li class="nav-item ms-3">
                        <button class="btn btn-outline-dark btn-sm me-1" onclick="ubahKeDark()">
                            <i class="bi bi-moon-stars-fill"></i> Dark
                        </button>
                        <button class="btn btn-outline-warning btn-sm" onclick="ubahKeLight()">
                            <i class="bi bi-sun-fill"></i> Light
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="hero" class="text-center p-5 bg-primary-subtle">
        <div class="container">
            <div class="row d-sm-flex align-items-center">
                <div class="col-md-6">
                    <img src="image/KOTA SOLO.jpg" class="img-fluid rounded" alt="Kota Solo Surakarta">
                </div>
                <div class="col-md-6 text-sm-start mt-4 mt-md-0">
                    <h1 class="fw-bold display-4">Selamat Datang di Surakarta</h1>
                    <div class="h5 text-danger">
                        <span id="tanggal"></span> | <span id="jam"></span>
                    </div>
                    <p class="lead">Kota Solo atau Surakarta adalah sebuah kota warisan budaya yang kaya akan sejarah dan tradisi Jawa. Website ini akan mengajak Anda menelusuri setiap sudut kota yang menawan.</p>
                    <p><strong>Sejarah Singkat:</strong> Perpindahan pusat pemerintahan dari Kartasura ke Desa Sala pada 17 Februari 1745 menjadi hari jadi Kota Solo. Keraton baru ini diberi nama Keraton Surakarta Hadiningrat.</p>
                </div>
            </div>
        </div>
    </section>

    <?php include "koneksi.php"; ?>
<section id="article" class="text-center p-5">
    <div class="container">
        <h1 class="fw-bold display-4 pb-3">Kuliner Khas yang Wajib Dicoba</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
            <?php
            $sql = "SELECT * FROM article ORDER BY tanggal DESC";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()){
            ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="image/<?= $row["gambar"]?>" class="card-img-top" alt="..." style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row["judul"]?></h5>
                            <p class="card-text text-truncate"><?= $row["isi"]?></p>
                        </div>
                        <div class="card-footer">
                            <small class="text-body-secondary">
                                <?= $row["tanggal"]?>
                            </small>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>
           

   <section id="gallery" class="text-center p-5">
  <div class="container">
    <h1 class="fw-bold display-4 pb-3">gallery</h1>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
      <div class="carousel-inner">
        <?php
        
        $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
        $hasil = $conn->query($sql);
        
        $active = "active"; 
        
        if ($hasil->num_rows > 0) {
            while ($row = $hasil->fetch_assoc()) {
        ?>
            <div class="carousel-item <?= $active ?>">
                <img src="image/<?= $row['gambar'] ?>" class="d-block w-100" alt="<?= $row['deskripsi'] ?>" style="height: 500px; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                   <h5><?= $row['deskripsi'] ?></h5> 
                </div>
            </div>
        <?php
                $active = ""; 
            }
        } else {
            
            echo '<div class="carousel-item active">
                    <img src="https://via.placeholder.com/1200x500?text=Belum+Ada+Gallery" class="d-block w-100" alt="Placeholder">
                  </div>';
        }
        ?>
    </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</section>

     <section id="schedule" class="text-center p-5">
    <div class="container">
        <h1 class="fw-bold display-4 pb-3">Schedule</h1>
        
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 p-4 shadow-sm">
                    <div class="display-4 text-danger mb-3"><i class="bi bi-book"></i></div>
                    <h5 class="fw-bold">Membaca</h5>
                    <p class="small text-muted">Menambah wawasan setiap pagi sebelum beraktivitas.</p>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 p-4 shadow-sm">
                    <div class="display-4 text-danger mb-3"><i class="bi bi-laptop"></i></div>
                    <h5 class="fw-bold">Menulis</h5>
                    <p class="small text-muted">Mencatat setiap pengalaman harian di jurnal pribadi.</p>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 p-4 shadow-sm">
                    <div class="display-4 text-danger mb-3"><i class="bi bi-people"></i></div>
                    <h5 class="fw-bold">Diskusi</h5>
                    <p class="small text-muted">Bertukar ide dengan teman dalam kelompok belajar.</p>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 p-4 shadow-sm">
                    <div class="display-4 text-danger mb-3"><i class="bi bi-bicycle"></i></div>
                    <h5 class="fw-bold">Olahraga</h5>
                    <p class="small text-muted">Menjaga kesehatan dengan bersepeda sore hari.</p>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 p-4 shadow-sm">
                    <div class="display-4 text-danger mb-3"><i class="bi bi-film"></i></div>
                    <h5 class="fw-bold">Movie</h5>
                    <p class="small text-muted">Menonton film yang bagus di bioskop.</p>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 p-4 shadow-sm">
                    <div class="display-4 text-danger mb-3"><i class="bi bi-bag"></i></div>
                    <h5 class="fw-bold">Belanja</h5>
                    <p class="small text-muted">Membeli kebutuhan bulanan di supermarket.</p>
                </div>
             </div>
         </div>
     </div> </section>

    <section id="aboutme" class="p-5 bg-info-subtle">
    <div class="container">
        <h1 class="fw-bold display-4 text-center pb-4">About Me</h1>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion shadow" id="accordionAboutMe">
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Universitas Dian Nuswantoro Semarang (2024-Now)
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionAboutMe">
                            <div class="accordion-body">
                                <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                SMA Batik 1 Surakarta (2020-2023)
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionAboutMe">
                            <div class="accordion-body">
                                Pendidikan Sekolah Menengah Atas di SMA Batik 1 Surakarta.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                SMP Al-Azhar Syifa Budi Solo (2017-2020)
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionAboutMe">
                            <div class="accordion-body">
                                Pendidikan Sekolah Menengah Pertama di SMP Al-Azhar Syifa Budi Solo.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div> </section>

    <section id="kontak" class="text-center p-5">
        <div class="container">
            <h1 class="fw-bold display-4 pb-3">Bagikan Pengalamanmu!</h1>
            <p class="lead">Punya cerita menarik atau masukan untuk pengembangan pariwisata Solo?</p>
            
            <form action="#" method="post" class="col-lg-8 mx-auto text-start">
                <fieldset>
                    <legend class="fs-4 mb-3">Formulir Masukan</legend>
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Anda:</label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Tulis nama Anda" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="contoh@email.com" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="favorit" class="form-label">Tempat Favorit di Solo:</label>
                        <select id="favorit" name="favorit" class="form-select">
                            <option value="keraton">Keraton Surakarta</option>
                            <option value="pasar_gede">Pasar Gede</option>
                            <option value="laweyan">Kampung Batik Laweyan</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="pesan" class="form-label">Cerita atau Masukan:</label>
                        <textarea id="pesan" name="pesan" rows="5" class="form-control" placeholder="Ceritakan pengalamanmu..."></textarea>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" id="setuju" name="setuju" class="form-check-input" required>
                        <label for="setuju" class="form-check-label">Saya menyatakan data yang diisi adalah benar.</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Kirim Cerita</button>
                </fieldset>
            </form>
        </div>
    </section>

    <footer class="text-center p-5">
        <div class="container">
            <div>
                <a href="#" class="h2 p-2 text-dark"><i class="bi bi-instagram"></i></a>
                <a href="#" class="h2 p-2 text-dark"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="h2 p-2 text-dark"><i class="bi bi-whatsapp"></i></a>
            </div>
            
            <div class="mt-3">
                <p>&#169; 2025 - Website Informasi Kota Solo. Dibuat oleh [Yurcel Ibnu Sina - A11.2024.15625 - Teknik Informatika].</p>
            </div>
        </div>
    </footer>

    <button type="button" id="backToTop" class="btn btn-danger rounded-circle position-fixed bottom-0 end-0 m-3 d-none p-3 shadow">
        <i class="bi bi-arrow-up h4"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script type="text/javascript">
        
        function tampilWaktu() {
            var waktu = new Date();
            var bulan = waktu.getMonth();
            var tanggal = waktu.getDate();
            var tahun = waktu.getFullYear();
            var jam = waktu.getHours();
            var menit = waktu.getMinutes();
            var detik = waktu.getSeconds();

            var arrBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

            var tanggal_full = tanggal + " " + arrBulan[bulan] + " " + tahun;
            var jam_full = jam + ":" + menit + ":" + detik;

            document.getElementById("tanggal").innerHTML = tanggal_full;
            document.getElementById("jam").innerHTML = jam_full;
        }

        tampilWaktu(); 
        setInterval(tampilWaktu, 1000);

        const backToTopBtn = document.getElementById("backToTop");

        backToTopBtn.addEventListener("click", function() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        });

        window.addEventListener("scroll", function() {
            if (window.scrollY > 300) {
                backToTopBtn.classList.remove("d-none"); 
                backToTopBtn.classList.add("d-block");  
            } else {
                backToTopBtn.classList.remove("d-block"); 
                backToTopBtn.classList.add("d-none");    
            }
        });

        function ubahKeDark() {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
        }
        function ubahKeLight() {
            document.documentElement.setAttribute('data-bs-theme', 'light');
        }
    </script>
</body>

</html>
