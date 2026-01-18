<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;

class AdminController extends Controller
{
    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'name' => strtolower($request->name),
        ]);

        $request->validate([
            'name' => 'required|unique:people,name',
            'photo' => 'required|image',
            'details' => 'nullable|string',
        ]);

        $photoPath = $request->file('photo')->store('people', 'public');
        $fullImagePath = storage_path('app/public/' . $photoPath);

        Person::create([
            'name' => strtolower($request->name),
            'photo' => $photoPath,
            'details' => $request->details,
        ]);

        // 🔥 Call Python Encoder API
        try {
            $response = \Illuminate\Support\Facades\Http::post(
                'http://127.0.0.1:5001/encode',
                [
                    'name' => strtolower($request->name),
                    'image_path' => $fullImagePath
                ]
            );

            if (!$response->successful()) {
                return back()->with('error', 'Face encoding failed: ' . ($response->json()['message'] ?? 'Unknown AI error'));
            }
        } catch (\Exception $e) {
            return back()->with('error', 'AI Service unreachable. Please ensure the Python backend is running.');
        }

        return back()->with('success', 'Person added & face encoded successfully');
    }

    public function index()
    {
        $people = Person::latest()->get();
        return view('admin.index', compact('people'));
    }

    public function destroy(Person $person)
    {
        // 1. Delete Biometric Data from Python API
        try {
            \Illuminate\Support\Facades\Http::post(
                'http://127.0.0.1:5001/delete',
                ['name' => strtolower($person->name)]
            );
        } catch (\Exception $e) {
            \Log::error("Failed to delete biometric data for {$person->name}: " . $e->getMessage());
        }

        // 2. Delete Photo from Storage
        if ($person->photo && \Storage::disk('public')->exists($person->photo)) {
            \Storage::disk('public')->delete($person->photo);
        }

        // 3. Delete DB Record
        $person->delete();

        return back()->with('success', 'Information and biometric signature deleted successfully.');
    }
}
