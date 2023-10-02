

      let urlParams = new URLSearchParams(window.location.search);
      var currentPage = urlParams.get('page');
      if(currentPage === null){
      currentPage = 1;
      }
      let post_on_page = 10;

      console.log(currentPage);

      let offset = 0;

      if(currentPage > 1){
       offset = post_on_page * (currentPage - 1);
      }

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
                                   block+="<li class='list-group-item   d-flex justify-content-between'><a href='category.php?categ_id="+obj[i].id+" '>"+obj[i].cat_name+"</a><p>автор категории -"+obj[i]['author'].author_name+"</p>  <p>всего постов-"+obj[i].post_count+"</p>  <p>последний пост был :"+obj[i].date_last_post+"</p><p>автор последнего поста - "+obj[i].author_last_post+"(id - "+obj[i].author_last_post_id+")</p></li>";

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
                            //  console.log(data);
                           if(data){

                           $("#CreateCat").trigger("reset");
                                getCategList();
                           }
                        }
                    });
                 
      }); 

////////////////


  

      
