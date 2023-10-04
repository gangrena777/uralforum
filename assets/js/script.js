

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



////////////////


  

      
