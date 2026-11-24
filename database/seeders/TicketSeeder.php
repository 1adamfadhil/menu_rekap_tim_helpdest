<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::Create([
            'ticket_number' => 'TKT-20260917-001',
            'user_id' => 3,
            'agent_id' => 2,
            'category_id' => 1,
            'title' => 'Internet kantor mati',
            'description' => 'Koneksi internet di lantai 3, sedang tidak dapat digunakan',
            'priority' => 'high',
            'status' => 'open',
            'attachment' => 'null',
        ]);

        Ticket::Create([
            'ticket_number' => 'TKT-20260917-002',
            'user_id' => 3,
            'agent_id' => null,
            'category_id' => 2,
            'title' => 'Laptop tidak menyala',
            'description' => 'Laptop tidak dapat menyala ketika power tidak di pencet',
            'priority' => 'medium',
            'status' => 'in_progress',
            'attachment' => 'null',
        ]);
        Ticket::Create([
            'ticket_number' => 'TKT-20260917-003',
            'user_id' => 3,
            'agent_id' => 2,
            'category_id' => 4,
            'title' => 'Reset password akun',
            'description' => 'User meminta bantuan untuk melakukan reset password akun',
            'priority' => 'low',
            'status' => 'closed',
            'attachment' => 'null',
        ]);
    }
}
