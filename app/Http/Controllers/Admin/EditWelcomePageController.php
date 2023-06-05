<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WelcomeInformation;
use Inertia\Inertia;
use Inertia\Response;

final class EditWelcomePageController extends Controller
{
    public function showEditWelcomePageForm(): Response
    {
        return Inertia::render('Admin/EditWelcomePage', [
            'welcome_informations' => WelcomeInformation::cachedFirstEntry(),
        ]);
    }
}
