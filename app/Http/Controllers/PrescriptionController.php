<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrescriptionRequest;
use App\Http\Requests\UpdatePrescriptionRequest;
use App\Models\Prescription;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $prescriptions = Prescription::all(); // Fetch all prescriptions
            return view('prescription.index', compact('prescriptions'));
        } else {
            $user = Auth::user(); // Get the currently authenticated user
            $prescriptions = $user->prescriptions()->latest()->get(); // Fetch prescriptions for the current user
            return view('prescription.index', compact('prescriptions'));
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('prescription.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrescriptionRequest $request)
    {

        $prescription = Prescription::create([
            'delivery_address' => $request->delivery_address,
            'notes' => $request->note,
            // 'attachment' => json_encode($attachmentPaths), // Save paths as JSON string
            'user_id' => auth()->id()
        ]);
        $attachments = $request->file('attachment');
        $attachmentPaths = [];

        foreach ($attachments as $attachment) {
            $extension = $attachment->extension();
            $content = file_get_contents($attachment);
            $filename = Str::random(25);
            $path = "attachments/$filename.$extension";
            Storage::disk('public')->put($path, $content);
            $attachmentPaths[] = $path;
            $prescription->update(['attachment' => json_encode($attachmentPaths)]);
        }




        return redirect()->route('prescriptions.index');

    }




    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {






        return view('prescription.show', compact('prescription'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prescription $prescription)
    {
        return view('prescription.edit', compact('prescription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrescriptionRequest $request, Prescription $prescription)
    {
        $prescription->update($request->validated());


        return redirect()->route('prescriptions.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return redirect(route('prescriptions.index'));

    }







}
