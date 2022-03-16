<template>
<li>
    <ul class="menu">
      <li><!-- start task item -->
        <a  style ="cursor : pointer" v-on:click='emit' > 
          <div class="pull-left">
            <img :src="url" class="img-circle" alt="User Image">
          </div>
          <h4>
            <span>{{   nom }}</span>
            <span>{{   prenom }}</span>
            <small><i class="fa fa-clock-o"></i> {{   time }}</small>
          </h4>
          <p>{{ message }}</p>
        </a>
      </li>
          <!-- end task item -->
    </ul>
</li>
</template>

<script>
    export default {
        props:[
            'url',
            'message',
            'time',
            'nom',
            'prenom',
        ],
        methods : {
            emit : function(){
                this.$emit('showChatBox' , this.message);
            }
        },
        computed:{

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

