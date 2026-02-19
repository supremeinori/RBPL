<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MR BONGKENG MANAGE SYSTEM</title>
</head>
<body>
    <form action="{{ route('login') }}" method="POST">
        @csrf
  <div class="imgcontainer">
    <img src="img_avatar2.png" alt="Avatar" class="avatar">
  </div>

  <div class="container" style="width:300px">
    <label for="uname"><b>Email</b></label>
    <input type="email" placeholder="Enter email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <button type="submit">Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
  </div>
  <ul>
  <li>admin = admin@mail.com (123456)</li>
  <li>desainer = desainer@email.com (255061)</li>
  <li>akuntan = akuntan@email.com (112262)</li>
</ul>

</form>
</body>
</html>