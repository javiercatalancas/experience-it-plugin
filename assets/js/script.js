jQuery(document).ready(function($) {
    function getUsers(page) {
        $.ajax({
            url: get_users_ajax.ajaxurl,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'get_users_paginated_action',
                page: page 
            },
            success: function(response) {
                console.log(response);
                $('#users-listing-table tbody').empty();    
                $('#error-message').css('display', 'none');
                $('#no-data-found').css('display', 'none');
                $('#search_term_name').val('');
                $('#search_term_surname1').val('');
                $('#search_term_surname2').val('');
                $('#search_term_email').val('');         
                $.each(response.users, function(index, user) {
					console.log('usuario',user.user);
                    var userRow = '<tr>' +
                        '<td>' + user.user + '</td>' +
                        '<td>' + (user.name || 'No especificado') + '</td>' +
                        '<td>' + (user.surname1 || 'No especificado') + '</td>' +
                        '<td>' + (user.surname2 || 'No especificado') + '</td>' +
                        '<td>' + (user.email || 'No especificado') + '</td>' +
                        '</tr>';
                    $('#users-listing-table tbody').append(userRow);
                });
                 if (page===1){
                var totalPages = response.total_pages;
                var currentPage = response.current_page;
                console.log(totalPages);
                console.log(currentPage);

                $('.pagination').empty();
                for (var i = 1; i <= totalPages; i++) {
                    var linkClass = (i === currentPage) ? 'active' : '';
                    $('.pagination').append('<a href="#" class="' + linkClass + '" data-page="' + i + '">' + i + '</a>');
                }
                } 
                
            },
            error: function(jqXHR, textStatus, error) {
                console.log("ERROR", error);
            }
        });
    }
     getUsers(1); 
     $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).data('page');
        getUsers(page);
    });  

function search(){
    var searchTermName = $('#search_term_name').val(); 
    var searchTermSurname1 = $('#search_term_surname1').val();
    var searchTermSurname2 = $('#search_term_surname2').val();
    var searchTermEmail = $('#search_term_email').val();
    $.ajax({
        url: get_users_ajax.ajaxurl,
        type: 'post',
        dataType: 'json',
        data: {
            action: 'search_users_ajax_action',
            search_term_name: searchTermName,
            search_term_surname1: searchTermSurname1,
            search_term_surname2: searchTermSurname2,
            search_term_email: searchTermEmail
            },
        success: function(response) {
            $('#users-listing-table tbody').empty();
            if(searchTermName === '' && searchTermSurname1 === '' && searchTermSurname2 === '' && searchTermEmail === '') {
                $('#error-message').css('display', 'block');
            } else {
                $('#error-message').css('display', 'none');
                $('#no-data-found').css('display', 'none');
                
                    $.each(response, function(index, user) {
                        if(user.id){
                        var userRow = '<tr>' +
                            '<td>' + user.user + '</td>' +
                            '<td>' + (user.name || 'No especificado') + '</td>' +
                            '<td>' + (user.surname1 || 'No especificado') + '</td>' +
                            '<td>' + (user.surname2 || 'No especificado') + '</td>' +
                            '<td>' + (user.email || 'No especificado') + '</td>' +
                            '</tr>';
                        $('#users-listing-table tbody').append(userRow);
                        $('#search_term_name').val('');
                        $('#search_term_surname1').val('');
                        $('#search_term_surname2').val('');
                        $('#search_term_email').val('');
                    } else {
                        $('#error-message').css('display', 'none');
                        $('#no-data-found').css('display', 'block');
                        console.log('no hay usuarios');
                    }
                    });

                

                
            }
            
            
        },
        error: function(error) {
            console.log("ERROR", error);
            $('#error-message').css('display', 'block');
        }
    });
}
$('#users-listing-search-form').on('submit', function(event) {
    event.preventDefault();
    search();
});

$('#reset-list').on('submit', function(event) {
    event.preventDefault();
    getUsers(1);
})

});

  /*   function getUsers(){
        $.ajax({
            url: get_users_ajax.ajaxurl,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'get_users_ajax',
            },
            success: function(response){
                $('users-listing-table tbody').empty();
                
                $.each(response, function(index, user) {
                    var userRow = '<tr>' +
                        '<td>' + user.username + '</td>' +
                        '<td>' + (user.name || 'No especificado') + '</td>' +
                        '<td>' + (user.surname1 || 'No especificado') + '</td>' +
                        '<td>' + (user.surname2 || 'No especificado') + '</td>' +
                        '<td>' + (user.email || 'No especificado') + '</td>' +
                        '</tr>';
                    $('#users-listing-table tbody').append(userRow);
                });
            },
            error: function(error){
                console.log("ERROR",error);
            }
        });
    }

    getUsers(); */


