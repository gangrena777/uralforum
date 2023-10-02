
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

</html>