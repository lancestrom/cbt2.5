<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CBT SMK TUNAS HARATPAN</title>
    <link rel="icon" type="image/png" href="https://smkth-jakbar.com/assets/images/logo.png" />
    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>assets/siswa/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>assets/siswa/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-md">
                                <div class="p-5">
                                    <div class="row">
                                        <div class="col-md mb-3">
                                            <h5 class="text-center">
                                                <img src="<?= base_url() ?>assets/images/logo.png"
                                                    style="width: 150px;height: 150px;" alt="IMG">
                                            </h5>
                                        </div>
                                    </div>
                                    <h4 class="text-center text-danger font-weight-bolder">
                                        <!-- <?= $this->agent->browser()  ?> br -->
                                        <div class="clock">
                                            <span id="hours">00</span> :
                                            <span id="minutes">00</span> :
                                            <span id="seconds">00</span>
                                        </div>
                                    </h4>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">SILAHKAN LOGIN</h1>
                                    </div>

                                    <?php if ($this->session->flashdata('pesan')): ?>
                                        <div class="mb-3"><?= $this->session->flashdata('pesan') ?></div>
                                    <?php endif; ?>

                                    <form class="user" method="post"
                                        action="<?= base_url('siswa_login/proses_login') ?>">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="username"
                                                placeholder="Masukan Username..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="password"
                                                placeholder="Masukan Password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>
        function updateClock() {
            const now = new Date();

            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();

            // Tambah 0 di depan jika < 10
            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            document.getElementById('hours').innerText = hours;
            document.getElementById('minutes').innerText = minutes;
            document.getElementById('seconds').innerText = seconds;
        }

        // Update tiap 1 detik
        setInterval(updateClock, 1000);
        updateClock();
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>assets/siswa/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/siswa/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>assets/siswa/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>assets/siswa/js/sb-admin-2.min.js"></script>

</body>

</html>