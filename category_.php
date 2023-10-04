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
<!--     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> -->
  <!--   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->


    <title>forum</title>
  </head>
  <body  onload="getPaginPost();getPosts()">


<div  class="container">
  
   <h1>Simple Forum</h1>

   <div><a href="/">На главную....</a></div>
   <h3>Список Постов</h3>
    <div class="datas"></div>
    <div class="pagin"></div>



    <h3>Добавить сообщение</h3> 

        <form  class="create_form"   id="CreatePost">
            <div class="form-group">
              <label for="exampleInput">Ваше имя</label>
              <input type="text" class="form-control"  name="name" required="">
             
            </div>
            <div class="form-group">
              <label for="exampleInput">Сообщение</label>
              <input type="textarea" class="form-control" name="text" required="">
            </div>

            <input type="hidden"  name="categId" value="<?php echo $_REQUEST['categ_id'];?>" />
                    
            <button type="submit" class="btn btn-primary" name="saveP">Submit</button>
        </form> 
       
</div>        
    
  </body>

<script>


function getPosts(){

           $.ajax({
                    url: 'action.php',
                    type: 'post',
                 
                    data: {'categ_id': <?php echo $_REQUEST['categ_id'];?>,'offset': offset },
                  
                    success: function(data) {

                        
                      if(data.trim()){
                             
                            var obj = JSON.parse(data);
      
                             if(obj.avaible == true ){

                                 console.log(obj);

                                 delete obj['avaible'];

                                  var block = "<ul class='list-group-posts list-group-flush '>";

                                   for(let i in obj ){
                                       var n = parseInt(i)+1;
                                         block+="<li class='list-group-item post  d-flex justify-content-between'><p>#"+n+"  создан : "+obj[i].date_create_post+"</p><p class='post_text'>\""+obj[i].text+"\"</p><p>автор сообщения  -"+obj[i].author['author_name']+"  зарегистрирован : "+obj[i].author['date_register']+"  оставил -"+obj[i].author_count_post+" сообщения</p></li>";

                                     }
                                   block+="</ul>";  

                          
                                 $(".datas").append(block);
                     
                              } 
                      }else{
                               $(".datas").append("<p class='alert alert-secondary'>Каких либо сообщений у данной темы нет!!!</p>");
                      }

                 
                    }
                });
            
}

function getPaginPost(){
  var x =  $.ajax({
      url: 'action.php',
      type: 'post',
      data: {
        'page':'posts', 'limit':post_on_page,'categ_id':<?php echo $_REQUEST['categ_id'];?>
      },
      success: function(dataz){

      //console.log(dataz);
        var obj = JSON.parse(dataz);

           //console.log(obj.count);
        
          if( obj.count > 10 ){
              var pages = "<ul class='pagination'>";


              for (var i = 0; i < obj.totalPage; i++) {

                    let n = i+1;
                    if(n == currentPage){
                      pages += "<li><a  class='item  current' href='category.php?categ_id=<?php echo $_REQUEST['categ_id'];?>&page="+n+" '>"+n+"</a></li>";
                    }else{
                      pages += "<li><a  class='item' href='category.php?categ_id=<?php echo $_REQUEST['categ_id'];?>&page="+n+" '>"+n+"</a></li>";
                    }
                    
              }
              pages+="</ul>";

              $(".pagin").append(pages);

          }
         

      }
    })
  
}      

$("#CreatePost").on("submit", function(e){

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
                       
                       if(data){

                       $("#CreatePost").trigger("reset");
                            getPosts();
                       }
                    }
                });
             
});

  </script>
</html>