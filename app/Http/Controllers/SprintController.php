<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Sprint;
use App\Http\Requests\StoreSprintRequest;
use App\Http\Requests\UpdateSprintRequest;
use App\Http\Requests\StoreDocumentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SprintController extends Controller
{
    public function index()
    {
        $sprints = Sprint::where('user_id', Auth::id())
            ->with('document')
            ->orderBy('start_date', 'desc')
            ->get();

        return Inertia::render('Sprint/Index', [
            'sprints' => $sprints,
        ]);
    }

    public function create()
    {
        return Inertia::render('Sprint/Create');
    }

    public function store(StoreSprintRequest $sprintRequest, StoreDocumentRequest $documentRequest): RedirectResponse
    {
        $validated = $sprintRequest->validated();

        $sprint = Sprint::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'target' => $validated['target'] ?? null,
            'status' => $validated['status'] ?? null,
        ]);

        $docData = $documentRequest->validated();
        if (collect($docData)->filter()->isNotEmpty()) {
            Document::create(array_merge($docData, ['sprint_id' => $sprint->id]));
        }

        return redirect()->route('sprints.index');
    }

    public function edit($id)
    {
        $sprint = Sprint::with('document')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return Inertia::render('Sprint/Edit', [
            'sprint' => $sprint,
        ]);
    }

    public function update(UpdateSprintRequest $sprintRequest, StoreDocumentRequest $documentRequest, $id): RedirectResponse
    {
        $validated = $sprintRequest->validated();

        $sprint = Sprint::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $sprint->update([
            'title' => $validated['title'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'target' => $validated['target'] ?? null,
            'status' => $validated['status'] ?? null,
        ]);

        $documentData = $documentRequest->validated();

        $document = $sprint->document;

        if ($document) {
            $document->update($documentData);
        } elseif (collect($documentData)->filter()->isNotEmpty()) {
            Document::create(array_merge($documentData, ['sprint_id' => $sprint->id]));
        }

        return redirect()->route('sprints.index');
    }

    public function destroy($id): RedirectResponse
    {
        $sprint = Sprint::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $sprint->document()->delete();
        $sprint->delete();

        return redirect()->route('sprints.index');
    }
}
