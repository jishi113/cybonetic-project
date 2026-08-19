<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Company;
use App\Models\User;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with(['assignedTo', 'company', 'tags'])->forAgent(auth()->user());

        if ($search = $request->input('search')) {
            $query->where(fn($q) => $q->where('title', 'like', "%$search%")
                ->orWhere('contact_name', 'like', "%$search%")
                ->orWhere('contact_email', 'like', "%$search%"));
        }

        $query->byStatus($request->input('status'));

        if ($agent = $request->input('agent_id')) {
            $query->where('assigned_to', $agent);
        }

        if ($from = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $leads = $query->latest()->paginate(15)->withQueryString();
        $agents = User::where('role', 'agent')->orderBy('name')->get();

        return view('leads.index', compact('leads', 'agents'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();
        $agents = User::where('role', 'agent')->orderBy('name')->get();

        return view('leads.create', compact('companies', 'agents'));
    }

    public function store(StoreLeadRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        if (auth()->user()->role === 'agent') {
            $data['assigned_to'] = auth()->id();
        }

        $lead = Lead::create($data);

        if ($request->has('tag_ids')) {
            $lead->tags()->sync($request->tag_ids);
        }

        return redirect()->route('leads.show', $lead)->with('success', 'Lead created successfully.');
    }

    public function show(Lead $lead)
    {
        $this->authorizeLeadAccess($lead);
        $lead->load(['assignedTo', 'company', 'activities.user', 'tags', 'createdBy']);

        return view('leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $this->authorizeLeadAccess($lead);
        $companies = Company::orderBy('name')->get();
        $agents = User::where('role', 'agent')->orderBy('name')->get();

        return view('leads.edit', compact('lead', 'companies', 'agents'));
    }

    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $this->authorizeLeadAccess($lead);
        $lead->update($request->validated());

        if ($request->has('tag_ids')) {
            $lead->tags()->sync($request->tag_ids ?? []);
        }

        return redirect()->route('leads.show', $lead)->with('success', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead)
    {
        $this->authorizeLeadAccess($lead);
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead moved to trash.');
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $request->validate(['status' => ['required', 'in:' . implode(',', array_keys(Lead::STATUSES))]]);
        $lead->update(['status' => $request->status]);

        return back()->with('success', 'Status updated.');
    }

    public function trashed()
    {
        $leads = Lead::onlyTrashed()->with(['assignedTo', 'company'])->latest()->paginate(15);

        return view('leads.trashed', compact('leads'));
    }

    public function restore($id)
    {
        $lead = Lead::onlyTrashed()->findOrFail($id);
        $lead->restore();

        return back()->with('success', 'Lead restored.');
    }

    private function authorizeLeadAccess(Lead $lead): void
    {
        $user = auth()->user();
        if ($user->role === 'agent' && $lead->assigned_to !== $user->id) {
            abort(403, 'You can only access your own leads.');
        }
    }
}