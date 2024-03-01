<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrescriptionRequest;
use App\Http\Requests\UpdatePrescriptionRequest;
use App\Models\Prescription;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Assuming there's a relationship between User and Prescription models
        // Fetch all prescriptions associated with the user, ordered by the latest
        $prescriptions = $user->prescriptions()->latest()->get();

        // dd($prescriptions[0]);

        // Pass the prescriptions to the view
        return view('prescription.index', compact('prescriptions'));
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


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prescription $prescription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrescriptionRequest $request, Prescription $prescription)
    {
        //
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
