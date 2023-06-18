<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInsuranceRequest;
use App\Http\Requests\StoreItpRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Http\Requests\StoreAutovehicle;
use App\Models\Auto;
use App\Models\Monitor;

class AutoController extends Controller
{
    public function index() {
        $auto = Auto::paginate();

        return Inertia::render('Admin/Auto/Auto', compact('auto'));
    }

    public function store(StoreAutovehicle $request) {
        try {
            Auto::create($request->only('type', 'registration_number'));
            Monitor::createLog(auth()->id(), 'a adaugat un nou vehicul ' . $request->registration_number . ' ' . $request->type . ' in baza de date', $request->ip(), 1);
        } catch (\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('Ai introdus cu succes masina in baza de date.')
        ]);
    }

    public function remove(Auto $auto, Request $request) {
        try {
            if (Storage::disk('public')->exists('auto/' . $auto->id)) {
                Storage::disk('public')->deleteDirectory('auto/' . $auto->id);
            }

            $auto->delete();
            Monitor::createLog(auth()->id(), 'a sters vehiculul ' . $auto->registration_number . ' ' . $auto->type . ' din baza de date', $request->ip(), 1);
        } catch(\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('Ai sters cu succes masina din baza de date.')
        ]);
    }

    public function edit(Auto $auto) {

        return Inertia::render('Admin/Auto/Edit', compact('auto'));
    }

    public function updateItp(Auto $auto, StoreItpRequest $request) {
        try {
            $auto->update($request->only('date_itp_begin', 'date_itp_end'));
            Monitor::createLog(auth()->id(), 'a actualizat datele ITP pentru vehiculul ' . $auto->registration_number . ' ' . $auto->type . ' in baza de date', $request->ip(), 1);
        } catch (\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('Ai introdus ITP-ul cu succes.')
        ]);
    }

    public function updateInsurance(Auto $auto, StoreInsuranceRequest $request) {
        try {
            $auto->update($request->only('date_insurance_begin', 'date_insurance_end'));
            Monitor::createLog(auth()->id(), 'a actualizat datele asigurarii pentru vehiculul ' . $auto->registration_number . ' ' . $auto->type . ' in baza de date', $request->ip(), 1);
        } catch (\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('Ai introdus asigurarea cu succes.')
        ]);
    }

    public function uploadDocuments(Auto $auto, Request $request) {
        try {
            $documents = collect($request->files)->collapse()->map(
                /**
                 * @param UploadedFile $file
                 */
                function (UploadedFile $file) use ($auto) {
                    $file_name = Str::slug($auto->type) . Str::random(64) . $auto->id;

                    Storage::disk('public')
                        ->putFileAs('auto/' . $auto->id, $file, $file_name . '.' . $file->getClientOriginalExtension());

                    return $file_name . '.' . $file->getClientOriginalExtension();
                }
            );
            $documents = $documents->merge($auto->files);
            $auto->update(['files' => $documents]);
            Monitor::createLog(auth()->id(), 'a actualizat incarcat documentele pentru vehiculul ' . $auto->registration_number . ' ' . $auto->type . ' in baza de date', $request->ip(), 1);
        } catch(\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('Ai introdus documentele cu succes.')
        ]);
    }

    public function deleteDocuments(Auto $auto, Request $request) {
        try {
            $auto->update(['files' => collect($auto->files)->reject(function ($file_name) use ($request, $auto) {
                if ($file_name === $request->file) {
                    Storage::disk('public')
                        ->delete('auto/' . $auto->id . '/' . $file_name);
                }

                return $file_name === $request->file;
            })]);
            Monitor::createLog(auth()->id(), 'a sters documentele pentru vehiculul ' . $auto->registration_number . ' ' . $auto->type . ' in baza de date', $request->ip(), 1);
        } catch(\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('Ai șters documentele cu succes.')
        ]);
    }
}
