<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Inertia\Inertia;

class LeadController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $leads = Lead::whereHas('imovel', function ($q) use ($user) {
            if (!$user->can('view leads')) {
                $q->where('user_id', $user->id);
            }
        })
            ->with(['imovel' => fn($q) => $q->withTrashed(), 'user'])
            ->latest()
            ->paginate(20);

        return Inertia::render('Admin/Leads/Index', compact('leads'));
    }

    public function show(Lead $lead)
    {
        $lead->load(['imovel' => fn($q) => $q->withTrashed(), 'user']);

        if (!auth()->user()->can('view leads') && $lead->imovel->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$lead->lido) {
            $lead->update(['lido' => true]);
        }

        return Inertia::render('Admin/Leads/Show', compact('lead'));
    }

    public function markAsUnread(Lead $lead)
    {
        if (!auth()->user()->can('view leads') && $lead->imovel->user_id !== auth()->id()) {
            abort(403);
        }

        $lead->update(['lido' => false]);

        return redirect()->route('admin.leads.index')
            ->with('success', 'Lead marcado como não lido.');
    }
}
