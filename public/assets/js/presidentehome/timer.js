// Armazena a referência do elemento do relógio
const clockElement = document.getElementById('clock');

function updateTime() {
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();
    clockElement.textContent =
        `${padNumber(hours)}:${padNumber(minutes)}:${padNumber(seconds)}`;
}

function padNumber(number) {
    return number.toString().padStart(2, '0');
}

setInterval(updateTime, 1000);