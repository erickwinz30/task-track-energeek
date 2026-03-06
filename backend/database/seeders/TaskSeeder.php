<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@energeek.id')->first();
        $john = User::where('email', 'john.doe@energeek.id')->first();
        $jane = User::where('email', 'jane.smith@energeek.id')->first();
        $ahmad = User::where('email', 'ahmad.rizki@energeek.id')->first();

        $ecommerceProject = Project::where('name', 'Website E-Commerce')->first();
        $mobileProject = Project::where('name', 'Aplikasi Mobile')->first();
        $backendProject = Project::where('name', 'Backend Services v2')->first();
        $dashboardProject = Project::where('name', 'Dashboard Analytics')->first();
        $paymentProject = Project::where('name', 'Integrasi Payment Gateway')->first();

        $todo = Category::where('name', 'Todo')->first();
        $inProgress = Category::where('name', 'In Progress')->first();
        $testing = Category::where('name', 'Testing')->first();
        $done = Category::where('name', 'Done')->first();
        $pending = Category::where('name', 'Pending')->first();

        $tasks = [
            // Website E-Commerce Tasks
            [
                'project_id' => $ecommerceProject->id,
                'category_id' => $inProgress->id,
                'created_by' => $admin->id,
                'title' => 'Integrasi Payment Gateway',
                'description' => 'Integrasi dengan payment gateway Midtrans untuk proses checkout.',
                'due_date' => \Carbon\Carbon::parse('2025-03-02'),
            ],
            [
                'project_id' => $ecommerceProject->id,
                'category_id' => $todo->id,
                'created_by' => $john->id,
                'title' => 'Setup CI/CD',
                'description' => 'Setup pipeline CI/CD menggunakan GitHub Actions.',
                'due_date' => \Carbon\Carbon::parse('2025-03-15'),
            ],
            [
                'project_id' => $ecommerceProject->id,
                'category_id' => $testing->id,
                'created_by' => $jane->id,
                'title' => 'Unit test auth',
                'description' => 'Membuat unit test untuk authentication module.',
                'due_date' => \Carbon\Carbon::parse('2025-03-10'),
            ],
            [
                'project_id' => $ecommerceProject->id,
                'category_id' => $done->id,
                'created_by' => $admin->id,
                'title' => 'Setup Laravel',
                'description' => 'Initial setup Laravel project dengan struktur folder.',
                'due_date' => \Carbon\Carbon::parse('2025-01-15'),
            ],
            [
                'project_id' => $ecommerceProject->id,
                'category_id' => $pending->id,
                'created_by' => $ahmad->id,
                'title' => 'Review klien',
                'description' => 'Review dan feedback dari klien terkait desain UI/UX.',
                'due_date' => \Carbon\Carbon::parse('2025-03-20'),
            ],
            [
                'project_id' => $ecommerceProject->id,
                'category_id' => $todo->id,
                'created_by' => $john->id,
                'title' => 'Desain DB schema',
                'description' => 'Desain database schema untuk produk, kategori, dan order.',
                'due_date' => \Carbon\Carbon::parse('2025-03-20'),
            ],
            [
                'project_id' => $ecommerceProject->id,
                'category_id' => $inProgress->id,
                'created_by' => $jane->id,
                'title' => 'Product listing',
                'description' => 'Implementasi halaman product listing dengan filter dan search.',
                'due_date' => \Carbon\Carbon::parse('2025-03-08'),
            ],
            [
                'project_id' => $ecommerceProject->id,
                'category_id' => $done->id,
                'created_by' => $admin->id,
                'title' => 'Auth API',
                'description' => 'Membuat API endpoint untuk login, register, dan logout.',
                'due_date' => \Carbon\Carbon::parse('2025-01-20'),
            ],

            // Aplikasi Mobile Tasks
            [
                'project_id' => $mobileProject->id,
                'category_id' => $testing->id,
                'created_by' => $admin->id,
                'title' => 'Bug Fix Login Mobile',
                'description' => 'Perbaikan bug pada fitur login di aplikasi mobile Android.',
                'due_date' => \Carbon\Carbon::parse('2025-03-04'),
            ],
            [
                'project_id' => $mobileProject->id,
                'category_id' => $inProgress->id,
                'created_by' => $john->id,
                'title' => 'Push Notification',
                'description' => 'Implementasi Firebase Cloud Messaging untuk push notification.',
                'due_date' => \Carbon\Carbon::parse('2025-03-12'),
            ],
            [
                'project_id' => $mobileProject->id,
                'category_id' => $todo->id,
                'created_by' => $jane->id,
                'title' => 'Offline Mode',
                'description' => 'Fitur offline mode dengan local storage menggunakan SQLite.',
                'due_date' => \Carbon\Carbon::parse('2025-03-25'),
            ],
            [
                'project_id' => $mobileProject->id,
                'category_id' => $done->id,
                'created_by' => $ahmad->id,
                'title' => 'UI/UX Design',
                'description' => 'Desain UI/UX untuk semua halaman utama aplikasi.',
                'due_date' => \Carbon\Carbon::parse('2025-02-10'),
            ],

            // Backend Services v2 Tasks (Archived Project)
            [
                'project_id' => $backendProject->id,
                'category_id' => $done->id,
                'created_by' => $admin->id,
                'title' => 'API Documentation',
                'description' => 'Dokumentasi API menggunakan Swagger/OpenAPI.',
                'due_date' => \Carbon\Carbon::parse('2024-12-01'),
            ],
            [
                'project_id' => $backendProject->id,
                'category_id' => $done->id,
                'created_by' => $john->id,
                'title' => 'Database Migration',
                'description' => 'Migration database dari monolith ke microservices.',
                'due_date' => \Carbon\Carbon::parse('2024-12-15'),
            ],

            // Dashboard Analytics Tasks
            [
                'project_id' => $dashboardProject->id,
                'category_id' => $todo->id,
                'created_by' => $admin->id,
                'title' => 'Grafik Penjualan',
                'description' => 'Implementasi grafik penjualan harian, mingguan, dan bulanan.',
                'due_date' => \Carbon\Carbon::parse('2025-03-18'),
            ],
            [
                'project_id' => $dashboardProject->id,
                'category_id' => $inProgress->id,
                'created_by' => $jane->id,
                'title' => 'Real-time Update',
                'description' => 'Implementasi WebSocket untuk real-time data update.',
                'due_date' => \Carbon\Carbon::parse('2025-03-10'),
            ],
            [
                'project_id' => $dashboardProject->id,
                'category_id' => $pending->id,
                'created_by' => $ahmad->id,
                'title' => 'Export Report',
                'description' => 'Fitur export laporan ke PDF dan Excel.',
                'due_date' => \Carbon\Carbon::parse('2025-03-22'),
            ],

            // Payment Gateway Tasks
            [
                'project_id' => $paymentProject->id,
                'category_id' => $testing->id,
                'created_by' => $admin->id,
                'title' => 'Xendit Integration',
                'description' => 'Integrasi payment gateway Xendit untuk virtual account.',
                'due_date' => \Carbon\Carbon::parse('2025-03-05'),
            ],
            [
                'project_id' => $paymentProject->id,
                'category_id' => $todo->id,
                'created_by' => $john->id,
                'title' => 'Payment Callback',
                'description' => 'Handle callback/notification dari payment gateway.',
                'due_date' => \Carbon\Carbon::parse('2025-03-15'),
            ],
            [
                'project_id' => $paymentProject->id,
                'category_id' => $done->id,
                'created_by' => $jane->id,
                'title' => 'Midtrans Sandbox',
                'description' => 'Setup dan testing Midtrans di sandbox environment.',
                'due_date' => \Carbon\Carbon::parse('2025-02-20'),
            ],
        ];

        foreach ($tasks as $taskData) {
            Task::firstOrCreate(
                [
                    'project_id' => $taskData['project_id'],
                    'title' => $taskData['title'],
                ],
                $taskData
            );
        }
    }
}
