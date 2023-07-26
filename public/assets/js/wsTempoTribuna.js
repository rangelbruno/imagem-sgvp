//Funcõa para trazer os dados dos vereadores que estão com o momento de fala
function dadosVereadorMomentodeFala(nome, partido) {
    if (nome === null) {
        alert("nulo");
        var nomeVereador = document.querySelector("#NameVereador");
        nomeVereador.innerHTML = "";

        var partidoVereador = document.querySelector("#partidoVereadorMomento");
        partidoVereador.innerHTML = "";
    } else {
        var nomeVereador = document.querySelector("#NameVereador");
        var partidoVereador = document.querySelector("#partidoVereadorMomento");

        nomeVereador.innerHTML = nome;
        partidoVereador.innerHTML = partido;
    }

    return;
}

function dadosVereadorAparte(nome, partido) {
    if (nome === null) {
        alert("Nulo");
        var nomeVereadorAparte = document.querySelector("#NomeVereadorAparte");
        nomeVereadorAparte.innerHTML = nome;

        var partidoVereadorAparte = document.querySelector(
            "#PartidoVereadorAparte"
        );
        partidoVereadorAparte.innerHTML = partido;
    } else {
        var nomeVereadorAparte = document.querySelector("#NomeVereadorAparte");
        nomeVereadorAparte.innerHTML = "";

        var partidoVereadorAparte = document.querySelector(
            "#PartidoVereadorAparte"
        );
        partidoVereadorAparte.innerHTML = "";
    }
    return;
}

// function dadosVereadorAparte(nome, partido) {}

//Formatar o tempo do cronometro
function formatTime(minutes, seconds) {
    return `${String(minutes).padStart(2, "0")}:${String(seconds).padStart(
        2,
        "0"
    )}`;
}

// Função para atualizar o cronômetro
function updateTimer(minutes) {
    let totalSeconds = minutes * 60;

    const timerElement = document.getElementById("timer");

    function update() {
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;
        timerElement.textContent = formatTime(minutes, seconds);

        if (totalSeconds <= 0) {
            clearInterval(interval);
            // Aqui você pode adicionar alguma ação quando o cronômetro chegar a zero.
            console.log("Cronômetro chegou a zero!");
        }

        totalSeconds--;
    }

    // Chame a função update imediatamente para evitar um atraso de 1 segundo no início
    update();

    // Chame a função update a cada segundo
    const interval = setInterval(update, 1000);
}

// Cria uma nova instânci a de WebSocket
const socket = new WebSocket(
    "ws://sgvp-backend-api.herokuapp.com/ws/tempoTribuna"
);

// Manipulador de evento para quando a conexão é estabelecida
socket.onopen = function () {
    console.log("Conexão estabelecida com sucesso!");
};

// Manipulador de evento para receber mensagens do servidor
socket.onmessage = function (event) {
    const data = event.data;
    const objeto = JSON.parse(data);
    const nomeVereadorMomento = objeto.vereadorMomento;
    const partidoVereadorMomento = objeto.partidoVereadorMomento;
    const nomeVereadorAparte = objeto.vereadorAparte;
    const partidoVereadorAparte = objeto.partidoVereadorAparte;

    dadosVereadorMomentodeFala(nomeVereadorMomento, partidoVereadorMomento);
    dadosVereadorAparte(nomeVereadorAparte, partidoVereadorAparte);
    const tempoTribuna = objeto.tempoTribuna;
    updateTimer(tempoTribuna);
};

// Manipulador de evento para lidar com erros
socket.onerror = function (error) {
    console.error("Erro WebSocket:", error);
};

// Manipulador de evento para lidar com o fechamento da conexão
socket.onclose = function () {
    console.log("Conexão fechada.");
};
