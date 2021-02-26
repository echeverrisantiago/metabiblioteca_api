$(document).ready(function(){

    /* Evento añadir libros */

    $('#addbook').click(function(){
        const bookname = $('#bookname').val();
        const bookurl = $('#bookurl').val();
        const author = $('#author').val();

        const data = {
            title: bookname,
            cover: bookurl,
            author: author
        };
console.log(data);
            fetch(document.location.origin+'/book/', {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {
        'Content-type': 'application/json; charset=UTF-8'
       },
    })
    .then(res => res.json())
    .then( function(data){
        if(data){
            window.location.replace('/');
    }
    });
    });

    /* Evento listar muestras */
    $('#addSamples').click(function(){
        fetch(document.location.origin+'/addSamples')
        .then(res => res.json())
        .then( function(data){
            if(data){
                 console.log(data);
                $('#addSamples').append(data);
            }
        });
    });
    /* Evento eliminar */
    jQuery('.delete-book').click(function(){
        book = $(this).attr('data-id');
        const bookCont = $('#book-'+book);
        fetch(document.location.origin+'/book/' + book, {
  method: 'DELETE',
  headers: {
    'Content-type': 'application/json; charset=UTF-8'
   },
})
.then(res => res.json())
.then( function(data){
    if(data == 1){
    bookCont.remove();
    if($('.book-wrapper').length < 1){
        window.location.replace('/');
    }
}
})
    });
});