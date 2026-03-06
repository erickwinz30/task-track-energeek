import api from "./api";
import type { LoginCredentials, LoginResponse, User } from "../types/auth";

export const authService = {
  async login(credentials: LoginCredentials): Promise<LoginResponse> {
    const response = await api.post<LoginResponse>("/login", credentials);
    return response.data;
  },

  async logout(): Promise<void> {
    await api.post("/logout");
  },

  async getCurrentUser(): Promise<User> {
    const response = await api.get<{ data: User }>("/user");
    return response.data.data;
  },
};
