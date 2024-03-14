
     <div class="col-12 p-5">
        <h2 class="text-center">log in</h2>
        <form action="<?php echo LOGIN_URL?>" method="POST" >
  
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input type="username" class="form-control" name="username" aria-describedby="username">
                <div id="username" class="form-text"></div>
              </div>

            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" class="form-control" name="password">
            </div>
            <button type="submit"class="btn btn-primary">Log in</button>
          </form>

     </div>
