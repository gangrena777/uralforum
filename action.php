 <?php
	
include('db.php');

 
if(!empty($_POST['page'])  && $_POST['page'] == 'category'){

  $limit = $_POST['limit'];

     $q = "SELECT * FROM post_category";
     if ($result = mysqli_query($link, $q)) {



        $data['count'] = mysqli_num_rows( $result );

        $data['totalPage'] = ceil($data['count']/ $limit);

        echo json_encode($data);
     
     }

}

if(!empty($_POST['page'])  && $_POST['page'] == 'posts'){

  $limit = $_POST['limit'];
  $categ_id = $_POST['categ_id'];

     $q = "SELECT * FROM posts WHERE category_id = '$categ_id'";
     if ($result = mysqli_query($link, $q)) {



        $res['count'] = mysqli_num_rows( $result );

        $res['totalPage'] = ceil($res['count']/ $limit);

        echo json_encode($res);
     
     }

}

if(!empty($_POST['categories'])  && $_POST['categories'] == 'all'){

  $offset = $_POST['offset'];

  $page_limit = 10;


                          $q = "SELECT * FROM post_category  ORDER BY id DESC LIMIT ".$offset." , ".$page_limit;

                          $result = array();
                          $res = mysqli_query($link, $q);


                          if(mysqli_num_rows($res) > 0) 
                          {

                              $row = mysqli_fetch_array($res);
                              

                             do{

                                  
                                  // получаем id автора категории
                                  $author_id = $row['author_cat_id'];

                                  $qq = "SELECT * FROM authors WHERE id = '$author_id'";

                                  $ress = mysqli_query($link, $qq);
                                    if(mysqli_num_rows($ress)>0) 
                                    {
                                        $roww = mysqli_fetch_array($ress);
                                    
                                        $row['author'] = $roww;

                                    }


                                    // получаем кол -во сообщений в данной категории
                                    $categ_id = $row['id'];
                                    $qqq = "SELECT * FROM posts WHERE category_id ='$categ_id' ORDER BY date_create_post DESC";

                                    $resss = mysqli_query($link, $qqq);
                                       if(mysqli_num_rows($resss) >0){
                                              
                                              $rowww = mysqli_fetch_array($resss);
                                              $row['post_count'] = mysqli_num_rows($resss);
                                              $row['date_last_post'] = $rowww['date_create_post'];
                                              $row['author_last_post_id'] = $rowww['author_id'];
                                              $post_author_id = $rowww['author_id'];


                                                  $qql = "SELECT * FROM authors WHERE id = '$post_author_id'";

                                                      $ressl = mysqli_query($link, $qql);
                                                        if(mysqli_num_rows($ressl)>0) 
                                                        {
                                                            $rowwl = mysqli_fetch_array($ressl);
                                                           // $row['author_name'] = $roww['author_name'];
                                                            $row['author_last_post'] = $rowwl['author_name'];

                                                        }


                                              
                                       }else{
                                           $row['post_count'] = "_";
                                           $row['date_last_post'] = "_";
                                           $row['author_last_post'] = "_";
                                           $row['author_last_post_id'] = "_";
                                       }





                                    $result[] = $row;


                                } 
                                while($row = mysqli_fetch_array($res));
                                  $result['avaible'] = true;

                                  echo  json_encode($result);

                          }

}

if(!empty($_REQUEST['name'])  &&  !empty($_REQUEST['cat_name']) ){



    $name = htmlspecialchars(trim($_REQUEST['name']));
    $cat_name  = htmlspecialchars(trim($_REQUEST['cat_name']));
    $date_create = date("Y-m-d");
             
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

    $sqlll = "INSERT INTO post_category (`cat_name`, `author_cat_id`) VALUES('".$cat_name."', '".$author_id."')";

    $resss = mysqli_query($link, $sqlll);
    if($resss){
       return  true;
    }
}//if(!empty($_REQUEST['name'])  &&  isset($_FILES['file']))



if(!empty($_REQUEST['categ_id'])){

  $id = htmlspecialchars(trim($_REQUEST['categ_id']));

  $offset = htmlspecialchars(trim( $_REQUEST['offset']));

  $page_limit = 10;

    $q = "SELECT * FROM posts WHERE category_id = '$id' ORDER BY date_create_post  LIMIT ".$offset." , ".$page_limit;

          $result = array();
          $res = mysqli_query($link, $q);


          if(mysqli_num_rows($res)>0) 
          {
              $row = mysqli_fetch_array($res);

              do{
                   $author_id = $row['author_id'];

                      $qq = "SELECT * FROM authors WHERE id = '$author_id'";

                      $ress = mysqli_query($link, $qq);
                        if(mysqli_num_rows($ress)>0) 
                        {
                            $roww = mysqli_fetch_array($ress);
                           // $row['author_name'] = $roww['author_name'];
                            $row['author'] = $roww;



                        }
                        $qqq = "SELECT * FROM posts WHERE author_id = '$author_id'";

                        $resss = mysqli_query($link, $qqq);
                        if(mysqli_num_rows($resss)>0){
                          $row['author_count_post'] = mysqli_num_rows($resss);
                        }
                        

                    $result[] = $row;
              }
              while ($row = mysqli_fetch_array($res));
              $result['avaible'] = true;

               echo  json_encode($result);
              
          }
        
         
}

if(!empty($_REQUEST['name'])  &&  !empty($_REQUEST['text'])  &&  !empty($_REQUEST['categId'])){



    $name = htmlspecialchars(trim($_REQUEST['name']));
    $text  = htmlspecialchars(trim($_REQUEST['text']));
    $categId = htmlspecialchars(trim($_REQUEST['categId']));
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