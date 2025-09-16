<?php

// Define o cabeçalho da resposta como JSON
header('Content-Type: application/json');


$gasoline = floatval($_POST['gasoline'] ?? 0);
$ethanol = floatval($_POST['ethanol'] ?? 0);
$consumoGasolina = floatval($_POST['consumoGasolina'] ?? 0);
$consumoEtanol = floatval($_POST['consumoEtanol'] ?? 0);


if ($gasoline <= 0 || $ethanol <= 0) {
    echo json_encode([
        "error" => true,
        "message" => "Valores inválidos de preço."
    ]);
    exit;
}


// --- Se o usuário informou consumos reais ---
if ($consumoGasolina > 0 && $consumoEtanol > 0) {
    $custoKmGasolina = $gasoline / $consumoGasolina;
    $custoKmEtanol = $ethanol / $consumoEtanol;


    if ($custoKmEtanol < $custoKmGasolina) {
        echo json_encode([
            "error" => false,
            "result" => "Etanol",
            "message" => "Etanol custa R$ " . number_format($custoKmEtanol, 2, ',', '.') . " por km rodado, contra R$ " . number_format($custoKmGasolina, 2, ',', '.') . " da gasolina."
        ]);
    } else {
        echo json_encode([
            "error" => false,
            "result" => "Gasolina",
            "message" => "Gasolina custa R$ " . number_format($custoKmGasolina, 2, ',', '.') . " por km rodado, contra R$ " . number_format($custoKmEtanol, 2, ',', '.') . " do etanol."
        ]);
    }
    exit;
}


/// --- Caso não tenha informado consumos, cai na regra dos 70% ---
$limite = $gasoline * 0.70;
$percentual = ($ethanol / $gasoline) * 100;

if ($ethanol <= $limite) {
    echo json_encode([
        "error" => false,
        "result" => "Etanol",
        "message" => "O preço do etanol (R$ " . number_format($ethanol, 2, ',', '.') .
            ") corresponde a " . number_format($percentual, 2, ',', '.') . "% do preço da gasolina (R$ " .
            number_format($gasoline, 2, ',', '.') . "). O etanol compensa (até R$ " .
            number_format($limite, 2, ',', '.') . ")."
    ]);
} else {
    echo json_encode([
        "error" => false,
        "result" => "Gasolina",
        "message" => "O preço do etanol (R$ " . number_format($ethanol, 2, ',', '.') .
            ") corresponde a " . number_format($percentual, 2, ',', '.') . "% do preço da gasolina (R$ " .
            number_format($gasoline, 2, ',', '.') . "). A gasolina compensa (etanol precisaria estar até R$ " .
            number_format($limite, 2, ',', '.') . ")."
    ]);
}

?>