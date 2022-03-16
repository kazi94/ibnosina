"use strict";

// if ('serviceWorker' in navigator) {
//     navigator.serviceWorker.register('sw.js').then(function (reg) {
//             console.log('Service Worker Registered!', reg);
//             reg.pushManager.getSubscription().then(function (sub) {
//                 if (sub === null) {
//                     // Update UI to ask user to register for Push
//                     console.log('Not subscribed to push service!');
//                 } else {
//                     // We have a subscription, update the database
//                     console.log('Subscription object: ', sub);
//                 }
//             });
//         })
//         .catch(function (err) {
//             console.log('Service Worker registration failed: ', err);
//         });
// }
function subscribeUser() {
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.ready.then(function (reg) {
      reg.pushManager.subscribe({
        userVisibleOnly: true
      }).then(function (sub) {
        console.log('Endpoint URL: ', sub.endpoint);
      })["catch"](function (e) {
        if (Notification.permission === 'denied') {
          console.warn('Permission for notifications was denied');
        } else {
          console.error('Unable to subscribe to push', e);
        }
      });
    });
  }
}

subscribeUser(); // Request notification permission to garanted

Notification.requestPermission(function (status) {
  console.log('Notification permission status:', status);
});

function displayNotification() {
  if (Notification.permission == 'granted') {
    navigator.serviceWorker.getRegistration().then(function (reg) {
      var options = {
        body: 'Here is a notification body!',
        icon: 'images/example.png',
        vibrate: [100, 50, 100],
        data: {
          dateOfArrival: Date.now(),
          primaryKey: 1
        },
        actions: [{
          action: 'explore',
          title: 'Explore this new world',
          icon: 'images/checkmark.png'
        }, {
          action: 'close',
          title: 'Close notification',
          icon: 'images/xmark.png'
        }]
      };
      reg.showNotification('Hello world!', options);
    });
  }
} //displayNotification();