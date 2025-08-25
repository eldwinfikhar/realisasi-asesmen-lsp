<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessee;
use App\Models\Entity;
use Illuminate\Validation\Rule;

class AssesseeController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        // Handle sorting
        $sort = request('sort', 'name');
        $direction = request('direction', 'asc');

        // Handle filtering
        $filterBy = request('filter_by');
        $filterValue = request('filter_value');

        // Validate sort column
        $allowedSorts = ['name', 'entity', 'band'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'name';
        }

        $query = Assessee::with('entity');

        if ($filterBy && $filterValue) {
            if ($filterBy === 'name') {
                $query->where('name', 'like', '%' . $filterValue . '%');
            } elseif ($filterBy === 'entity') {
                $query->whereHas('entity', function($q) use ($filterValue) {
                    $q->where('name', 'like', '%' . $filterValue . '%');
                });
            } elseif ($filterBy === 'band') {
                $query->where('band', 'like', '%' . $filterValue . '%');
            }
        }

        // Map 'entity' to entity name for sorting
        if ($sort === 'entity') {
            $assessees = $query->get()->sortBy(function($assessee) {
                return $assessee->entity ? $assessee->entity->name : '';
            }, SORT_REGULAR, $direction === 'desc');
            $assessees = $direction === 'desc' ? $assessees->reverse()->values() : $assessees->values();
        } else {
            $assessees = $query->orderBy($sort, $direction)->get();
        }

        return view('assessees.index', [
            'assessees' => $assessees,
            'sort' => $sort,
            'direction' => $direction,
            'filter_by' => $filterBy,
            'filter_value' => $filterValue
        ]);
    }

    // Show the form for creating a new resource.
    public function create()
    {
        $entities = Entity::all();
        $assessee = new Assessee();
        return view('assessees.form', compact('entities', 'assessee'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validate all required fields

$validated = $request->validate([
    'name' => [
        'required',
        'string',
        'max:255',
        Rule::unique('assessees')
            ->where('entity_id', $request->input('entity_id')),
    ],
    'band' => 'nullable|required_if:assessee_type,Internal|string|max:50',
    'entity_id' => 'required|exists:entities,id',
    'assessee_type' => 'required|in:Internal,Eksternal',
    'location' => 'nullable|required_if:assessee_type,Eksternal|string|max:255'
]);

        // Explicitly nullify unused fields
        if ($validated['assessee_type'] === 'Internal') {
            $validated['location'] = null;
        }
        if ($validated['assessee_type'] === 'Eksternal') {
            $validated['band'] = null;
        }

        Assessee::create($validated);

        return redirect()->route('assessees.index')->with('success', 'Data asesi berhasil ditambahkan.');
    }

    // Display the specified resource.
    public function show($id)
    {
        // 
        // Logic to display a specific assessee
        
    }

    // Show the form for editing the specified resource.

    public function edit(Assessee $assessee)
    {
        $entities = Entity::all();
        return view('assessees.form', compact('entities', 'assessee'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Assessee $assessee)
    {

        $validated = $request->validate([
            'name' => [
        'required',
        'string',
        'max:255',
        Rule::unique('assessees')
            ->where('entity_id', $request->input('entity_id'))
            ->ignore($assessee->id),
    ],
            'band' => 'nullable|required_if:assessee_type,Internal|string|max:50',
            'entity_id' => 'required|exists:entities,id',
            'assessee_type' => 'required|in:Internal,Eksternal',
            'location' => 'nullable|required_if:assessee_type,Eksternal|string|max:255',
        ]);

        // Explicitly nullify unused fields
        if ($validated['assessee_type'] === 'Internal') {
            $validated['location'] = null;
        }
        if ($validated['assessee_type'] === 'Eksternal') {
            $validated['band'] = null;
        }

        $assessee->update($validated);

        return redirect()->route('assessees.index')->with('success', 'Data asesi berhasil diperbarui.');
    }

    // Remove the specified resource from storage.
    public function destroy(Assessee $assessee)
    {
        $assessee->delete();
        return redirect()->route('assessees.index')->with('success', 'Data asesi berhasil dihapus.');
    }
}
