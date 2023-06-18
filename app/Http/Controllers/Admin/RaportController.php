<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\Auto;

class RaportController extends Controller
{
    public function index() {
        return Inertia::render("Admin/Raport/Raport");
    }


    public function autoReport() {
        $automobiles = Auto::all()->map(function (Auto $auto) {
            $data = [];
            $data['model'] = $auto->type;
            $data['plate'] = $auto->registration_number;
            $data['itp_begin'] = $auto->date_itp_begin ?? "N/A";
            $data['itp_end'] = $auto->date_itp_end ?? "N/A";
            $data['itp_diff'] = "ITP fără dată de expirare";
            if ($auto->date_itp_end) {
                $data['itp_diff'] = Carbon::parse($auto->date_itp_end)->longRelativeToNowDiffForHumans();
            }
            $data['insurance_begin'] = $auto->date_insurance_begin ?? "Neintrodus";
            $data['insurance_end'] = $auto->date_insurance_end ?? "Neintrodus";

            $data['insurance_diff'] = "Asigurare fără dată de expirare";
            if ($auto->date_insurance_end) {
                $data['insurance_diff'] = Carbon::parse($auto->date_insurance_end)->longRelativeToNowDiffForHumans();
            }
            return $data;
        });
        return response()->json($automobiles);
    }


}
