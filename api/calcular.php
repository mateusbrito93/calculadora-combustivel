<?php
header('Content-Type: application/json');

// --- Dicionário de Traduções do Backend ---
$messages = [
    'pt' => [
        'invalid_price' => "Os preços devem ser valores numéricos positivos.",
        'invalid_consumption' => "Os valores de consumo devem ser numéricos positivos ao usar a opção de consumo do veículo.",
        'result_etanol_consumo' => "Etanol custa R$ %s por km, contra R$ %s da gasolina. Abasteça com Etanol!",
        'result_gasolina_consumo' => "Gasolina custa R$ %s por km, contra R$ %s do etanol. Abasteça com Gasolina!",
        'result_etanol_70' => "O preço do etanol (R$ %s) corresponde a %.1f%% do preço da gasolina (R$ %s). O etanol é vantajoso (limite de 70%%: R$ %s).",
        'result_gasolina_70' => "O preço do etanol (R$ %s) corresponde a %.1f%% do preço da gasolina (R$ %s). A gasolina é mais vantajosa (etanol deveria custar até R$ %s)."
    ],
    'en' => [
        'invalid_price' => "Prices must be positive numeric values.",
        'invalid_consumption' => "Consumption values must be positive numeric when using the vehicle consumption option.",
        'result_etanol_consumo' => "Ethanol costs $%s per km, versus $%s for gasoline. Fill up with Ethanol!",
        'result_gasolina_consumo' => "Gasoline costs $%s per km, versus $%s for ethanol. Fill up with Gasoline!",
        'result_etanol_70' => "The price of ethanol ($%s) is %.1f%% of the gasoline price ($%s). Ethanol is advantageous (70%% limit: $%s).",
        'result_gasolina_70' => "The price of ethanol ($%s) is %.1f%% of the gasoline price ($%s). Gasoline is more advantageous (ethanol should cost up to $%s)."
    ],
    'es' => [
        'invalid_price' => "Los precios deben ser valores numéricos positivos.",
        'invalid_consumption' => "Los valores de consumo deben ser numéricos positivos al usar la opción de consumo del vehículo.",
        'result_etanol_consumo' => "El etanol cuesta R$ %s por km, frente a R$ %s de la gasolina. ¡Llene con Etanol!",
        'result_gasolina_consumo' => "La gasolina cuesta R$ %s por km, frente a R$ %s del etanol. ¡Llene con Gasolina!",
        'result_etanol_70' => "El precio del etanol ($%s) corresponde al %.1f%% del precio de la gasolina ($%s). El etanol es ventajoso (límite del 70%%: $%s).",
        'result_gasolina_70' => "El precio del etanol ($%s) corresponde al %.1f%% del precio de la gasolina ($%s). La gasolina es más ventajosa (el etanol debería costar hasta $%s)."
    ]
];

// Detecta o idioma ou usa 'pt' como padrão
$lang = $_POST['lang'] ?? 'pt';
if (!array_key_exists($lang, $messages)) {
    $lang = 'pt';
}
$t = $messages[$lang]; // Atalho para as traduções do idioma selecionado

// --- Processamento dos Dados ---
$gasolinePrice = floatval($_POST['gasoline'] ?? 0);
$ethanolPrice = floatval($_POST['ethanol'] ?? 0);
$consumoGasolina = floatval($_POST['consumoGasolina'] ?? 0);
$consumoEtanol = floatval($_POST['consumoEtanol'] ?? 0);

if ($gasolinePrice <= 0 || $ethanolPrice <= 0) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => true, "message" => $t['invalid_price']]);
    exit;
}

// Formatação de números monetários. Usar `number_format` para exibição na mensagem.
// O backend deve retornar números para o frontend formatar se precisar exibir,
// mas para o propósito de mensagens, podemos formatar aqui.
$nf_options = [
    'decimal_separator' => ($lang === 'pt' ? ',' : '.'),
    'thousand_separator' => ($lang === 'pt' ? '.' : ','),
    'currency_symbol' => ($lang === 'pt' ? 'R$ ' : ($lang === 'en' ? '$' : '$')) // Pode ser ajustado por país
];

// --- Lógica de Cálculo ---
$result_key = '';
$result_message = '';

if ($consumoGasolina > 0 && $consumoEtanol > 0) {
    if ($consumoGasolina <= 0 || $consumoEtanol <= 0) {
        http_response_code(400);
        echo json_encode(["error" => true, "message" => $t['invalid_consumption']]);
        exit;
    }
    $custoKmGasolina = $gasolinePrice / $consumoGasolina;
    $custoKmEtanol = $ethanolPrice / $consumoEtanol;

    if ($custoKmEtanol < $custoKmGasolina) {
        $result_key = "Etanol";
        $result_message = sprintf($t['result_etanol_consumo'], 
            number_format($custoKmEtanol, 2, $nf_options['decimal_separator'], $nf_options['thousand_separator']), 
            number_format($custoKmGasolina, 2, $nf_options['decimal_separator'], $nf_options['thousand_separator'])
        );
    } else {
        $result_key = "Gasolina";
        $result_message = sprintf($t['result_gasolina_consumo'], 
            number_format($custoKmGasolina, 2, $nf_options['decimal_separator'], $nf_options['thousand_separator']), 
            number_format($custoKmEtanol, 2, $nf_options['decimal_separator'], $nf_options['thousand_separator'])
        );
    }
} else {
    $limite = $gasolinePrice * 0.70;
    $percentual = ($ethanolPrice / $gasolinePrice) * 100;

    if ($ethanolPrice <= $limite) {
        $result_key = "Etanol";
        $result_message = sprintf($t['result_etanol_70'], 
            number_format($ethanolPrice, 2, $nf_options['decimal_separator'], $nf_options['thousand_separator']), 
            $percentual, 
            number_format($gasolinePrice, 2, $nf_options['decimal_separator'], $nf_options['thousand_separator']), 
            number_format($limite, 2, $nf_options['decimal_separator'], $nf_options['thousand_separator'])
        );
    } else {
        $result_key = "Gasolina";
        $result_message = sprintf($t['result_gasolina_70'], 
            number_format($ethanolPrice, 2, $nf_options['decimal_separator'], $nf_options['thousand_separator']), 
            $percentual, 
            number_format($gasolinePrice, 2, $nf_options['decimal_separator'], $nf_options['thousand_separator']), 
            number_format($limite, 2, $nf_options['decimal_separator'], $nf_options['thousand_separator'])
        );
    }
}

http_response_code(200); // OK
echo json_encode(["error" => false, "result" => $result_key, "message" => $result_message, "result_key" => $result_key]);

?>