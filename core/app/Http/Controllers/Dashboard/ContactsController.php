<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Contact;
use App\Models\ContactsGroup;
use App\Models\Country;
use App\Http\Requests;
use App\Models\WebmasterSection;
use App\Models\User;
use Auth;
use File;
use Helper;
use Illuminate\Config;
use Illuminate\Http\Request;
use Redirect;

class ContactsController extends Controller
{

    private $uploadPath = "uploads/contacts/";

    // Define Default Variables

    public function __construct()
    {
        $this->middleware('auth');

        // Check Permissions
        if (!@Auth::user()->permissionsGroup->newsletter_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
    }

    public function index($group_id = null)
    {
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        //List of groups
        if (@Auth::user()->permissionsGroup->view_status) {
            $ContactsGroups = ContactsGroup::where('created_by', '=', Auth::user()->id)->orderby('id', 'asc')->get();
        } else {
            $ContactsGroups = ContactsGroup::orderby('id', 'asc')->get();
        }

        //List of Countries
        $Countries = Country::orderby('title_' . @Helper::currentLanguage()->code, 'asc')->get();

        if (@Auth::user()->permissionsGroup->view_status) {
            if ($group_id > 0) {
                //List of group contacts
                $Contacts = Contact::where('created_by', '=', Auth::user()->id)->where('group_id', '=',
                    $group_id)->orderby('id',
                    'desc')->paginate(config('smartend.backend_pagination'));
            } elseif ($group_id == "wait") {
                //List waiting activation Contacts
                $Contacts = Contact::where('created_by', '=', Auth::user()->id)->where('status', '=',
                    '0')->orderby('id',
                    'desc')->paginate(config('smartend.backend_pagination'));
            } elseif ($group_id == "blocked") {
                //List waiting activation Contacts
                $Contacts = Contact::where('created_by', '=', Auth::user()->id)->where('status', '=',
                    '2')->orderby('id',
                    'desc')->paginate(config('smartend.backend_pagination'));
            } else {
                //List of all contacts
                $Contacts = Contact::where('created_by', '=', Auth::user()->id)->orderby('id',
                    'desc')->paginate(config('smartend.backend_pagination'));
            }
        } else {
            if ($group_id > 0) {
                //List of group contacts
                $Contacts = Contact::where('group_id', '=', (int)$group_id)->orderby('id',
                    'desc')->paginate(config('smartend.backend_pagination'));
            } elseif ($group_id == "wait") {
                //List waiting activation Contacts
                $Contacts = Contact::where('status', '=', '0')->orderby('id',
                    'desc')->paginate(config('smartend.backend_pagination'));
            } elseif ($group_id == "blocked") {
                //List waiting activation Contacts
                $Contacts = Contact::where('status', '=', '2')->orderby('id',
                    'desc')->paginate(config('smartend.backend_pagination'));
            } else {
                //List of all contacts
                $Contacts = Contact::orderby('id', 'desc')->paginate(config('smartend.backend_pagination'));
            }
        }

        if (@Auth::user()->permissionsGroup->view_status) {
            //Count of waiting activation Contacts
            $WaitContactsCount = Contact::where('created_by', '=', Auth::user()->id)->where('status', '=',
                '0')->count();

            //Count of Blocked Contacts
            $BlockedContactsCount = Contact::where('created_by', '=', Auth::user()->id)->where('status', '=',
                '2')->count();

            //Count of All Contacts
            $AllContactsCount = Contact::where('created_by', '=', Auth::user()->id)->count();
        } else {
            //Count of waiting activation Contacts
            $WaitContactsCount = Contact::where('status', '=', '0')->count();

            //Count of Blocked Contacts
            $BlockedContactsCount = Contact::where('status', '=', '2')->count();

            //Count of All Contacts
            $AllContactsCount = Contact::count();
        }


        $search_word = "";

        return view("dashboard.contacts.list",
            compact("Contacts", "GeneralWebmasterSections", "ContactsGroups", "Countries", "WaitContactsCount",
                "BlockedContactsCount", "AllContactsCount", "group_id", "search_word"));
    }

    public function search(Request $request)
    {
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        //List of groups
        if (@Auth::user()->permissionsGroup->view_status) {
            $ContactsGroups = ContactsGroup::where('created_by', '=', Auth::user()->id)->orderby('id', 'asc')->get();
        } else {
            $ContactsGroups = ContactsGroup::orderby('id', 'asc')->get();
        }

        //List of Countries
        $Countries = Country::orderby('title_' . @Helper::currentLanguage()->code, 'asc')->get();

        if (@Auth::user()->permissionsGroup->view_status) {
            if ($request->q != "") {
                //find Contacts
                $Contacts = Contact::where('created_by', '=', Auth::user()->id)->where('first_name', 'like',
                    '%' . $request->q . '%')
                    ->orwhere('last_name', 'like', '%' . $request->q . '%')
                    ->orwhere('company', 'like', '%' . $request->q . '%')
                    ->orwhere('city', 'like', '%' . $request->q . '%')
                    ->orwhere('notes', 'like', '%' . $request->q . '%')
                    ->orwhere('phone', '=', $request->q)
                    ->orwhere('email', '=', $request->q)
                    ->orderby('id', 'desc')->paginate(config('smartend.backend_pagination'));
            } else {
                //List of all contacts
                $Contacts = Contact::where('created_by', '=', Auth::user()->id)->orderby('id',
                    'desc')->paginate(config('smartend.backend_pagination'));
            }
        } else {
            if ($request->q != "") {
                //find Contacts
                $Contacts = Contact::where('first_name', 'like', '%' . $request->q . '%')
                    ->orwhere('last_name', 'like', '%' . $request->q . '%')
                    ->orwhere('company', 'like', '%' . $request->q . '%')
                    ->orwhere('city', 'like', '%' . $request->q . '%')
                    ->orwhere('notes', 'like', '%' . $request->q . '%')
                    ->orwhere('phone', '=', $request->q)
                    ->orwhere('email', '=', $request->q)
                    ->orderby('id', 'desc')->paginate(config('smartend.backend_pagination'));
            } else {
                //List of all contacts
                $Contacts = Contact::orderby('id', 'desc')->paginate(config('smartend.backend_pagination'));
            }
        }
        if (@Auth::user()->permissionsGroup->view_status) {
            //Count of waiting activation Contacts
            $WaitContactsCount = Contact::where('created_by', '=', Auth::user()->id)->where('status', '=',
                '0')->count();

            //Count of Blocked Contacts
            $BlockedContactsCount = Contact::where('created_by', '=', Auth::user()->id)->where('status', '=',
                '2')->count();

            //Count of All Contacts
            $AllContactsCount = Contact::where('created_by', '=', Auth::user()->id)->count();
        } else {
            //Count of waiting activation Contacts
            $WaitContactsCount = Contact::where('status', '=', '0')->count();

            //Count of Blocked Contacts
            $BlockedContactsCount = Contact::where('status', '=', '2')->count();

            //Count of All Contacts
            $AllContactsCount = Contact::count();
        }
        $group_id = "";
        $search_word = $request->q;

        return view("dashboard.contacts.list",
            compact("Contacts", "GeneralWebmasterSections", "ContactsGroups", "Countries", "WaitContactsCount",
                "BlockedContactsCount", "AllContactsCount", "group_id", "search_word"));
    }

    public function storeGroup(Request $request)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        $ContactsGroup = new ContactsGroup;
        $ContactsGroup->name = strip_tags($request->name);
        $ContactsGroup->created_by = Auth::user()->id;
        $ContactsGroup->save();

        return redirect()->action('Dashboard\ContactsController@index');
    }

