<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Monitor;

class LogsController extends Controller
{
    public function index()
    {
        $logs = Monitor::with('user')->paginate(10);

        return Inertia::render('Admin/Logs/Logs', compact('logs'));
    }
}
