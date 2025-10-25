<?php
namespace App\Http\Controllers;

use App\Models\BookingQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\BookingQueryMail;
use App\Models\User;
use App\Models\PriceModel;
use App\Models\DocumentType;
use App\Models\FlatDocuments;
use App\Models\BulkSmsData;
use App\Models\Contact;
use App\Models\EmiPayment;
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
            'preferred_date' => 'nullable|date',
            'message' => 'nullable|string',
            'nid_front_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nid_back_pic'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Store files
        $nidFrontPath = null;
        $nidBackPath = null;

        if ($request->hasFile('nid_front_pic')) {
            $nidFrontPath = $request->file('nid_front_pic')->store('uploads/nid_pics', 'public');
        }

        if ($request->hasFile('nid_back_pic')) {
            $nidBackPath = $request->file('nid_back_pic')->store('uploads/nid_pics', 'public');
        }

        $validated['nid_front_pic'] = $nidFrontPath;
        $validated['nid_back_pic']  = $nidBackPath;

        $query = BookingQuery::create($validated);

        $existingUser = User::where('email', $validated['email'])->first();
        if ($existingUser) {
            return redirect()->route('login-new')->with('warning', 'You already have an account. Please login.');
        }

         $user = User::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make('123456'),
            'permissions_id' => 1, 
            'must_change_password' => true,
        ]);
        if ($user) {
            Auth::guard('user')->login($user);
            return redirect()->route('change-password')->with('success', 'Please change your password first!');
        }

        $mail_to = Helper::GeneralSiteSettings("land_query_mail");
        // Send Email
        Mail::to($query->email)->send(new BookingQueryMail($query));
        return redirect()->route('dashboard-new')->with('success', 'Your booking is submitted and account created successfully!');
    }

    public function getFlats(Request $request)
    {
        $bookedFlatIds = DB::table('price')->pluck('flat_id')->toArray();

        $tags = DB::table('topic_tags')
            ->join('tags', 'topic_tags.tag_id', '=', 'tags.id')
            ->where('topic_tags.topic_id', $request->project_id)
            ->whereNotIn('tags.id', $bookedFlatIds) 
            ->select('tags.id', 'tags.title')
            ->get();

        return response()->json([
            'tags' => $tags
        ]);
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

        $all_prices_details = PriceModel::with(['customer'])
        ->when($user->status == 0, function ($query) use ($user) {
            return $query->where('customer_id', $user->contact_id);
        })
        ->get();
        // Step 1: Default empty collections
        $prices_details = collect();
        $emi_details = collect();

        $filter_customer_id = $request->input('filter_customer_id');
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

                    $total_paid = 0;
                    $total_paid_with_extras = 0;
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
        }
        // Step 5: Static data
        $Contact = Contact::find($user->contact_id);
        $customer_details = $prices_details->isNotEmpty() ? $prices_details->first()->customer : null;
        $allDocumentTypes = DocumentType::all();

        $bulksmsdata = BulkSmsData::all();

        return view('user-dashboard', compact('all_prices_details','prices_details', 'customer_details', 'allDocumentTypes', 'emi_details', 'user', 'Contact', 'filter_customer_id', 'filter_from_date', 'filter_to_date', 'bulksmsdata'));
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
