$(document).ready(function() {

    function updateDocumentList() {
        var selectedDocuments = $('.new-control-input:checked').not('#todoAll').map(function() {
            return {
                title: $(this).closest('tr').find('.open-pdf').text(),
                nrsequence: $(this).data('nrsequence')
            };
        }).get();

        console.log('selectedDocuments:', selectedDocuments);

        $('#selected-documents-list').empty();
        $.each(selectedDocuments, function(index, doc) {
            $('#selected-documents-list').append($('<p></p>').text(doc.title));
        });

        if (selectedDocuments.length > 0) {
            $('#bulk-voting-button').show();
        } else {
            $('#bulk-voting-button').hide();
        }
    }

    $('.new-control-input').on('change', function() {
        updateDocumentList();
    });

    $('#bulk-voting-button').on('click', function() {
        updateDocumentList();
    });

    $(".vote-button-bloco").click(function() {
        var selectedDocuments = $('.new-control-input:checked').not('#todoAll').map(function() {
            return $(this).data('nrsequence');
        }).get();

        console.log('selectedDocuments:', selectedDocuments);

        var vote = $(this).data('vote');
        var nrSequenceUsuario = $('meta[name="nr-sequence"]').attr('content');

        var dadosVoto = {
            usuarioVoto: {
                nrSequence: nrSequenceUsuario
            },
            voto: vote,
            documentos: selectedDocuments
        };

        console.log('dadosVoto:', dadosVoto);

        $.ajax({
            url: "/votacao-bloco",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            contentType: "application/json",
            data: JSON.stringify(dadosVoto),
            success: function(response) {
                console.log('Success response:', response);
                $('#vote-message').html('').hide();
                $('#vote-message').removeClass('alert alert-danger').addClass(
                    'alert alert-success');
                $('#vote-message').text(response.message).show();
            },
            error: function(error) {
                console.log('Error:', error);
                $('#vote-message').html('').hide();
                $('#vote-message').removeClass('alert alert-success').addClass(
                    'alert alert-danger');
                var errorMsg = error.responseJSON && error.responseJSON.message ?
                    error.responseJSON.message :
                    "Erro ao enviar a votação, por favor tente novamente.";
                $('#vote-message').text(errorMsg).show();
            }
        });
    });
});