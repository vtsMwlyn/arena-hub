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
        User::create(["name" => "admin", "email" => "admin@gmail.com", "password" => Hash::make("password")]);
        $andi = User::create(["name" => "Andi", "email" => "andi@gmail.com", "password" => Hash::make("password")]);
        $budi = User::create(["name" => "Budi", "email" => "budi@gmail.com", "password" => Hash::make("password")]);
        $cindy = User::create(["name" => "Cindy", "email" => "cindy@gmail.com", "password" => Hash::make("password")]);
        $dian = User::create(["name" => "Dian", "email" => "dian@gmail.com", "password" => Hash::make("password")]);

        $lapangan123 = Court::create(["name" => "Lapangan 123", "address" => "Jalan 123, Bandung", "open" => "06:00:00", "close" => "21:00:00", "operational_days" => serialize(["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]), "categories" => serialize(["Football", "Basketball", "Badminton", "Gymnastics", "Volleyball", "Tennis"]), "rent_per_hour" => 40000]);
        $gor69 = Court::create(["name" => "Gor 69", "address" => "Jalan 69, Bandung", "open" => "08:00:00", "close" => "20:00:00", "operational_days" => serialize(["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"]), "categories" => serialize(["Football", "Basketball", "Badminton", "Volleyball", "Tennis"]), "rent_per_hour" => 50000]);
        $griyasportcenter = Court::create(["name" => "Griya Sport Center", "address" => "Taman Kopo Indah, Bandung", "open" => "07:00:00", "close" => "13:00:00", "operational_days" => serialize(["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"]), "categories" => serialize(["Football", "Basketball", "Badminton", "Volleyball", "Swimming"]), "rent_per_hour" => 35000]);

        Booking::create(["user_id" => $andi->id, "court_id" => $lapangan123->id, "date" => Carbon::now()->format('Y-m-d'), "start_time" => "10:00:00", "end_time" => "12:00:00", "people" => 4, "category" => "Badminton"]);
        Booking::create(["user_id" => $cindy->id, "court_id" => $gor69->id, "date" => Carbon::now()->format('Y-m-d'), "start_time" => "08:00:00", "end_time" => "10:00:00", "people" => 7, "category" => "Basketball"]);
        Booking::create(["user_id" => $cindy->id, "court_id" => $griyasportcenter->id, "date" => Carbon::tomorrow()->format('Y-m-d'), "start_time" => "09:00:00", "end_time" => "11:00:00", "people" => 6, "category" => "Volleyball"]);
        Booking::create(["user_id" => $budi->id, "court_id" => $griyasportcenter->id, "date" => Carbon::tomorrow()->format('Y-m-d'), "start_time" => "07:00:00", "end_time" => "11:00:00", "people" => 5, "category" => "Swimming"]);
    }
}
