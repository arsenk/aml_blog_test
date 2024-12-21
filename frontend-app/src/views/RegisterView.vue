<template>
  <div class="register">
    <Register />
  </div>
</template>

<script>
import Register from "@/components/Register.vue";

export default {
  name: "RegisterView",
  components: {
    Register,
  },
};
</script>

<style scoped>
.register {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f4f7fb;
  padding: 20px;
}
</style>
