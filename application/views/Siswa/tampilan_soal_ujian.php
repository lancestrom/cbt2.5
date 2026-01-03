<div class="container">
    <div class="row">
        <div class="col-md mt-4">
            <div class="card">
                <div class="card-body bg-primary text-white">
                    <h4><?= $siswa['nama_siswa'] ?> <br> <?= $siswa['nama_mapel'] ?>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md mt-4">
            <div class="card">
                <div class="card-header">
                    SOAL UJIAN
                </div>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-md">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Questions: render all but show one at a time via JS -->
                                    <!-- Wrap all questions in a single form so final submit sends all answers -->
                                    <form id="examForm" method="post"
                                        action="<?= base_url() ?>Dashboard_siswa/simpan_jawaban">
                                        <div id="questions">
                                            <?php
                                            $no = 1;
                                            foreach ($soal as $idx => $row) {
                                            ?>
                                                <div class="question" data-index="<?= $idx ?>" style="display: none;">
                                                    <h5>Soal <?= $no++; ?></h5>

                                                    <div class="mb-3"> <?= $row['soal'] ?> </div>
                                                    <!-- answer inputs named as array keyed by soal id -->
                                                    <?php $soal_id = isset($row['id_soal']) ? $row['id_soal'] : $idx; ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="jawaban[<?= $soal_id ?>]" value="A"
                                                            id="q<?= $soal_id ?>a">
                                                        <label class="form-check-label" for="q<?= $soal_id ?>a">A.
                                                            <?= $row['pilA'] ?></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="jawaban[<?= $soal_id ?>]" value="B"
                                                            id="q<?= $soal_id ?>b">
                                                        <label class="form-check-label" for="q<?= $soal_id ?>b">B.
                                                            <?= $row['pilB'] ?></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="jawaban[<?= $soal_id ?>]" value="C"
                                                            id="q<?= $soal_id ?>c">
                                                        <label class="form-check-label" for="q<?= $soal_id ?>c">C.
                                                            <?= $row['pilC'] ?></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="jawaban[<?= $soal_id ?>]" value="D"
                                                            id="q<?= $soal_id ?>d">
                                                        <label class="form-check-label" for="q<?= $soal_id ?>d">D.
                                                            <?= $row['pilD'] ?></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="jawaban[<?= $soal_id ?>]" value="E"
                                                            id="q<?= $soal_id ?>e">
                                                        <label class="form-check-label" for="q<?= $soal_id ?>e">E.
                                                            <?= $row['pilE'] ?></label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <!-- Controls -->
                                        <div class="d-flex align-items-center mt-3" id="controls">
                                            <button id="nextBtn" class="btn btn-primary mr-2" disabled>Next</button>
                                            <div id="timerDisplay" class="ml-2">Waktu tersisa: <span
                                                    id="timer">5</span>s
                                            </div>
                                            <div class="ml-auto d-flex align-items-center" id="progress">Soal <span
                                                    id="current">1</span> / <span id="total"><?= count($soal) ?></span>
                                                <!-- Submit button: hidden until last question -->
                                                <button id="submitBtn" type="submit"
                                                    class="btn btn-success ml-3 d-none">Kirim Jawaban</button>
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

<!-- JS: timer and navigation -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const questions = Array.from(document.querySelectorAll('.question'));
        const total = questions.length;
        let current = 0;
        let countdown = null; // interval
        let remaining = 1; // seconds per question

        const nextBtn = document.getElementById('nextBtn');
        const timerEl = document.getElementById('timer');
        const currentEl = document.getElementById('current');
        const totalEl = document.getElementById('total');

        totalEl.textContent = total;

        function showQuestion(index) {
            questions.forEach((q, i) => q.style.display = (i === index) ? '' : 'none');
            current = index;
            currentEl.textContent = current + 1;
            // no previous button: nothing to disable here
            // hide submit button unless this is the last question
            const submitBtn = document.getElementById('submitBtn');
            if (current === total - 1) {
                // last question: keep next disabled until timer ends, but show submit after timer
                submitBtn.classList.add('d-none');
            } else {
                // not last: ensure submit hidden
                submitBtn.classList.add('d-none');
            }
            nextBtn.disabled = true; // disallow next until timer ends
            startTimer();
        }

        function startTimer() {
            // clear previous timer
            if (countdown) clearInterval(countdown);
            remaining = 1;
            timerEl.textContent = remaining;
            countdown = setInterval(() => {
                remaining -= 1;
                timerEl.textContent = remaining;
                if (remaining <= 0) {
                    clearInterval(countdown);
                    // if not last question, enable Next
                    if (current < total - 1) {
                        nextBtn.disabled = false; // now user CAN go next
                    } else {
                        // last question: show the submit button so user can send the full form
                        const submitBtn = document.getElementById('submitBtn');
                        submitBtn.classList.remove('d-none');
                        submitBtn.disabled = false;
                        // update timer display to indicate ready to submit
                        document.getElementById('timerDisplay').textContent =
                            'Selesai. Silakan kirim jawaban Anda.';
                        nextBtn.disabled = true;
                    }
                }
            }, 1000);
        }

        function goNext() {
            if (current < total - 1) {
                showQuestion(current + 1);
            } else {
                // reached end
                alert('Ujian selesai.');
            }
        }

        // previous navigation removed

        nextBtn.addEventListener('click', function() {
            if (!nextBtn.disabled) goNext();
        });

        // init
        if (total > 0) showQuestion(0);
    });
</script>