<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobCategory;

class JobCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Nail Artist',
            'Receptionist',
            'Beauty Therapist',
            'Sales',
        ];

        foreach ($categories as $cat) {
            JobCategory::create(['name' => $cat]);
        }
    }
}
