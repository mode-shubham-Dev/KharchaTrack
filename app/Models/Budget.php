<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'month',
        'year',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'month'  => 'integer',
        'year'   => 'integer',
    ];

    // ===== RELATIONSHIPS =====

    // Budget belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Budget belongs to a Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ===== SCOPES =====

    // Get budgets for current month
    public function scopeCurrentMonth($query)
    {
        return $query->where('month', now()->month)
                     ->where('year', now()->year);
    }

    // Get budgets for specific month and year
    public function scopeForMonth($query, $month, $year)
    {
        return $query->where('month', $month)
                     ->where('year', $year);
    }

    // ===== HELPER METHODS =====

    // Get how much user spent for this budget's category this month
    public function getSpentAttribute()
    {
        return Transaction::where('user_id', $this->user_id)
            ->where('category_id', $this->category_id)
            ->where('type', 'expense')
            ->whereMonth('date', $this->month)
            ->whereYear('date', $this->year)
            ->sum('amount');
    }

    // Get remaining amount
    public function getRemainingAttribute()
    {
        return $this->amount - $this->spent;
    }

    // Get percentage spent
    public function getPercentageAttribute()
    {
        if ($this->amount == 0) return 0;
        return round(($this->spent / $this->amount) * 100);
    }

    // Get status based on percentage
    public function getStatusAttribute()
    {
        $percentage = $this->percentage;

        if ($percentage >= 100) return 'danger';
        if ($percentage >= 80)  return 'warning';
        if ($percentage >= 50)  return 'moderate';
        return 'safe';
    }

    // Get status color
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'danger'   => '#ef4444',
            'warning'  => '#f59e0b',
            'moderate' => '#6366f1',
            'safe'     => '#22c55e',
        };
    }
}