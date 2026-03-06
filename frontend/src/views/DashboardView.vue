<script setup lang="ts">
import { onMounted, ref } from "vue";
import AppShell from "@/components/AppShell.vue";
import { dashboardService } from "@/services/dashboardService";
import type { DashboardData } from "@/types/dashboard";

const todayLabel = new Date().toLocaleDateString("id-ID", {
  weekday: "long",
  day: "2-digit",
  month: "long",
  year: "numeric",
});

const isLoading = ref(false);
const errorMessage = ref("");
const dashboardData = ref<DashboardData>({
  active_projects_count: 0,
  pending_tasks_count: 0,
  upcoming_tasks: [],
});

const loadDashboardData = async () => {
  isLoading.value = true;
  errorMessage.value = "";

  try {
    const response = await dashboardService.getSummary();
    dashboardData.value = response.data;
  } catch (error: any) {
    errorMessage.value =
      error?.response?.data?.message || "Gagal memuat data dashboard.";
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  loadDashboardData();
});
</script>

<template>
  <AppShell>
    <section class="dashboard">
      <header class="top-header">
        <div>
          <h2>Dashboard</h2>
          <p>Selamat datang di task tracker</p>
        </div>
        <span class="today-chip">{{ todayLabel }}</span>
      </header>

      <div class="stats-grid">
        <article class="stat-card">
          <div class="stat-icon folder"></div>
          <div>
            <small>Project Aktif</small>
            <strong>{{
              isLoading ? "-" : dashboardData.active_projects_count
            }}</strong>
          </div>
        </article>

        <article class="stat-card">
          <div class="stat-icon hourglass"></div>
          <div>
            <small>Task Belum Selesai</small>
            <strong>{{
              isLoading ? "-" : dashboardData.pending_tasks_count
            }}</strong>
          </div>
        </article>
      </div>

      <section class="task-panel">
        <div class="task-panel-header">
          <h3>Task Mendekati Due Date</h3>
          <button type="button" class="refresh-btn" @click="loadDashboardData">
            Refresh
          </button>
        </div>

        <div v-if="errorMessage" class="error-box">
          <p>{{ errorMessage }}</p>
          <button type="button" @click="loadDashboardData">Coba Lagi</button>
        </div>

        <p v-else-if="isLoading" class="panel-state">
          Memuat data dashboard...
        </p>

        <p
          v-else-if="dashboardData.upcoming_tasks.length === 0"
          class="panel-state"
        >
          Belum ada task.
        </p>

        <ul v-else class="task-list">
          <li
            v-for="task in dashboardData.upcoming_tasks"
            :key="task.id"
            class="task-row"
          >
            <div class="task-main">
              <span class="dot" :class="task.urgency"></span>
              <div>
                <strong>{{ task.title }}</strong>
                <small>{{ task.subtitle }}</small>
              </div>
            </div>
            <p class="due" :class="task.urgency">{{ task.due_text }}</p>
          </li>
        </ul>
      </section>
    </section>
  </AppShell>
</template>

<style scoped>
.dashboard {
  width: 100%;
  position: relative;
  animation: fade-up 0.45s ease both;
}

.top-header {
  background: linear-gradient(180deg, #e2e8ec 0%, #dee5e9 100%);
  border: 1px solid #d2dce2;
  border-radius: 12px;
  padding: 16px;
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 12px;
}

.top-header h2 {
  font-size: 31px;
  color: #233043;
  margin: 0;
  line-height: 1.1;
}

.top-header p {
  margin: 6px 0 0;
  color: #536070;
  font-weight: 700;
  letter-spacing: 0.1px;
}

.today-chip {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 999px;
  border: 1px solid #c8d4dd;
  background: #f4f7f9;
  color: #556378;
  font-size: 12px;
  font-weight: 700;
  padding: 8px 12px;
}

.stats-grid {
  margin-top: 12px;
  display: grid;
  grid-template-columns: repeat(2, minmax(200px, 1fr));
  gap: 12px;
}

.stat-card {
  border: 1px solid #d5dee5;
  background: #f8fafb;
  border-radius: 12px;
  padding: 16px;
  display: flex;
  align-items: center;
  gap: 12px;
  box-shadow: 0 2px 8px rgba(31, 42, 61, 0.04);
  transition: transform 0.2s ease;
}

.stat-card:hover {
  transform: translateY(-2px);
}

.stat-card small {
  display: block;
  color: #67758a;
  margin-bottom: 2px;
}

.stat-card strong {
  font-size: 34px;
  color: #212f45;
  line-height: 1;
}

.stat-icon {
  width: 26px;
  height: 26px;
  border-radius: 7px;
}

.stat-icon.folder {
  background: radial-gradient(circle at 30% 30%, #e2ebfb, #c8d8f0);
}

.stat-icon.hourglass {
  background: radial-gradient(circle at 30% 30%, #fff0c8, #f4dd97);
}

.task-panel {
  margin-top: 14px;
  border: 1px solid #d4dde3;
  background: #f8fafb;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(31, 42, 61, 0.04);
}

.task-panel-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  padding: 14px 16px;
  border-bottom: 1px solid #dde4e9;
}

.task-panel h3 {
  margin: 0;
  font-size: 19px;
  color: #243145;
  font-weight: 800;
}

.refresh-btn {
  border: 1px solid #c8d4dd;
  background: #f4f7f9;
  color: #506077;
  padding: 6px 10px;
  border-radius: 8px;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
}

.refresh-btn:hover {
  background: #e8eef2;
}

.panel-state {
  margin: 0;
  padding: 20px 16px;
  color: #6e7d92;
  font-weight: 700;
}

.error-box {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  padding: 16px;
}

.error-box p {
  margin: 0;
  color: #ce5151;
  font-weight: 700;
}

.error-box button {
  border: 1px solid #d4dce2;
  background: #ffffff;
  color: #4d5d73;
  padding: 8px 10px;
  border-radius: 8px;
  font-weight: 700;
  cursor: pointer;
}

.task-list {
  margin: 0;
  padding: 0;
  list-style: none;
}

.task-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  padding: 13px 16px;
  border-bottom: 1px solid #e1e7ec;
}

.task-row:last-child {
  border-bottom: 0;
}

.task-main {
  display: flex;
  align-items: center;
  gap: 10px;
}

.task-main strong {
  display: block;
  color: #253348;
  font-size: 17px;
  font-weight: 700;
}

.task-main small {
  color: #7a8798;
  font-size: 13px;
  font-weight: 700;
}

.dot {
  width: 8px;
  height: 8px;
  border-radius: 999px;
  flex-shrink: 0;
}

.dot.danger {
  background: #ea5353;
}

.dot.warning {
  background: #e2a940;
}

.dot.normal {
  background: #5484ee;
}

.due {
  margin: 0;
  font-size: 13px;
  font-weight: 700;
  white-space: nowrap;
}

.due.danger {
  color: #d45050;
}

.due.warning {
  color: #d9961d;
}

.due.normal {
  color: #64758c;
}

@keyframes fade-up {
  from {
    opacity: 0;
    transform: translateY(8px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@media (max-width: 900px) {
  .top-header {
    flex-direction: column;
  }

  .task-panel-header {
    flex-direction: column;
    align-items: flex-start;
  }

  .top-header h2 {
    font-size: 28px;
  }

  .stats-grid {
    grid-template-columns: 1fr;
  }

  .task-row {
    flex-direction: column;
    align-items: flex-start;
  }
}
</style>
