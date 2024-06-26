function fadeIn(element, step = 0.05) {
    element.style.opacity = 0;

    let opacity = 0;
    const interval = setInterval(() => {
        opacity += step;
        element.style.opacity = opacity;

        if (opacity >= 1) {
            clearInterval(interval);
        }
    }, 50);
}