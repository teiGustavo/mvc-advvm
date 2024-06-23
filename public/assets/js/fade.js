// Função para aplicar o efeito fadeIn
function fadeIn(element) {
    // Define a opacidade inicial como 0
    element.style.opacity = 0;

    // Cria um loop para aumentar gradualmente a opacidade
    let opacity = 0;
    const interval = setInterval(() => {
        opacity += 0.05;
        element.style.opacity = opacity;

        // Para o loop quando a opacidade atingir 1
        if (opacity >= 1) {
            clearInterval(interval);
        }
    }, 50); // Intervalo de 50 milissegundos
}

// Função para aplicar o efeito fadeOut
function fadeOut(element) {
    // Define a opacidade inicial como 1
    element.style.opacity = 1;

    // Cria um loop para diminuir gradualmente a opacidade
    let opacity = 1;
    const interval = setInterval(() => {
        opacity -= 0.05;
        element.style.opacity = opacity;

        // Para o loop quando a opacidade atingir 0
        if (opacity <= 0) {
            clearInterval(interval);
        }
    }, 50); // Intervalo de 50 milissegundos
}