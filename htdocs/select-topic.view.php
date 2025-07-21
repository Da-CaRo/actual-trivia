<!DOCTYPE html>
<html lang="es">

<head>
    <title>Actual Trivia</title>
    <meta charset="utf-8">
    <link href="styles/select-topic.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php include "header.php" ?>
    <main class="content-section">
        <div class="theme-selection-title">
            <h2>Selecciona un tema</h2>
        </div>

        <div class="themes-container">
            <div class="theme-item left-column" data-topic-category="sports&lei">
                <p class="text-right">Deportes y Pasatiempos</p>
                <div class="placeholder-image" id="theme-image-1"></div>
            </div>
            <div class="theme-item right-column" data-topic-category="geography">
                <div class="placeholder-image" id="theme-image-2"></div>
                <p class="text-left">Geografía</p>
            </div>
            <div class="theme-item left-column" data-topic-category="art&litera">
                <p class="text-right">Arte y Literatura</p>
                <div class="placeholder-image" id="theme-image-3"></div>
            </div>
            <div class="theme-item right-column" data-topic-category="science&na">
                <div class="placeholder-image" id="theme-image-4"></div>
                <p class="text-left">Ciencia y naturaleza</p>
            </div>
            <div class="theme-item left-column" data-topic-category="entertainm">
                <p class="text-right">Entretenimiento</p>
                <div class="placeholder-image" id="theme-image-5"></div>
            </div>
            <div class="theme-item right-column" data-topic-category="history">
                <div class="placeholder-image" id="theme-image-6"></div>
                <p class="text-left">Historia</p>
            </div>
        </div>
    </main>
    </main>
    <?php include "footer.php" ?>

    <script src="scripts/preloadQuestions.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Función para obtener todos los elementos que representan un tema
            const topicCards = document.querySelectorAll('.theme-item'); // Usa la clase que apliques a tus temas

            topicCards.forEach(card => {
                card.addEventListener('click', () => {
                    const topicCategory = card.dataset.topicCategory; // Obtiene el valor de data-topic-category

                    if (topicCategory) {
                        /*currentQuestionCount = JSON.parse(localStorage.getItem('cachedQuestions')).filter(q => q.category === topicCategory).length
                        if (currentQuestionCount < 1) {
                            console.log('No hay preguntas disponibles para este tema.');
                            fetchAndStoreQuestions()
                        }
                        */
                        // Redirige a la página de preguntas, pasando el tema como parámetro URL
                        window.location.href = `question.php?topic=${encodeURIComponent(topicCategory)}`;
                    } else {
                        console.error('No se pudo obtener la categoría del tema para el click:', card);
                    }
                });
            });
        });
    </script>



</body>

</html>