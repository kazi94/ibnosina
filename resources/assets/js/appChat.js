import Echo from 'laravel-echo'
import axios from 'axios'
import Vue from 'vue'
import VueChatScroll from 'vue-chat-scroll'
import Toaster from 'v-toaster'
import 'v-toaster/dist/v-toaster.css'

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
Vue.component('message', require('./components/message.vue').default);
Vue.component('last-message', require('./components/last-message.vue').default);
Vue.component('contact', require('./components/contact.vue').default);
Vue.component('right-contact', require('./components/right-contact.vue').default);



/*Start Chat Room*/
let to_user = $('#to_user').val();
const app1 = new Vue({
	el: '#app1',
	data: {
		message: '',
		chat: [ // store messages by contact
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
			}
		],
		contact: [{
			id: '',
			nom: '',
			prenom: '',
			last_message: '',
			date_message: '',
			status: '',
			url: '',
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
		getStyle(to_user_id, auth_id) {
			// créer un style pour l'utilisateur authentifié et externe
			let style = "";
			if (to_user_id != auth_id)
				return style = {
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
		showConversation(to_user_id, to_user_name, to_user_prenom, auth_id, state = null) {
			this.to_user_name = to_user_name; // add Name and NickName to the header of conversation
			this.to_user_prenom = to_user_prenom;
			this.to_user = to_user_id;
			this.auth_id = auth_id;
			this.chat.length = 0; // empty chat array
			axios.get('/chat/' + to_user_id)
				.then(
					response => {
						if (state != null && state == 'status online')
							this.status = 'En ligne';
						else this.status = 'Hors ligne';
						response.data.forEach((val, index) => {
							this.chat.push({
								message: val.message,
								time: val.time,
								style: this.getStyle(val.to_user_id, auth_id)
							});
						});
					});
		},
		send() {
			if (this.message.length != 0) {
				axios.post('/send', {
						message: this.message,
						time: new Date(),
						user: this.to_user,
					}, {
						headers: {
							"X-Socket-Id": window.Echo.socketId(),
						}
					})
					.then(response => {
						this.chat.push({
							message: this.message,
							user: this.to_user,
							time: this.getTime(),
							style: {
								content_flex: 'content_flex1',
								img: 'img1',
								content: 'content1',
								bubble: 'bubble1',
								p: 'p1'
							}
						});
						this.message = ''

					})
					.catch(error => {});
			}
		},
		getTime() {
			let time = new Date();
			return time.getHours() + ":" + time.getMinutes();
			// return time.getHours()+':'+time.getMinutes();
		},
		getUsers() { // récupérer les utilisateurs envoyé par le serveur
			axios.post('/getOldMessage')
				.then((response) => {
					if (response.data != '')
						response.data.forEach((val, index) => {
							this.contact.push({
								id: val.user_id,
								nom: val.name,
								prenom: val.prenom,
								last_message: val.message,
								date_message: val.time,
								status: 'status offline',
								url: "https://ui-avatars.com/api/?name=" + val.name + "+" + val.prenom
							});
						});
				})
				.catch(error => {
					console.log(error);
					this.$toaster.warning(error);
				});
		},
		deleteSession() {
			axios.post('/deleteSession')
				.then(response => this.$toaster.success('Chat history is deleted'));
		}
	},
	mounted() {
		this.getUsers(); // return the users with the last discussion in the left sidebar

		window.Echo.private('chat')
			.listen('ChatEvent', (e) => {
				this.chat.push({
					message: e.message,
					user: e.to_user_id,
					nom: e.user,
					prenom: e.userPrenom,
					time: this.getTime(),
					url: "https://ui-avatars.com/api/?name=" + e.user + "+" + e.user,
					style: {
						content_flex: 'middle2',
						img: 'img2',
						content: 'content2',
						bubble: 'bubble2',
						p: 'p2'
					}
				});
				this.info = 'Vous avez ' + (++this.count) + " nouveau message(s)"
				this.$toaster.success("Vous avez un nouveau message");
			})
		// .listenForWhisper('typing', (e) => {
		//   if (e.name != '') {
		//       this.typing = 'typing...'
		//   }else{
		//     this.typing = ''
		//   }
		// });

		window.Echo.join(`chat`)
			.here((users) => {
				this.contact.forEach((val, index) => {
					users.forEach((value, index) => {
						if (value.name == val.nom)
							val.status = 'status online';
					})
				});
				this.numberOfUsers = users.length;
			})
			.joining((user) => {
				this.numberOfUsers += 1;
				this.contact.forEach((val, index) => {
					if (val.nom == user.name) {
						val.status = 'status online';
					}
				});
				this.$toaster.success(user.name + ' est en ligne');
			})
			.leaving((user) => {
				this.contact.forEach((val, index) => {
					if (val.nom == user.name) {
						val.status = 'status offline';
					}
				});
				this.numberOfUsers -= 1;
				this.$toaster.warning(user.name + ' s\'est déconnecté');
			});
	}
});
/*End Chat Room*/