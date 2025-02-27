<?php

namespace Database\Seeders;

use App\Models\VendorType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorTypes = [
            ['en' => 'Hospital', 'ar' => 'مستشفى'],
            ['en' => 'Clinic', 'ar' => 'عيادة'],
            ['en' => 'Pharmacy', 'ar' => 'صيدلية'],
            ['en' => 'Lab', 'ar' => 'معمل'],
            ['en' => 'Home Care', 'ar' => 'رعاية منزلية']
        ];
        foreach ($vendorTypes as $vendorType) {
            VendorType::updateOrCreate([
                'name' => $vendorType,
            ]);
        }
    }
}
