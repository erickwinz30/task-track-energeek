<script setup lang="ts">
import AppShell from "@/components/AppShell.vue";
</script>

<template>
  <AppShell>
    <section class="page-block">
      <h2>Task</h2>
      <p>Halaman task siap diisi daftar task dan status progres.</p>
    </section>
  </AppShell>
</template>

<style scoped>
.page-block {
  background: #f7f8f9;
  border: 1px solid #d4dde2;
  border-radius: 10px;
  padding: 18px;
}

h2 {
  margin: 0;
  color: #233043;
}

p {
  margin: 8px 0 0;
  color: #647289;
}
</style>
