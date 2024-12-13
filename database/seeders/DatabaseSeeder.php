<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Group;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon; // Thêm use cho Carbon

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo người dùng admin
        User::factory()->create([
            'name' => 'ThachDeepTry',
            'email' => 'thach@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Tạo người dùng thường
        User::factory()->create([
            'name' => 'ToanSoPearl',
            'email' => 'toan@example.com',
            'password' => bcrypt('password'),
        ]);

        // Tạo thêm 10 người dùng
        User::factory(10)->create();

        // Tạo nhóm và tin nhắn
        for ($i = 0; $i < 5; $i++) {
            $group = Group::factory()->create([
                'owner_id' => 1,
            ]);

            // Gán người dùng ngẫu nhiên vào nhóm
            $users = User::inRandomOrder()->limit(rand(2, 5))->pluck('id');

            $group->users()->attach(array_unique([1, ...$users]));
        }
        // Tạo tin nhắn
        Message::factory(100)->create();

        // Lấy danh sách tin nhắn trong nhóm
        $messages = Message::whereNull('group_id')
            ->orderBy('created_at')
            ->get();

        // Xử lý hội thoại
        $conversations = $messages->groupBy(function ($message) {
            return collect([$message->sender_id, $message->receiver_id])->sort()->implode('_');
        })->map(function ($groupedMessages) {
            return [
                'user_id1' => $groupedMessages->first()->sender_id,
                'user_id2' => $groupedMessages->first()->receiver_id,
                'last_message_id' => $groupedMessages->last()->id,
                'created_at' => new Carbon(),
                'updated_at' => new Carbon(),
            ];
        })->values();
        Conversation::insertOrIgnore($conversations->toArray());
    }
}