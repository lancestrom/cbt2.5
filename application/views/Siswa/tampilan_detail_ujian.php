<div class="container">
    <div class="row">
        <div class="col-md mt-4">
            <div class="card">
                <div class="card-body bg-primary text-white">
                    <h4><?= $siswa['nama_siswa'] ?>
                    </h4>
                    <h4><?= $siswa['kelas'] ?>
                    </h4>

                    <h5>
                        <a class="btn btn-danger btn-sm text-uppercase font-weight-bolder"
                            href="<?= base_url() ?>Dashboard_siswa/logout">Logout</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-center text-uppercase font-weight-bolder">
                        <?= $ujian['id_jadwal'] ?>
                    </h5>
                    <h5 class="text-center text-uppercase font-weight-bolder">
                        <?= $ujian['nama_mapel'] ?>
                    </h5>
                    <h5 class="text-center text-uppercase font-weight-bolder">
                        <?= $ujian['tanggal_mulai'] ?>
                    </h5>
                    <h5 class="text-center text-uppercase font-weight-bolder">
                        <?= $ujian['waktu_mulai'] ?> - <?= $ujian['waktu_selesai'] ?>
                    </h5>
                    <h5 class="text-center text-uppercase font-weight-bolder">
                        <?= $ujian['durasi'] ?> Menit
                    </h5>
                    <h5 class="text-center">
                        <a class="btn btn-sm btn-primary"
                            href="<?= base_url() ?>Dashboard_siswa/ujian_siswa/<?= $ujian['id_jadwal'] ?>">
                            MULAI</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>