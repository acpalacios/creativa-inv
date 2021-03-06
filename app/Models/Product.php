<?php

namespace App\Models;

class Product extends Model
{

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('name');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('quantity', 'like', '%'.$search.'%')
                    ->orWhereHas('contact', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%'.$search.'%')
                        ->orWhere('last_name', 'like', '%'.$search.'%');
                    });
            });
        });
    }
}
