<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Models\PriceModel;
use App\Models\Contact;
use App\Models\DocumentType;
use App\Models\MaterialType;
use Auth;
use File;
use Helper;

class FlatBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Permissions
        $data_sections_arr = explode(",", Auth::user()->permissionsGroup->data_sections);
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $prices = PriceModel::with(['project', 'flat', 'customer'])->get();
        return view("dashboard.flat-booking.list", compact("prices", "GeneralWebmasterSections"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::where('status', 1)->get();
        $documentTypes = DocumentType::all();
        $materialTypes = MaterialType::all();
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        return view("dashboard.flat-booking.create", compact("GeneralWebmasterSections", "contacts", "documentTypes", "materialTypes"));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
