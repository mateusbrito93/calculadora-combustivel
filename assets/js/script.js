document.addEventListener('DOMContentLoaded', () => {
    const fuelForm = document.getElementById('fuelForm');
    const resultArea = document.getElementById('resultArea');
    const submitButton = fuelForm.querySelector('button[type="submit"]');
    const spinner = submitButton.querySelector('.spinner-border');

    const gasolineInput = document.getElementById('gasoline');
    const ethanolInput = document.getElementById('ethanol');

    const consumoGasolinaInput = document.getElementById('consumoGasolina');
    const consumoEtanolInput = document.getElementById('consumoEtanol');

    const toggleConsumo = document.getElementById('toggleConsumo');
    const consumoFields = document.getElementById('consumoFields');

    toggleConsumo.addEventListener('click', function (e) {
        e.preventDefault();
        if (consumoFields.style.display === 'none') {
            consumoFields.style.display = 'block';
            toggleConsumo.textContent = '➖ Ocultar campos de consumo';
        } else {
            consumoFields.style.display = 'none';
            toggleConsumo.textContent = '➕ Usar consumo do veículo';
            // limpa valores se esconder
            document.getElementById('consumoGasolina').value = '';
            document.getElementById('consumoEtanol').value = '';
        }
    });

    // Função para formatar o valor enquanto o usuário digita
    function formatCurrencyInput(event) {
        const input = event.target;
        // 1. Pega o valor atual e remove tudo que não for número
        let value = input.value.replace(/\D/g, '');

        // Se o valor estiver vazio, não faz nada
        if (value === '') {
            return;
        }

        // 2. Converte para número para remover zeros à esquerda (ex: 0050 se torna 50)
        value = parseInt(value, 10).toString();

        // 3. Adiciona o ponto decimal
        if (value.length === 1) {
            // Se o usuário digitou '5', o campo mostrará '0.05'
            input.value = '0.0' + value;
        } else if (value.length === 2) {
            // Se o usuário digitou '58', o campo mostrará '0.58'
            input.value = '0.' + value;
        } else {
            // Se o usuário digitou '589', o campo mostrará '5.89'
            const integerPart = value.slice(0, -2);
            const decimalPart = value.slice(-2);
            input.value = integerPart + '.' + decimalPart;
        }
    }

    gasolineInput.addEventListener('input', formatCurrencyInput);
    ethanolInput.addEventListener('input', formatCurrencyInput);


    fuelForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const gasolinePrice = gasolineInput.value;
        const ethanolPrice = ethanolInput.value;

        if (!gasolinePrice || !ethanolPrice || gasolinePrice <= 0 || ethanolPrice <= 0) {
            displayResult({
                error: true,
                message: 'Por favor, insira valores válidos e positivos para ambos os combustíveis.'
            });
            return;
        }

        spinner.classList.remove('d-none');
        submitButton.disabled = true;

        const formData = new FormData();
        formData.append('gasoline', gasolinePrice);
        formData.append('ethanol', ethanolPrice);
        formData.append('consumoGasolina', consumoGasolinaInput.value);
        formData.append('consumoEtanol', consumoEtanolInput.value);

        fetch('api/calcular.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                displayResult(data);
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
                displayResult({
                    error: true,
                    message: 'Ocorreu um erro de comunicação com o servidor. Tente novamente.'
                });
            })
            .finally(() => {
                spinner.classList.add('d-none');
                submitButton.disabled = false;
            });
    });

    function displayResult(data) {
        resultArea.innerHTML = '';
        resultArea.style.display = 'block';

        let alertClass = '';
        let resultTitle = '';
        let resultMessage = '';

        if (data.error) {
            alertClass = 'alert-danger';
            resultTitle = 'Erro!';
            resultMessage = data.message;
        } else {
            if (data.result === 'Etanol') {
                alertClass = 'alert-success';
                resultTitle = `Abasteça com ${data.result}!`;
            } else {
                alertClass = 'alert-info';
                resultTitle = `Abasteça com ${data.result}!`;
            }
            resultMessage = data.message;
        }

        const resultHTML = `
            <div class="alert ${alertClass}" role="alert">
                <h4 class="alert-heading">${resultTitle}</h4>
                <p>${resultMessage}</p>
            </div>
        `;

        resultArea.innerHTML = resultHTML;
    }
});