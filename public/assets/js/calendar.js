var meses = [
    "Janeiro",
    "Fevereiro",
    "Março",
    "Abril",
    "Maio",
    "Junho",
    "Julho",
    "Agosto",
    "Setembro",
    "Outubro",
    "Novembro",
    "Dezembro",
];

var data = Date();

var formatData = data.replace(/(\d{2})(\/)(\d{2})/, "$3$2$1");

var newData = new Date(formatData);

var dataAtual =
    newData.getDate() + " de " + meses[newData.getMonth()] + " " + "de" + "";
newData.getFullYear().toString();

var anoAtual = newData.getFullYear().toString();

const dataAtualFront = dataAtual + " " + anoAtual;

var setDate = window.document.getElementById("dataAtual");
setDate.innerHTML = dataAtualFront;
