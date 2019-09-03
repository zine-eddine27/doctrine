let app={
    

    init : function(){

        console.log(document.location.href) ;

        $('#like').click(app.addLike) ;
    },

    addLike : function(e){

        

        $id = $(e.currentTarget).attr('data-likeId') ;

        $.ajax(
        {
            url: document.location.href + '/like',
            method:'GET',
            dataType:'json'
        }
        ).done(function(response){

            if(response != false ){
                $('#nbLike').text(response) ;
                $('.like img').attr('src' , '/symfo/challenge-doctrine/public/images/liked.svg') ;
            }

            
        }
        ) ;
       

    }
}
$(app.init) ;


        