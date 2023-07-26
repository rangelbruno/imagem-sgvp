$(document).ready(function() {
    // Esconde o botão de votação quando a página é carregada
    $('#voting-button').hide();
    $('#prepare-voting-button').hide(); // Esconde o botão de preparar votação
    $('.alert').hide(); // Esconde o alerta

    // Variável para armazenar o nrSequenceDocumento
    var nrSequenceDocumento;

    // Quando um checkbox é clicado
    $(".new-control-input").change(function() {
        // Verifica se algum checkbox está selecionado
        var checkboxSelected = $(".new-control-input:checked").length > 0;

        if (checkboxSelected) {
            // Pega o nrSequence do documento a partir do atributo data-nrsequence
            nrSequenceDocumento = $(this).data('nrsequence');
            // Armazena o nrSequence no modal
            $('.bd-example-modal-lg').data('nrsequence', nrSequenceDocumento);
            // Armazena o nrSequence no botão de acompanhamento de votação
            $('#acompanhar-votacao').data('nrsequence', nrSequenceDocumento);
            // Mostra o botão de votação
            $('#voting-button').show();

            // Verifica o status do documento
            var statusDocumento = $(this).data('status');
            if (statusDocumento !== 'VOTACAO') {
                // Mostra o botão de preparar votação
                $('#prepare-voting-button').show().data('nrsequence', nrSequenceDocumento);
            } else {
                // Esconde o botão de preparar votação
                $('#prepare-voting-button').hide();
            }

            // Destaca a linha do documento selecionado
            $('.document-row-' + nrSequenceDocumento).addClass('highlight-row');
        } else {
            // Nenhum checkbox está selecionado, esconde o botão de votação e preparar votação
            $('#voting-button').hide();
            $('#prepare-voting-button').hide();
            // Remove o destaque de todas as linhas de documentos
            $('.highlight-row').removeClass('highlight-row');
        }
    });

    // Quando o botão "Preparar Votação" é clicado
    $('#prepare-voting-button').click(function() {
        // Recupera o nrSequenceDocumento a partir do botão
        var nrSequenceDocumento = $(this).data('nrsequence');

        // Verifica se nrSequenceDocumento é válido
        if (!nrSequenceDocumento) {
            $('.alert strong').text('Error! Número de sequência do documento não encontrado!');
            $('.alert').show();
            return;
        }

        // Envia a requisição para alterar o status do documento
        $.ajax({
            url: "/votacao/preparar/" + nrSequenceDocumento,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            contentType: "application/json",
            data: JSON.stringify({
                statusDocumento: "VOTACAO"
            }),
            success: function(response) {
                // Esconde o botão de preparar votação
                $('#prepare-voting-button').hide();
                // Destaca a linha do documento selecionado
                $('.document-row-' + nrSequenceDocumento).addClass('highlight-row');
                // Altera a classe do alerta para sucesso
                $('.alert').removeClass('alert-light-danger').addClass(
                    'alert-light-success');
                // Atualiza o texto do alerta com a mensagem de sucesso
                $('.alert strong').text(response.message);
                // Mostra o alerta
                $('.alert').show();
            },
            error: function(error) {
                // Mostra a mensagem de erro da API, se disponível
                var errorMsg = error.responseJSON && error.responseJSON.message ? error
                    .responseJSON.message :
                    "Erro ao preparar a votação, por favor tente novamente.";
                // Altera a classe do alerta para erro
                $('.alert').removeClass('alert-light-success').addClass(
                    'alert-light-danger');
                // Atualiza o texto do alerta com a mensagem de erro
                $('.alert strong').text('Error! ' + errorMsg);
                // Mostra o alerta
                $('.alert').show();
            }
        });
    });
});