<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px;">
                <div class="card-body d-flex align-items-center justify-content-between text-white p-4">
                    <div>
                        <h4 class="mb-1 fw-bold"><?= $siswa['nama_siswa'] ?></h4>
                        <div class="small">
                            <?= isset($siswa['nama_kelas']) ? $siswa['nama_kelas'] . ' — ' : '' ?><strong><?= $siswa['nama_mapel'] ?></strong>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="mt-1 small">Total Soal: <strong
                                style="font-size: 1.3em;"><?= count($soal) ?></strong></div>
                        <div class="mt-3">
                            <div style="font-size: 0.9em;">Sisa Waktu</div>
                            <div style="font-size: 2em; font-weight: bold; color: #ffd700;" id="examTimeDisplayHeader">
                                30:00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-gradient text-white p-3"
                    style="background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-0 fw-bold">📋 SOAL UJIAN</h5>
                        </div>
                        <div class="small">
                            <span>Per soal: <strong>10 detik</strong></span> |
                            <span>Total: <strong id="examTimeDisplay">30:00</strong></span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Navigation Panel -->
                        <div class="col-lg-3 mb-3 mb-lg-0">
                            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: #f8f9fa;">
                                <div class="card-header bg-light border-bottom"
                                    style="border-radius: 10px 10px 0 0; font-weight: bold;">
                                    📌 Navigasi Soal
                                </div>
                                <div class="card-body p-2">
                                    <div class="d-flex flex-wrap gap-2" id="qBtns"
                                        style="max-height: 450px; overflow-y: auto;"></div>
                                </div>
                                <div class="card-footer bg-light border-top p-3" style="border-radius: 0 0 10px 10px;">
                                    <div class="progress mb-3" style="height: 25px; border-radius: 8px;">
                                        <div id="progressBar" class="progress-bar bg-success" role="progressbar"
                                            style="width:0%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.85em;">
                                            0%</div>
                                    </div>
                                    <div class="small text-muted">
                                        ✓ Terjawab: <strong id="answeredCount" style="color: #28a745;">0</strong> /
                                        <strong id="totalCount"><?= count($soal) ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Question Display -->
                        <div class="col-lg-9">
                            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                                <div class="card-body p-4">
                                    <form id="examForm" method="post"
                                        action="<?= base_url('Dashboard_siswa/simpan_jawaban') ?>">
                                        <input type="hidden" name="id_mapel"
                                            value="<?= isset($soal[0]['id_mapel']) ? $soal[0]['id_mapel'] : '' ?>">

                                        <div id="recoverAlert" class="alert alert-info d-none small"
                                            style="border-radius: 8px;">
                                            <strong>ℹ️ Informasi:</strong> Jawaban dipulihkan dari sesi sebelumnya.
                                            Pastikan meninjau dan mengirim kembali.
                                        </div>

                                        <div id="questions">
                                            <?php
                                            $no = 1;
                                            foreach ($soal as $idx => $row) {
                                                $soal_id = isset($row['id_soal']) ? $row['id_soal'] : $idx;
                                            ?>
                                                <div class="question" data-index="<?= $idx ?>"
                                                    data-soal-id="<?= $soal_id ?>" style="display: none;">
                                                    <div
                                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                                                        <h5 class="mb-0 fw-bold">Soal <?= $no++; ?></h5>
                                                    </div>

                                                    <div class="mb-4 p-3 bg-light"
                                                        style="border-left: 5px solid #667eea; border-radius: 8px;">
                                                        <?= $row['soal'] ?>
                                                    </div>

                                                    <?php if (!empty($row['gambar']) && is_file(FCPATH . 'assets/images/gambar/' . $row['gambar'])) : ?>
                                                        <div class="text-center mb-4">
                                                            <img src="<?= base_url('assets/images/gambar/' . $row['gambar']) ?>"
                                                                alt="Gambar soal <?= $idx + 1 ?>"
                                                                class="img-fluid rounded shadow"
                                                                style="max-height: 300px; object-fit: contain;">
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="mb-3">
                                                        <label class="list-group-item p-3 mb-2 cursor-pointer"
                                                            style="border-radius: 8px; border: 2px solid #e0e0e0; transition: all 0.3s ease; cursor: pointer;">
                                                            <input class="form-check-input me-3" type="radio"
                                                                name="jawaban[<?= $soal_id ?>]" value="A"
                                                                id="q<?= $soal_id ?>a">
                                                            <span class="fw-bold" style="color: #667eea;">A.</span>
                                                            <?= $row['pilA'] ?>
                                                        </label>
                                                        <label class="list-group-item p-3 mb-2 cursor-pointer"
                                                            style="border-radius: 8px; border: 2px solid #e0e0e0; transition: all 0.3s ease; cursor: pointer;">
                                                            <input class="form-check-input me-3" type="radio"
                                                                name="jawaban[<?= $soal_id ?>]" value="B"
                                                                id="q<?= $soal_id ?>b">
                                                            <span class="fw-bold" style="color: #667eea;">B.</span>
                                                            <?= $row['pilB'] ?>
                                                        </label>
                                                        <label class="list-group-item p-3 mb-2 cursor-pointer"
                                                            style="border-radius: 8px; border: 2px solid #e0e0e0; transition: all 0.3s ease; cursor: pointer;">
                                                            <input class="form-check-input me-3" type="radio"
                                                                name="jawaban[<?= $soal_id ?>]" value="C"
                                                                id="q<?= $soal_id ?>c">
                                                            <span class="fw-bold" style="color: #667eea;">C.</span>
                                                            <?= $row['pilC'] ?>
                                                        </label>
                                                        <label class="list-group-item p-3 mb-2 cursor-pointer"
                                                            style="border-radius: 8px; border: 2px solid #e0e0e0; transition: all 0.3s ease; cursor: pointer;">
                                                            <input class="form-check-input me-3" type="radio"
                                                                name="jawaban[<?= $soal_id ?>]" value="D"
                                                                id="q<?= $soal_id ?>d">
                                                            <span class="fw-bold" style="color: #667eea;">D.</span>
                                                            <?= $row['pilD'] ?>
                                                        </label>
                                                        <label class="list-group-item p-3 cursor-pointer"
                                                            style="border-radius: 8px; border: 2px solid #e0e0e0; transition: all 0.3s ease; cursor: pointer;">
                                                            <input class="form-check-input me-3" type="radio"
                                                                name="jawaban[<?= $soal_id ?>]" value="E"
                                                                id="q<?= $soal_id ?>e">
                                                            <span class="fw-bold" style="color: #667eea;">E.</span>
                                                            <?= $row['pilE'] ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <!-- Controls -->
                                        <div class="mt-4 pt-3 border-top" id="controls">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <button id="prevBtn" type="button" class="btn btn-outline-secondary"
                                                        style="border-radius: 8px; padding: 10px 30px;" disabled>
                                                        ← Sebelumnya
                                                    </button>
                                                </div>
                                                <div class="col-auto">
                                                    <button id="nextBtn" type="button" class="btn btn-primary"
                                                        style="border-radius: 8px; padding: 10px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;"
                                                        disabled>
                                                        Selanjutnya →
                                                    </button>
                                                </div>
                                                <div class="col-auto">
                                                    <div id="timerDisplay" class="d-flex align-items-center gap-2">
                                                        <span style="font-size: 1.2em;">⏱️</span>
                                                        <span id="timerText"
                                                            style="font-weight: bold; color: #667eea;">Tunggu </span>
                                                        <span id="timer"
                                                            style="font-size: 1.3em; font-weight: bold; color: #e74c3c;">10</span>
                                                        <span id="timerText2"
                                                            style="font-weight: bold; color: #667eea;">s...</span>
                                                    </div>
                                                </div>
                                                <div class="col text-end">
                                                    <span class="badge bg-primary"
                                                        style="padding: 8px 15px; font-size: 0.95em;">
                                                        Soal <span id="current">1</span> / <span
                                                            id="total"><?= count($soal) ?></span>
                                                    </span>
                                                    <button id="submitBtn" type="button"
                                                        class="btn btn-success ms-3 d-none"
                                                        style="border-radius: 8px; padding: 10px 30px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none;">
                                                        ✓ Kirim Jawaban
                                                    </button>
                                                </div>
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



<!-- Modal markup included via JS -->

<style>
    /* Enhanced Styles */
    .list-group-item {
        cursor: pointer;
        transition: all 0.3s ease !important;
    }

    .list-group-item:hover {
        background-color: #f0f0f0 !important;
        transform: translateX(5px);
    }

    .list-group-item input[type="radio"]:checked+span,
    input[type="radio"]:checked~span {
        color: #667eea !important;
    }

    .list-group-item input[type="radio"]:checked~* {
        font-weight: 600;
    }

    label.list-group-item input[type="radio"]:checked {
        border-color: #667eea;
    }

    label {
        cursor: pointer;
    }

    label input[type="radio"]:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
    }

    /* Navigation Buttons */
    .nav-btn {
        width: 40px;
        height: 40px;
        padding: 0;
        border-radius: 8px;
        font-size: 12px;
        font-weight: bold;
        transition: all 0.3s ease;
        border: 2px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nav-btn.answered {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }

    .nav-btn.current {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .nav-btn.unanswered {
        background-color: white;
        color: #667eea;
    }

    .nav-btn:hover {
        transform: scale(1.1);
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .question {
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    /* Responsive */
    @media (max-width: 992px) {

        .col-lg-3,
        .col-lg-9 {
            margin-bottom: 20px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pastikan $soal[0]['id_jadwal'] dan $siswa['username'] tersedia
        // Jika tidak, pastikan controller Anda melewatkan data ini dengan benar ke view.
        const EXAM_ID = "<?= isset($soal[0]['id_jadwal']) ? $soal[0]['id_jadwal'] : 'default_exam_id' ?>";
        const USERNAME = "<?= $siswa['username'] ?>";

        // ==================== CONFIGURATION ====================
        const DELAY_BETWEEN_QUESTIONS = 120; // Disamakan dengan tampilan (10 detik)
        const STORAGE_KEY_ANSWERS = `exam_answers_${USERNAME}_${EXAM_ID}`;
        const STORAGE_KEY_START_TIME = `exam_start_time_${USERNAME}_${EXAM_ID}`;
        const STORAGE_KEY_TIME_REMAINING = `exam_time_remaining_${USERNAME}_${EXAM_ID}`;
        const STORAGE_KEY_LAST_QUESTION = `last_question_index_${USERNAME}_${EXAM_ID}`;
        const STORAGE_KEY_WAIT_UNTIL = `exam_wait_until_${USERNAME}_${EXAM_ID}`;
        const EXAM_DURATION_SECONDS = 30 * 60; // Durasi ujian 30 menit (hardcoded)

        // ==================== STATE ====================
        let currentQuestionIndex = 0;
        let totalQuestions = document.querySelectorAll('.question').length;
        let transitionTimer = null;
        let examTimer;
        let examTimeRemaining;
        let canNavigate = false;
        let questionTimers = {}; // Track timer for each question 
        let examStartTime;

        // ==================== INITIALIZATION ==================== 
        function init() {
            setupQuestions();
            setupNavigationButtons();
            loadSavedAnswers();

            // Initialize examTimeRemaining and examStartTime 
            let savedStartTime = localStorage.getItem(STORAGE_KEY_START_TIME);
            let savedTimeRemaining = localStorage.getItem(STORAGE_KEY_TIME_REMAINING);

            if (savedStartTime && savedTimeRemaining) {
                // Recover from saved state 
                examStartTime = parseInt(savedStartTime);

                // FIX: Gunakan waktu mulai awal dan durasi total untuk menghitung sisa waktu secara absolut.
                // Ini mencegah waktu "melompat" atau berkurang dua kali saat refresh.
                let elapsedSecondsTotal = Math.floor((Date.now() - examStartTime) / 1000);
                examTimeRemaining = EXAM_DURATION_SECONDS - elapsedSecondsTotal;

                if (examTimeRemaining < 0) {
                    examTimeRemaining = 0;
                } else {
                    document.getElementById('recoverAlert').classList.remove('d-none');
                }
            } else {
                // Start new exam 
                examStartTime = Date.now();
                examTimeRemaining = EXAM_DURATION_SECONDS;
                localStorage.setItem(STORAGE_KEY_START_TIME, examStartTime);
                localStorage.setItem(STORAGE_KEY_TIME_REMAINING, examTimeRemaining);
            }

            updateExamTimeDisplay(); // Update display immediately after initialization 

            // If examTimeRemaining is 0 or less, submit immediately 
            if (examTimeRemaining <= 0) {
                submitExam();
                return; // Stop further initialization if exam is already over 
            }

            startExamTimer();

            // Load last viewed question from localStorage 
            let lastQuestionIndex = localStorage.getItem(STORAGE_KEY_LAST_QUESTION);
            let startIndex = lastQuestionIndex ? parseInt(lastQuestionIndex) : 0;

            // Ensure index is valid 
            if (startIndex < 0 || startIndex >= totalQuestions) {
                startIndex = 0;
            }

            showQuestion(startIndex);
            setupAnswerAutoSave();
            updateNavigationUI();

            // Start timer on first question 
            startQuestionTimer();
        }

        // ==================== EXAM TIMER ==================== 
        function startExamTimer() {
            examTimer = setInterval(() => {
                examTimeRemaining--;
                localStorage.setItem(STORAGE_KEY_TIME_REMAINING, examTimeRemaining);
                updateExamTimeDisplay();

                if (examTimeRemaining <= 0) {
                    clearInterval(examTimer);
                    submitExam();
                }
            }, 1000);
        }

        function updateExamTimeDisplay() {
            // Pastikan waktu tidak menampilkan angka negatif
            if (examTimeRemaining < 0) examTimeRemaining = 0;

            const minutes = Math.floor(examTimeRemaining / 60);
            const seconds = examTimeRemaining % 60;
            const timeString = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            document.getElementById('examTimeDisplayHeader').textContent = timeString;
            document.getElementById('examTimeDisplay').textContent = timeString;

            // Change color if time is running out
            const header = document.getElementById('examTimeDisplayHeader');
            if (examTimeRemaining <= 300) { // 5 minutes
                header.style.color = '#ffa500'; // Orange
            }
            if (examTimeRemaining <= 60) { // 1 minute
                header.style.color = '#e74c3c'; // Red
            }
        }

        // ==================== QUESTION SETUP ====================
        function setupQuestions() {
            const questions = document.querySelectorAll('.question');
            questions.forEach((q, idx) => {
                q.style.display = idx === 0 ? 'block' : 'none';
                questionTimers[idx] = DELAY_BETWEEN_QUESTIONS;
            });
        }

        // ==================== NAVIGATION ====================
        function setupNavigationButtons() {
            const container = document.getElementById('qBtns');
            container.innerHTML = '';

            for (let i = 0; i < totalQuestions; i++) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'nav-btn unanswered';
                btn.textContent = i + 1;
                btn.dataset.index = i;
                btn.style.cursor = 'pointer';

                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (i !== currentQuestionIndex && canNavigate) {
                        showQuestion(i);
                    }
                });

                container.appendChild(btn);
            }
        }

        function updateNavigationUI() {
            const buttons = document.querySelectorAll('.nav-btn');
            buttons.forEach((btn, idx) => {
                btn.className = 'nav-btn';

                const soalId = getQuestionId(idx);
                const answerName = `jawaban[${soalId}]`;
                const selectedAnswer = document.querySelector(`input[name="${answerName}"]:checked`);

                if (idx === currentQuestionIndex) {
                    btn.classList.add('current');
                    btn.textContent = idx + 1;
                } else if (selectedAnswer) {
                    btn.classList.add('answered');
                    btn.textContent = idx + 1;
                } else {
                    btn.classList.add('unanswered');
                    btn.textContent = idx + 1;
                }
            });

            updateProgressBar();
            updateAnsweredCount();
        }

        // ==================== QUESTION NAVIGATION ====================
        function showQuestion(index) {
            if (index < 0 || index >= totalQuestions) return;

            const questions = document.querySelectorAll('.question');
            questions.forEach(q => q.style.display = 'none');
            questions[index].style.display = 'block';

            currentQuestionIndex = index;

            // Save current question index to localStorage
            localStorage.setItem(STORAGE_KEY_LAST_QUESTION, index);

            // Update current question display
            document.getElementById('current').textContent = index + 1;

            updateNavigationUI();
            updateButtonStates();

            // Scroll to top
            document.querySelector('.question').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function nextQuestion() {
            if (currentQuestionIndex < totalQuestions - 1 && canNavigate) {
                canNavigate = false;
                showQuestion(currentQuestionIndex + 1);
                startQuestionTimer();
            }
        }

        function prevQuestion() {
            if (currentQuestionIndex > 0 && canNavigate) {
                canNavigate = false;
                showQuestion(currentQuestionIndex - 1);
                startQuestionTimer();
            }
        }

        function updateButtonStates() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');
            const isLastQuestion = currentQuestionIndex === totalQuestions - 1;

            // Update Prev button
            prevBtn.disabled = currentQuestionIndex === 0 || !canNavigate;

            // If on last question, hide Next button and show Submit button
            if (isLastQuestion) {
                nextBtn.classList.add('d-none');
                submitBtn.classList.remove('d-none');
            } else {
                nextBtn.classList.remove('d-none');
                submitBtn.classList.add('d-none');
            }

            // Next button disabled if on last question or can't navigate
            nextBtn.disabled = isLastQuestion || !canNavigate;
        }

        // ==================== QUESTION TIMER ====================
        function startQuestionTimer() {
            if (transitionTimer) clearInterval(transitionTimer);

            // Gunakan key unik per soal agar jeda tersimpan meskipun refresh
            const waitKey = `${STORAGE_KEY_WAIT_UNTIL}_${currentQuestionIndex}`;
            let navigableAt = localStorage.getItem(waitKey);

            if (!navigableAt) {
                // Jika belum ada, tentukan waktu kapan tombol boleh diklik (sekarang + delay)
                navigableAt = Date.now() + (DELAY_BETWEEN_QUESTIONS * 1000);
                localStorage.setItem(waitKey, navigableAt);
            } else {
                navigableAt = parseInt(navigableAt);
            }

            let timeLeft = Math.ceil((navigableAt - Date.now()) / 1000);

            const timerElement = document.getElementById('timer');
            const timerDisplay = document.getElementById('timerDisplay');

            if (timeLeft <= 0) {
                canNavigate = true;
                timerDisplay.style.display = 'none';
                updateButtonStates();
                return;
            }

            canNavigate = false;
            timerDisplay.style.display = 'flex';
            timerElement.textContent = timeLeft;
            updateButtonStates();

            transitionTimer = setInterval(() => {
                timeLeft = Math.ceil((navigableAt - Date.now()) / 1000);

                if (timeLeft <= 0) {
                    clearInterval(transitionTimer);
                    timerDisplay.style.display = 'none';
                    canNavigate = true;
                    updateButtonStates();
                } else {
                    timerElement.textContent = timeLeft;
                }
            }, 1000);
        }

        function disableNavigation() {
            document.getElementById('prevBtn').disabled = true;
            document.getElementById('nextBtn').disabled = true;
        }

        // ==================== AUTO-SAVE ANSWERS ====================
        function setupAnswerAutoSave() {
            const form = document.getElementById('examForm');
            const inputs = form.querySelectorAll('input[type="radio"]');

            inputs.forEach(input => {
                input.addEventListener('change', () => {
                    saveAnswersToStorage();
                    updateNavigationUI();

                    // Show recovery alert if there are saved answers
                    if (Object.keys(getSavedAnswers()).length > 0) {
                        document.getElementById('recoverAlert').classList.remove('d-none');
                    }
                });
            });

            // Save on page unload
            window.addEventListener('beforeunload', () => {
                saveAnswersToStorage();
                localStorage.setItem(STORAGE_KEY_LAST_QUESTION, currentQuestionIndex);
            });
        }

        function saveAnswersToStorage() {
            const form = document.getElementById('examForm');
            const formData = new FormData(form);
            const answers = {};

            for (let [key, value] of formData.entries()) {
                if (key.startsWith('jawaban[')) {
                    answers[key] = value;
                }
            }

            localStorage.setItem(STORAGE_KEY_ANSWERS, JSON.stringify(answers));
            localStorage.setItem(STORAGE_KEY_START_TIME, examStartTime);
            localStorage.setItem(STORAGE_KEY_TIME_REMAINING, examTimeRemaining);
        }

        function getSavedAnswers() {
            const saved = localStorage.getItem(STORAGE_KEY_ANSWERS);
            return saved ? JSON.parse(saved) : {};
        }

        function loadSavedAnswers() {
            const saved = getSavedAnswers();

            for (let [key, value] of Object.entries(saved)) {
                const input = document.querySelector(`input[name="${key}"][value="${value}"]`);
                if (input) {
                    input.checked = true;
                }
            }
            // The recoverAlert is now handled in init() based on savedStartTime and savedTimeRemaining 
        }

        // ==================== PROGRESS TRACKING ====================
        function updateProgressBar() {
            let answered = 0;
            for (let i = 0; i < totalQuestions; i++) {
                const soalId = getQuestionId(i);
                const answerName = `jawaban[${soalId}]`;
                if (document.querySelector(`input[name="${answerName}"]:checked`)) {
                    answered++;
                }
            }

            const percentage = Math.round((answered / totalQuestions) * 100);
            const progressBar = document.getElementById('progressBar');
            progressBar.style.width = percentage + '%';
            progressBar.textContent = percentage + '%';
        }

        function updateAnsweredCount() {
            let answered = 0;
            for (let i = 0; i < totalQuestions; i++) {
                const soalId = getQuestionId(i);
                const answerName = `jawaban[${soalId}]`;
                if (document.querySelector(`input[name="${answerName}"]:checked`)) {
                    answered++;
                }
            }
            document.getElementById('answeredCount').textContent = answered;
        }

        function getQuestionId(index) {
            return document.querySelectorAll('.question')[index]?.dataset.soalId || index;
        }

        // ==================== SUBMIT ====================
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            e.preventDefault();
            submitExam();
        });

        function submitExam() {
            // if (!confirm(
            //         'Apakah Anda yakin ingin mengirim jawaban? Ujian akan diakhiri dan jawaban tidak dapat diubah lagi.'
            //     )) {
            //     return;
            // }

            clearInterval(examTimer);
            if (transitionTimer) clearInterval(transitionTimer);

            // Bersihkan data ujian dari localStorage agar tidak muncul di ujian berikutnya
            localStorage.removeItem(STORAGE_KEY_ANSWERS);
            localStorage.removeItem(STORAGE_KEY_START_TIME);
            localStorage.removeItem(STORAGE_KEY_TIME_REMAINING);
            localStorage.removeItem(STORAGE_KEY_LAST_QUESTION);
            for (let i = 0; i < totalQuestions; i++) {
                localStorage.removeItem(`${STORAGE_KEY_WAIT_UNTIL}_${i}`);
            }

            document.getElementById('examForm').submit();
        }

        // ==================== EVENT LISTENERS ====================
        document.getElementById('prevBtn').addEventListener('click', prevQuestion);
        document.getElementById('nextBtn').addEventListener('click', nextQuestion);

        // Start
        init();
    });
</script>