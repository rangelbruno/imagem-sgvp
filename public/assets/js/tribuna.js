const { isNull } = require("lodash");

var tempo = 120;
var tempoAtual = 2;
var intervalo;
var vereadorAtual = null;
var vereadorAParte = null;

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

var nrSeqTribuna = 1;
var minutoAdicional = 0;
var nrSeqVereadorAparte;

function setIDVereadorMomento(nrSequence) {
    nrSeqTribuna = nrSequence;
}
function setIDVereadorAparte(nrSequence) {
    nrSeqVereadorAparte = nrSequence;
}
function setMinutosAdicionais(minutosAdicionais) {
    minutoAdicional = minutosAdicionais;
    alert(minutoAdicional);
}

var nrSequence;
var token;
var nrSeqSessao;

function setVereador(idvereador, tokenVereador, nrSessao) {
    nrSequence = idvereador;
    token = tokenVereador;
    nrSeqSessao = nrSessao;
}

function adicionarTempo() {
    const minutosAdicionais = document.getElementById("tempoAdicional").value;

    const data = {
        tribuna: "Momento",
        tempoAdicional: minutosAdicionais, //Vai ir como nulo
        tempoTribuna: null,
        nrSeqUsuarioTribuna: {
            nrSequence: nrSequence,
        },
        nrSeqUsuarioAparte: {
            nrSequence: nrSeqVereadorAparte,
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
}

function iniciarVereador(nrSequence, token, nrSeqSessao, nome) {
    setIDVereadorMomento(nrSequence);

    if (tempoAtual === undefined) {
        tempoAtual = 2;
    }

    const data = {
        tribuna: "Momento",
        tempoAdicional: minutoAdicional, //Vai ir como nulo
        tempoTribuna: tempoAtual,
        nrSeqUsuarioTribuna: {
            nrSequence: nrSequence,
        },

        nrSeqSessao: {
            nrSequence: nrSeqSessao,
        },
    };

    console.log(tempoAtual);
    setVereador(nrSequence, token, nrSeqSessao);

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
    tempoAtual = tempo;

    atualizarCorCard(nrSequence, "iniciar");
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
    //Lógica para adicionar o vereador que está falando a parte

    // const data = {
    //     tribuna: "A Parte",
    //     tempoTribuna: 0,
    //     nrSeqUsuarioTribuna: {
    //         nrSequence: null,
    //     },

    //     nrSeqUsuarioAparte: {
    //         nrSequence: null,
    //     },
    //     nrSeqSessao: {
    //         nrSequence: nrSeqSessao,
    //     },
    // };

    // console.log(data);

    // const url = "https://sgvp-backend-api.herokuapp.com/api/tempoTribuna";

    // const options = {
    //     method: "POST",
    //     headers: {
    //         "Content-Type": "application/json",
    //         Authorization: `Bearer ${token}`, // Adiciona o token no cabeçalho de autorização
    //         // Outros cabeçalhos podem ser adicionados aqui, se necessário
    //     },
    //     body: JSON.stringify(data),
    // };

    // fetch(url, options)
    //     .then((response) => {
    //         if (!response.ok) {
    //             throw new Error("Erro ao realizar a requisição.");
    //         }
    //         return response.json();
    //     })
    //     .then((data) => {
    //         console.log("Resposta A parte:", data);
    //     })
    //     .catch((error) => {
    //         console.error(error);
    //     });
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
    setIDVereadorAparte(nrSequence);
    //Lógica para adicionar o vereador que está falando a parte

    const data = {
        tribuna: "A Parte",
        tempoTribuna: 2,
        nrSeqUsuarioTribuna: {
            nrSequence: nrSeqTribuna,
        },
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

// function pararVereadorAParte(nrSequence) {
//     document.getElementById("nomeVereadorAParte").innerText = "";
//     document.getElementById(`a-parte-${nrSequence}`).classList.remove("d-none");
//     document
//         .getElementById(`parar-a-parte-${nrSequence}`)
//         .classList.add("d-none");
//     atualizarCorCard(nrSequence, "parar");
// }

function adicionarTempoPersonalizado(minutosAdicionais) {
    console.log(minutosAdicionais);
    if (minutosAdicionais > 0) {
        const segundosAdicionais = minutosAdicionais * 60;
        tempo += segundosAdicionais;
        tempoAtual += segundosAdicionais;
        console.log(minutosAdicionais);
    }
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
