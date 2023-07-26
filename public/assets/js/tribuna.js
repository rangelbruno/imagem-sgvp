const { isNull } = require("lodash");

let tempo = 120;
let tempoAtual = 0;
let intervalo;
let vereadorAtual = null;
let vereadorAParte = null;

function formatarTempo(segundos) {
    let minutos = Math.floor(segundos / 60);
    segundos = segundos % 60;
    return `${minutos.toString().padStart(2, "0")}:${segundos
        .toString()
        .padStart(2, "0")}`;
}

function atualizarCronometro() {
    const tempoElement = document.getElementById("tempo");
    tempoElement.innerText = formatarTempo(tempoAtual);

    if (tempoAtual <= 10) {
        tempoElement.style.color = "red";
    } else {
        tempoElement.style.color = "green";
    }
}

function iniciarContagem() {
    clearInterval(intervalo);
    intervalo = setInterval(() => {
        if (tempoAtual > 0) {
            tempoAtual--;
            atualizarCronometro();
        } else {
            pararVereadorIniciar(vereadorAtual);
        }
    }, 1000);
}

function atualizarCorCard(nrSequence, acao) {
    const cardElement = document.querySelector(`#card-${nrSequence}`);
    const mediaElement = cardElement.querySelector(".media");

    // Limpar as cores de fundo
    mediaElement.style.backgroundColor = "";

    if (acao === "iniciar") {
        mediaElement.style.backgroundColor = "rgba(0, 128, 0, 0.1)"; // Fundo verde
    } else if (acao === "a-parte") {
        mediaElement.style.backgroundColor = "rgba(255, 255, 0, 0.2)"; // Fundo amarelo
    }
}

function iniciarVereador(nrSequence, token, nrSeqSessao, nome) {
    const data = {
        tribuna: "Momento",
        tempoTribuna: 2,
        nrSeqUsuarioTribuna: {
            nrSequence: nrSequence,
        },

        nrSeqSessao: {
            nrSequence: nrSeqSessao,
        },
    };

    console.log(data);

    const url = "https://sgvp-backend-api.herokuapp.com/api/tempoTribuna";

    const options = {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`, // Adiciona o token no cabeçalho de autorização
            // Outros cabeçalhos podem ser adicionados aqui, se necessário
        },
        body: JSON.stringify(data),
    };
    fetch(url, options)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Erro ao realizar a requisição.");
            }
            return response.json();
        })
        .then((data) => {
            console.log("Resposta:", data);
        })
        .catch((error) => {
            console.error(error);
        });

    document.getElementById("nomeVereador").innerText = nome;
    document.getElementById(`iniciar-${nrSequence}`).classList.add("d-none");
    document.getElementById(`parar-${nrSequence}`).classList.remove("d-none");
    document.querySelectorAll(".iniciar").forEach((el) => {
        el.classList.add("d-none");
    });
    document.querySelectorAll(".a-parte").forEach((el) => {
        if (el.id !== `a-parte-${nrSequence}`) {
            el.classList.remove("d-none");
        } else {
            el.classList.add("d-none");
        }
    });
    document.querySelectorAll(".parar-a-parte").forEach((el) => {
        el.classList.add("d-none");
    });
    // tempoAtual = tempo;
    // console.log(tempo);
    // iniciarContagem();
    // atualizarCorCard(nrSequence, "iniciar");
}

function resetAParteCard() {
    if (vereadorAParte !== null) {
        document
            .getElementById(`a-parte-${vereadorAParte}`)
            .classList.remove("d-none");
        document
            .getElementById(`parar-a-parte-${vereadorAParte}`)
            .classList.add("d-none");
        document
            .getElementById(`iniciar-${vereadorAParte}`)
            .classList.remove("d-none");
        document.getElementById("nomeVereadorAParte").innerText = "";

        // Limpar a cor do fundo do card no estado "A parte"
        atualizarCorCard(vereadorAParte, "parar");
        vereadorAParte = null;
    }
}

function pararVereadorIniciar(nrSequence) {
    // clearInterval(intervalo);
    document.getElementById("nomeVereador").innerText = "";
    // document.getElementById("tempo").innerText = "00:00";
    // tempoAtual = tempo;
    // vereadorAtual = null;
    document.querySelectorAll(".iniciar").forEach((el) => {
        el.classList.remove("d-none");
    });
    document.querySelectorAll(".a-parte").forEach((el) => {
        el.classList.add("d-none");
    });
    document.querySelectorAll(".parar").forEach((el) => {
        el.classList.add("d-none");
    });
    document.querySelectorAll(".parar-a-parte").forEach((el) => {
        el.classList.add("d-none");
    });
    // if (vereadorAParte !== null) {
    //     document.getElementById("nomeVereadorAParte").innerText = "";
    //     document
    //         .getElementById(`a-parte-${vereadorAParte}`)
    //         .classList.remove("d-none");
    //     document
    //         .getElementById(`parar-a-parte-${vereadorAParte}`)
    //         .classList.add("d-none");
    //     atualizarCorCard(vereadorAParte, "a-parte");
    //     vereadorAParte = null;
    // }
    // atualizarCorCard(nrSequence, "parar");
}

function aparteVereador(nrSequence, nome, token, nrSeqSessao) {
    console.log(nrSeqSessao);
    //Lógica para adicionar o vereador que está falando a parte

    const data = {
        tribuna: "A Parte",
        tempoTribuna: 2,
        nrSeqUsuarioAparte: {
            nrSequence: nrSequence,
        },
        nrSeqSessao: {
            nrSequence: nrSeqSessao,
        },
    };

    console.log(data);

    const url = "https://sgvp-backend-api.herokuapp.com/api/tempoTribuna";

    const options = {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`, // Adiciona o token no cabeçalho de autorização
            // Outros cabeçalhos podem ser adicionados aqui, se necessário
        },
        body: JSON.stringify(data),
    };

    fetch(url, options)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Erro ao realizar a requisição.");
            }
            return response.json();
        })
        .then((data) => {
            console.log("Resposta A parte:", data);
        })
        .catch((error) => {
            console.error(error);
        });
    // document
    //     .getElementById(`a-parte-${vereadorAParte}`)
    //     .classList.remove("d-none");
    // document
    //     .getElementById(`parar-a-parte-${vereadorAParte}`)
    //     .classList.add("d-none");
    // atualizarCorCard(vereadorAParte, "parar");

    document.getElementById("nomeVereadorAParte").innerText = nome;
    document.getElementById(`a-parte-${nrSequence}`).classList.add("d-none");
    document
        .getElementById(`parar-a-parte-${nrSequence}`)
        .classList.remove("d-none");
    atualizarCorCard(nrSequence, "a-parte");
}

