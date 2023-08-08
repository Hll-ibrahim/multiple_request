<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('appointment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $request->validate([
            'sessions.*.title' => 'required',
            'sessions.*.content' => 'required',
        ],
            [
                'sessions.*.title.required' => 'Başlık alanı gereklidir!',
                'sessions.*.content.required' => 'İçerik alanı gereklidir!',

            ]
        );


        $sessions = $request->sessions;


        // Her bir session için bir kayıt oluşturuyoruz.
        foreach ($sessions as $session) {
            Appointment::create([
                'title' => $session['title'],
                'content' => $session['content'],
            ]);
        }

        return response()->json(['success' => 'success']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
