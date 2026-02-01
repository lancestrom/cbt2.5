<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= htmlspecialchars($title ?? 'Login', ENT_QUOTES, 'UTF-8') ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="https://smkth-jakbar.com/assets/images/logo.png" />

    <!-- Vendor CSS (kept as-is) -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/login/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/login/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/login/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/login/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/login/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/login/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/login/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/login/css/main.css">

    <style>
        /* Small, local tweaks */
        body {
            background-color: #f4f6f8;
        }

        .login-card {
            border-radius: .6rem;
            overflow: hidden;
        }

        .login-side {
            background-image: url('https://smkth-jakbar.com/assets/images/background3.jpeg');
            background-size: cover;
            background-position: center;
        }

        .logo-img {
            width: 140px;
            height: 140px;
            object-fit: contain;
        }

        .meta-small {
            font-size: .9rem;
            color: #6c757d;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }

        .flash-alert {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>

    <main role="main" class="d-flex align-items-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center align-items-center">

                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="card login-card shadow-sm">
                        <div class="row no-gutters">
                            <div class="col-md-5 d-none d-md-block login-side"></div>
                            <div class="col-md-7">
                                <div class="card-body p-4">

                                    <div class="text-center mb-3">
                                        <img src="https://smkth-jakbar.com/assets/images/logo.png" alt="Logo"
                                            class="logo-img mb-2">
                                        <h5 class="mb-0">CBT ADMIN</h5>
                                        <div class="meta-small text-uppercase">SMK Tunas Harapan</div>
                                    </div>

                                    <!-- Flash messages (allow raw HTML but also fallback to plain text) -->
                                    <?php if ($this->session->flashdata('pesan')): ?>
                                        <div class="flash-alert"><?= $this->session->flashdata('pesan'); ?></div>
                                    <?php endif; ?>

                                    <form method="POST" action="<?= base_url() ?>Login/proses_login" novalidate>

                                        <div class="form-group">
                                            <label for="username" class="sr-only">Username</label>
                                            <input id="username" autofocus class="form-control" type="text"
                                                name="username" placeholder="Username" required aria-required="true">
                                        </div>

                                        <div class="form-group">
                                            <label for="password" class="sr-only">Password</label>
                                            <input id="password" class="form-control" type="password" name="password"
                                                placeholder="Password" required aria-required="true">
                                        </div>

                                        <div class="form-group text-center">
                                            <button type="submit"
                                                class="btn btn-primary btn-block font-weight-bold">Login</button>
                                        </div>

                                        <div class="text-center meta-small">
                                            <div>
                                                <?= htmlspecialchars($this->agent->browser() ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                                •
                                                <?= htmlspecialchars($this->input->ip_address() ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="text-center text-muted small mt-3">Pastikan username & password Anda benar. Hubungi admin
                        jika ada masalah.</p>
                </div>

            </div>
        </div>
    </main>


    <!-- Vendor JS (kept as-is) -->
    <script src="<?= base_url() ?>assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= base_url() ?>assets/login/vendor/animsition/js/animsition.min.js"></script>
    <script src="<?= base_url() ?>assets/login/vendor/bootstrap/js/popper.js"></script>
    <script src="<?= base_url() ?>assets/login/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/login/vendor/select2/select2.min.js"></script>
    <script src="<?= base_url() ?>assets/login/vendor/daterangepicker/moment.min.js"></script>
    <script src="<?= base_url() ?>assets/login/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="<?= base_url() ?>assets/login/vendor/countdowntime/countdowntime.js"></script>
    <script src="<?= base_url() ?>assets/login/js/main.js"></script>

    <script>
        // Small UX helper: focus username on page load (try/catch for safety)
        (function() {
            try {
                document.getElementById('username').focus();
            } catch (e) {}
        })();
    </script>

</body>

</html>