<?php

// Define o cabeçalho da resposta como JSON
header('Content-Type: application/json');

// Garante que o método da requisição seja POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode([
        'error' => true,
        'message' => 'Método não permitido. Utilize POST.'
    ]);
    exit;
}

// Verifica se os dados foram enviados
if (!isset($_POST['gasoline']) || !isset($_POST['ethanol'])) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'error' => true,
        'message' => 'Parâmetros incompletos. Envie os preços da gasolina e do etanol.'
    ]);
    exit;
}

// Pega os valores e converte para float
$gasolinePrice = floatval(str_replace(',', '.', $_POST['gasoline']));
$ethanolPrice = floatval(str_replace(',', '.', $_POST['ethanol']));

// Validação dos valores
if ($gasolinePrice <= 0 || $ethanolPrice <= 0) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'error' => true,
        'message' => 'Os preços devem ser valores numéricos positivos.'
    ]);
    exit;
}

// --- Lógica Principal do Cálculo ---
// A regra geral é que o etanol é vantajoso se o seu preço for até 70% do preço da gasolina.
$ratio = $ethanolPrice / $gasolinePrice;
$threshold = 0.70;

$result = '';
$message = '';

if ($ratio <= $threshold) {
    $result = 'Etanol';
    $message = sprintf(
        'O preço do etanol (R$ %.2f) corresponde a <strong>%.1f%%</strong> do preço da gasolina (R$ %.2f), que é menor ou igual ao limite de 70%%.',
        $ethanolPrice,
        $ratio * 100,
        $gasolinePrice
    );
} else {
    $result = 'Gasolina';
    $message = sprintf(
        'O preço do etanol (R$ %.2f) corresponde a <strong>%.1f%%</strong> do preço da gasolina (R$ %.2f), que é maior que o limite de 70%%.',
        $ethanolPrice,
        $ratio * 100,
        $gasolinePrice
    );
}

// Monta a resposta de sucesso
$response = [
    'error' => false,
    'result' => $result,
    'ratio' => round($ratio, 4),
    'gasoline_price' => $gasolinePrice,
    'ethanol_price' => $ethanolPrice,
    'message' => $message
];

http_response_code(200); // OK
echo json_encode($response);

?>