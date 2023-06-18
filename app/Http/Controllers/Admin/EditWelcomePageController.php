<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WelcomeInformation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

final class EditWelcomePageController extends Controller
{
    public function showEditWelcomePageForm(): Response
    {
        return Inertia::render('Admin/EditWelcomePage', [
            'welcomeInformations' => WelcomeInformation::cachedFirstEntry(),
        ]);
    }

    public function deleteMessage(Request $request): RedirectResponse
    {
        try {
            if (! WelcomeInformation::cachedFirstEntry()->removeMessageFromEntry($request->post('message'))) {
                throw new \Exception('Couldn\'t save the modifications on the messages');
            }

            if (! WelcomeInformation::cacheInvalidateFirstEntry()) {
                throw new \Exception('Couldn\'t invalidate cache for the first entry in edit welcome page');
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

        return redirect()->back();
    }

    public function updateData(): RedirectResponse
    {
        try {
            if (! WelcomeInformation::cacheInvalidateFirstEntry()) {
                throw new \Exception('Couldn\'t invalidate cache for the first entry in edit welcome page');
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

        return redirect()->back();
    }
}
