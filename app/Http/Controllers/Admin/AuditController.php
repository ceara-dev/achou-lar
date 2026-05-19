<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function index()
    {
        $audits = Audit::with('user')
            ->latest()
            ->paginate(15);

        return Inertia::render('Admin/Audits/Index', compact('audits'));
    }

    public function show(Audit $audit)
    {
        $audit->load('user');
        return Inertia::render('Admin/Audits/Show', compact('audit'));
    }
}
