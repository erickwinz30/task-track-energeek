# Checklist & Panduan Pengerjaan Tes Junior Fullstack 2026

## 🛠 Tech Stack (Wajib Sesuai)

- [ ] **Backend:** Laravel **minimal versi 12**, PHP **minimal 8.2**.
- [ ] **Database:** **PostgreSQL** (Wajib pakai Migration & Seeder).
- [ ] **Frontend:** Vue.js 3+ **TypeScript** (Wajib **Composition API**).
- [ ] **HTTP Client:** Wajib menggunakan **Axios** (bukan fetch biasa).
- [ ] **Auth:** Laravel Sanctum (**Personal Access Token** / PAT).
- [ ] **Arsitektur:** **Monorepo** (API dan Frontend dalam 1 repository).
- [ ] **Inertia:** **TIDAK DIPAKAI** (Gunakan REST API + SPA terpisah).

## 📂 Struktur Folder Frontend (Wajib)

Pastikan struktur `frontend/src/` sesuai panduan:

- [ ] `public/` (Static assets)
- [ ] `components/` (UI Reusable: Form, Modal, Button, dll)
- [ ] `views/` (Halaman utama)
- [ ] `routes/` (Konfigurasi Vue Router)
- [ ] `stores/` (Pinia/Vuex untuk state management & session login)
- [ ] `services/` (Axios instance, API functions, Interceptors)
- [ ] `types/` (TypeScript interfaces)
- [ ] `plugins/` (Helper functions)
- [ ] `main.ts` (Entry point)

## 🔐 Authentication

- [ ] Login menggunakan Email & Password.
- [ ] **Tidak ada fitur Register** (User admin dibuat via Seeder).
- [ ] Logout harus **revoke token** aktif di backend.
- [ ] Token disimpan di frontend (localStorage/Pinia) dan dikirim via Header `Authorization: Bearer <token>`.

## 📦 Fitur & Logika Bisnis

### Project Management

- [ ] **CRU Project** (Create, Read, Update).
- [ ] **TIDAK ADA DELETE** project (Hanya update status `active` ↔ `archived`).
- [ ] Search project by judul.
- [ ] Detail project menampilkan list task (bisa berbentuk card).
- [ ] Tambah task bisa dilakukan dari halaman detail project.

### Task Management

- [ ] **CRUD Task** (Create, Read, Update, Delete).
- [ ] **Soft Delete:** Saat hapus, field `deleted_at` dan `deleted_by` **WAJIB terisi**.
- [ ] Kategori task diambil dari **Seeder** (Dropdown: Todo, In Progress, Testing, Done, Pending).
- [ ] Search task by judul.
- [ ] Due date wajib ada.

### Dashboard

- [ ] Menampilkan Total Project Aktif.
- [ ] Menampilkan Total Task Belum Selesai.
- [ ] Menampilkan List Task yang mendekati Due Date.

## ⚠️ Validasi & Error Handling

- [ ] **Pesan Error Deskriptif:** Tampilkan pesan error **per-field** jika validasi gagal.
- [ ] **DILARANG** menampilkan pesan generic seperti "Error 500" atau "Terjadi kesalahan".
- [ ] Email harus **unique** & valid formatnya.
- [ ] Nama user boleh duplikat.
- [ ] Semua field bersifat **required** kecuali disebutkan opsional.

## 📄 Dokumentasi (Wajib Ada di Root)

- [ ] **README.md:**
  - [ ] Cara instalasi (Backend & Frontend).
  - [ ] Cara menjalankan aplikasi.
  - [ ] Cara menjalankan testing.
  - [ ] Link API Documentation (Swagger/Postman).
- [ ] **AI_USAGE.md:**
  - [ ] Daftar prompt yang digunakan.
  - [ ] Nama model (MCP) & Tool AI (ChatGPT, Claude, dll).
  - [ ] Transparansi penggunaan AI.
- [ ] **API Documentation:**
  - [ ] Swagger UI atau format yang bisa di-export ke Bruno/Insomnia/Postman.

## 🧪 Testing

- [ ] **Backend:** Minimal 1 test menggunakan **PHPUnit**.
- [ ] **Frontend:** Minimal 1 test menggunakan **Vitest** atau **Vue Test Utils**.

## 🚀 Fitur Bonus (Nilai Tambah)

- [ ] **NPM Audit:** Bersih (no critical issues).
- [ ] **Docker Compose:** Bisa jalan dengan `docker-compose up`.
- [ ] **Deploy Online:** Ada URL live yang bisa diakses (sertakan di README).

## 🚫 Common Pitfalls (JANGAN LAKUKAN)

- [ ] ❌ Salah Stack (MySQL instead of PostgreSQL, Laravel 11 instead of 12).
- [ ] ❌ Hard Delete Project (Harusnya archive).
- [ ] ❌ Lupa field `deleted_by` saat soft delete task.
- [ ] ❌ Error message generic tanpa detail field.
- [ ] ❌ Lupa file `AI_USAGE.md`.
- [ ] ❌ Struktur frontend sembarangan (tidak ada folder `services`, `stores`, dll).
- [ ] ❌ Commit history kosong (hanya upload file final).
- [ ] ❌ Menggunakan Inertia.js (Harus REST API + Axios).

## ✅ Langkah Pengerjaan Disarankan

1.  Setup Repository & Struktur Folder.
2.  Setup Database (Migration & Seeder).
3.  Setup Backend API (Auth, Project, Task Controllers).
4.  Setup Frontend (Axios, Stores, Views).
5.  Integrasi Frontend & Backend.
6.  Validasi & Error Handling.
7.  Testing (PHPUnit & Vitest).
8.  Dokumentasi (README & AI_USAGE).
9.  Final Check & Push ke GitHub.
