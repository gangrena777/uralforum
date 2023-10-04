 <?php
	
include('db.php');

 ////cat pagin
if(!empty($_POST['page'])  && $_POST['page'] == 'category'){



  $limit = $_POST['limit'];

     $q = "SELECT id FROM post_category";
     if ($result = mysqli_query($link, $q)) {



        $data['count'] = mysqli_num_rows( $result );

        $data['totalPage'] = ceil($data['count']/ $limit);

        echo json_encode($data);
     
     }

}
///post pagin
if(!empty($_POST['page'])  && $_POST['page'] == 'posts'){



  $limit = $_POST['limit'];
  $categ_id = $_POST['categ_id'];

     $q = "SELECT id FROM posts WHERE category_id = '$categ_id'";
     if ($result = mysqli_query($link, $q)) {



        $res['count'] = mysqli_num_rows( $result );

        $res['totalPage'] = ceil($res['count']/ $limit);

        echo json_encode($res);
     
     }

}
/// get all categories
if(!empty($_POST['categories'])  && $_POST['categories'] == 'all'){

  $offset = $_POST['offset'];


  $page_limit = 10;


                          $q = "SELECT * FROM post_category  ORDER BY id DESC LIMIT ".$offset." , ".$page_limit;

                          $result = array();
                         //$authors = array();
                         // $categ_ids = array();
                          $res = mysqli_query($link, $q);


                          if(mysqli_num_rows($res) > 0) 
                          {

                              $row = mysqli_fetch_array($res);
                              

                             do{
                                    $row['author'] = array();
                                    $row['post_count'] = 0;
                                    $result[] = $row;

                                    $authors[] = $row['author_cat_id'];
                                    $categ_ids[] = $row['id'];


                                } 
                                while($row = mysqli_fetch_array($res));

                              

                                if (count($authors) > 0 ) {

                                  $sql = "SELECT * FROM authors WHERE id IN (" . implode("," , $authors ). ")";
                                  $authors_result  = mysqli_query($link , $sql);
                                  while ($author = mysqli_fetch_assoc($authors_result)) {
                                      foreach ($result as $key => $value) {
                                          if($value['author_cat_id'] == $author['id']){
                                              $result[$key]['author'] = $author;
                                          }
                                      }
                                  }
                                }


                                $sqll = "SELECT * FROM posts ORDER BY date_create_post ASC";

                                $authorIds = array();
                                $all_posts = mysqli_query($link, $sqll);
                                  while ($post = mysqli_fetch_assoc($all_posts)) {
                                      foreach ($result as $key => $value) {
                                          
                                          if($value['id'] == $post['category_id']){
                                            $result[$key]['date_last_post'] = $post['date_create_post'];
                                            $result[$key]['author_last_post_id'] = $post['author_id'];
                                            $authorIds[] = $post['author_id'];

                                              
                                          }
                                          if($value['id'] == $post['category_id']){
                                            $result[$key]['post_count'] = $result[$key]['post_count'] + 1;

                                              
                                          }
                                      }
                                  }

                                if (count($authorIds) > 0 ) {

                                $sql = "SELECT id,author_name FROM authors WHERE id IN (" . implode("," , $authorIds ). ")";
                                  $authors_result  = mysqli_query($link , $sql);
                                  while ($author = mysqli_fetch_assoc($authors_result)) {
                                      foreach ($result as $key => $value) {
                                          if($value['author_last_post_id'] == $author['id']){
                                              $result[$key]['author_last_post'] = $author['author_name'];
                                          }
                                      }
                                  }
                                }

                                

                                  $result['avaible'] = true;

                                  echo  json_encode($result);

                          }

}
////insert category
if(!empty($_REQUEST['name'])  &&  !empty($_REQUEST['cat_name']) ){



    $name = htmlspecialchars(trim($_REQUEST['name']));
    $cat_name  = htmlspecialchars(trim($_REQUEST['cat_name']));
    $date_create = date("Y-m-d");

    $name = mysqli_real_escape_string($link, $name);

    $cat_name = mysqli_real_escape_string($link, $cat_name);
             
    $sql = "SELECT * FROM authors  WHERE author_name = '$name'";
      
    $res = mysqli_query($link, $sql);

    if(mysqli_num_rows($res)>0){
     
       $author = mysqli_fetch_array($res);

        $author_id  = $author['id'];

  

    }else{

         $sqll = "INSERT INTO authors (`author_name`,`date_register`) VALUES ('".$name."','".$date_create."')";
          
                   $ress = mysqli_query($link, $sqll);

                    if($ress){

                       $author_id = mysqli_insert_id($link);
                      
                    }
    }

        // $sqlll = "INSERT INTO post_category (`cat_name`, `author_cat_id`) VALUES('".$cat_name."', '".$author_id."')";

        // $resss = mysqli_query($link, $sqlll);
        // if($resss){
        //    return  true;
        // }


      $sqlll = "INSERT INTO post_category (`cat_name`, `author_cat_id`) VALUES(?, ?)";
      $stmt = mysqli_prepare($link, $sqlll);
      mysqli_stmt_bind_param($stmt, 'ss', $cat_name, $author_id);

      $resss = mysqli_stmt_execute($stmt);

        //Closing the statement
       mysqli_stmt_close($stmt);
       //Closing the connection
       mysqli_close($link);
     
     

      if($resss){
           return  true;
        }

}//if(!empty($_REQUEST['name'])  &&  isset($_FILES['file']))



