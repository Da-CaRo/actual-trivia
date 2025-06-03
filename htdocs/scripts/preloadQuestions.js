document.addEventListener('DOMContentLoaded', () => {
    // URL de tu script PHP. ¡Asegúrate de que esta URL sea la correcta!
    const phpApiUrl = 'https://actual-trivia.great-site.net/scripts/getQuestions.php';

    // Clave para almacenar las preguntas en localStorage
    const localStorageKey = 'cachedQuestions';

    async function preloadQuestions() {
        console.log('Intentando precargar preguntas...');

        // **1. Comprobar si las preguntas ya existen en localStorage**
        const cachedQuestions = localStorage.getItem(localStorageKey);

        if (cachedQuestions) {
            // Si ya existen, las cargamos desde localStorage
            console.log('Preguntas encontradas en localStorage. No se realiza petición al servidor.');
            try {
                const questions = JSON.parse(cachedQuestions);
                // Opcional: Puedes hacer algo con las preguntas aquí si las necesitas inmediatamente
                // Por ejemplo, pasar 'questions' a alguna otra función en tu app
                console.log('Preguntas cargadas desde localStorage:', questions.length, 'preguntas.');
            } catch (error) {
                // Si el JSON en localStorage está corrupto, lo borramos e intentamos cargar de nuevo
                console.error('Error al parsear las preguntas de localStorage. Se intentará recargar del servidor.', error);
                localStorage.removeItem(localStorageKey);
                // Llamamos a la función de nuevo para que haga la petición al servidor
                await fetchAndStoreQuestions();
            }
        } else {
            // Si no existen, realizamos la petición al servidor
            console.log('Preguntas no encontradas en localStorage. Realizando petición al servidor...');
            await fetchAndStoreQuestions();
        }
    }

    // Función separada para realizar la petición y almacenar las preguntas
    async function fetchAndStoreQuestions() {
        try {
            const response = await fetch(phpApiUrl);

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status} - ${response.statusText}. Respuesta: ${await response.text()}`);
            }

            const questions = await response.json();

            if (!Array.isArray(questions)) {
                throw new Error('La respuesta del servidor no es un array de preguntas válido.');
            }

            // Almacenar las preguntas en localStorage
            localStorage.setItem(localStorageKey, JSON.stringify(questions));
            console.log('Preguntas precargadas y almacenadas en localStorage desde el servidor:', questions.length, 'preguntas.');

        } catch (error) {
            console.error('Error al precargar preguntas desde el servidor:', error);
            // Considera añadir un mensaje al usuario si la carga falla
            // alert('Hubo un problema al cargar las preguntas. Por favor, revisa tu conexión.');
        }
    }

    // Llama a la función principal para iniciar la precarga
    preloadQuestions();
});