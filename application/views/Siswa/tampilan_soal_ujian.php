<div class="container">
    <div class="row">
        <div class="col-md mt-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between bg-primary text-white">
                    <div>
                        <h4 class="mb-1"><?= $siswa['nama_siswa'] ?></h4>
                        <div class="small">
                            <?= isset($siswa['nama_kelas']) ? $siswa['nama_kelas'] . ' — ' : '' ?><strong><?= $siswa['nama_mapel'] ?></strong>
                        </div>
                    </div>
                    <div class="text-end small">
                        <!-- <div>Waktu server: <strong id="serverTimeHeader"><?= date('Y-m-d H:i:s') ?></strong></div> -->
                        <div class="mt-1">Total Soal: <strong><?= count($soal) ?></strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md mt-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div><strong>SOAL UJIAN</strong></div>
                    <div class="small text-muted">Durasi per soal: <strong>3 detik</strong></div>
                </div>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <div class="card mb-3">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                    data-toggle="collapse" data-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    Jumlah Soal
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="card-body p-2" id="questionNav"
                                                    style="max-height:420px; overflow:auto;">
                                                    <div id="qBtns" class="d-flex flex-wrap"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-header">Pilih Soal</div> -->

                                <div class="card-footer">
                                    <div class="progress">
                                        <div id="progressBar" class="progress-bar bg-success" role="progressbar"
                                            style="width:0%">0%</div>
                                    </div>
                                    <div class="small text-muted mt-2">Terjawab: <span id="answeredCount">0</span> /
                                        <span id="totalCount"><?= count($soal) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Questions: render all but show one at a time via JS -->
                                    <!-- Wrap all questions in a single form so final submit sends all answers -->
                                    <form id="examForm" method="post"
                                        action="<?= base_url('Dashboard_siswa/simpan_jawaban') ?>">

                                        <input type="hidden" name="id_mapel"
                                            value="<?= isset($soal[0]['id_mapel']) ? $soal[0]['id_mapel'] : '' ?>">

                                        <div id="recoverAlert" class="alert alert-info d-none small">Jawaban dipulihkan
                                            dari sesi sebelumnya. Pastikan meninjau dan mengirim kembali.</div>

                                        <div id="questions">
                                            <?php
                                            $no = 1;
                                            foreach ($soal as $idx => $row) {
                                                $soal_id = isset($row['id_soal']) ? $row['id_soal'] : $idx;
                                            ?>
                                            <div class="question" data-index="<?= $idx ?>"
                                                data-soal-id="<?= $soal_id ?>">
                                                <h5 class="mb-3">Soal <?= $no++; ?></h5>
                                                <div class="mb-3"> <?= $row['soal'] ?> </div>

                                                <?php if (!empty($row['gambar']) && file_exists(FCPATH . 'assets/images/gambar/' . $row['gambar'])) : ?>
                                                <div class="text-center mb-3">
                                                    <img src="<?= base_url('assets/images/gambar/' . $row['gambar']) ?>"
                                                        alt="Gambar soal <?= $idx + 1 ?>"
                                                        class="img-fluid rounded shadow-sm"
                                                        style="max-height:360px; object-fit:contain;">
                                                </div>
                                                <?php endif; ?>
                                                <!-- answer inputs named as array keyed by soal id -->
                                                <div class="list-group mb-2">
                                                    <label class="list-group-item list-group-item-action">
                                                        <input class="form-check-input me-2" type="radio"
                                                            name="jawaban[<?= $soal_id ?>]" value="A"
                                                            id="q<?= $soal_id ?>a">
                                                        <strong>A.</strong> <?= $row['pilA'] ?>
                                                    </label>
                                                    <label class="list-group-item list-group-item-action">
                                                        <input class="form-check-input me-2" type="radio"
                                                            name="jawaban[<?= $soal_id ?>]" value="B"
                                                            id="q<?= $soal_id ?>b">
                                                        <strong>B.</strong> <?= $row['pilB'] ?>
                                                    </label>
                                                    <label class="list-group-item list-group-item-action">
                                                        <input class="form-check-input me-2" type="radio"
                                                            name="jawaban[<?= $soal_id ?>]" value="C"
                                                            id="q<?= $soal_id ?>c">
                                                        <strong>C.</strong> <?= $row['pilC'] ?>
                                                    </label>
                                                    <label class="list-group-item list-group-item-action">
                                                        <input class="form-check-input me-2" type="radio"
                                                            name="jawaban[<?= $soal_id ?>]" value="D"
                                                            id="q<?= $soal_id ?>d">
                                                        <strong>D.</strong> <?= $row['pilD'] ?>
                                                    </label>
                                                    <label class="list-group-item list-group-item-action">
                                                        <input class="form-check-input me-2" type="radio"
                                                            name="jawaban[<?= $soal_id ?>]" value="E"
                                                            id="q<?= $soal_id ?>e">
                                                        <strong>E.</strong> <?= $row['pilE'] ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <!-- Controls -->
                                        <div class="d-flex align-items-center mt-3" id="controls">
                                            <button id="prevBtn" type="button" class="btn btn-secondary mr-2"
                                                disabled>Prev</button>
                                            <button id="nextBtn" type="button" class="btn btn-primary mr-2"
                                                disabled>Next</button>
                                            <div id="timerDisplay" class="ml-2 text-muted">Jeda: <span
                                                    id="timer">3</span>s</div>
                                            <!-- <div class="ml-4" id="serverClock">Waktu server: <strong
                                                    id="serverTime"><?= date('Y-m-d H:i:s') ?></strong> <small
                                                    class="text-muted">(<?= date_default_timezone_get() ?>)</small>
                                            </div> -->
                                            <div class="ml-auto d-flex align-items-center" id="progress">
                                                <div class="me-3">Soal <span id="current">1</span> / <span
                                                        id="total"><?= count($soal) ?></span></div>
                                                <!-- Submit button: hidden until last question -->

                                                <button type="submit"
                                                    class="btn btn-success ml-3 d-none">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* subtle show/hide animation for questions */
.question {
    display: none;
    opacity: 0;
    transition: opacity .35s ease-in-out;
}

.question.show {
    display: block;
    opacity: 1;
}

/* question nav buttons */
.qnav {
    min-width: 40px;
}

.qnav.current {
    background: #0d6efd;
    color: #fff;
}

.qnav.answered {
    border-color: #28a745;
}

/* simple modal */
.modal-backdrop-custom {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1050;
}

.modal-custom {
    background: #fff;
    padding: 20px;
    border-radius: 6px;
    max-width: 480px;
    width: 90%;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}
</style>

<!-- JS: timer, server clock and navigation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const questions = Array.from(document.querySelectorAll('.question'));
    const total = questions.length;
    let current = 0;
    let countdown = null; // interval
    const delaySeconds = 3; // 3 seconds delay per requirement
    let remaining = delaySeconds; // seconds per question

    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const timerEl = document.getElementById('timer');
    const currentEl = document.getElementById('current');
    const totalEl = document.getElementById('total');
    const submitBtn = document.getElementById('submitBtn');
    const examForm = document.getElementById('examForm');
    const qBtnsContainer = document.getElementById('qBtns');
    const progressBar = document.getElementById('progressBar');
    const answeredCountEl = document.getElementById('answeredCount');
    const serverTimeElHeader = document.getElementById('serverTimeHeader');
    const serverTimeEl = document.getElementById('serverTime');

    // Server time initialization from PHP server time (will tick client-side)
    let serverTs = <?= time() ?> * 1000; // milliseconds

    function formatServerTime(ts) {
        const d = new Date(ts);
        const yyyy = d.getFullYear();
        const mm = String(d.getMonth() + 1).padStart(2, '0');
        const dd = String(d.getDate()).padStart(2, '0');
        const hh = String(d.getHours()).padStart(2, '0');
        const min = String(d.getMinutes()).padStart(2, '0');
        const ss = String(d.getSeconds()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd} ${hh}:${min}:${ss}`;
    }

    setInterval(() => {
        serverTs += 1000;
        if (serverTimeEl) serverTimeEl.textContent = formatServerTime(serverTs);
        if (serverTimeElHeader) serverTimeElHeader.textContent = formatServerTime(serverTs);
    }, 1000);

    totalEl.textContent = total;
    document.getElementById('totalCount').textContent = total;

    // build nav buttons
    function buildQuestionButtons() {
        qBtnsContainer.innerHTML = '';
        questions.forEach((q, idx) => {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'btn btn-outline-secondary btn-sm qnav me-1 mb-1';
            b.textContent = idx + 1;
            b.dataset.index = idx;
            b.addEventListener('click', () => {
                showQuestion(idx);
            });
            qBtnsContainer.appendChild(b);
        });
        updateQuestionNav();
    }

    function updateQuestionNav() {
        const btns = Array.from(qBtnsContainer.querySelectorAll('button'));
        btns.forEach((b, idx) => {
            b.classList.toggle('current', idx === current);
            const anyChecked = questions[idx].querySelector('input[type=radio]:checked');
            b.classList.toggle('answered', !!anyChecked);
        });
    }

    function updateProgress() {
        const answered = questions.filter(q => q.querySelector('input[type=radio]:checked')).length;
        answeredCountEl.textContent = answered;
        const pct = Math.round((answered / total) * 100);
        progressBar.style.width = pct + '%';
        progressBar.textContent = pct + '%';
    }

    function showQuestion(index, initialRemaining) {
        if (index < 0 || index >= total) return;
        questions.forEach((q, i) => q.classList.toggle('show', i === index));
        current = index;
        currentEl.textContent = current + 1;

        prevBtn.disabled = (current === 0);
        nextBtn.disabled = true; // re-enforce delay
        submitBtn.classList.add('d-none');

        updateQuestionNav();
        updateProgress();
        startTimer(initialRemaining);
        // persist current position immediately
        saveState();
    }

    function startTimer(initialRemaining) {
        if (countdown) clearInterval(countdown);
        remaining = (typeof initialRemaining === 'number') ? initialRemaining : delaySeconds;
        timerEl.textContent = remaining;

        countdown = setInterval(() => {
            remaining -= 1;
            timerEl.textContent = (remaining >= 0) ? remaining : 0;

            if (remaining <= 0) {
                clearInterval(countdown);
                // save current state when a question's timer finishes
                saveState();
                if (current < total - 1) {
                    nextBtn.disabled = false;
                } else {
                    // last question: show Submit and require manual confirmation
                    submitBtn.classList.remove('d-none');
                    submitBtn.disabled = false;
                    document.getElementById('timerDisplay').textContent =
                        '';
                    nextBtn.disabled = true;
                    try {
                        submitBtn.focus();
                    } catch (e) {}
                }
            }
            n
        }, 1000);
    }

    function goNext() {
        if (current < total - 1) showQuestion(current + 1);
    }
    prevBtn.addEventListener('click', () => {
        if (!prevBtn.disabled) showQuestion(current - 1);
    });
    nextBtn.addEventListener('click', () => {
        if (!nextBtn.disabled) goNext();
    });



    // build initial UI
    buildQuestionButtons();

    /* Persistence: save user answers and current state to localStorage so accidental refresh won't lose it */
    const storageKey =
        'exam_state_<?= isset($siswa['id_siswa']) ? $siswa['id_siswa'] : 'user' ?>_<?= isset($soal[0]['id_mapel']) ? $soal[0]['id_mapel'] : 'mapel' ?>';

    function saveState() {
        try {
            const answers = {};
            questions.forEach(q => {
                const soalId = q.dataset.soalId || q.dataset.index;
                const checked = q.querySelector('input[type=radio]:checked');
                if (checked) answers[soalId] = checked.value;
            });
            const state = {
                answers,
                current,
                remaining,
                ts: Date.now()
            };
            localStorage.setItem(storageKey, JSON.stringify(state));
            // small UX hint: briefly show that progress was autosaved
            // (left out for brevity; recoverAlert will show when restored)
        } catch (e) {
            console.warn('saveState failed', e);
        }
    }

    function loadState() {
        try {
            const raw = localStorage.getItem(storageKey);
            if (!raw) return null;
            const st = JSON.parse(raw);
            if (st && st.answers) {
                Object.keys(st.answers).forEach(soalId => {
                    const selector = `input[name="jawaban[${soalId}]"][value="${st.answers[soalId]}"]`;
                    const input = document.querySelector(selector);
                    if (input) input.checked = true;
                });
                updateQuestionNav();
                updateProgress();
                return st;
            }
        } catch (e) {
            console.warn('loadState failed', e);
        }
        return null;
    }

    function clearState() {
        try {
            localStorage.removeItem(storageKey);
        } catch (e) {
            /* ignore */
        }
    }

    // if there's saved state, restore answers and current index, otherwise show first question
    const restored = loadState();
    if (restored) {
        // reveal a small notice and restore position+timer
        document.getElementById('recoverAlert').classList.remove('d-none');
        showQuestion((typeof restored.current === 'number') ? restored.current : 0, (typeof restored
            .remaining === 'number') ? restored.remaining : undefined);
    } else {
        if (total > 0) showQuestion(0);
    }

    // add saving when answers change
    document.querySelectorAll('.question input[type=radio]').forEach(r => {
        r.addEventListener('change', () => {
            updateQuestionNav();
            updateProgress();
            saveState();
        });
    });

    // Modal (simple JS modal to avoid dependency)
    const modalBackdrop = document.createElement('div');
    modalBackdrop.className = 'modal-backdrop-custom';
    modalBackdrop.id = 'confirmSubmitModal';
    modalBackdrop.innerHTML = `
        <div class="modal-custom">
            <h5>Konfirmasi Kirim Jawaban</h5>
            <p>Yakin ingin mengirim semua jawaban Anda? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="text-end">
                <button type="button" class="btn btn-secondary btn-sm me-2" id="modalCancel">Batal</button>
                <button type="button" class="btn btn-primary btn-sm" id="modalConfirm">Kirim</button>
            </div>
        </div>`;
    document.body.appendChild(modalBackdrop);

    document.getElementById('modalCancel').addEventListener('click', () => {
        modalBackdrop.style.display = 'none';
    });
    document.getElementById('modalConfirm').addEventListener('click', function() {
        // disable confirm to prevent double submit
        this.disabled = true;
        modalBackdrop.style.display = 'none';
        // clear saved state to avoid stale restores
        clearState();
        // show sending message & submit form
        document.getElementById('timerDisplay').textContent = 'Mengirim jawaban...';
        // disable submit button
        submitBtn.disabled = true;
        submitBtn.textContent = 'Mengirim...';
        examForm.submit();
    });

    submitBtn.addEventListener('click', function() {
        // show modal
        document.getElementById('confirmSubmitModal').style.display = 'flex';
    });

    // expose updateProgress if other code changes answers
    window.updateExamProgress = updateProgress;

});
</script>

<!-- Modal markup included via JS -->