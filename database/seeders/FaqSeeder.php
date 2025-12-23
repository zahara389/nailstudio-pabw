<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq; 

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faqs = [
            [
                'question' => 'Berapa lama proses pengerjaan Nail Art?',
                'answer' => 'Proses pengerjaan biasanya memakan waktu 60-90 menit tergantung pada tingkat kerumitan desain yang Anda pilih dan kondisi kuku saat ini.'
            ],
            [
                'question' => 'Apakah saya perlu melakukan booking terlebih dahulu?',
                'answer' => 'Sangat disarankan untuk melakukan booking minimal 1-2 hari sebelumnya melalui WhatsApp agar Anda mendapatkan slot waktu yang diinginkan dan tidak perlu mengantre.'
            ],
            [
                'question' => 'Berapa lama ketahanan Gel Polish yang digunakan?',
                'answer' => 'Gel polish kami menggunakan bahan premium berkualitas tinggi yang dapat bertahan hingga 3-4 minggu tanpa mengelupas jika dirawat dengan benar.'
            ],
            [
                'question' => 'Apakah produk yang digunakan aman untuk kuku sensitif atau ibu hamil?',
                'answer' => 'Tentu saja! Kami hanya menggunakan produk yang sudah teruji, non-toxic, dan berkualitas premium yang aman untuk kuku sensitif maupun ibu hamil.'
            ],
            [
                'question' => 'Apakah saya bisa membawa referensi desain sendiri (Custom Design)?',
                'answer' => 'Bisa banget! Anda bebas membawa referensi foto desain dari internet atau sosial media, dan teknisi kami akan berusaha mewujudkannya semirip mungkin.'
            ],
            [
                'question' => 'Di mana lokasi tepatnya Nails Studio Bandung?',
                'answer' => 'Kami berlokasi sangat strategis di Jl. Telekomunikasi No. 1, Terusan Buah Batu, Bandung. Lokasi kami tepat berada di dekat Gerbang Utama Telkom University.'
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}