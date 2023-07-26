$(document).ready(function() {
    // Esconde o botão de votação quando a página é carregada
    $('#voting-button').hide();
    $('#vote-message').hide();

    // Variável para armazenar o nrSequenceDocumento
    var nrSequenceDocumento;

    // Quando um checkbox é clicado
    $(".new-control-input").click(function() {
        // Pega o nrSequence do documento a partir do atributo data-nrsequence
        nrSequenceDocumento = $(this).data('nrsequence');
        // Armazena o nrSequence no modal
        $('.bd-example-modal-lg').data('nrsequence', nrSequenceDocumento);
        // Armazena o nrSequence no botão de acompanhamento de votação
        $('#acompanhar-votacao').data('nrsequence', nrSequenceDocumento);
        // Mostra o botão de votação
        $('#voting-button').show();
    });

    // Quando o modal é aberto
    $(".bd-example-modal-lg").on("shown.bs.modal", function() {
        // Emitir o evento do Pusher para o canal 'modal-channel'
        var pusher = new Pusher('875de7708', {
            cluster: 'sa1',
            encrypted: true
        });

        var channel = pusher.subscribe('modal-channel');
        channel.bind('server-modal-open', function(data) {
            console.log(data.message);
        });

        // Obtenha o título do modal
        var titulo = $('#myLargeModalLabel').text();
        // Enviar o título como parte do POST Ajax para o Laravel
        $.post("/modal-open", {
            _token: "{{ csrf_token() }}",
            titulo: titulo,
            nrSequenceDocumento: nrSequenceDocumento
        });
    });

    // Quando o botão de votação é clicado
    $(".vote-button").click(function() {
        // Recupera o voto a partir do atributo data-vote do botão clicado
        var vote = $(this).data('vote');
        // Recupera o nrSequenceUsuario a partir da metatag
        var nrSequenceUsuario = $('meta[name="nr-sequence"]').attr('content');
        // Recupera o nrSequenceDocumento a partir do modal
        var nrSequenceDocumento = $('.bd-example-modal-lg').data('nrsequence');
        // Esconde os botões de votação
        $(this).parent().hide();

        // Cria o objeto de dados para enviar para a API
        var dadosVoto = {
            usuarioVoto: {
                nrSequence: nrSequenceUsuario
            },
            documento: {
                nrSequence: nrSequenceDocumento
            },
            voto: vote
        };

        // Envia a votação para o endpoint da API
        $.ajax({
            url: "/votacao",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            contentType: "application/json",
            data: JSON.stringify(dadosVoto),
            success: function(response) {
                // Mostra a mensagem de sucesso e esconde os botões
                $('#vote-message').text(response.message).show();
            },
            error: function(error) {
                // Mostra a mensagem de erro da API, se disponível
                var errorMsg = error.responseJSON && error.responseJSON.message ?
                    error.responseJSON.message :
                    "Erro ao enviar a votação, por favor tente novamente.";
                $('#vote-message').text(errorMsg).show();
            }
        });
    });

    // Quando o botão "Acompanhar votação" é clicado
    $("#acompanhar-votacao").click(function() {
        // Recupera o nrSequence a partir do atributo data-nrsequence do botão
        var nrSequence = $(this).data('nrsequence');
        // Redireciona para a rota de votação
        window.location.href = "/votacao/" + nrSequence;
    });

});