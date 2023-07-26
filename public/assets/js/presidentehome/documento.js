$(document).ready(function() {
    $('.open-pdf').on('click', function() {
        var title = $(this).data('title');
        var pdf = $(this).data('pdf');

        $('.modal-title').text(title);
        $('#pdf-embed').attr('src', pdf);
    });
});