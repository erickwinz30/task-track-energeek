import { defineStore } from "pinia";
import { ref, computed } from "vue";
import { authService } from "@/services/authService";
import type { User, LoginCredentials, ValidationError } from "@/types/auth";
import { useRouter } from "vue-router";

export const useAuthStore = defineStore("auth", () => {
  const router = useRouter();

  // State
  const user = ref<User | null>(null);
  const token = ref<string | null>(localStorage.getItem("auth_token"));
  const isLoading = ref(false);
  const errors = ref<ValidationError>({});

  // Getters
  const isAuthenticated = computed(() => !!token.value);
  const isAdmin = computed(() => user.value?.is_admin ?? false);

  // Actions
  const clearErrors = () => {
    errors.value = {};
  };

  const login = async (credentials: LoginCredentials): Promise<boolean> => {
    isLoading.value = true;
    clearErrors();

    try {
      const response = await authService.login(credentials);

      if (response.success) {
        // Simpan token dan user
        token.value = response.data.token;
        user.value = response.data.user;

        // Simpan ke localStorage
        localStorage.setItem("auth_token", response.data.token);
        localStorage.setItem("user", JSON.stringify(response.data.user));

        console.log("Login successful:", response.data.user);

        // Redirect ke dashboard
        await router.push("/dashboard");
        return true;
      }

      return false;
    } catch (error: any) {
      if (error.response?.status === 422) {
        // Validation errors
        errors.value = error.response.data.errors || {};
      } else if (error.response?.status === 401) {
        // Invalid credentials
        errors.value = {
          email: [error.response.data.message || "Email atau password salah"],
        };
      } else {
        errors.value = {
          general: ["Terjadi kesalahan. Silakan coba lagi."],
        };
      }
      return false;
    } finally {
      isLoading.value = false;
    }
  };

  const logout = async (): Promise<void> => {
    try {
      await authService.logout();
    } catch (error) {
      console.error("Logout error:", error);
    } finally {
      // Clear local storage
      localStorage.removeItem("auth_token");
      localStorage.removeItem("user");

      // Clear state
      token.value = null;
      user.value = null;

      // Redirect ke login
      await router.push("/login");
    }
  };

  const fetchUser = async (): Promise<void> => {
    if (!token.value) return;

    try {
      const userData = await authService.getCurrentUser();
      user.value = userData;
      localStorage.setItem("user", JSON.stringify(userData));
    } catch (error) {
      console.error("Failed to fetch user:", error);
      await logout();
    }
  };

  const initializeAuth = (): void => {
    const storedToken = localStorage.getItem("auth_token");
    const storedUser = localStorage.getItem("user");

    if (storedToken) {
      token.value = storedToken;
      if (storedUser) {
        try {
          user.value = JSON.parse(storedUser);
        } catch (e) {
          console.error("Failed to parse stored user:", e);
        }
      }
    }
  };

  return {
    // State
    user,
    token,
    isLoading,
    errors,
    // Getters
    isAuthenticated,
    isAdmin,
    // Actions
    login,
    logout,
    fetchUser,
    initializeAuth,
    clearErrors,
  };
});
