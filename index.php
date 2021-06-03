<!DOCTYPE html>
<html>
<head>
    <title>Web Push Notification in PHP/MySQL using FCM</title>
    <script src="https://www.gstatic.com/firebasejs/8.6.2/firebase.js"></script>

    <!--    <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-app.js"></script>-->


    <!-- TODO: Add SDKs for Firebase products that you want to use
         https://firebase.google.com/docs/web/setup#available-libraries -->

    <script src="jQuery.js"></script>
    <!--    <script src="firebase-messaging-sw.js"></script>-->
    <!--    <link rel="manifest" href="manifest.json">-->
    <script>
        // Initialize Firebase

        var firebaseConfig = {
            apiKey: "AIzaSyAZsD2YKh5uTm9fr6LQxyUYrCqnUpz2wyg",
            authDomain: "test-fcm-beabb.firebaseapp.com",
            projectId: "test-fcm-beabb",
            storageBucket: "test-fcm-beabb.appspot.com",
            messagingSenderId: "425481361035",
            appId: "1:425481361035:web:03d3ced15d2c4ceb83268e",
            measurementId: "G-3GKZH99EK0"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();
        messaging.requestPermission()
            .then(function () {
                console.log('Notification permission granted.');
                // TODO(developer): Retrieve an Instance ID token for use with FCM.
                if (isTokenSentToServer()) {
                    console.log('Token already saved.');
                } else {
                    getRegToken();
                }

            })
            .catch(function (err) {
                console.log('Unable to get permission to notify.', err);
            });

        function getRegToken(argument) {
            if ("serviceWorker" in navigator) {
                navigator.serviceWorker
                    .register("./firebase-messaging-sw.js")
                    .then(function (registration) {
                        console.log("Registration successful, scope is:", registration.scope);
                        messaging.getToken()
                            .then(function (currentToken) {
                                if (currentToken) {
                                    saveToken(currentToken);
                                    console.log(currentToken);
                                    setTokenSentToServer(true);
                                } else {
                                    console.log('No Instance ID token available. Request permission to generate one.');
                                    setTokenSentToServer(false);
                                }
                            })
                            .catch(function (err) {
                                console.log(currentToken)
                                console.log('An error occurred while retrieving token. ', err);
                                setTokenSentToServer(false);
                            });
                    })
                    .catch(function (err) {
                        console.log("Service worker registration failed, error:", err);
                    });
            }
        }

        function setTokenSentToServer(sent) {
            window.localStorage.setItem('sentToServer', sent ? 1 : 0);
        }

        function isTokenSentToServer() {
            return window.localStorage.getItem('sentToServer') === "1";
        }

        function saveToken(currentToken) {
            $.ajax({
                url: 'action.php',
                method: 'post',
                data: 'token=' + currentToken
            }).done(function (result) {
                console.log(result);
            })
        }

        messaging.onMessage(function (payload) {
            console.log("Message received. ", payload);
            notificationTitle = payload.data.title;
            notificationOptions = {
                body: payload.data.body,
                icon: payload.data.icon,
                image: payload.data.image
            };
            var notification = new Notification(notificationTitle, notificationOptions);
        });
    </script>
</head>
<body>
<center>
    <h1>FCM Web Push Notification in PHP/MySQL from localhost</h1>
</center>
</body>