    // public function store(Request $request)
    // {
    //     // Check Permissions
    //     if (!@Auth::user()->permissionsGroup->add_status) {
    //         return Redirect::to(route('NoPermission'))->send();
    //     }

    //     //
    //     $this->validate($request, [
    //         'email' => 'email|required|unique:users,email',
    //         'phone' => 'required|unique:contacts,phone',
    //         'file'  => 'image'
    //     ]);

    //     // Start of Upload Files
    //     $formFileName = "file";
    //     $fileFinalName_ar = "";
    //     if ($request->$formFileName != "") {
    //         $fileFinalName_ar = time() . rand(1111,
    //                 9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
    //         $path = $this->getUploadPath();
    //         $request->file($formFileName)->move($path, $fileFinalName_ar);

    //         // resize & optimize
    //         Helper::imageResize($path.$fileFinalName_ar);
    //         Helper::imageOptimize($path.$fileFinalName_ar);
    //     }
    //     // End of Upload Files

    //     $Contact = new Contact;
    //     $Contact->group_id = $request->group_id;
    //     $Contact->first_name = strip_tags($request->first_name);
    //     $Contact->last_name = strip_tags($request->last_name);
    //     $Contact->company = strip_tags($request->company);
    //     $Contact->email = strip_tags($request->email);
    //     $Contact->password = $request->password;
    //     $Contact->phone = $request->phone;
    //     $Contact->country_id = $request->country_id;
    //     $Contact->city = $request->city;
    //     $Contact->address = strip_tags($request->address);
    //     $Contact->photo = $fileFinalName_ar;
    //     $Contact->notes = $request->notes;
    //     $Contact->status = 1;
    //     $Contact->created_by = Auth::user()->id;
    //     $Contact->save();
    //     $user = User::create([
    //         'name' => $Contact->first_name,
    //         'email' => $Contact->email,
    //         'password' => Hash::make('123456'),
    //         'permissions_id' => 1, 
    //         'contact_id'    => $Contact->id,
    //     ]);

