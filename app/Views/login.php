<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  </head>
  <body>
      

<div class="w3-panel w3-blue-grey w3-animate-top info-text-conatiner" style="margin:0; display:none;">
  <h3>Information!</h3>
  <p class="info-text"></p>
</div> 
        
<div class="w3-card-4">

<header class="w3-container w3-blue">
  <h1>Login</h1>
</header>

<div class="w3-container">

        <br>
          <form class="w3-container">

        <input class="w3-input email-input" type="text">
        <label>Email</label>

        <input class="w3-input password-input" type="text">
        <label>Password</label>

        </form> 

        <br>
        <button class="w3-button w3-blue" onclick="login()"> Submit </button>
        <br>
        <br>
</div>         
        
</div> 
        
                
    
</body>
</html>


<script>

const login = async () => { 

    const email = document.querySelector(".email-input");
    const password = document.querySelector(".password-input");
    const messageContainer = document.querySelector(".info-text-conatiner");
    const messageContainerText = document.querySelector(".info-text");
        
        
    if (email.value < 4)    
    {
        console.log( "bad email" );
        return null;
    }
        
    if (password.value < 4)    
    {
        console.log( "bad password" );
        return null;
    }
                
    const postData = new FormData();
    postData.append("login-form-email", email.value);
    postData.append("login-form-password", password.value);

    try {
        const response = await fetch('/login-post', {
            method: 'POST', 
            body: postData,
        });

        const jsonUserData = await response.json();
        
        messageContainer.style.display = 'block';
        messageContainerText.innerHTML = jsonUserData.message;
        
        if (!jsonUserData.error)
        {
            window.location = '/dashboard';
        }

        //console.log( jsonUserData.name );
    }
    catch (error) {
        console.error(error);
    }
        
}

        
</script>
