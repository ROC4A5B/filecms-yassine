<?php include 'filehandler.class.php';?>
<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    </head>
    <body>
        <form action='filehandler.class.php' method='post' class='select' >
        <?=filehandler::listfile(); ?>
         </form>
        <div class='kiezen'></div>
        <div class='hans'>
        </div>
             <script>
                 var inputform = "";
                 $('form').on('submit', function() {
                   var that = $(this),
                       url = that.attr('action'),
                       method = that.attr('method'),
                       data = {};
                       that.find('[name]').each(function(index, value) {
                          var that = $(this),
                          name = that.attr('name'),
                          value = that.val();
                          
                          data[name] = value;
                       });
                       
                       $.ajax({
                           url: url,
                           type: method,
                           data: data,
                           success: function(response){
                               $('div.kiezen').html(response);
                               inputform = response;
                               console.log(inputform);
                           }
                       });
                    return false;
                 });
                 
            </script>
    </body>
</html>

