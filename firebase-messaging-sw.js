importScripts('https://www.gstatic.com/firebasejs/8.6.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.9.1/firebase-messaging.js');
/*Update this config*/
var firebaseConfig = {
    apiKey: "AIzaSyAZsD2YKh5uTm9fr6LQxyUYrCqnUpz2wyg",
    authDomain: "test-fcm-beabb.firebaseapp.com",
    projectId: "test-fcm-beabb",
    storageBucket: "test-fcm-beabb.appspot.com",
    messagingSenderId: "425481361035",//"103953800507",
    appId: "1:425481361035:web:03d3ced15d2c4ceb83268e",
    measurementId: "G-3GKZH99EK0"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = payload.data.title;
    const notificationOptions = {
        body: payload.data.body,
        icon: 'http://localhost/fcm/img/icon.png',
        image: 'http://localhost/fcm/img/d.png'
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});
// [END background_handler]
