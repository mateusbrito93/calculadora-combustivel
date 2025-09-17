document.addEventListener('DOMContentLoaded', () => {
    // --- Seletores de Elementos ---
    const fuelForm = document.getElementById('fuelForm');
    const themeCheckbox = document.getElementById('theme-checkbox');
    const resultArea = document.getElementById('resultArea');
    const submitButton = fuelForm.querySelector('button[type="submit"]');
    const spinner = submitButton.querySelector('.spinner-border');
    const gasolineInput = document.getElementById('gasoline');
    const ethanolInput = document.getElementById('ethanol');
    const consumoGasolinaInput = document.getElementById('consumoGasolina');
    const consumoEtanolInput = document.getElementById('consumoEtanol');
    const toggleConsumo = document.getElementById('toggleConsumo');
    const consumoFields = document.getElementById('consumoFields');
    const themeToggleButton = document.getElementById('theme-toggle');
    const langButtons = document.querySelectorAll('.lang-btn');

    // --- Dicionário de Traduções ---
    const translations = {
        pt: {
            pageTitle: "Etanol ou Gasolina? | Calculadora Inteligente",
            mainTitle: "Etanol ou Gasolina?",
            subtitle: "Descubra qual combustível é mais vantajoso agora!",
            gasolinePriceLabel: "Preço Gasolina (R$/L)",
            gasolinePlaceholder: "Ex: 5.89",
            ethanolPriceLabel: "Preço Etanol (R$/L)",
            ethanolPlaceholder: "Ex: 3.99",
            useConsumptionLink: "➕ Usar consumo do veículo",
            hideConsumptionLink: "➖ Ocultar campos de consumo",
            gasolineConsumptionLabel: "Consumo com Gasolina (km/L)",
            ethanolConsumptionLabel: "Consumo com Etanol (km/L)",
            consumptionPlaceholder: "Ex: 10",
            calculateButton: "Calcular",
            footerReserved: "© 2025 Todos os direitos reservados",
            resultPrefix: "Abasteça com", // Adicionado para mensagens de resultado
            error: "Erro!"
        },
        en: {
            pageTitle: "Ethanol or Gasoline? | Smart Calculator",
            mainTitle: "Ethanol or Gasoline?",
            subtitle: "Find out which fuel is more advantageous now!",
            gasolinePriceLabel: "Gasoline Price ($/L)",
            gasolinePlaceholder: "Ex: 5.89",
            ethanolPriceLabel: "Ethanol Price ($/L)",
            ethanolPlaceholder: "Ex: 3.99",
            useConsumptionLink: "➕ Use vehicle consumption",
            hideConsumptionLink: "➖ Hide consumption fields",
            gasolineConsumptionLabel: "Consumption with Gasoline (km/L)",
            ethanolConsumptionLabel: "Consumption with Ethanol (km/L)",
            consumptionPlaceholder: "Ex: 10",
            calculateButton: "Calculate",
            footerReserved: "© 2025 All rights reserved",
            resultPrefix: "Fill up with",
            error: "Error!"
        },
        es: {
            pageTitle: "¿Etanol o Gasolina? | Calculadora Inteligente",
            mainTitle: "¿Etanol o Gasolina?",
            subtitle: "¡Descubre qué combustible es más ventajoso ahora!",
            gasolinePriceLabel: "Precio Gasolina ($/L)",
            gasolinePlaceholder: "Ej: 5.89",
            ethanolPriceLabel: "Precio Etanol ($/L)",
            ethanolPlaceholder: "Ej: 3.99",
            useConsumptionLink: "➕ Usar consumo del vehículo",
            hideConsumptionLink: "➖ Ocultar campos de consumo",
            gasolineConsumptionLabel: "Consumo con Gasolina (km/L)",
            ethanolConsumptionLabel: "Consumo con Etanol (km/L)",
            consumptionPlaceholder: "Ej: 10",
            calculateButton: "Calcular",
            footerReserved: "© 2025 Todos los derechos reservados",
            resultPrefix: "Abastecer con",
            error: "¡Error!"
        }
    };

    // --- Lógica de Idioma ---
    let currentLang = localStorage.getItem('language') || 'pt';

    const setLanguage = (lang) => {
        currentLang = lang;
        localStorage.setItem('language', lang);
        document.documentElement.lang = lang;

        document.querySelectorAll('[data-i18n-key]').forEach(element => {
            const key = element.getAttribute('data-i18n-key');
            element.textContent = translations[lang][key];
        });

        // Atualiza placeholders
        document.querySelectorAll('[data-i18n-placeholder-key]').forEach(element => {
            const key = element.getAttribute('data-i18n-placeholder-key');
            element.placeholder = translations[lang][key];
        });

        // Atualiza o texto do título da página
        document.title = translations[lang].pageTitle;

        // Atualiza o texto do link de consumo separadamente
        if (consumoFields.style.display === 'none') {
            toggleConsumo.textContent = translations[lang].useConsumptionLink;
        } else {
            toggleConsumo.textContent = translations[lang].hideConsumptionLink;
        }

        langButtons.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.lang === lang);
        });
    };

    langButtons.forEach(button => {
        button.addEventListener('click', () => {
            setLanguage(button.dataset.lang);
        });
    });

    const setTheme = (theme) => {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        // Sincroniza o estado do checkbox com o tema
        themeCheckbox.checked = theme === 'dark';
    };

    // Evento de 'change' no checkbox para alternar o tema
    themeCheckbox.addEventListener('change', () => {
        setTheme(themeCheckbox.checked ? 'dark' : 'light');
    });

    // Inicializa o tema com base no localStorage ou preferência do sistema
    const savedTheme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    setTheme(savedTheme);


    // --- Lógica da Calculadora ---
    toggleConsumo.addEventListener('click', function (e) {
        e.preventDefault();
        const isHidden = consumoFields.style.display === 'none';
        consumoFields.style.display = isHidden ? 'block' : 'none';
        toggleConsumo.textContent = isHidden ? translations[currentLang].hideConsumptionLink : translations[currentLang].useConsumptionLink;
        if (!isHidden) { // Se for mostrar os campos, limpa-os
            consumoGasolinaInput.value = '';
            consumoEtanolInput.value = '';
        }
    });

    function formatCurrencyInput(event) {
        const input = event.target;
        let value = input.value.replace(/\D/g, '');
        if (value === '') {
            input.value = ''; // Limpa se não houver dígitos
            return;
        }
        value = parseInt(value, 10).toString();

        // Garante que haja pelo menos '0.00' para valores muito pequenos
        while (value.length < 3) {
            value = '0' + value;
        }

        const integerPart = value.slice(0, -2);
        const decimalPart = value.slice(-2);
        input.value = integerPart + '.' + decimalPart;
    }


    gasolineInput.addEventListener('input', formatCurrencyInput);
    ethanolInput.addEventListener('input', formatCurrencyInput);
    // Para campos de consumo, não formatamos como moeda
    // consumoGasolinaInput.addEventListener('input', formatCurrencyInput); 
    // consumoEtanolInput.addEventListener('input', formatCurrencyInput); 

    fuelForm.addEventListener('submit', function (event) {
        event.preventDefault();
        spinner.classList.remove('d-none');
        submitButton.disabled = true;

        const formData = new FormData(fuelForm);
        formData.append('lang', currentLang); // Envia o idioma atual para o backend

        fetch('api/calcular.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => displayResult(data))
            .catch(error => {
                console.error('Erro na requisição:', error);
                displayResult({
                    error: true,
                    message: translations[currentLang].connectionError || 'Ocorreu um erro de comunicação com o servidor. Tente novamente.',
                    result: translations[currentLang].error
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

        let alertClass = data.error ? 'alert-danger' : (data.result_key === 'Etanol' ? 'alert-success' : 'alert-info');
        let resultTitle = data.error ? translations[currentLang].error : `${translations[currentLang].resultPrefix} ${data.result}!`;

        const resultHTML = `
            <div class="alert ${alertClass}" role="alert">
                <h4 class="alert-heading">${resultTitle}</h4>
                <p>${data.message}</p>
            </div>`;
        resultArea.innerHTML = resultHTML;
    }

    // --- Inicialização da Página ---
    setLanguage(currentLang);
});