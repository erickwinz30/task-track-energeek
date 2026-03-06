export type DashboardTaskUrgency = "danger" | "warning" | "normal";

export interface DashboardTask {
  id: number;
  title: string;
  subtitle: string;
  due_date: string;
  due_text: string;
  urgency: DashboardTaskUrgency;
}

export interface DashboardData {
  active_projects_count: number;
  pending_tasks_count: number;
  upcoming_tasks: DashboardTask[];
}

export interface DashboardResponse {
  success: boolean;
  message: string;
  data: DashboardData;
}
