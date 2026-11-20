<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Urutan alur pelayanan kasir (PBI-10)
    public const STATUSES = [
        'pending' => 'Baru Masuk',
        'diterima' => 'Diterima',
        'diproses' => 'Diproses',
        'siap' => 'Siap Saji',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];

    protected $fillable = [
        'user_id',
        'order_type',
        'dining_table_id',
        'total_price',
        'status',
    ];

    // Relasi ke User (Pemesan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function diningTable()
    {
        return $this->belongsTo(DiningTable::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    // Status berikutnya dalam alur, null kalau sudah selesai/dibatalkan
    public function getNextStatusAttribute(): ?string
    {
        $flow = ['pending', 'diterima', 'diproses', 'siap', 'selesai'];
        $index = array_search($this->status, $flow, true);

        return $index === false ? null : ($flow[$index + 1] ?? null);
    }

    public function getCodeAttribute(): string
    {
        return '#ORD-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}
