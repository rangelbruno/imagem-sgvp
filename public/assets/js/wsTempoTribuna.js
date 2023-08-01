//Funcõa para trazer os dados dos vereadores que estão com o momento de fala
function dadosVereadorMomentodeFala(nome, partido) {
    if (nome && partido === "null") {
        var nomeVereador = document.querySelector("#NameVereador");
        var partidoVereador = document.querySelector("#partidoVereadorMomento");

        nomeVereador.innerHTML = "";
        partidoVereador.innerHTML = "";
    } else {
        var nomeVereador = document.querySelector("#NameVereador");
        var partidoVereador = document.querySelector("#partidoVereadorMomento");

        nomeVereador.innerHTML = nome;
        partidoVereador.innerHTML = partido;
    }
}

function limparTelão(tribuna) {
    console.log(tribuna);
    if (tribuna === "Limpar") {
        const timer = document.getElementById("timer");
    }
}

function dadosVereadorAparte(nome, partido) {
    if (nome && partido === "null") {
        var nomeVereadorAparte = document.querySelector("#NomeVereadorAparte");
        var partidoVereadorAparte = document.querySelector(
            "#PartidoVereadorAparte"
        );

        nomeVereadorAparte.innerHTML = "";
        partidoVereadorAparte.innerHTML = "";
    } else {
        var nomeVereadorAparte = document.querySelector("#NomeVereadorAparte");
        var partidoVereadorAparte = document.querySelector(
            "#PartidoVereadorAparte"
        );

        nomeVereadorAparte.innerHTML = nome;
        partidoVereadorAparte.innerHTML = partido;
    }
}

// function dadosVereadorAparte(nome, partido) {}

//Formatar o tempo do cronometro
function formatTime(minutes, seconds) {
    return `${String(minutes).padStart(2, "0")}:${String(seconds).padStart(
        2,
        "0"
    )}`;
}

let interval;
let totalSegundos = 0;
let segundosAdicionais = 0;
function setTotalSegundos(totalSeconds) {
    totalSegundos = totalSeconds;
}

// Função para atualizar o cronômetro
function updateTimer(minutes, minutoAdicional, tribuna) {
    let totalSeconds = 0;

    if (minutoAdicional === "null") {
        totalSeconds = minutes * 60;
    }

    if (minutes === "null") {
        totalSeconds = minutoAdicional * 60 + totalSegundos;
    }

    const timerElement = document.getElementById("timer");

    function update(tribuna) {
        if (tribuna === "Limpar") {
            const timerElement = document.getElementById("timer");
            timerElement.innerHTML = "";
        }
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;
        timerElement.textContent = formatTime(minutes, seconds);

        if (totalSeconds <= 0) {
            clearInterval(interval);

            // Aqui você pode adicionar alguma ação quando o cronômetro chegar a zero.
            console.log("Cronômetro chegou a zero!");
        }
        setTotalSegundos(totalSeconds);
        totalSeconds--;
    }

    // Verifique se o intervalo já está ativo
    if (interval) {
        clearInterval(interval);
    }

    // Inicialize o intervalo
    interval = setInterval(update, 1000);

    // Chame a função update imediatamente para evitar um atraso de 1 segundo no início
    update(tribuna);
}

// Cria uma nova instânci a de WebSocket
function reconnectWebSocket() {
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
        console.log(objeto);
        const nomeVereadorMomento = objeto.vereadorMomento;
        const partidoVereadorMomento = objeto.partidoVereadorMomento;
        const partidoVereadorAparte = objeto.partidoVereadorAparte;
        const vereadorAparte = objeto.vereadorAparte;
        const tempoAdicional = objeto.tempoAdicional;
        dadosVereadorMomentodeFala(nomeVereadorMomento, partidoVereadorMomento);
        const tempoTribuna = objeto.tempoTribuna;
        const tribuna = objeto.tribuna;
        dadosVereadorAparte(vereadorAparte, partidoVereadorAparte);
        updateTimer(tempoTribuna, tempoAdicional, tribuna);
    };

    // Manipulador de evento para lidar com erros
    socket.onerror = function (error) {
        console.error("Erro WebSocket:", error);
    };

    // Manipulador de evento para lidar com o fechamento da conexão
    socket.onclose = function () {
        console.log("Conexão fechada.");
        setTimeout(reconnectWebSocket, 1000);
    };
}

reconnectWebSocket();
