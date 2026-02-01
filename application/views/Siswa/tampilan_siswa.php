<style>
    /* Small, self-contained styles for student dashboard */
    .student-header {
        border-radius: .5rem;
    }

    .student-clock {
        font-weight: 700;
        font-size: 1.25rem;
        letter-spacing: .1rem;
    }

    .exam-card .card-body {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .exam-empty {
        padding: 2rem;
        text-align: center;
    }

    @media (max-width: 576px) {
        .student-clock {
            font-size: 1rem;
        }
    }
</style>

<div class="row mb-3">
    <div class="col-md-8">
        <div class="card student-header shadow-sm">
            <div
                class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div>
                    <h4 class="mb-1 text-primary mb-md-0">Halo,
                        <?= htmlspecialchars($siswa['nama_siswa'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h4>
                    <div class="text-muted">Kelas:
                        <strong><?= htmlspecialchars($siswa['kelas'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></strong>
                    </div>
                </div>
                <div class="mt-3 mt-md-0 text-md-right">
                    <div class="student-clock text-danger mb-2" aria-live="polite">
                        <span id="hours">00</span> : <span id="minutes">00</span> : <span id="seconds">00</span>
                    </div>
                    <a class="btn btn-outline-danger btn-sm font-weight-bold"
                        href="<?= base_url('Dashboard_siswa/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mt-3 mt-md-0">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6 class="mb-1 text-secondary">Informasi</h6>
                <p class="small text-muted mb-0">Pastikan koneksi stabil saat mengikuti ujian.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Ujian Tersedia</h5>

                <div class="row">
                    <?php if (!empty($ujian) && is_array($ujian)): ?>
                        <?php foreach ($ujian as $row): ?>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card exam-card h-100">
                                    <div class="card-body">
                                        <div>
                                            <div class="font-weight-bold">
                                                <?= htmlspecialchars($row['nama_mapel'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></div>
                                            <?php if (!empty($row['durasi'])): ?>
                                                <div class="small text-muted">Durasi:
                                                    <?= htmlspecialchars($row['durasi'], ENT_QUOTES, 'UTF-8'); ?> menit</div>
                                            <?php endif; ?>
                                            <?php if (!empty($row['tanggal_mulai'])): ?>
                                                <div class="small text-muted">Tanggal:
                                                    <?= htmlspecialchars($row['tanggal_mulai'], ENT_QUOTES, 'UTF-8'); ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <a class="btn btn-success btn-sm" role="button"
                                                href="<?= base_url('Dashboard_siswa/detail_soal/' . htmlspecialchars($row['id_jadwal'], ENT_QUOTES, 'UTF-8')) ?>">Mulai</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info exam-empty">Tidak ada ujian tersedia saat ini. Silakan cek kembali
                                nanti.</div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    // Live clock for student dashboard
    (function() {
        function pad(v) {
            return v.toString().padStart(2, '0');
        }

        function updateClock() {
            var d = new Date();
            document.getElementById('hours').textContent = pad(d.getHours());
            document.getElementById('minutes').textContent = pad(d.getMinutes());
            document.getElementById('seconds').textContent = pad(d.getSeconds());
        }
        updateClock();
        setInterval(updateClock, 1000);
    })();
</script>