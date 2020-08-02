function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    var element = document.getElementById("gmail");
    element.value = profile.getEmail();
    console.log("Test email:", element.value);
    // console.log('ID: ' + profile.getId());
    // console.log('Name: ' + profile.getName());
    // console.log('Image URL: ' + profile.getImageUrl());
}

// function verify(email) {
//     var handle = email.substring(s.indexOf('@'));
//     if (handle === "@students.sboe.org") {
//         location.href = 'myrelativepage.php';
//     }
// }