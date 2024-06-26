function fadeOut(element, removeElement = true, step = 0.25) {
    element.style.opacity = 1;

    let opacity = 1;
    const interval = setInterval(() => {
        opacity -= step;
        element.style.opacity = opacity;

        if (opacity <= 0) {
            clearInterval(interval);

            if (removeElement === true) {
                element.remove();
            }
        }
    }, 50);
}