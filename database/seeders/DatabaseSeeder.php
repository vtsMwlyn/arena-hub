<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Booking;
use App\Models\Court;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create(["name" => "admin", "role" => "admin", "phone" => "081234567890", "email" => "admin@gmail.com", "password" => Hash::make("password")]);
        $andi = User::create(["name" => "Andi", "phone" => "081122334455", "email" => "andi@gmail.com", "password" => Hash::make("password")]);
        $budi = User::create(["name" => "Budi", "phone" => "080987654321", "email" => "budi@gmail.com", "password" => Hash::make("password")]);
        $cindy = User::create(["name" => "Cindy", "phone" => "086911110001", "email" => "cindy@gmail.com", "password" => Hash::make("password")]);
        $dian = User::create(["name" => "Dian", "phone" => "086946460002", "email" => "dian@gmail.com", "password" => Hash::make("password")]);

        $lapangan123 = Court::create(["name" => "Lapangan 123", "address" => "Jalan 123, Bandung", "open" => "06:00:00", "closed" => "21:00:00", "operational_days" => json_encode(["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]), "categories" => json_encode(["Football", "Basketball", "Badminton", "Gymnastics", "Volleyball", "Tennis"]), "rent_per_hour" => 40000]);
        $gor69 = Court::create(["name" => "Gor 69", "address" => "Jalan 69, Bandung", "open" => "08:00:00", "closed" => "20:00:00", "operational_days" => json_encode(["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"]), "categories" => json_encode(["Football", "Basketball", "Badminton", "Volleyball", "Tennis"]), "rent_per_hour" => 50000]);
        $griyasportcenter = Court::create(["name" => "Griya Sport Center", "address" => "Taman Kopo Indah, Bandung", "open" => "07:00:00", "closed" => "13:00:00", "operational_days" => json_encode(["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"]), "categories" => json_encode(["Football", "Basketball", "Badminton", "Volleyball", "Swimming"]), "rent_per_hour" => 35000]);

        Booking::create(["user_id" => $andi->id, "court_id" => $lapangan123->id, "date" => Carbon::now()->format('Y-m-d'), "start_time" => "10:00:00", "end_time" => "12:00:00", "people" => 4, "category" => "Badminton"]);
        Booking::create(["user_id" => $cindy->id, "court_id" => $gor69->id, "date" => Carbon::now()->format('Y-m-d'), "start_time" => "08:00:00", "end_time" => "10:00:00", "people" => 7, "category" => "Basketball"]);
        Booking::create(["user_id" => $cindy->id, "court_id" => $griyasportcenter->id, "date" => Carbon::tomorrow()->format('Y-m-d'), "start_time" => "09:00:00", "end_time" => "11:00:00", "people" => 6, "category" => "Volleyball"]);
        Booking::create(["user_id" => $budi->id, "court_id" => $griyasportcenter->id, "date" => Carbon::tomorrow()->format('Y-m-d'), "start_time" => "07:00:00", "end_time" => "11:00:00", "people" => 5, "category" => "Swimming"]);
    }
}
