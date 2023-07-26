$(document).ready(function() {
    // Manipula o evento de mudança do checkbox
    $('.new-control-input').change(function() {
        var quantidadeSelecionada = $('.new-control-input:checked').length;

        if (quantidadeSelecionada > 1) {
            $('#voting-button').hide();
            $('#bulk-voting-button').show();
        } else if (quantidadeSelecionada == 1) {
            $('#voting-button').show();
            $('#bulk-voting-button').hide();
        } else {
            $('#voting-button').hide();
            $('#bulk-voting-button').hide();
        }
    });

    // Manipula o evento de clique do botão de votação
    $('#voting-button').click(function() {
        // Pega o id do documento a partir do id do checkbox
        var documentoId = $('.new-control-input:checked').attr('id').replace('todo-', '');

        // Busca o documento correspondente
        var documento = documentos.find(function(doc) {
            return doc.nrSequence == documentoId;
        });

        if (documento) {
            // Atualiza o título do modal com o título do documento
            $('#myLargeModalLabel').text(documento.titulo);
            $('.bd-example-modal-lg').modal('show');
        }
    });
});