function pararVereadorAParte(nrSequence) {
    document.getElementById("nomeVereadorAParte").innerText = "";
    document.getElementById(`a-parte-${nrSequence}`).classList.remove("d-none");
    document
        .getElementById(`parar-a-parte-${nrSequence}`)
        .classList.add("d-none");
    atualizarCorCard(nrSequence, "parar");
}

function adicionarTempoPersonalizado(minutosAdicionais) {
    if (minutosAdicionais > 0) {
        const segundosAdicionais = minutosAdicionais * 60;
        tempo += segundosAdicionais;
        tempoAtual += segundosAdicionais;
        atualizarCronometro();
    }
}

function adicionarTempo() {
    const minutosAdicionais = parseInt(
        document.getElementById("tempoAdicional").value,
        10
    );
    if (!isNaN(minutosAdicionais) && minutosAdicionais > 0) {
        adicionarTempoPersonalizado(minutosAdicionais);
        document.getElementById("tempoAdicional").value = "";
    }

    console.log(minutosAdicionais);
}

function handleKeyDown(event) {
    if (event.key === "Enter") {
        adicionarTempo();
    }
}

function resetarTempo() {
    tempo = 0;
    tempoAtual = tempo;
    atualizarCronometro();
    if (vereadorAtual !== null) {
        clearInterval(intervalo);
        iniciarContagem();
    }
}

document
    .getElementById("adicionarTempo")
    .addEventListener("click", adicionarTempo);
document
    .getElementById("tempoAdicional")
    .addEventListener("keydown", handleKeyDown);
document
    .getElementById("adicionarUmMinuto")
    .addEventListener("click", () => adicionarTempoPersonalizado(1));
document
    .getElementById("adicionarCincoMinutos")
    .addEventListener("click", () => adicionarTempoPersonalizado(5));
document.getElementById("resetarTempo").addEventListener("click", resetarTempo);
