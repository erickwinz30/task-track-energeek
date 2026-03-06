<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@energeek.id')->first();
        $john = User::where('email', 'john.doe@energeek.id')->first();
        $jane = User::where('email', 'jane.smith@energeek.id')->first();

        $projects = [
            [
                'created_by' => $admin->id,
                'name' => 'Website E-Commerce',
                'description' => 'Redesign dan development ulang platform belanja online perusahaan.',
                'status' => 'active',
                'created_at' => \Carbon\Carbon::parse('2025-01-12'),
            ],
            [
                'created_by' => $admin->id,
                'name' => 'Aplikasi Mobile',
                'description' => 'App cross-platform pelanggan untuk iOS dan Android.',
                'status' => 'active',
                'created_at' => \Carbon\Carbon::parse('2025-02-03'),
            ],
            [
                'created_by' => $john->id,
                'name' => 'Backend Services v2',
                'description' => 'Migrasi ke microservices architecture untuk scalability yang lebih baik.',
                'status' => 'archived',
                'created_at' => \Carbon\Carbon::parse('2024-11-01'),
            ],
            [
                'created_by' => $jane->id,
                'name' => 'Dashboard Analytics',
                'description' => 'Dashboard untuk monitoring dan analytics bisnis real-time.',
                'status' => 'active',
                'created_at' => \Carbon\Carbon::parse('2025-02-15'),
            ],
            [
                'created_by' => $admin->id,
                'name' => 'Integrasi Payment Gateway',
                'description' => 'Integrasi multiple payment gateway (Midtrans, Xendit, Doku).',
                'status' => 'active',
                'created_at' => \Carbon\Carbon::parse('2025-01-20'),
            ],
        ];

        foreach ($projects as $projectData) {
            $created_at = $projectData['created_at'];
            unset($projectData['created_at']);

            Project::firstOrCreate(
                ['name' => $projectData['name']],
                array_merge($projectData, ['created_at' => $created_at])
            );
        }
    }
}
