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

    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>⛽</text></svg>">
</head>

<body>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg calculator-card">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h1 class="card-title fw-bold">Etanol ou Gasolina?</h1>
                            <p class="card-subtitle text-muted">Descubra qual combustível é mais vantajoso agora!</p>
                        </div>

                        <form id="fuelForm">
                            <div class="mb-3">
                                <label for="gasoline" class="form-label fw-medium">Preço da Gasolina (R$)</label>
                                <input type="number" class="form-control form-control-lg" id="gasoline" name="gasoline"
                                    placeholder="Ex: 5.89" step="0.01" required>
                            </div>

                            <div class="mb-4">
                                <label for="ethanol" class="form-label fw-medium">Preço do Etanol (R$)</label>
                                <input type="number" class="form-control form-control-lg" id="ethanol" name="ethanol"
                                    placeholder="Ex: 3.99" step="0.01" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                    <span class="spinner-border spinner-border-sm d-none" role="status"
                                        aria-hidden="true"></span>
                                    Calcular Vantagem
                                </button>
                            </div>
                        </form>

                        <div id="resultArea" class="mt-4" style="display: none;">
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <small class="text-muted">© 2025 Todos os direitos reservados</small><br>
                    <small class="text-muted">By <a href="https://www.linkedin.com/in/mateusbrito93/" target="_blank">Mateus Brito</a></small>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>

</body>

</html>