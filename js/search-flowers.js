$(document).ready(function (){
    $('#search').on('keyup', function(e){
        let searchTerm = $('#search').val();

        $.get(
            'flowers-search-results.php',
            {
                search: searchTerm
            },

            function(data){
                $('#flowers-table').html(data);

            },
            'html'
        )
    })
})