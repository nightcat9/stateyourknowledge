$(document).ready(function (){
    $('#search').on('keyup', function(e){
        let searchTerm = $('#search').val();

        $.get(
            'states-search-results.php',
            {
                search: searchTerm
            },

            function(data){
                $('#states-table').html(data);

            },
            'html'
        )
    })
})