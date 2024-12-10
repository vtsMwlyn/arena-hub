<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function bookers(){
        return $this->belongsToMany(User::class, "bookings");
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function scopeFilter($query, array $filters){
		$query->when($filters["search"] ?? false, function($query, $search){
			return $query->where(function($query) use($search){
				$query->where("name", "like", "%" . $search . "%");
			});
		});

        $query->when($filters["category"] ?? false, function($query, $category){
			return $query->where(function($query) use($category){
				$query->where("categories", "like", "%" . $category . "%");
			});
		});
	}
}
