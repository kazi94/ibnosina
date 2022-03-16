"use strict";

// install event
self.addEventListener('install', function (evt) {
  console.log('service worker installed');
});
self.addEventListener('activate', function (evt) {
  console.log('service worker activated');
});
self.addEventListener('fetch', function (evt) {
  console.log('service worker fetched');
}); // When user  click on close on push (android and desktop) notification (swipe movement in android)

self.addEventListener('notificationclose', function (e) {
  var notification = e.notification;
  var primaryKey = notification.data.primaryKey;
  console.log('Closed notification: ' + primaryKey);
}); // When user click anywhere (not necesseraly on added extra buttons) on push (android and desktop) notification

self.addEventListener('notificationclick', function (e) {
  var notification = e.notification;
  var primaryKey = notification.data.primaryKey;
  var action = e.action;

  if (action === 'close') {
    notification.close();
  } else {
    clients.openWindow('http://www.example.com');
    notification.close();
  }
}); // listen to push messages send by the server to the client via the service worker

self.addEventListener('push', function (e) {
  var body;

  if (e.data) {
    body = e.data.text();
  } else {
    body = 'Push message no payload';
  }

  var options = {
    body: body,
    icon: 'images/example.png',
    vibrate: [100, 50, 100],
    data: {
      dateOfArrival: Date.now(),
      primaryKey: '2'
    },
    actions: [{
      action: 'explore',
      title: 'Explore this new world',
      icon: 'images/checkmark.png'
    }, {
      action: 'close',
      title: 'Close',
      icon: 'images/xmark.png'
    }]
  };
  e.waitUntil(self.registration.showNotification('Hello world!', options));
}); // self.addEventListener('beforeinstallprompt', (event) => {
//     console.log('👍', 'beforeinstallprompt', event);
//     // Stash the event so it can be triggered later.
//     window.deferredPrompt = event;
//     // Remove the 'hidden' class from the install button container
//     divInstall.classList.toggle('hidden', false);
// });
// self.addEventListener('click', () => {
//     console.log('👍', 'butInstall-clicked');
//     const promptEvent = window.deferredPrompt;
//     if (!promptEvent) {
//         // The deferred prompt isn't available.
//         return;
//     }
//     // Show the install prompt.
//     promptEvent.prompt();
//     // Log the result
//     promptEvent.userChoice.then((result) => {
//         console.log('👍', 'userChoice', result);
//         // Reset the deferred prompt variable, since
//         // prompt() can only be called once.
//         window.deferredPrompt = null;
//         // Hide the install button.
//         divInstall.classList.toggle('hidden', true);
//     });
// });