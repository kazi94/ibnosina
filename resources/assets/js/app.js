/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Echo from 'laravel-echo'

import axios from 'axios'
import Vue from 'vue'
import VueChatScroll from 'vue-chat-scroll'
import Toaster from 'v-toaster'
import 'v-toaster/dist/v-toaster.css'
import ChatComponent from './components/message-box.vue';
window.Pusher = require('pusher-js');
window.Vue = require('vue');

// for auto scroll
Vue.use(VueChatScroll)
/// for notifications
Vue.use(Toaster, {
	timeout: 5000
})
window.Echo = new Echo({
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
Vue.component('chat-box', ChatComponent);


const app = new Vue({
	el: '#app',
	data: {
		chat: [ // store messages by contact
			{
				message: '',
				user: '',
				nom: '',
				prenom: '',
				time: '',
				url: ''
			}
		],
		info: 'Vous n\'avez aucun message',
		count: 0,
		roleMedecin: '',
		rolePharmacien: '',

	},
	methods: {
		getTime() {
			let time = new Date();
			return time.getHours() + ":" + time.getMinutes();
			// return time.getHours()+':'+time.getMinutes();
		},

	},
	mounted() {
		this.roleMedecin = $('.roleMedecin').text();
		this.rolePharmacien = $('.rolePharmacien').text();
		//Listen to Message Event
		window.Echo.private('chat')
			.listen('ChatEvent', (e) => {
				this.chat.push({
					message: e.message,
					user: e.to_user_id,
					nom: e.user,
					prenom: e.userPrenom,
					time: this.getTime(),
					url: "https://ui-avatars.com/api/?name=" + e.user + "+" + e.user
				});
				this.info = 'Vous avez ' + (++this.count) + " nouveau message(s)"
				this.$toaster.success("Vous avez un nouveau message");
			})

		window.Echo.join(`chat`)
			.joining((user) => {
				this.$toaster.success(user.name + ' est en ligne');
			})
			.leaving((user) => {
				this.$toaster.warning(user.name + ' s\'est déconnecté');
			});

		//Listen to PreAnalyse And Pharmaceutic analyse Event	
		window.Echo.private('channel')
			.listen('PrescriptionAnalyse', (e) => {
				if (this.rolePharmacien == "on" && e.role == "analyse_ph") // notification to Pharmacists
				{
					this.info = "La prescription num°" + e.prescription_id + " Prescrit par Dr." + e.prescripteur.prenom + " " + e.prescripteur.name + " représente un  risque";
					this.$toaster.warning(this.info);
				} else if (e.role == "medecin_presc" && this.roleMedecin == "on") // si l'utilisateur en ligne  à le role : medecin prescripteur
				{
					this.info = "La prescription num°" + e.prescription_id + ",à était analysé par Dr." + e.prescripteur.prenom + " " + e.prescripteur.name;
					this.$toaster.warning(this.info);
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