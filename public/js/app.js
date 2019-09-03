let app={
    

    init : function(){

        

        $('#like').click(app.addLike) ;
    },

    addLike : function(e){

        $.ajax(
        {
            url: document.location.href + '/like',
            method:'GET',
            dataType:'json'
        }
        ).done(function(response){


console.log(response.dislike)


             if( response.statut == 'like' ){

                $('#nbLike').text(response.nbLike) ;
                $('.like img').attr('src' , '/symfo/challenge-doctrine/public/images/liked.svg') ;
            }else{

                $('#nbLike').text(response.nbLike) ;
                $('.like img').attr('src' , '/symfo/challenge-doctrine/public/images/noliked.svg') ;
            }

            
        }
        ) ;
       

    }
}
$(app.init) ;


        