<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link href="styles/footer.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <footer class="main-footer">
        <div class="footer-left">
            <h3>Enlaces de Interés</h3>
            <ul>
                <li><a href="#">Política de Privacidad</a></li>
                <li><a href="#">Términos y Condiciones</a></li>
                <li><a href="#">Preguntas Frecuentes</a></li>
                <li><a href="#">Trabaja con Nosotros</a></li>
                <li><a href="#">Mapa del Sitio</a></li>
                <li>
                    <a href="#"
                        onclick="localStorage.removeItem('cachedQuestions'); alert('cachedQuestions eliminado'); return false;">
                        Eliminar cachedQuestions
                    </a>
                </li>
                <li>
                    <a href="#"
                        onclick="localStorage.removeItem('usedQuestions'); alert('usedQuestions eliminado'); return false;">
                        Eliminar usedQuestions
                    </a>
                </li>
            </ul>
        </div>
        <div class="footer-right">
            <h3>Síguenos en Redes</h3>
            <div class="social-icons-box">
                <a href="#" target="_blank" aria-label="Instagram">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/instagram-new.png" alt="Instagram">
                </a>
                <a href="#" target="_blank" aria-label="TikTok">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/tiktok--v1.png" alt="TikTok">
                </a>
                <a href="#" target="_blank" aria-label="X (Twitter)">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/twitterx.png" alt="X (Twitter)">
                </a>
                <a href="#" target="_blank" aria-label="YouTube">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/youtube--v1.png" alt="YouTube">
                </a>
                <a href="https://github.com/Da-CaRo/actual-trivia" target="_blank" aria-label="GitHub">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/github.png" alt="GitHub">
                </a>
            </div>
        </div>
    </footer>
</body>

</html>