
<!DOCTYPE html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <script
             src="https://code.jquery.com/jquery-3.7.0.min.js"
              integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
                 crossorigin="anonymous"></script>
    <script type="text/javascript"  src="assets/js/script.js"></script>


    <title>forum</title>
  </head>
  <body  onload="getPaginCat();getCategList()">


        <div  class="container">

         <h1>Simple Forum</h1>
         <h3>Список категорий : </h3>
          <div class="datas"></div>

          <div class="pagin"></div>



          <h3>Добавить категорию</h3> 

              <form  class="create_form"   id="CreateCat">
                  <div class="form-group">
                    <label for="exampleInput">Ваше имя</label>
                    <input type="text" class="form-control"  name="name" required="">
                   
                  </div>
                  <div class="form-group">
                    <label for="exampleInput">Название категории</label>
                    <input type="text" class="form-control" name="cat_name" required="">
                  </div>
                          
                  <button type="submit" class="btn btn-primary" name="save">Submit</button>
              </form> 
             
        </div>        
    
  </body>
  <script type="text/javascript">
  	

  	  function getPaginCat(){
        $.ajax({
          url: 'action.php',
          type: 'post',
          data: {
            'page':'category','limit':post_on_page
          },
          success: function(data){

            var obj = JSON.parse(data);

             if( obj.count > 0 ){
            var pages = "<ul class='pagination'>";


            for (var i = 0; i < obj.totalPage; i++) {

                  let n = i+1;
                  if(n == currentPage){
                    pages += "<li><a  class='item  current' href='?page="+n+" '>"+n+"</a></li>";
                  }else{
                    pages += "<li><a  class='item' href='?page="+n+" '>"+n+"</a></li>";
                  }
                  
            }
            pages+="</ul>";

            $(".pagin").append(pages);
              }


          }
        })
      }  

      function getCategList(){

               $.ajax({
                        url: 'action.php',
                        type: 'post',
                     
                        data: {'categories':'all','offset': offset },
                      
                        success: function(data) {

                           var obj = JSON.parse(data);
                          

                           if(obj.avaible == true){

                             console.log(obj);

                                 delete obj['avaible'];

                               var block = "<ul class='list-group list-group-flush '>";

                                for(let i in obj ){
                                  var n = parseInt(i)+1;
                                   let date_last_post, author_last_post_id, author_last_post; 
                                   if(obj[i].date_last_post) {
                                   	 		date_last_post = obj[i].date_last_post;
                                   }else{
                                   			date_last_post = "_";
                                   }
                                    ////////
                                   if(obj[i].author_last_post){
                                   		author_last_post = obj[i].author_last_post
                                   }else{
                                   	    author_last_post = "_";
                                   }
                                     ///////////
                                    if(obj[i].author_last_post_id){
                                   		author_last_post_id = obj[i].author_last_post_id
                                   }else{
                                   	    author_last_post_id = "_";
                                   }
                                   

                                   block+="<li class='list-group-item   d-flex justify-content-between'><a href='category.php?categ_id="+obj[i].cat_id+" '>"+obj[i].cat_name+"</a><p>автор категории -"+obj[i].author_name+"</p>  <p>всего постов-"+obj[i].post_count+"</p>  <p>последний пост был :"+date_last_post+"</p><p>автор последнего поста - "+author_last_post+"(id - "+author_last_post_id+")</p></li>";
                                    console.log(obj[i]);
                                }
                                block+="</ul>";  

                              
                                $(".datas").append(block);
                         
                            }else{
                              console.log(obj);

                            }

                     
                        }
                    });
                 
      }

      $("#CreateCat").on("submit", function(e){

      $(".datas").empty();


           e.preventDefault(); 
                    // prevent from default action

                    var formData = new FormData(this);

                    $.ajax({
                        url: 'action.php',
                        type: 'post',
                        cache: false,
                        data: formData,
                        processData: false,
                         contentType: false,
                        success: function(data) {
                              console.log(data);
                           if(data){

                           $("#CreateCat").trigger("reset");
                                getCategList();
                           }
                        }
                    });
                 
      }); 
  </script>

</html>