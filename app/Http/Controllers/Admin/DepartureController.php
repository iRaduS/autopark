<?php
namespace App\Http\Controllers\Admin;

use App\Models\Monitor;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Models\Auto;
use App\Models\Employee;
use App\Models\Location;
use App\Models\DepartureTicket;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DepartureController extends \App\Http\Controllers\Controller
{
    public function index() {
        $automobiles = Auto::select(['id', 'registration_number', 'type'])->get();
        $employees = Employee::select(['id', 'last_name', 'first_name'])->get()->map(function (Employee $employee) {
            return ['id' => $employee->id, 'name' => $employee->last_name . ' ' . $employee->first_name];
        });
        $locations = Location::select(['id', 'name'])->get();
        $tickets = DepartureTicket::with('location')->orderBy('id', 'DESC')->paginate();
        return Inertia::render('Admin/Departures/Index', compact('automobiles', 'employees', 'locations', 'tickets'));
    }

    public function save(Request $request) {
        try {
            $location_name = Location::select('name')->where('id', $request->location_id)->first()->name;
            $automobile_registration = Auto::select('registration_number')->where('id', $request->automobile_id)->first()->registration_number;
            $driver_name = Employee::select(['last_name', 'first_name', 'title'])->where('id', $request->driver_id)->first();

            $spreadsheet = IOFactory::load(storage_path('app/template/lista_pasageri.xlsx'));
            $spreadsheet->getActiveSheet()->setCellValue('A9', '                                                                              RUTA ROMANIA(GALATI) – ' . $location_name);
            $spreadsheet->getActiveSheet()->setCellValue('A12', '                                                                                                                   ' . $location_name . ', pentru prestari, servicii, incepand cu data de ' . $request->date);
            $spreadsheet->getActiveSheet()->setCellValue('A13', '                                                                                                                   Transportul se va realiza cu autovehiculul firmei ' . $automobile_registration);

            $spreadsheet->getActiveSheet()->setCellValue('B17', '1 (SOFER)');
            $spreadsheet->getActiveSheet()->setCellValue('C17', $driver_name->last_name);
            $spreadsheet->getActiveSheet()->setCellValue('D17', $driver_name->first_name);
            $spreadsheet->getActiveSheet()->setCellValue('E17', $driver_name->title);

//            dd($request->pass);
            collect($request->pass)->map(function ($employee_id, $index) use ($spreadsheet) {
                $employee = Employee::where('id', $employee_id)->first();
                $spreadsheet->getActiveSheet()->setCellValue('B' . (18 + $index), $index + 2 . ' (PASAGER)');
                $spreadsheet->getActiveSheet()->setCellValue('C' . (18 + $index), $employee->last_name);
                $spreadsheet->getActiveSheet()->setCellValue('D' . (18 + $index), $employee->first_name);
                $spreadsheet->getActiveSheet()->setCellValue('E' . (18 + $index), $employee->title);
            });

            $dep_ticket = DepartureTicket::create([
                'location_id' => $request->location_id,
                'auto_id' => $request->automobile_id,
                'employee_id' => $request->driver_id,
                'passangers' => json_encode($request->pass),
                'create_date' => $request->date
            ]);

            $writer = IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save(storage_path('app/transport/bilet_deplasare' . $dep_ticket->id . '.xls'));
            Monitor::createLog(auth()->id(), 'a creat o foaie de deplasare', $request->ip(), 2);

        } catch (\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with(['success' => __('Ai incarcat cu succes situatia')]);
    }

    public function delete(DepartureTicket $ticket, Request $request) {
        try {
            if (Storage::disk('local')->exists('transport/bilet_deplasare' . $ticket->id . '.xls')) {
                Storage::disk('local')->delete('transport/bilet_deplasare' . $ticket->id . '.xls');
            }
            $ticket->delete();
            Monitor::createLog(auth()->id(), 'a sters o foaie de deplasare', $request->ip(), 2);
        } catch (\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with(['success' => __('Ai sters cu succes situatia')]);
    }

    public function download(DepartureTicket $ticket, Request $request) {
        if (Storage::disk('local')->exists('transport/bilet_deplasare' . $ticket->id . '.xls')) {
            Monitor::createLog(auth()->id(), 'a descarcat o foaie de deplasare', $request->ip(), 2);

            return response()->download(storage_path('app/transport/bilet_deplasare' . $ticket->id . '.xls'));
        }

        return Redirect::back();
    }
}