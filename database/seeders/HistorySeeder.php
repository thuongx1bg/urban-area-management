<?php

namespace Database\Seeders;

use App\Models\History;
use App\Models\QrCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

//        $qrIds = QrCode::get()->pluck('id');
//        $key = array_rand(array($qrIds)); // Lấy một key ngẫu nhiên
//        $randomNumber = $qrIds[$key]; // Lấy giá trị tại key đó
        for ($i = 0; $i < 2000; $i++) { // Tạo 50 bản ghi, bạn có thể thay đổi số lượng theo ý muốn

            History::create([
                'qr_id' => random_int(1,500), // Thay thế 'other_field' và 'value' với các trường và giá trị thực tế của bạn
                'created_at' => now()->subDays(rand(0, 365))->subMinutes(rand(0, 1440)) // Tạo ngẫu nhiên ngày trong khoảng 1 năm qua
            ]);
        }
    }
}
