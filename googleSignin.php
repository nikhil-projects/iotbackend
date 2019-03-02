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
	
	window.location = "https://foc-electronics.com/iotv2/createCookie.php?token=" + id_token+"&dest=https://foc-electronics.com/home";
	    
}
</script>

</body>
</html>
