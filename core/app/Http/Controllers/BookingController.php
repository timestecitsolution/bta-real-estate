<?php
namespace App\Http\Controllers;

use App\Models\BookingQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\BookingQueryMail;
use App\Models\User;
use App\Models\PriceModel;
use App\Models\DocumentType;
use App\Models\MaterialDetails;
use App\Models\FlatDocuments;
use App\Models\BulkSmsData;
use App\Models\Contact;
use App\Models\EmiPayment;
use App\Models\ClientApplicationSubject;
use App\Models\CentralApplication;
use App\Models\LandlordEngagement;
use Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    public function create()
    {
        $projects = Project::all();
        return view('booking.form', compact('projects'));
    }

    public function getUploadPath(string $subFolder = null)
    {
        $subFolder = $subFolder ?? 'misc';
        $basePath = base_path('../uploads/');
        $path = $basePath . $subFolder . '/';

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        return $path;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'nid_no' => 'required|string|digits_between:10,17',
            'passport_no' => 'required|string|max:9',
            'birth_certificate_no' => 'string|max:17',
            'project_id' => 'required',
            'flat_id' => 'required',
            'preferred_date' => 'required|nullable|date',
            'message' => 'nullable|string',
            'nid_front_pic' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'nid_back_pic'  => 'image|mimes:jpeg,png,jpg|max:2048',
        ], 
        [
            // 🔴 Custom messages
            'nid_front_pic.image'    => 'NID front must be an image file.',
            'nid_front_pic.mimes'    => 'NID front image must be jpeg, jpg or png format.',
            'nid_front_pic.max'      => 'NID front image size must not exceed 2MB.',

            'nid_back_pic.image'    => 'NID back must be an image file.',
            'nid_back_pic.mimes'    => 'NID back image must be jpeg, jpg or png format.',
            'nid_back_pic.max'      => 'NID back image size must not exceed 2MB.',
        ]
        );

        // Store files
        $nidFrontPath = null;
        $nidBackPath = null;

        // ---------- NID FRONT ----------
        if ($request->hasFile('nid_front_pic')) {

            $file = $request->file('nid_front_pic');
            $path = $this->getUploadPath('visit_nid');

            $fileName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);

            $nidFrontPath = 'visit_nid/' . $fileName;
        }

        // ---------- NID BACK ----------
        if ($request->hasFile('nid_back_pic')) {

            $file = $request->file('nid_back_pic');
            $path = $this->getUploadPath('visit_nid');

            $fileName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);

            $nidBackPath = 'visit_nid/' . $fileName;
        }

        $validated['nid_front_pic'] = $nidFrontPath;
        $validated['nid_back_pic']  = $nidBackPath;

        $query = BookingQuery::create($validated);

        $mail_to = Helper::GeneralSiteSettings("land_query_mail");
        // Send Email
        Mail::to($query->email)->send(new BookingQueryMail($query));
        
        return redirect()->back()->with('success', 'Your visit booking request is submitted successfully!');
    }

    public function getFlats_old(Request $request)
    {
        $priceFlatIds = DB::table('price')
            ->pluck('flat_id')
            ->toArray();

        $engagedFlatIds = DB::table('landlord_engagements')
            ->pluck('flat_id')
            ->toArray();

        $excludedFlatIds = array_unique(array_merge(
            $priceFlatIds,
            $engagedFlatIds
        ));

        $tags = DB::table('topic_tags')
            ->join('tags', 'topic_tags.tag_id', '=', 'tags.id')
            ->where('topic_tags.topic_id', $request->project_id)
            ->when(!empty($excludedFlatIds), function ($q) use ($excludedFlatIds) {
                $q->whereNotIn('tags.id', $excludedFlatIds);
            })
            ->select('tags.id', 'tags.title')
            ->get();
        return response()->json([
            'tags' => $tags
        ]);
    }

    public function getFlats(Request $request)
    {
        $currentFlatId = $request->current_flat_id;
        
        $priceFlatIds = DB::table('price')
            ->pluck('flat_id')
            ->toArray();

        $bookedFlatIds = DB::table('booked_flat_info')
            ->pluck('flat_id')
            ->toArray();

        $engagedFlatIds = DB::table('landlord_engagements')
            ->pluck('flat_id')
            ->toArray();

        $excludedFlatIds = array_unique(array_merge(
            $priceFlatIds,
            $bookedFlatIds,
            $engagedFlatIds
        ));

        if ($currentFlatId) {
            $excludedFlatIds = array_diff($excludedFlatIds, [$currentFlatId]);
        }

        $flats = DB::table('flat_details')
            ->where('flat_details.project_id', $request->project_id)
            ->when(!empty($excludedFlatIds), function ($q) use ($excludedFlatIds) {
                $q->whereNotIn('flat_details.id', $excludedFlatIds);
            })
            ->select('flat_details.id', 'flat_details.flat_name', 'flat_details.flat_size')
            ->get();
        return response()->json([
            'flats' => $flats
        ]);
    }


    public function getFlatsByCustomer($customer_id)
    {
        $flats = PriceModel::where('customer_id', $customer_id)
                    ->where('is_cancelled', '!=', 1)
                    ->with('flat')
                    ->get()
                    ->pluck('flat');  
        return response()->json($flats);
    }
    public function getFlatsByLandlord($customer_id)
    {
        $flats = LandlordEngagement::where('landlord_id', $customer_id)
                    ->with(['project', 'flat', 'customer', 'flatDocuments', 'materials.materialType'])
                    ->get()
                    ->pluck('flat');  
        return response()->json($flats);
    }

    public function loginbookinguser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('user')->attempt($credentials)) {
            return redirect()->route('dashboard-new');
        }

        return back()->withErrors([
            'email' => 'Credentials do not match.',
        ]);
    }

    public function dashboard(Request $request)
    {
        $user = Auth::guard('user')->user();

        $all_prices_details = PriceModel::with(['project', 'flat', 'customer'])
        ->when($user->status == 0, function ($query) use ($user) {
            return $query->where('customer_id', $user->contact_id);
        })->get();
        $allocated_flats = LandlordEngagement::with(['project', 'flat', 'customer', 'flatDocuments', 'materials.materialType'])
                ->when($user->status == 0, function ($query) use ($user) {
                    return $query->where('landlord_id', $user->contact_id);
                })->get();
                
        // Step 1: Default empty collections
        $prices_details = collect();
        $emi_details = collect();
        $material_details = collect();
        $landlord_id = null;


        $filter_customer_id = $request->input('filter_customer_id');
        $filter_flat_id = $request->input('filter_flat_id');
        $filter_from_date = $request->input('filter_from_date');
        $filter_to_date = $request->input('filter_to_date');

        // Step 2: If form is submitted (POST) and customer selected
        if ($request->isMethod('post') && $request->filled('filter_customer_id')) {   
            // Step 3: Fetch prices based on customer
            $prices_details = PriceModel::with(['project', 'flat', 'customer'])
                ->where('customer_id', $filter_customer_id)
                ->when($user->status == 0, function ($query) use ($user) {
                    return $query->where('customer_id', $user->contact_id);
                })
                ->get();
            // Step 4: Fetch EMI based on selected prices
            $price_ids = $prices_details->pluck('id');

            $emi_details = EmiPayment::whereIn('price_id', $price_ids)
                ->when($filter_from_date && $filter_to_date, function ($query) use ($filter_from_date, $filter_to_date) {
                    return $query->whereBetween('emi_paid_date', [$filter_from_date, $filter_to_date]);
                })
                ->when($filter_from_date && !$filter_to_date, function ($query) use ($filter_from_date) {
                    return $query->whereDate('emi_paid_date', '>=', $filter_from_date);
                })
                ->when(!$filter_from_date && $filter_to_date, function ($query) use ($filter_to_date) {
                    return $query->whereDate('emi_paid_date', '<=', $filter_to_date);
                })
                ->get();

                //  Dynamic EMI Balance Calculation
                $prices = $prices_details->keyBy('id');
                $calculatedEmis = collect();

                foreach ($emi_details->groupBy('price_id') as $price_id => $emis) {

                    $price_info = $prices[$price_id];
                    $total_price = floatval($price_info->price ?? 0); 
                    $emi_count = intval($price_info->emi_count ?? 0);
                    $booking_amount = floatval($price_info->booking_amount ?? 0);
                    $downpayment_amount = floatval($price_info->downpayment_amount ?? 0);

                    $total_paid = $booking_amount + $downpayment_amount;
                    $total_paid_with_extras = $booking_amount + $downpayment_amount;
                    $actual_emi_paid_count = 0;

                    foreach ($emis as $index => $emi) {

                        $emi_amount = floatval($emi->emi_amount ?? 0);
                        $extras_amount = floatval($emi->extras_amount ?? 0);


                        if ($emi_amount > 0) {
                            $total_paid += $emi_amount;
                            $actual_emi_paid_count++;
                        }

                        // $total_paid += $emi_amount;
                        $total_paid_with_extras += ($emi_amount + $extras_amount);

                        $emi->total_paid_amount = $total_paid;
                        $emi->remaining_due = max($total_price - $total_paid, 0);

                        $emi->total_paid_amount_with_extras = $total_paid_with_extras;
                        $emi->remaining_due_amount_with_extras = max($total_price - $total_paid_with_extras, 0);

                        $emi->remaining_emi_count = max($emi_count - $actual_emi_paid_count, 0);

                        $calculatedEmis->push($emi);
                    }
                }

                $emi_details = $calculatedEmis;

                $material_details = MaterialDetails::whereIn('booking_id', $price_ids)
                    ->join('material_types', 'material_details.material_type_id', '=', 'material_types.id')
                    ->select('material_details.*', 'material_types.material_type')
                    ->get();
        }elseif($request->isMethod('post') && $request->filled('landlord_id')){
            $landlord_id = $request->input('landlord_id');

            // Step 3: Fetch prices based on landlord
            $allocated_flats = LandlordEngagement::with(['project', 'flat', 'customer', 'flatDocuments', 'materials.materialType'])
                ->where('landlord_id', $landlord_id)
                ->when($user->status == 0, function ($query) use ($user) {
                    return $query->where('landlord_id', $user->contact_id);
                })
                ->get();
        }
        // Step 5: Static data
        $Contact = Contact::find($user->contact_id);

        $customer_details = $prices_details->isNotEmpty() ? $prices_details->first()->customer : null;
        $allDocumentTypes = DocumentType::all();
        $applicationSubjects = ClientApplicationSubject::where('type', 'application')->get();

        $bulksmsdata = BulkSmsData::all();
        $applicationdata = CentralApplication::with(['subject', 'creator', 'feedbacks.feedbackCreator', 'attachments', 'project', 'flat'])
            ->where('applied_by', $user->id)
            ->get();

        return view('user-dashboard', compact('all_prices_details','prices_details', 'customer_details', 'allDocumentTypes', 'emi_details', 'user', 'Contact', 'filter_customer_id', 'filter_flat_id', 'filter_from_date', 'filter_to_date', 'bulksmsdata', 'material_details', 'applicationSubjects', 'applicationdata', 'allocated_flats', 'landlord_id'));
    }


    public function UserLogin()
    {
        return view('user-login');
    }
    public function UserLogout()
    {
        Auth::guard('user')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/user/login');
    }
    
}
