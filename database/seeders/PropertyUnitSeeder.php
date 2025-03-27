<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Units;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
    {
        // Create first property
        $property1 = Property::create([
            'propertyName' => 'Sunrise Apartments',
            'totalUnits' => 15,
            'city' => 'Nairobi',
            'invoicingDay' => '1',
            'smsReminderDay' => '25',
            'waterRate' => 500,
            'electricityRate' => '15.50',
            'penaltyPercentage' => '5',
            'streetName' => 'Moi Avenue',
            'paymentUnstructions' => 'Pay via M-Pesa to Till Number 123456 or Bank Transfer to Account 1234567890',
        ]);

        // Create units for property1 (15 units)
        for ($i = 1; $i <= 15; $i++) {
            Units::create([
                'name' => 'Unit ' . $i,
                'property_id' => $property1->id,
                'rentAmount' => rand(15000, 30000), // Random rent between 15,000 and 30,000
                'accountNumber' => 'SUN-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'notes' => $i % 3 == 0 ? 'Recently renovated' : null,
            ]);
        }

        // Create second property
        $property2 = Property::create([
            'propertyName' => 'Green Valley Homes',
            'totalUnits' => 12,
            'city' => 'Mombasa',
            'invoicingDay' => '5',
            'smsReminderDay' => '28',
            'waterRate' => 450,
            'electricityRate' => '16.75',
            'penaltyPercentage' => '7',
            'streetName' => 'Nyerere Road',
            'paymentUnstructions' => 'Pay via M-Pesa Paybill 123456, Account Number is your unit number',
        ]);

        // Create units for property2 (12 units)
        for ($i = 1; $i <= 12; $i++) {
            Units::create([
                'name' => 'GVH-' . $i,
                'property_id' => $property2->id,
                'rentAmount' => rand(18000, 35000), // Random rent between 18,000 and 35,000
                'accountNumber' => 'GVH-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'notes' => $i % 4 == 0 ? 'Includes parking space' : null,
            ]);
        }
    }
}
