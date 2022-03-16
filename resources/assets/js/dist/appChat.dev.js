"use strict";

var _laravelEcho = _interopRequireDefault(require("laravel-echo"));

var _axios = _interopRequireDefault(require("axios"));

var _vue = _interopRequireDefault(require("vue"));

var _vueChatScroll = _interopRequireDefault(require("vue-chat-scroll"));

var _vToaster = _interopRequireDefault(require("v-toaster"));

require("v-toaster/dist/v-toaster.css");

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

window.Pusher = require('pusher-js');
window.Vue = require('vue'); // for auto scroll

_vue["default"].use(_vueChatScroll["default"]); /// for notifications


_vue["default"].use(_vToaster["default"], {
  timeout: 5000
});

window.Echo = new _laravelEcho["default"]({
  broadcaster: 'pusher',
  key: '940e41e60e0379fc7e5d',
  cluster: 'eu',
  encrypted: true
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

_vue["default"].component('message', require('./components/message.vue')["default"]);

_vue["default"].component('last-message', require('./components/last-message.vue')["default"]);

_vue["default"].component('contact', require('./components/contact.vue')["default"]);

_vue["default"].component('right-contact', require('./components/right-contact.vue')["default"]);
/*Start Chat Room*/


var to_user = $('#to_user').val();
var app1 = new _vue["default"]({
  el: '#app1',
  data: {
    message: '',
    chat: [// store messages by contact
    {
      message: '',
      user: '',
      nom: '',
      prenom: '',
      time: '',
      to_user: '',
      url: '',
      style: {
        content_flex: '',
        img: '',
        content: '',
        bubble: '',
        p: ''
      }
    }],
    contact: [{
      id: '',
      nom: '',
      prenom: '',
      last_message: '',
      date_message: '',
      status: '',
      url: ''
    }],
    to_user_name: '',
    to_user_prenom: '',
    typing: '',
    to_user: '',
    auth_id: '',
    status: 'Hors ligne',
    numberOfUsers: 0,
    isExtUser: false,
    isHidden: false,
    info: 'Vous n\'avez aucun message',
    count: 0
  },
  methods: {
    getStyle: function getStyle(to_user_id, auth_id) {
      // créer un style pour l'utilisateur authentifié et externe
      var style = "";
      if (to_user_id != auth_id) return style = {
        content_flex: 'content_flex1',
        img: 'img1',
        content: 'content1',
        bubble: 'bubble1',
        p: 'p1'
      };
      return style = {
        content_flex: 'middle2',
        img: 'img2',
        content: 'content2',
        bubble: 'bubble2',
        p: 'p2'
      };
    },
    showConversation: function showConversation(to_user_id, to_user_name, to_user_prenom, auth_id) {
      var _this = this;

      var state = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : null;
      this.to_user_name = to_user_name; // add Name and NickName to the header of conversation

      this.to_user_prenom = to_user_prenom;
      this.to_user = to_user_id;
      this.auth_id = auth_id;
      this.chat.length = 0; // empty chat array

      _axios["default"].get('/chat/' + to_user_id).then(function (response) {
        if (state != null && state == 'status online') _this.status = 'En ligne';else _this.status = 'Hors ligne';
        response.data.forEach(function (val, index) {
          _this.chat.push({
            message: val.message,
            time: val.time,
            style: _this.getStyle(val.to_user_id, auth_id)
          });
        });
      });
    },
    send: function send() {
      var _this2 = this;

      if (this.message.length != 0) {
        _axios["default"].post('/send', {
          message: this.message,
          time: new Date(),
          user: this.to_user
        }, {
          headers: {
            "X-Socket-Id": window.Echo.socketId()
          }
        }).then(function (response) {
          _this2.chat.push({
            message: _this2.message,
            user: _this2.to_user,
            time: _this2.getTime(),
            style: {
              content_flex: 'content_flex1',
              img: 'img1',
              content: 'content1',
              bubble: 'bubble1',
              p: 'p1'
            }
          });

          _this2.message = '';
        })["catch"](function (error) {});
      }
    },
    getTime: function getTime() {
      var time = new Date();
      return time.getHours() + ":" + time.getMinutes(); // return time.getHours()+':'+time.getMinutes();
    },
    getUsers: function getUsers() {
      var _this3 = this;

      // récupérer les utilisateurs envoyé par le serveur
      _axios["default"].post('/getOldMessage').then(function (response) {
        if (response.data != '') response.data.forEach(function (val, index) {
          _this3.contact.push({
            id: val.user_id,
            nom: val.name,
            prenom: val.prenom,
            last_message: val.message,
            date_message: val.time,
            status: 'status offline',
            url: "https://ui-avatars.com/api/?name=" + val.name + "+" + val.prenom
          });
        });
      })["catch"](function (error) {
        console.log(error);

        _this3.$toaster.warning(error);
      });
    },
    deleteSession: function deleteSession() {
      var _this4 = this;

      _axios["default"].post('/deleteSession').then(function (response) {
        return _this4.$toaster.success('Chat history is deleted');
      });
    }
  },
  mounted: function mounted() {
    var _this5 = this;

    this.getUsers(); // return the users with the last discussion in the left sidebar

    window.Echo["private"]('chat').listen('ChatEvent', function (e) {
      _this5.chat.push({
        message: e.message,
        user: e.to_user_id,
        nom: e.user,
        prenom: e.userPrenom,
        time: _this5.getTime(),
        url: "https://ui-avatars.com/api/?name=" + e.user + "+" + e.user,
        style: {
          content_flex: 'middle2',
          img: 'img2',
          content: 'content2',
          bubble: 'bubble2',
          p: 'p2'
        }
      });

      _this5.info = 'Vous avez ' + ++_this5.count + " nouveau message(s)";

      _this5.$toaster.success("Vous avez un nouveau message");
    }); // .listenForWhisper('typing', (e) => {
    //   if (e.name != '') {
    //       this.typing = 'typing...'
    //   }else{
    //     this.typing = ''
    //   }
    // });

    window.Echo.join("chat").here(function (users) {
      _this5.contact.forEach(function (val, index) {
        users.forEach(function (value, index) {
          if (value.name == val.nom) val.status = 'status online';
        });
      });

      _this5.numberOfUsers = users.length;
    }).joining(function (user) {
      _this5.numberOfUsers += 1;

      _this5.contact.forEach(function (val, index) {
        if (val.nom == user.name) {
          val.status = 'status online';
        }
      });

      _this5.$toaster.success(user.name + ' est en ligne');
    }).leaving(function (user) {
      _this5.contact.forEach(function (val, index) {
        if (val.nom == user.name) {
          val.status = 'status offline';
        }
      });

      _this5.numberOfUsers -= 1;

      _this5.$toaster.warning(user.name + ' s\'est déconnecté');
    });
  }
});
/*End Chat Room*/