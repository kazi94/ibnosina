<template>
  <li style="cursor: pointer;" v-on:click="emit">
    <div><img :src="url" alt="avatar" /></div>
    <div class="content">
      <h5>{{ prenom }} {{ nom }}</h5>
      <span>{{ service }}, {{ grade }}</span>
    </div>
  </li>
</template>

<script>
export default {
  props: ["nom", "prenom", "id", "auth_id", "service", "grade", "url"],
  methods: {
    emit: function() {
      this.$emit(
        "show_conversation",
        this.id,
        this.nom,
        this.prenom,
        this.auth_id
      );
    },
  },
  computed: {},
  mounted() {
    console.log("Right-contact Component mounted.");
  },
};
</script>
