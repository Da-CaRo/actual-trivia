document.addEventListener('DOMContentLoaded', () => {
    const countdownDisplay = document.getElementById('countdown');
    const timerButton = document.getElementById('timer-button');
    const skipButton = document.getElementById('skip-button');
    const backToThemesButton = document.getElementById('back-to-themes-button');

    const startTime = 30;

    let timeLeft = startTime;
    let timerInterval;
    let isRunning = false;
    let isPaused = false;
    let audioContextResumed = false;

    const beepSound = new Audio('https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/success.mp3');
    beepSound.load();

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
    }

    function updateCountdownDisplay() {
        countdownDisplay.textContent = formatTime(timeLeft);
    }

    function startTimer() {
        if (!audioContextResumed) {
            const dummyAudio = new Audio();
            dummyAudio.src = 'data:audio/mpeg;base64,...';

            dummyAudio.volume = 0;
            dummyAudio.play().then(() => {
                console.log('Contexto de audio reanudado con éxito.');
                audioContextResumed = true;
                _actualStartTimerLogic();
            }).catch(e => {
                console.error('Error al reanudar el contexto de audio:', e);
                _actualStartTimerLogic();
            });
        } else {
            _actualStartTimerLogic();
        }
    }

    function _actualStartTimerLogic() {
        if (isRunning && !isPaused) {
            return;
        }

        isRunning = true;
        isPaused = false;
        timerButton.textContent = 'Parar';
        timerButton.classList.remove('primary-button');
        timerButton.classList.add('secondary-button');

        timerInterval = setInterval(() => {
            timeLeft--;
            updateCountdownDisplay();

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                isRunning = false;
                isPaused = false;
                timerButton.textContent = 'Acabado';
                timerButton.disabled = true;

                beepSound.currentTime = 0;
                beepSound.play().catch(e => console.error("Error al reproducir el sonido:", e)); // Añade un catch para errores de reproducción

                countdownDisplay.style.color = '#28a745';
                countdownDisplay.style.backgroundColor = '#d4edda';
            }
        }, 1000);
    }

    function pauseTimer() {
        clearInterval(timerInterval);
        isRunning = false;
        isPaused = true;
        timerButton.textContent = 'Continuar';
        timerButton.classList.remove('secondary-button');
        timerButton.classList.add('primary-button');
    }

    function resetTimer() {
        clearInterval(timerInterval);
        timeLeft = startTime;
        isRunning = false;
        isPaused = false;
        updateCountdownDisplay();
        timerButton.textContent = 'Empezar';
        timerButton.disabled = false;
        timerButton.classList.remove('secondary-button');
        timerButton.classList.add('primary-button');
        countdownDisplay.style.color = '#dc3545';
        countdownDisplay.style.backgroundColor = '#ffe0e0';
        beepSound.pause();
        beepSound.currentTime = 0;
    }

    updateCountdownDisplay();

    timerButton.addEventListener('click', () => {
        if (!isRunning && !isPaused) {
            startTimer();
        } else if (isRunning && !isPaused) {
            pauseTimer();
        } else if (!isRunning && isPaused) {
            startTimer();
        }
    });

    skipButton.addEventListener('click', () => {
        alert('Pregunta omitida (o lógica para pasar a la siguiente pregunta).');
        resetTimer();
    });

    backToThemesButton.addEventListener('click', () => {
        window.location.href = 'index.html';
    });
});