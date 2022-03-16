<template>
  <li :class="styles.content_flex">
    <img src="/avatar/avatar-male-2.jpg" alt="avatar" :class="styles.img" />
    <div :class="styles.content">
      <div class="message">
        <div :class="styles.bubble">
          <p :class="styles.p"><slot></slot></p>
        </div>
      </div>
      <span>{{ time }}</span>
    </div>
  </li>
</template>

<script>
export default {
  props: ["time", "styles"],
  props: {
    time: String,
    styles: Object,
  },
  computed: {
    className() {
      return "list-group-item-" + this.color;
    },
    badgeClass() {
      return "badge-" + this.color;
    },
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
<style>
#time {
  font-size: 9px;
  margin-top: 10px;
  color: black;
}
</style>
