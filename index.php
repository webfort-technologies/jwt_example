<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <title>JWT</title>
  </head>
  <body>
    <div class="container p-5">
      <div class="h1 text-center">JWT Made Simple</div>
      <div class="py-5">
        <img src="assets/images/how_jwt_works.png" alt="img-fluid">
        
      </div>

      <div class="h1 text-center my-4">See in action</div>
      <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Step No.</th>
      <th scope="col">Client Side</th>
      <th scope="col">Server Side Response</th> 
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>User Sign-in (using email/password)

        <hr>

        <form class="form-signin" id="frmLogin">

          <label class="mb-2">Email address</label>
          <input type="text" value="shishir.raven@gmail.com" name="email" id="inputEmail" class=" mb-2 form-control" placeholder="Email address" required autofocus>
          <label for="inputPassword" class="mb-2" value="123456">Password</label>
          <input name="password" type="password" id="inputPassword" class="mb-2 form-control" placeholder="Password" required>
          
          <button class="btn  btn-primary " type="submit">Send email/password to server </button>

          <hr>
          <div class="bg-light rounded p-3"> 
          Hint <br>
          Username : shishir.raven@gmail.com <br>
          Password : 123456
          </div>
     
          
        </form>
      </td>
      <td>
          Accept Username / password and check validity, If correct return JWT to the Client. 
          <hr>
          RESULT from <b>token_issuer.php</b>
          <div class="bg-warning rounded p-3" id="loginResult">⚠️ Fill the login form to see results here</div>
          <hr>
          You can verify the token here <a href="https://jwt.io/">jwt.io</a>

      </td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>
         JWT
         <input type="text" class="form-control" id="jwt">
        <div class="btn btn-primary" id="btnGetResource">Send Request</div>
      </td>
      <td>
          Get the data if a valid JWT is sent to the server in authentication header 
          <hr>
          RESULT from <strong>get_request.php</strong>
          <div class="bg-warning rounded p-3" id="requestResult">⚠️ Send Request to see results</div>
          <hr>
          
</td>
     
    </tr>
    
  </tbody>
</table>
      


    </div>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

       <script>
      $(function(){
          var store = store || {};
          /*
           * Sets the jwt to the store object
           */
          store.setJWT = function(data){
              this.JWT = data;
          }

          $("#btnGetResource").click(function(e){

            
              e.preventDefault();
              $.ajax({

                  url: 'get_request.php',

                  beforeSend: function(request){
                      request.setRequestHeader('Authorization', 'Bearer ' + $("#jwt").val());
                  },

                  type: 'GET',
                  success: function(data) {
                      // Decode and show the returned data nicely.
                      $("#requestResult").text(JSON.stringify(data));
                  },

                  error: function() {
                      $("#requestResult").text("❌ Error form Server");
                  }

              });
          });

          /*
           * Submit the login form via ajax
           */
           
        $("#frmLogin").submit(function(e)
        {
                e.preventDefault();
                $.ajax({
                  type: "POST",
                  dataType: "JSON",
                  url: 'token_issuer.php',
                  data: $("#frmLogin").serialize(),
                  success: function(data)
                            {
                                store.setJWT(data.jwt);
                                $("#loginResult").text(store.JWT);
                                $("#jwt").val(store.JWT);

                            },
                  fail: function()
                            {
                              
                                $("#jwt").val("error");
                                $("#loginResult").text("Error");
                            }
                        });
          }); 

      });
      </script>
  </body>
</html>