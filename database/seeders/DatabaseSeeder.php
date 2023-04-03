<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Line;
use App\Models\Order;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // Lines Dummy
        for ($i = 0;$i < 10;$i++) {
            Line::create([
                'name' => 'line '.sprintf("%02d", $i),
                'username' => 'line_'.sprintf("%02d", $i),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10)
            ]);
        }

        // Orders Dummy
        $colours = [
            "red",
            "green",
            "blue"
        ];

        $sizes = [
            "s",
            "m",
            "l",
            "xl",
            "xxl",
        ];

        for ($i = 0;$i < 10;$i++) {
            Order::create([
                'ws_number' => Str::random(10),
                'buyer_name' => 'buyer '.sprintf("%02d", random_int(1,5)),
                'style_name' => 'style '.sprintf("%02d", random_int(1,5)),
                'product_type' => 'product type '.sprintf("%02d", random_int(1,5)),
                'product_color' => $colours[(random_int(1,3)-1)],
                'product_size' => $sizes[(random_int(1,5)-1)],
                'qty' => random_int(100,1000),
                'qty_output' => 0
            ]);
        }
    }
}
