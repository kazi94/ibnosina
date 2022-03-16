<template>
<!-- Message. Default to the left -->
<div class="direct-chat-msg" :class="position">
  <div class="direct-chat-info clearfix">
    <span class="direct-chat-name " :class="positionContact">Alexander Pierce</span>
    <span class="direct-chat-timestamp " :class="positionTime">23 Jan 2:00 pm</span>
  </div>
  <!-- /.direct-chat-info -->
  <img class="direct-chat-img" :src="url" alt="Message User Image"><!-- /.direct-chat-img -->
  <div class="direct-chat-text">
    {{ message }}
  </div>
  <!-- /.direct-chat-text -->
</div>
<!-- /.direct-chat-msg -->
</template>

<script>
    export default {
        props:[
        'message', 
        'time',
        'nom',
        'prenom',
        'position',
        'positionContact',
        'positionTime',
        'url',
        ],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