    //     return redirect()->action('Dashboard\ContactsController@index');
    // }

    public function store(Request $request)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }

        // Validation
        $this->validate($request, [
            'email' => 'email|required|unique:users,email',
            'phone' => 'required|unique:contacts,phone',
            'file'  => 'nullable|image',
            'nid_front'   => 'nullable|image',
            'nid_back'    => 'nullable|image',
            'nid_no' => 'nullable|digits_between:10,17',             
            'passport_no' => 'nullable|alpha_num|max:9',                 
            'birth_certificate_no' => 'nullable|digits_between:10,17', 
        ]);

        // Upload Helper Function
        $uploadFile = function ($inputName) use ($request) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $fileFinalName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                $path = $this->getUploadPath();
                $file->move($path, $fileFinalName);

                // resize & optimize
                Helper::imageResize($path.$fileFinalName);
                Helper::imageOptimize($path.$fileFinalName);

                return $fileFinalName;
            }
            return null;
        };

        $photoFile     = $uploadFile('file');
        $nidFrontFile  = $uploadFile('nid_front');
        $nidBackFile   = $uploadFile('nid_back');

        $Contact = new Contact;
        $Contact->first_name = strip_tags($request->first_name);
        $Contact->last_name = strip_tags($request->last_name);
        $Contact->email = strip_tags($request->email);
        $Contact->phone = $request->phone;
        $Contact->nid_no = $request->nid_no;
        $Contact->passport_no = $request->passport_no;
        $Contact->birth_certificate_no = $request->birth_certificate_no;
        $Contact->photo = $photoFile;
        $Contact->nid_front = $nidFrontFile;
        $Contact->nid_back = $nidBackFile;
        $Contact->notes = $request->notes;
        $Contact->status = 1;
        $Contact->created_by = Auth::user()->id;
        $Contact->save();

        User::create([
            'name' => trim($Contact->first_name . ' ' . $Contact->last_name),
            'email' => $Contact->email,
            'password' => Hash::make('123456'),
            'permissions_id' => 1,
            'contact_id' => $Contact->id,
        ]);

        return redirect()->action('Dashboard\ContactsController@index');
    }


    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = Config::get('app.APP_URL') . $uploadPath;
    }

    public function edit($id)
    {
        //
        $ContactToEdit = Contact::find($id);
        if (!empty($ContactToEdit)) {
            return redirect()->action('Dashboard\ContactsController@index', $ContactToEdit->group_id)->with('ContactToEdit',
                $ContactToEdit);
        } else {
            return redirect()->action('Dashboard\ContactsController@index');
        }
    }

    public function editGroup($id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->edit_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        if (@Auth::user()->permissionsGroup->view_status) {
            $EditContactsGroup = ContactsGroup::where('created_by', '=', Auth::user()->id)->find($id);
        } else {
            $EditContactsGroup = ContactsGroup::find($id);
        }
        if (!empty($EditContactsGroup)) {
            return redirect()->action('Dashboard\ContactsController@index')->with('EditContactsGroup', $EditContactsGroup);
        } else {
            return redirect()->action('Dashboard\ContactsController@index');
        }
    }

    public function update(Request $request, $id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->edit_status) {
            return Redirect::to(route('NoPermission'))->send();
        }

        // Fetch contact
        if (@Auth::user()->permissionsGroup->view_status) {
            $Contact = Contact::where('created_by', '=', Auth::user()->id)->find($id);
        } else {
            $Contact = Contact::find($id);
        }

        if (empty($Contact)) {
            return redirect()->action('Dashboard\ContactsController@index');
        }

        // Validation
        $this->validate($request, [
            'email' => 'required|email',
            'file' => 'nullable|image',
            'nid_front' => 'nullable|image',
            'nid_back' => 'nullable|image',
            'passport_no' => 'nullable|alpha_num|max:9',
            'nid_no' => 'nullable|numeric',
            'birth_certificate_no' => 'nullable|numeric',
        ]);

        // Helper function for file upload
        $uploadFile = function ($fileInputName, $oldFile = null) {
            if ($fileInputName && request()->hasFile($fileInputName)) {
                $file = request()->file($fileInputName);
                $fileName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                $path = public_path('uploads/contacts/');
                $file->move($path, $fileName);

                // Resize & optimize
                Helper::imageResize($path.$fileName);
                Helper::imageOptimize($path.$fileName);

                // Delete old file
                if ($oldFile && File::exists($path.$oldFile)) {
                    File::delete($path.$oldFile);
                }

                return $fileName;
            }
            return $oldFile; // keep old if no new upload
        };

        // Update files
        $Contact->photo = $uploadFile('file', $Contact->photo);
        $Contact->nid_front = $uploadFile('nid_front', $Contact->nid_front);
        $Contact->nid_back = $uploadFile('nid_back', $Contact->nid_back);

        // Update other fields
        $Contact->first_name = strip_tags($request->first_name);
        $Contact->last_name = strip_tags($request->last_name);
        $Contact->email = strip_tags($request->email);
        $Contact->phone = $request->phone;
        $Contact->notes = $request->notes;
        $Contact->passport_no = $request->passport_no;
        $Contact->nid_no = $request->nid_no;
        $Contact->birth_certificate_no = $request->birth_certificate_no;
        $Contact->status = $request->status;
        $Contact->updated_by = Auth::user()->id;
        $Contact->save();

        $user = User::where('contact_id', $id)->first();
        if ($user) {
            $user->name = trim($Contact->first_name . ' ' . $Contact->last_name);
            $user->email = $Contact->email;
            $user->save();
        }

        // return redirect()->action('Dashboard\ContactsController@index')
        //                 ->with('ContactToEdit', $Contact)
        //                 ->with('doneMessage2', __('backend.saveDone'));
        return redirect()->action('Dashboard\ContactsController@index')
                         ->with('ContactToEdit', Contact::find($id))
                         ->with('doneMessage2', __('backend.saveDone'));

    }


    public function updateGroup(Request $request, $id)
    {
        //
        $ContactsGroup = ContactsGroup::find($id);
        if (!empty($ContactsGroup)) {
            $ContactsGroup->name = strip_tags($request->name);
            $ContactsGroup->updated_by = Auth::user()->id;
            $ContactsGroup->save();
        }
        return redirect()->action('Dashboard\ContactsController@index');
    }

    public function destroy($id)
    {
        if (!@Auth::user()->permissionsGroup->delete_status) {
            return Redirect::to(route('NoPermission'))->send();
        }

        if (@Auth::user()->permissionsGroup->view_status) {
            $Contact = Contact::where('created_by', '=', Auth::user()->id)->find($id);
        } else {
            $Contact = Contact::find($id);
        }

        if (!empty($Contact)) {
            if ($Contact->photo != "") {
                File::delete($this->getUploadPath() . $Contact->photo);
            }

            $user = User::where('contact_id', $Contact->id)->first();
            if ($user) {
                $user->delete();
            }

            $Contact->delete();
        }

        return redirect()->action('Dashboard\ContactsController@index');
    }


    public function destroyGroup($id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->delete_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        if (@Auth::user()->permissionsGroup->view_status) {
            $ContactsGroup = ContactsGroup::where('created_by', '=', Auth::user()->id)->find($id);
        } else {
            $ContactsGroup = ContactsGroup::find($id);
        }
        if (!empty($ContactsGroup)) {
            $ContactsGroup->delete();
            return redirect()->action('Dashboard\ContactsController@index');
        } else {
            return redirect()->action('Dashboard\ContactsController@index');
        }
    }

    public function updateAll(Request $request)
    {
        //
        if ($request->ids != "") {
            if ($request->action == "activate") {
                Contact::wherein('id', $request->ids)
                    ->update(['status' => 1]);

            } elseif ($request->action == "block") {
                Contact::wherein('id', $request->ids)
                    ->update(['status' => 0]);

            } elseif ($request->action == "delete") {
                // Check Permissions
                if (!@Auth::user()->permissionsGroup->delete_status) {
                    return Redirect::to(route('NoPermission'))->send();
                }
                // Delete Contacts file
                $Contacts = Contact::wherein('id', $request->ids)->get();
                foreach ($Contacts as $Contact) {
                    if ($Contact->photo != "") {
                        File::delete($this->getUploadPath() . $Contact->photo);
                    }
                }

                Contact::wherein('id', $request->ids)
                    ->delete();

            }
        }
        return redirect()->action('Dashboard\ContactsController@index')->with('doneMessage', __('backend.saveDone'));
    }


}
