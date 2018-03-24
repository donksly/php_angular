/**EXPLAIN THE CODE BY COMMENTS**/

$(document).ready(function(){
    /**move to top on click of edit button in list of apartments**/
    $('body').on('click', '#edit_list', function(){
        $('html, body').animate({scrollTop:0}, 'slow');
    });

    /**get header parameter(token)**/
    var url = window.location.search.split('token='[-1]);
    $('#tokeninput').val(url);

});