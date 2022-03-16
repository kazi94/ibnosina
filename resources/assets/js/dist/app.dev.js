"use strict";

var _laravelEcho = _interopRequireDefault(require("laravel-echo"));

var _axios = _interopRequireDefault(require("axios"));

var _vue = _interopRequireDefault(require("vue"));

var _vueChatScroll = _interopRequireDefault(require("vue-chat-scroll"));

var _vToaster = _interopRequireDefault(require("v-toaster"));

require("v-toaster/dist/v-toaster.css");

var _messageBox = _interopRequireDefault(require("./components/message-box.vue"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
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

_vue["default"].component('chat-box', _messageBox["default"]);

var app = new _vue["default"]({
  el: '#app',
  data: {
    chat: [// store messages by contact
    {
      message: '',
      user: '',
      nom: '',
      prenom: '',
      time: '',
      url: ''
    }],
    info: 'Vous n\'avez aucun message',
    count: 0,
    roleMedecin: '',
    rolePharmacien: ''
  },
  methods: {
    getTime: function getTime() {
      var time = new Date();
      return time.getHours() + ":" + time.getMinutes(); // return time.getHours()+':'+time.getMinutes();
    }
  },
  mounted: function mounted() {
    var _this = this;

    this.roleMedecin = $('.roleMedecin').text();
    this.rolePharmacien = $('.rolePharmacien').text(); //Listen to Message Event

    window.Echo["private"]('chat').listen('ChatEvent', function (e) {
      _this.chat.push({
        message: e.message,
        user: e.to_user_id,
        nom: e.user,
        prenom: e.userPrenom,
        time: _this.getTime(),
        url: "https://ui-avatars.com/api/?name=" + e.user + "+" + e.user
      });

      _this.info = 'Vous avez ' + ++_this.count + " nouveau message(s)";

      _this.$toaster.success("Vous avez un nouveau message");
    });
    window.Echo.join("chat").joining(function (user) {
      _this.$toaster.success(user.name + ' est en ligne');
    }).leaving(function (user) {
      _this.$toaster.warning(user.name + ' s\'est déconnecté');
    }); //Listen to PreAnalyse And Pharmaceutic analyse Event	

    window.Echo["private"]('channel').listen('PrescriptionAnalyse', function (e) {
      if (_this.rolePharmacien == "on" && e.role == "analyse_ph") // notification to Pharmacists
        {
          _this.info = "La prescription num°" + e.prescription_id + " Prescrit par Dr." + e.prescripteur.prenom + " " + e.prescripteur.name + " représente un  risque";

          _this.$toaster.warning(_this.info);
        } else if (e.role == "medecin_presc" && _this.roleMedecin == "on") // si l'utilisateur en ligne  à le role : medecin prescripteur
        {
          _this.info = "La prescription num°" + e.prescription_id + ",à était analysé par Dr." + e.prescripteur.prenom + " " + e.prescripteur.name;

          _this.$toaster.warning(_this.info);
        }
    });
  }
});
/*Start Chat Box*/
// const app = new Vue({
//     el: '#app',
//     data:{
//       message:'',
//       to_user_id:'',
//       chat : [ // store messages by contact
//       		{
//       			message : '',
//       			nom    : '',
//       			time    : '',
//       			prenom : '',
//       			position :'',
//       			positionContact:'',
//       			positionTime :'',
//       			url:''
//       		}
//       ],
//       isHidden : true
//     },
//     methods:
//     {
//     	pushChat(val){
// 			this.chat.push({
// 				message : val.message,
// 				time    : val.time,
// 				nom : ' Jhon',
// 				prenom : 'Doe',
// 				position : (this.to_user_id == val.to_user_id ? '' : 'right'),
// 				positionContact : (this.to_user_id == val.to_user_id ? 'pull-left' : 'pull-right'),
// 				positionTime : (this.to_user_id == val.to_user_id ? 'pull-right' : 'pull-left'),
// 				url : "https://ui-avatars.com/api/?name=jhon+doe"
// 			}); 
//     	},
// 		showChatBox(event){ // Display COnversation in Chat Box
// 			this.to_user_id = event.target.id; // get to User Id
//     		axios.get('/chat/'+this.to_user_id) // get Conversation between auth_user and to_user
//     			.then(
//     				(response) => {
// 	            	response.data.forEach((val, index) =>{
// 	            		this.pushChat(val);
// 					});
// 					this.isHidden = false //display Chat Box
//     			});	
// 		},    	
// 		send(){ // Send Message to The Server
// 			if (this.message.length != 0) {
// 			  axios.post('/send', 
// 			  	{
// 				    message : this.message,
// 				    time    : new Date(),
// 				    user    :this.to_user_id,
// 				},
// 				{
// 				    headers: 
// 				    {
// 				        "X-Socket-Id": window.Echo.socketId(),
// 					}
// 				})
// 			    .then(response => {
// 					this.chat.push({
// 						message : this.message,
// 						time    : this.getTime(),
// 						nom     : 'Jhon',
// 						prenom  : 'Doe',
// 						position: 'right',
// 						positionContact : 'pull-right',
// 						positionTime    : 'pull-left',
// 						url : "https://ui-avatars.com/api/?name=jhon+doe"
// 					}); 			    	
// 			    	this.message = ''
// 			    })
// 			    .catch(error => {
// 			    });
// 			} 
// 		},
// 		getTime(){
// 			let time = new Date();
// 			return time.getHours()+":"+time.getMinutes();
// 			// return time.getHours()+':'+time.getMinutes();
// 		}
//     },
//     mounted()
//     {		
// 		window.Echo.private('chat')
//           .listen('ChatEvent', (e) => {
// 			this.chat.push({
// 				message : e.message,
// 				time    : this.getTime(),
// 				nom     : 'Jhon',
// 				prenom  : 'Doe',
// 				position: '',
// 				positionContact : 'pull-left',
// 				positionTime    : 'pull-right',
// 				url : "https://ui-avatars.com/api/?name=jhon+doe"
// 			});         	       		
//           })
//     }
// });

/*End Chat Box */