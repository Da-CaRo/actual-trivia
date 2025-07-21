<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Pregunta</title>
    <link href="styles/question.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php include "header.php" ?>

    <main class="question-page-container">
        <div class="question-header-banner">
            <h2 class="question-theme-color" id="question-topic">Tema</h2>
            <p class="question-type-text" id="question-id">ID</p>
        </div>

        <div class="question-content-wrapper">
            <div class="question-main-area" data-questionId="">
                <div class="question-statement-box">
                    <h3>Enunciado de la Pregunta:</h3>
                    <p id="question-text">Pregunta</p>
                </div>
                <div class="question-answer-box">
                    <h3>Respuesta Correcta:</h3>
                    <p id="question-answer">Respuesta</p>
                </div>
            </div>

            <div class="question-sidebar-area">
                <div class="timer-box">
                    <h4>Tiempo Restante:</h4>
                    <div id="countdown" class="countdown-display"></div>
                    <button id="timer-button" class="action-button primary-button">Empezar</button>
                </div>
                <button id="skip-button" class="action-button secondary-button">Omitir Pregunta</button>
                <button id="back-to-themes-button" class="action-button tertiary-button">Seleccion de Tema</button>
            </div>
        </div>
    </main>

    <?php include "footer.php" ?>
    <script src="scripts/timer.js"></script>
    <script>
        // --- Function to display the question on the page ---
        // This function updates the HTML elements with the question's data.
        function displayQuestion(question) {
            if (!question) {
                console.error("No se recibió un objeto de pregunta válido para mostrar.");
                document.getElementById('question-topic').innerHTML = "Error";
                document.getElementById('question-id').innerHTML = "";
                document.getElementById('question-text').innerHTML = "No se pudo cargar la pregunta.";
                document.getElementById('question-answer').innerHTML = "";
                // If the report button handler is loaded, disable it if no valid question
                if (typeof initializeReportButton === 'function') {
                    initializeReportButton(0); // Pass 0 or null to disable reporting
                }
                return;
            }

            document.getElementById('question-topic').innerHTML = question.category;
            document.getElementById('question-id').innerHTML = question.id;
            document.getElementById('question-text').innerHTML = question.question;
            document.getElementById('question-answer').innerHTML = question.answer;
        }

        // --- NUEVA FUNCIÓN: Marcar pregunta como usada y eliminarla del caché ---
        function markQuestionAsUsedAndRemoveFromCache(questionId) {
            // Convertir questionId a número entero para asegurar una comparación correcta
            const numericQuestionId = parseInt(questionId, 10);

            if (isNaN(numericQuestionId) || numericQuestionId === 0) {
                console.warn("markQuestionAsUsedAndRemoveFromCache: ID de pregunta no válido o 0. Operación abortada.");
                return;
            }

            console.log(`Marcando pregunta ${numericQuestionId} como usada y eliminando del caché.`);

            // --- 1. Eliminar la pregunta de 'cachedQuestions' ---
            const cachedQuestionsKey = 'cachedQuestions';
            let cachedQuestions = JSON.parse(localStorage.getItem(cachedQuestionsKey) || '[]');

            const initialCacheLength = cachedQuestions.length;
            // Filtra el array, eliminando la pregunta con el ID actual
            // Aseguramos que q.id también sea un número antes de comparar
            cachedQuestions = cachedQuestions.filter(q => parseInt(q.id, 10) !== numericQuestionId);

            if (cachedQuestions.length < initialCacheLength) {
                localStorage.setItem(cachedQuestionsKey, JSON.stringify(cachedQuestions));
                console.log(`Pregunta ${numericQuestionId} eliminada de 'cachedQuestions'. Nuevo total: ${cachedQuestions.length}`);
            } else {
                console.warn(`Pregunta ${numericQuestionId} no encontrada en 'cachedQuestions' para eliminar. (Quizás ya fue eliminada o el ID no coincide)`);
            }

            // --- 2. Añadir el ID de la pregunta a 'usedQuestions' ---
            const usedQuestionsKey = 'usedQuestions';
            let usedQuestions = JSON.parse(localStorage.getItem(usedQuestionsKey) || '[]');

            // Evitar duplicados en usedQuestions
            if (!usedQuestions.includes(numericQuestionId)) { // Compara directamente el número
                usedQuestions.push(numericQuestionId);
                localStorage.setItem(usedQuestionsKey, JSON.stringify(usedQuestions));
                console.log(`ID de pregunta ${numericQuestionId} añadido a 'usedQuestions'. Total de usadas: ${usedQuestions.length}`);
            } else {
                console.log(`ID de pregunta ${numericQuestionId} ya estaba en 'usedQuestions'. No se añadió de nuevo.`);
            }
        }

        // --- Logic to load and display a question from localStorage based on URL topic ---
        document.addEventListener('DOMContentLoaded', () => {
            console.log('question.php: DOMContentLoaded disparado. Buscando preguntas en localStorage.');

            // Get the topic from the URL query parameter
            const urlParams = new URLSearchParams(window.location.search);
            const selectedTopic = urlParams.get('topic');

            if (!selectedTopic) {
                console.error('ERROR: No se encontró el parámetro "topic" en la URL.');
                alert('No se ha seleccionado ningún tema. Por favor, vuelve a la selección de temas.');
                window.location.href = 'select-topic.php'; // Redirect if no topic is provided
                return;
            }
            console.log('Tema seleccionado de la URL:', selectedTopic);

            const localStorageKey = 'cachedQuestions';
            const cachedQuestions = localStorage.getItem(localStorageKey);

            if (!cachedQuestions) {
                console.error('ERROR: No se encontraron preguntas precargadas en localStorage.');
                alert('No se encontraron preguntas precargadas. Por favor, visita la página de selección de temas primero para cargarlas.');
                window.location.href = 'select-topic.php'; // Redirect if no cached data
                return;
            }

            try {
                const allQuestions = JSON.parse(cachedQuestions);
                console.log('Total de preguntas precargadas desde localStorage:', allQuestions.length);

                // Filter questions by the selected topic (case-sensitive match for q.category)
                const filteredQuestions = allQuestions.filter(q => q.category === selectedTopic);
                console.log(`Preguntas filtradas para el tema "${selectedTopic}":`, filteredQuestions.length);

                if (filteredQuestions.length > 0) {
                    // Select a random question from the filtered list
                    const randomIndex = Math.floor(Math.random() * filteredQuestions.length);
                    const questionToDisplay = filteredQuestions[randomIndex];
                    displayQuestion(questionToDisplay); // Call the display function
                } else {
                    console.warn(`ADVERTENCIA: No se encontraron preguntas para el tema "${selectedTopic}" en el caché.`);
                    alert(`Lo sentimos, no hay preguntas disponibles para el tema "${selectedTopic}".`);
                    window.location.href = 'select-topic.php'; // Redirect or show a message
                }

            } catch (error) {
                console.error('ERROR: Error al parsear o filtrar preguntas de localStorage:', error);
                alert('Hubo un problema al cargar las preguntas desde el caché. Intenta de nuevo desde la selección de temas.');
                localStorage.removeItem(localStorageKey); // Clear potentially corrupt cache
                window.location.href = 'select-topic.php';
            }
        });

        // Event listener for the "Back to Themes" button
        document.getElementById('back-to-themes-button').addEventListener('click', () => {
            window.location.href = 'select-topic.php';
        });

        // You might want to add logic for the "Skip Question" button here as well,
        // which would involve re-running the filtering and random selection for the same topic.
        // Example for "Skip Question":
        document.getElementById('skip-button').addEventListener('click', () => {
            console.log('Omitir Pregunta pulsado.');
            const urlParams = new URLSearchParams(window.location.search);
            const selectedTopic = urlParams.get('topic');

            // Obtener el ID de la pregunta actual
            // Puedes guardar el ID en un atributo question-main-area en el elemento del enunciado
            // Asegúrate de que displayQuestion lo haga:
            const currentQuestionId = document.getElementById('question-id').innerHTML;

            if (!currentQuestionId) {
                alert('No se pudo identificar la pregunta actual.');
                return;
            }

            // Eliminar la pregunta actual del localStorage y marcarla como usada
            markQuestionAsUsedAndRemoveFromCache(currentQuestionId);

            // Volver a cargar las preguntas filtradas
            const localStorageKey = 'cachedQuestions';
            const cachedQuestions = localStorage.getItem(localStorageKey);

            if (cachedQuestions && selectedTopic) {
                try {
                    const allQuestions = JSON.parse(cachedQuestions);
                    const filteredQuestions = allQuestions.filter(q => q.category === selectedTopic);

                    if (filteredQuestions.length > 0) {
                        // Seleccionar una pregunta aleatoria
                        const randomIndex = Math.floor(Math.random() * filteredQuestions.length);
                        const newQuestion = filteredQuestions[randomIndex];
                        displayQuestion(newQuestion);
                    } else {
                        alert(`No hay más preguntas disponibles para el tema "${selectedTopic}".\nVolviendo a la página de selección de temas para cargar mas. `);
                        window.location.href = 'select-topic.php';
                    }
                } catch (error) {
                    console.error('Error al omitir pregunta:', error);
                    alert('Hubo un problema al cargar la siguiente pregunta. Intenta de nuevo.');
                }
            } else {
                window.location.href = 'select-topic.php'; // Fallback if no topic or cache
            }
        });
    </script>
</body>

</html>