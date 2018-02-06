


$(document).ready(function(){

    $('#filterForm').submit();

});


$('#filterForm').submit(function(event){

    var inputs = $(this).serializeArray();

    var data = {};
    $.each( inputs, function( key, val ) {
        data[val.name] = val.value;
    });



    $.post( "/api/filter", data)
        .done(function( data ) {

            var data = JSON.parse(data);

            var html = '';
            $.each( data, function( index, value ){

                html += '<tr>';
                html += '<td>' +value.url_image+ '</td>';
                html += '<td>' +value.post_date+ '</td>';
                html += '<td>' +value.amount_likes+ '</td>';
                html += '<td>' +value.amount_comments+ '</td>';

                var commentList= '<table>';

              $.each( value.comments, function( index, comment ){

                    commentList+= '<tr><td>' +comment.message+ '</tr></td>';

                });
                commentList += '</table>'

                html += '<td>' +commentList+ '</td>';


                var likeList= '<table>';

                $.each( value.userlikes, function( index, userlike ){

                    likeList+= '<tr><td>' +userlike.name+ '</tr></td>';

                });
                likeList += '</table>'

                html += '<td>' +likeList+ '</td>';

                html += '</tr>';

            });



            $('#content tbody').html(html);


        },'json')
        .fail(function() {

            alert( "Api callerror" );
        });


    event.preventDefault();


});