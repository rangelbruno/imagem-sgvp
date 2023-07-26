// Criando um objeto Date com a data atual
var dataAtual = new Date();

// Obtendo o dia do mês
var dia = dataAtual.getDate();

// Obtendo o número do mês (lembrando que os meses começam em 0)
var mes = dataAtual.getMonth();

// Obtendo o ano com 4 dígitos
var ano = dataAtual.getFullYear();

// Criando um array com os nomes dos meses
var nomesMeses = [
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

// Obtendo o nome do mês com base no número do mês obtido anteriormente
var nomeMes = nomesMeses[mes];

var dataAtual = dia + " de " + nomeMes + " de " + ano;

var dataFront = document.getElementById("dataAtual");
dataFront.textContent = dataAtual;

// Exibindo a data no formato desejado
console.log(dataAtual);