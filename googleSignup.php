<html>
<head>
<meta charset="utf-8" />
<title>google login test</title>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<meta name="google-signin-client_id" content="290195616061-o388q70kko75rap924seng1345hjo3cu.apps.googleusercontent.com">
</head>
<body>

<H1>Sign up for EasyIOT</h1>
<p id="instructions">
First sign in to your google account using the button below:

</p>

  <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>

<div id="signupform">
<p>Then click sign up below</p>
<form action="https://foc-electronics.com/iotv2/googleSignupBackend1.php" method="post">
<input type="hidden" name="idtoken" id="idtoken" value="">
<button type="submit">Sign Up</button>
</form>
</div>


    <script>
      function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());

        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);
	$(document).ready(function(){
	$("#idtoken").val(id_token);
	$("#instructions").text("You are already logged in with google!");		
	});    
}
</script>

</body>
</html>
