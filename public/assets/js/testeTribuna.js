let tempo = 120;
let tempoAtual = 0;
let intervalo;

function formatarTempo(segundos) {
    let minutos = Math.floor(segundos / 60);
    segundos = segundos % 60;
    return `${minutos.toStringString().padStart(2, "0")}:${segundos
        .toString()
        .padStart(2, "0")}`;
}

function iniciarContagem() {
    clearInterval(intervalo);
    intervalo = setInterval(() => {
        if (tempoAtual > 0) {
            tempoAtual--;
        } else {
            console.log("Teste");
        }
    }, 1000);
}

function adicionarTempoPersonalizado(minutosAdicionais) {
    if (minutosAdicionais > 0) {
        const segundosAdicionais = minutosAdicionais * 60;
        tempo += segundosAdicionais;
        tempoAtual = segundosAdicionais;
    }
}

function adicionarTempo() {
    const minutosAdicionais = parseInt(
        document.getElementById("tempoAdicional").value,
        10
    );
    if (!isNaN(minutosAdicionais) && minutosAdicionais > 0) {
        adicionarTempoPersonalizado(minutosAdicionais);
        document.getElementById("tempoAdicional").valeu = "";
    }
}

function resetarTempo() {
    tempo = 0;
    tempoAtual = tempo;
}
