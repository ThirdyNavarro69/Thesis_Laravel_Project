<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StudioPhotographersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, create or get an existing studio and owner
        // You might want to create these first with separate seeders
        
        // Get existing studio (assuming at least one exists)
        $studio = DB::table('tbl_studios')->first();
        
        if (!$studio) {
            // If no studio exists, create one
            $ownerId = DB::table('tbl_users')->insertGetId([
                'uuid' => Str::uuid(),
                'location_id' => null,
                'role' => 'studio-photographer',
                'first_name' => 'Studio',
                'middle_name' => null,
                'last_name' => 'Owner',
                'user_type' => 'photographer',
                'email' => 'studio.owner@example.com',
                'mobile_number' => '09123456789',
                'password' => Hash::make('password123'),
                'profile_photo' => null,
                'status' => 'active',
                'email_verified' => 1,
                'verification_token' => null,
                'token_expiry' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            
            $studioId = DB::table('tbl_studios')->insertGetId([
                'user_id' => $ownerId,
                'studio_name' => 'Sample Studio',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } else {
            $studioId = $studio->id;
            $ownerId = $studio->user_id;
        }
        
        // Get existing service or create one
        $service = DB::table('tbl_services')->first();
        if (!$service) {
            $serviceId = DB::table('tbl_services')->insertGetId([
                'studio_id' => $studioId,
                'category_id' => 1, // Assuming category 1 exists
                'service_name' => 'Portrait Photography',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } else {
            $serviceId = $service->id;
        }
        
        // Create 10 photographer users and link them
        $photographerUsers = [];
        
        for ($i = 1; $i <= 10; $i++) {
            // Create user
            $userId = DB::table('tbl_users')->insertGetId([
                'uuid' => Str::uuid(),
                'location_id' => null,
                'role' => 'studio-photographer',
                'first_name' => 'Photographer',
                'middle_name' => null,
                'last_name' => 'User' . $i,
                'user_type' => 'photographer',
                'email' => 'photographer' . $i . '@example.com',
                'mobile_number' => '0912' . str_pad($i, 7, '0', STR_PAD_LEFT),
                'password' => Hash::make('password123'),
                'profile_photo' => null,
                'status' => 'active',
                'email_verified' => 1,
                'verification_token' => null,
                'token_expiry' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            
            // Create studio_photographer record
            DB::table('tbl_studio_photographers')->insert([
                'studio_id' => $studioId,
                'owner_id' => $ownerId,
                'photographer_id' => $userId,
                'position' => 'Photographer',
                'specialization' => $serviceId,
                'years_of_experience' => rand(1, 10),
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            
            $photographerUsers[] = $userId;
        }
        
        $this->command->info('Successfully created 10 studio photographer users with studio links.');
        $this->command->info('Studio ID: ' . $studioId);
        $this->command->info('Owner ID: ' . $ownerId);
        $this->command->info('Service ID: ' . $serviceId);
        $this->command->info('Photographer User IDs: ' . implode(', ', $photographerUsers));
    }
}