<script setup lang="ts">
import { computed } from "vue";
import { RouterLink, useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";

type NavItem = {
  label: string;
  to: string;
  iconClass: string;
};

const route = useRoute();
const authStore = useAuthStore();

const navItems: NavItem[] = [
  { label: "Dashboard", to: "/dashboard", iconClass: "icon-dashboard" },
  { label: "Project", to: "/projects", iconClass: "icon-project" },
  { label: "Task", to: "/tasks", iconClass: "icon-task" },
];

const currentUser = computed(() => authStore.user);
const avatarInitial = computed(() => {
  const name = currentUser.value?.name?.trim();
  return name ? name.charAt(0).toUpperCase() : "A";
});

const isRouteActive = (to: string): boolean => {
  return route.path === to || route.path.startsWith(`${to}/`);
};

const handleLogout = async () => {
  await authStore.logout();
};
</script>

<template>
  <aside class="sidebar">
    <div class="brand">
      <h1>
        <span class="brand-main">Task</span
        ><span class="brand-accent">Tracker</span>
      </h1>
    </div>

    <nav class="menu">
      <RouterLink
        v-for="item in navItems"
        :key="item.to"
        :to="item.to"
        class="menu-item"
        :class="{ active: isRouteActive(item.to) }"
      >
        <span class="menu-icon" :class="item.iconClass"></span>
        <span>{{ item.label }}</span>
      </RouterLink>
    </nav>

    <div class="sidebar-footer">
      <button class="logout-button" type="button" @click="handleLogout">
        <span class="menu-icon icon-logout"></span>
        Keluar
      </button>

      <div class="profile">
        <div class="avatar">{{ avatarInitial }}</div>
        <div class="profile-text">
          <strong>{{ currentUser?.name || "Admin Energeek" }}</strong>
          <small>{{ currentUser?.is_admin ? "Administrator" : "User" }}</small>
        </div>
      </div>
    </div>
  </aside>
</template>

<style scoped>
.sidebar {
  width: 240px;
  min-width: 240px;
  min-height: 100vh;
  background: #1f2a3d;
  color: #d5deea;
  display: flex;
  flex-direction: column;
  border-right: 1px solid rgba(255, 255, 255, 0.08);
}

.brand {
  padding: 22px 24px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.brand h1 {
  font-size: 22px;
  margin: 0;
  letter-spacing: 0.3px;
}

.brand-main {
  color: #f1f5fc;
}

.brand-accent {
  color: #58a5ff;
}

.menu {
  display: flex;
  flex-direction: column;
  gap: 4px;
  padding: 14px 12px;
}

.menu-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 11px 12px;
  color: #b9c6d8;
  border-radius: 8px;
  font-size: 14px;
  text-decoration: none;
  transition: background-color 0.2s ease;
}

.menu-item:hover {
  background: #25334a;
}

.menu-item.active {
  background: #2b3a54;
  color: #f7fbff;
}

.menu-icon {
  width: 14px;
  height: 14px;
  border-radius: 4px;
  display: inline-block;
}

.icon-dashboard {
  background: #8ea6c6;
}

.icon-project {
  background: #7a8ba5;
}

.icon-task {
  background: #59c973;
}

.icon-logout {
  background: #c8894f;
}

.sidebar-footer {
  margin-top: auto;
  padding: 14px 12px 16px;
  border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.logout-button {
  width: 100%;
  background: transparent;
  border: 0;
  color: #cfd9e7;
  padding: 10px 12px;
  border-radius: 8px;
  text-align: left;
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  font-size: 14px;
}

.logout-button:hover {
  background: #25334a;
}

.profile {
  margin-top: 16px;
  display: flex;
  gap: 10px;
  align-items: center;
}

.avatar {
  width: 28px;
  height: 28px;
  border-radius: 999px;
  background: #3d6de0;
  color: white;
  display: grid;
  place-items: center;
  font-size: 12px;
  font-weight: 700;
}

.profile-text {
  display: flex;
  flex-direction: column;
  min-width: 0;
}

.profile-text strong {
  color: #f2f6fd;
  font-size: 13px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.profile-text small {
  color: #9ba9bd;
  font-size: 12px;
}

@media (max-width: 900px) {
  .sidebar {
    width: 100%;
    min-width: 100%;
    min-height: auto;
  }

  .menu {
    flex-direction: row;
    overflow-x: auto;
    padding-top: 8px;
  }

  .menu-item {
    white-space: nowrap;
  }

  .sidebar-footer {
    display: none;
  }
}
</style>
