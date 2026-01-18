<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;

class FaceRecognitionController extends Controller
{
    public function scan(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // base64 string
        ]);

        $imageStream = $request->input('image');
        $imageStream = str_replace('data:image/png;base64,', '', $imageStream);
        $imageStream = str_replace(' ', '+', $imageStream);
        $imageName = 'scan_' . time() . '.png';
        $path = 'temp_scans/' . $imageName;

        if (!\Storage::disk('public')->exists('temp_scans')) {
            \Storage::disk('public')->makeDirectory('temp_scans');
        }

        \Storage::disk('public')->put($path, base64_decode($imageStream));

        $fullPath = storage_path('app/public/' . $path);

        // Call Python API
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post('http://127.0.0.1:5001/recognize', [
                'json' => ['image_path' => $fullPath]
            ]);

            $result = json_decode($response->getBody(), true);

            // Cleanup temp image
            \Storage::disk('public')->delete($path);

            if ($result['status'] === 'success') {
                $name = strtolower($result['name']);
                $person = Person::where('name', $name)->first();

                if ($person) {
                    return response()->json([
                        'status' => 'success',
                        'name' => ucfirst($person->name),
                        'details' => $person->details,
                        'photo' => asset('storage/' . $person->photo)
                    ]);
                }
            }

            return response()->json([
                'status' => 'unknown',
                'message' => $result['message'] ?? 'Person not recognized'
            ]);

        } catch (\Exception $e) {
            $message = 'AI Service unreachable';
            if (str_contains($e->getMessage(), 'Connection refused')) {
                $message = 'AI Service Offline (Port 5001). Please start the Python backend.';
            }

            return response()->json([
                'status' => 'error',
                'message' => $message . ': ' . $e->getMessage()
            ], 500);
        }
    }

    public function recognize(Request $request)
    {
        $name = strtolower($request->input('name'));

        $person = Person::where('name', $name)->first();

        if (!$person) {
            return response()->json([
                'status' => 'not_found'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'name' => $person->name,
            'photo' => $person->photo ? asset('storage/' . $person->photo) : null,
            'details' => $person->details
        ]);
    }
}
