<?php

namespace App\Models\V1;

use App\helpers\GlobalHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class FuelOil extends Model
{

    protected $table = 'fuel_oil';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function list_data()
    {
        $data = DB::table('fuel_oil AS FO')
            ->leftJoin('vehicle_setup AS VS', function ($join) {
                $join->on('VS.id', '=', 'FO.vehicle_id')
                    ->on('FO.org_code', '=', 'VS.org_code')
                    ->whereNull('FO.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->where('FO.org_code', GlobalHelper::getOrganizationCode())
            ->whereNull('FO.deleted_at')
            ->select('VS.vehicle_reg_no')
            ->selectRaw("FO.*")
            ->get();

        return $data;
    }


    public static function current_stock($vehicle_id, $log_book_id = null)
    {
        $data = DB::table('fuel_oil AS FO')
            ->where('FO.org_code', GlobalHelper::getOrganizationCode())
            ->where('FO.vehicle_id', $vehicle_id)
            ->whereNull('FO.deleted_at')
            ->selectRaw("(SUM(FO.in) - SUM(FO.out)) as total_oil")
            ->when($log_book_id != null, function ($q) use ($log_book_id) {
                $q->where('FO.log_book_id', '!=', $log_book_id);
            })
            ->groupBy('FO.vehicle_id')
            ->first()->total_oil;
        return $data;
    }

}
