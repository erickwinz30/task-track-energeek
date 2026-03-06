<script setup lang="ts">
import AppSidebar from "@/components/AppSidebar.vue";
</script>

<template>
  <div class="app-shell">
    <AppSidebar />
    <main class="app-content">
      <slot />
    </main>
  </div>
</template>

<style scoped>
.app-shell {
  display: flex;
  min-height: 100vh;
  background: #e4eaee;
}

.app-content {
  flex: 1;
  padding: 18px 20px;
}

@media (max-width: 900px) {
  .app-shell {
    flex-direction: column;
  }

  .app-content {
    padding: 14px;
  }
}
</style>
