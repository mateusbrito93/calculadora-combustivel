<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etanol ou Gasolina? | Calculadora Inteligente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Favicon padrão (fallback) -->
    <link rel="icon" type="image/png" sizes="32x32" href="icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="icons/favicon-16x16.png">

    <!-- Apple Touch Icon (para iOS) -->
    <link rel="apple-touch-icon" sizes="180x180" href="icons/apple-touch-icon.png">

    <!-- Ícone maior (Android/Chrome e fallback para PWA) -->
    <link rel="icon" type="image/png" sizes="512x512" href="icons/apple-touch-icon-512.png">

    <!-- Manifesto para Android/Chrome -->
    <link rel="manifest" href="icons/site.webmanifest">
    <meta name="theme-color" content="#ffffff">
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="controls-container">
                    <div class="language-switcher">
                        <button class="lang-btn" data-lang="pt" title="Português"><img src="assets/flags/br.svg"
                                alt="Bandeira do Brasil"></button>
                        <button class="lang-btn" data-lang="en" title="English"><img src="assets/flags/us.svg"
                                alt="Bandeira dos Estados Unidos"></button>
                        <button class="lang-btn" data-lang="es" title="Español"><img src="assets/flags/es.svg"
                                alt="Bandeira da Espanha"></button>
                    </div>
                    <div class="theme-switch-wrapper">
                        <label class="theme-switch" for="theme-checkbox" title="Mudar tema">
                            <input type="checkbox" id="theme-checkbox" />
                            <div class="slider round">
                                <div class="slider-icon sun"><i class="bi bi-sun-fill"></i></div>
                                <div class="slider-icon moon"><i class="bi bi-moon-stars-fill"></i></div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="card shadow-lg calculator-card">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h1 class="card-title fw-bold" data-i18n-key="mainTitle">Etanol ou Gasolina?</h1>
                            <p class="card-subtitle text-muted" data-i18n-key="subtitle">Descubra qual combustível é
                                mais vantajoso agora!</p>
                        </div>

                        <form id="fuelForm">
                            <div class="mb-3">
                                <label for="gasoline" class="form-label" data-i18n-key="gasolinePriceLabel">Preço
                                    Gasolina (R$/L)</label>
                                <input type="text" class="form-control form-control-lg" id="gasoline" name="gasoline"
                                    data-i18n-placeholder-key="gasolinePlaceholder" placeholder="Ex: 5.89" required>
                            </div>

                            <div class="mb-3">
                                <label for="ethanol" class="form-label" data-i18n-key="ethanolPriceLabel">Preço Etanol
                                    (R$/L)</label>
                                <input type="text" class="form-control form-control-lg" id="ethanol" name="ethanol"
                                    data-i18n-placeholder-key="ethanolPlaceholder" placeholder="Ex: 3.99" required>
                            </div>

                            <div class="mb-3 text-center">
                                <a href="#" id="toggleConsumo" class="toggle-link" data-i18n-key="useConsumptionLink">➕
                                    Usar consumo do veículo</a>
                            </div>

                            <div id="consumoFields" class="border rounded p-3 mb-3 consumption-fields-container"
                                style="display:none;">
                                <div class="mb-3">
                                    <label for="consumoGasolina" class="form-label"
                                        data-i18n-key="gasolineConsumptionLabel">Consumo com Gasolina (km/L)</label>
                                    <input type="number" step="0.1" class="form-control form-control-lg"
                                        id="consumoGasolina" name="consumoGasolina"
                                        data-i18n-placeholder-key="consumptionPlaceholder" placeholder="Ex: 10">
                                </div>
                                <div class="mb-3">
                                    <label for="consumoEtanol" class="form-label"
                                        data-i18n-key="ethanolConsumptionLabel">Consumo com Etanol (km/L)</label>
                                    <input type="number" step="0.1" class="form-control form-control-lg"
                                        id="consumoEtanol" name="consumoEtanol"
                                        data-i18n-placeholder-key="consumptionPlaceholder" placeholder="Ex: 7">
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    <span data-i18n-key="calculateButton">Calcular</span>
                                </button>
                            </div>
                        </form>

                        <div id="resultArea" class="mt-4" style="display:none;"></div>
                    </div>
                    <div class="text-center mt-3 pb-3">
                        <small class="text-muted" data-i18n-key="footerReserved">© 2025 Todos os direitos
                            reservados</small><br>
                        <small class="text-muted">By <a href="https://www.linkedin.com/in/mateusbrito93/"
                                target="_blank">Mateus Brito</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/script.js"></script>
</body>

</html>