<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'status',
        'amount',
        'player_id',
        'pay_date'
    ];

    private const GAME_COST = 450;

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public static function balance()
    {
        $currentMonth = date('m/Y');
        $gameCost = static::GAME_COST;

        $result = DB::select(
            <<<SQL
                SELECT
                    (SUM(`value`) + (
                        (
                            SELECT
                                SUM(`value`) - {$gameCost}
                            FROM
                                payments
                            WHERE
                                STATUS = 'PAGO' AND month_year <> '{$currentMonth}'
                        )
                    ) - {$gameCost}) AS total
                FROM
                    payments
                WHERE
                    STATUS = 'PAGO' AND month_year = '{$currentMonth}';
            SQL
        );

        if (count($result)) {
            return $result[0]->total;
        }

        return 0;
    }

    public static function totalPaid()
    {
        $result = DB::select(
            <<<SQL
                SELECT
                    SUM(`value`) as total
                FROM
                    payments
                WHERE
                    STATUS = 'PAGO';
            SQL
        );

        if (count($result)) {
            return $result[0]->total;
        }

        return 0;
    }

    public static function totalPaidThisMonth(string $monthYear)
    {
        $result = DB::select(
            <<<SQL
                SELECT
                    SUM(`value`) as total
                FROM
                    payments
                WHERE
                    STATUS = 'PAGO' AND month_year = '{$monthYear}';
            SQL
        );

        if (count($result)) {
            return $result[0]->total;
        }

        return 0;
    }
}
