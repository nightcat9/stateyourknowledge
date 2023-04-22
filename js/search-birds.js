$(document).ready(function (){
    $('#search').on('keyup', function(e){
        let searchTerm = $('#search').val();

        $.get(
            'birds-search-results.php',
            {
                search: searchTerm
            },

            function(data){
                $('#birds-table').html(data);

            },
            'html'
        )
    })
})