if(!empty($_REQUEST['categ_id'])){

  $id = htmlspecialchars(trim($_REQUEST['categ_id']));

  $id = mysqli_real_escape_string($link, $id);
  $offset = htmlspecialchars(trim( $_REQUEST['offset']));

  $offset = mysqli_real_escape_string($link, $offset);

  $page_limit = 10;

    $q = "SELECT * FROM posts WHERE category_id = '$id' ORDER BY date_create_post  LIMIT ".$offset." , ".$page_limit;

          $result = array();

          $authorIds = array();

          $res = mysqli_query($link, $q);


          if(mysqli_num_rows($res)>0) 
          {
              $row = mysqli_fetch_array($res);

              do{
              
                    $authorIds[] = $row['author_id'];
                    $row['author_count_post'] = 0;
                    $row['author'] = array();

                    $result[] = $row;
              }
              while ($row = mysqli_fetch_array($res));
              
               if (count($authorIds) > 0 ) {

                  $sql = "SELECT * FROM authors WHERE id IN (" . implode("," , $authorIds ). ")";
                  $authors_result  = mysqli_query($link , $sql);
                  while ($author = mysqli_fetch_assoc($authors_result)) {
                      foreach ($result as $key => $value) {
                          if($value['author_id'] == $author['id']){
                              $result[$key]['author'] = $author;
                          }
                      }
                  }
                }


                $sqll = "SELECT id, author_id FROM posts";

                $authorIds = array();
                $all_posts = mysqli_query($link, $sqll);
                while ($post = mysqli_fetch_assoc($all_posts)) {
                  foreach ($result as $key => $value) {


                    if($value['id'] == $post['author_id']){
                       $result[$key]['author_count_post'] = $result[$key]['author_count_post'] + 1;
                    }
                  }
                }

              $result['avaible'] = true;

               echo  json_encode($result);
              
          }
        
         
}
////insert post
if(!empty($_REQUEST['name'])  &&  !empty($_REQUEST['text'])  &&  !empty($_REQUEST['categId'])){



    $name = htmlspecialchars(trim($_REQUEST['name']));
    $text  = htmlspecialchars(trim($_REQUEST['text']));
    $categId = htmlspecialchars(trim($_REQUEST['categId']));

    $name = mysqli_real_escape_string($link, $name);
    $text = mysqli_real_escape_string($link, $text);
    $categId = mysqli_real_escape_string($link, $categId);

    $date_create = date("Y-m-d H:i:s");
             
    $sql = "SELECT * FROM authors  WHERE author_name = '$name'";
      
    $res = mysqli_query($link, $sql);
    if(mysqli_num_rows($res)>0) 
    {
      $author = mysqli_fetch_array($res);

        $author_id  = $author['id'];
    }else{

         $sqll = "INSERT INTO authors (`author_name`,`date_register`) VALUES ('".$name."','".$date_create."')";
          
                   $ress = mysqli_query($link, $sqll);

                    if($ress){

                       $author_id = mysqli_insert_id($link);
                      
                    }
    }
     echo json_encode($author_id);
    $sqlll = "INSERT INTO posts (`text`, `author_id`,`date_create_post`, `category_id`) VALUES('".$text."', '".$author_id."', '".$date_create."' , '".$categId."')";

    $resss = mysqli_query($link, $sqlll);
    if($resss){
       return  true;
    }
}


?>