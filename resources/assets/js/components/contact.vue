<template>
    <li>
    <a href="#chat1" v-on:click="emit" class="filter direct " data-chat="open" data-toggle="tab" role="tab" aria-controls="chat1" aria-selected="false">
      <div :class="status"><img :src="url" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
      <div class="content">
        <div class="headline">
          <h5>{{ nom }} {{ prenom }}</h5>
          <span>{{ time }}</span>
        </div>
        <p>{{ message }}</p>
      </div>
    </a>
    </li>
</template>

<script>
    export default {
        props:[
            'nom',
            'prenom',
            'status',
            'id',
            'auth_id',
            'message',
            'time',
            'url',
        ],
        methods : {
            emit : function(){
            console.log(this.id);
                this.$emit('show_conversation' , this.id , this.nom , this.prenom , this.auth_id , this.status);
            }
        },
        computed:{

        },
        mounted() {
            console.log('Contact Component mounted.');
        }
    }
</script>

