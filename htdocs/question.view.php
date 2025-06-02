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
            <p class="question-type-text" id="question-category">Respuesta Simple</p>
        </div>

        <div class="question-content-wrapper">
            <div class="question-main-area">
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
</body>

</html>