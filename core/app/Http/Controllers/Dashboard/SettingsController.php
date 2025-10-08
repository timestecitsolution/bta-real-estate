<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Setting;
use App\Models\WebmasterSection;
use Auth;
use File;
use Illuminate\Http\Request;
use Redirect;
use Helper;

class SettingsController extends Controller
{
    // Define Default Settings ID
    private $uploadPath = "uploads/settings/";

    public function __construct()
    {
        $this->middleware('auth');

        // Check Permissions
        if (!@Auth::user()->permissionsGroup->settings_status || !Helper::GeneralWebmasterSettings("settings_status")) {
            return Redirect::to(route('NoPermission'))->send();
        }

        \Session()->forget('_Loader_Web_Settings');

    }

    public function edit()
    {
        //

        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        $id = 1;
        $Setting = Setting::find($id);
        if (!empty($Setting)) {
            return view("dashboard.settings.settings", compact("Setting", "GeneralWebmasterSections"));

        } else {
            return redirect()->route('adminHome');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id = 1 for default settings
     * @return \Illuminate\Http\Response
     */
    public function updateSiteInfo(Request $request)
    {
        //
        $id = 1;
        $Setting = Setting::find($id);
        if (!empty($Setting)) {

            $this->validate($request, [
                'style_logo_en' => 'image',
                'style_logo_ar' => 'image',
                'style_fav' => 'image',
                'style_apple' => 'image',
                'style_bg_image' => 'image',
                'style_footer_bg' => 'image',
                'banner_image' => 'image',
            ]);
            foreach (Helper::languagesList() as $ActiveLanguage) {

                // Start of Upload Files
                $formFileName = "style_logo_" . $ActiveLanguage->code;
                $fileFinalName = "";
                if ($request->$formFileName != "") {
                    $this->validate($request, [
                        $formFileName => 'image'
                    ]);

                    $fileFinalName = time() . rand(1111,
                            9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
                    $path = $this->uploadPath;
                    $request->file($formFileName)->move($path, $fileFinalName);
                }

                //save file name
                if ($fileFinalName != "") {
                    // Delete a banner file
                    if ($Setting->{"style_logo_" . $ActiveLanguage->code} != "" && $Setting->{"style_logo_" . $ActiveLanguage->code} != "nologo.png") {
                        File::delete($this->uploadPath . $Setting->{"style_logo_" . $ActiveLanguage->code});
                    }

                    $Setting->{"style_logo_" . $ActiveLanguage->code} = $fileFinalName;
                }

                $Setting->{"site_title_" . $ActiveLanguage->code} = strip_tags($request->{"site_title_" . $ActiveLanguage->code});
                $Setting->{"site_desc_" . $ActiveLanguage->code} = strip_tags($request->{"site_desc_" . $ActiveLanguage->code});
                $Setting->{"site_keywords_" . $ActiveLanguage->code} = strip_tags($request->{"site_keywords_" . $ActiveLanguage->code});
                $Setting->{"contact_t1_" . $ActiveLanguage->code} = strip_tags($request->{"contact_t1_" . $ActiveLanguage->code});
                $Setting->{"contact_t7_" . $ActiveLanguage->code} = strip_tags($request->{"contact_t7_" . $ActiveLanguage->code});
            }
            $Setting->site_webmails = $request->site_webmails;
            $Setting->notify_messages_status = $request->notify_messages_status;
            $Setting->notify_comments_status = $request->notify_comments_status;
            $Setting->notify_orders_status = $request->notify_orders_status;
            $Setting->notify_table_status = $request->notify_table_status;
            $Setting->notify_private_status = $request->notify_private_status;
            $Setting->site_url = $request->site_url;


            $formFileName2 = "style_fav";
            $fileFinalName2 = "";
            if ($request->$formFileName2 != "") {
                // Delete a style_fav photo
                if ($Setting->style_fav != "" && $Setting->style_fav != "nofav.png") {
                    File::delete($this->uploadPath . $Setting->style_fav);
                }

                $fileFinalName2 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName2)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName2)->move($path, $fileFinalName2);
            }


            $formFileName3 = "style_apple";
            $fileFinalName3 = "";
            if ($request->$formFileName3 != "") {
                // Delete a style_apple photo
                if ($Setting->style_apple != "" && $Setting->style_apple != "nofav.png") {
                    File::delete($this->uploadPath . $Setting->style_apple);
                }

                $fileFinalName3 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName3)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName3)->move($path, $fileFinalName3);
            }


            $formFileName4 = "style_bg_image";
            $fileFinalName4 = "";
            if ($request->$formFileName4 != "") {
                // Delete a style_bg_image photo
                if ($Setting->style_bg_image != "") {
                    File::delete($this->uploadPath . $Setting->style_bg_image);
                }

                $fileFinalName4 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName4)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName4)->move($path, $fileFinalName4);
            }


            $formFileName5 = "style_footer_bg";
            $fileFinalName5 = "";
            if ($request->$formFileName5 != "") {
                // Delete a style_footer_bg photo
                if ($Setting->style_footer_bg != "" && $Setting->style_footer_bg != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->style_footer_bg);
                }

                $fileFinalName5 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName5)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName5)->move($path, $fileFinalName5);
            }


            

            // End of Upload Files
            if ($fileFinalName2 != "") {
                $Setting->style_fav = $fileFinalName2;
            }
            if ($fileFinalName3 != "") {
                $Setting->style_apple = $fileFinalName3;
            }

            $Setting->style_color1 = $request->style_color1;
            $Setting->style_color2 = $request->style_color2;
            $Setting->style_color3 = $request->style_color3;
            $Setting->style_color4 = $request->style_color4;
            $Setting->style_type = ($request->style_type) ? 1 : 0;
            $Setting->style_change = ($request->style_change) ? 1 : 0;
            $Setting->style_bg_type = $request->style_bg_type;
            $Setting->style_bg_pattern = $request->style_bg_pattern;
            $Setting->style_bg_color = $request->style_bg_color;
            if ($fileFinalName4 != "") {
                $Setting->style_bg_image = $fileFinalName4;
            }
            $Setting->style_subscribe = $request->style_subscribe;
            $Setting->style_footer = $request->style_footer;
            $Setting->style_header = $request->style_header;
            if ($request->photo_delete == 1) {
                // Delete style_footer_bg
                if ($Setting->style_footer_bg != "" && $Setting->style_footer_bg != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->style_footer_bg);
                }

                $Setting->style_footer_bg = "";
            }


            

            if ($fileFinalName5 != "") {
                $Setting->style_footer_bg = $fileFinalName5;
            }

            


            $Setting->style_preload = $request->style_preload;
            $Setting->css = $request->css_code;
            $Setting->js = $request->js_code;
            $Setting->body = $request->body_code;

            $Setting->social_link1 = $request->social_link1;
            $Setting->social_link2 = $request->social_link2;
            $Setting->social_link3 = $request->social_link3;
            $Setting->social_link4 = $request->social_link4;
            $Setting->social_link5 = $request->social_link5;
            $Setting->social_link6 = $request->social_link6;
            $Setting->social_link7 = $request->social_link7;
            $Setting->social_link8 = $request->social_link8;
            $Setting->social_link9 = $request->social_link9;
            $Setting->social_link10 = $request->social_link10;

            $Setting->contact_t3 = $request->contact_t3;
            $Setting->contact_t4 = $request->contact_t4;
            $Setting->contact_t5 = $request->contact_t5;
            $Setting->contact_t6 = $request->contact_t6;

            $Setting->site_status = $request->site_status;
            $Setting->close_msg = $request->close_msg;

            // setting by mamun start

            $formFileName6 = "banner_image";
            $fileFinalName6 = "";
            if ($request->$formFileName6 != "") {
                // Delete a banner_image photo
                if ($Setting->banner_image != "" && $Setting->banner_image != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->banner_image);
                }

                $fileFinalName6 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName6)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName6)->move($path, $fileFinalName6);
            }


            if ($request->photo_delete_bi == 1) {
                // Delete banner_image
                if ($Setting->banner_image != "" && $Setting->banner_image != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->banner_image);
                }
                $Setting->banner_image = "";
            }



            if ($fileFinalName6 != "") {
                $Setting->banner_image = $fileFinalName6;
            }

            $Setting->banner_title = $request->banner_title;
            $Setting->banner_heading = $request->banner_heading;
            $Setting->banner_description = $request->banner_description;
            $Setting->banner_button_link = $request->banner_button_link;



            $formFileName7 = "about_us_image";
            $fileFinalName7 = "";
            if ($request->$formFileName7 != "") {
                // Delete a about_us_image photo
                if ($Setting->about_us_image != "" && $Setting->about_us_image != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->about_us_image);
                }

                $fileFinalName7 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName7)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName7)->move($path, $fileFinalName7);
            }


            if ($request->photo_delete_bi == 1) {
                // Delete about_us_image
                if ($Setting->about_us_image != "" && $Setting->about_us_image != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->about_us_image);
                }
                $Setting->about_us_image = "";
            }



            if ($fileFinalName7 != "") {
                $Setting->about_us_image = $fileFinalName7;
            }

            $Setting->about_us_title = $request->about_us_title;
            $Setting->about_us_heading = $request->about_us_heading;
            $Setting->about_us_description = $request->about_us_description;
            $Setting->about_us_button_link = $request->about_us_button_link;



            $Setting->architecture_title1 = $request->architecture_title1;
            $Setting->architecture_title2 = $request->architecture_title2;
            $Setting->architecture_title3 = $request->architecture_title3;
            $Setting->architecture_title4 = $request->architecture_title4;

            $Setting->architecture_heading1 = $request->architecture_heading1;
            $Setting->architecture_heading2 = $request->architecture_heading2;
            $Setting->architecture_heading3 = $request->architecture_heading3;
            $Setting->architecture_heading4 = $request->architecture_heading4;


            $formFileName8 = "architecture_icon1";
            $fileFinalName8 = "";
            if ($request->$formFileName8 != "") {
                // Delete a architecture_icon1 photo
                if ($Setting->architecture_icon1 != "" && $Setting->architecture_icon1 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon1);
                }

                $fileFinalName8 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName8)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName8)->move($path, $fileFinalName8);
            }


            if ($request->photo_delete_ai1 == 1) {
                // Delete architecture_icon1
                if ($Setting->architecture_icon1 != "" && $Setting->architecture_icon1 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon1);
                }
                $Setting->architecture_icon1 = "";
            }



            if ($fileFinalName8 != "") {
                $Setting->architecture_icon1 = $fileFinalName8;
            }


            $formFileName9 = "architecture_icon2";
            $fileFinalName9 = "";
            if ($request->$formFileName9 != "") {
                // Delete a architecture_icon2 photo
                if ($Setting->architecture_icon2 != "" && $Setting->architecture_icon2 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon2);
                }

                $fileFinalName9 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName9)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName9)->move($path, $fileFinalName9);
            }


            if ($request->photo_delete_ai2 == 1) {
                // Delete architecture_icon2
                if ($Setting->architecture_icon2 != "" && $Setting->architecture_icon2 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon2);
                }
                $Setting->architecture_icon2 = "";
            }



            if ($fileFinalName9 != "") {
                $Setting->architecture_icon2 = $fileFinalName9;
            }

            $formFileName10 = "architecture_icon3";
            $fileFinalName10 = "";
            if ($request->$formFileName10 != "") {
                // Delete a architecture_icon3 photo
                if ($Setting->architecture_icon3 != "" && $Setting->architecture_icon3 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon3);
                }

                $fileFinalName10 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName10)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName10)->move($path, $fileFinalName10);
            }


            if ($request->photo_delete_ai3 == 1) {
                // Delete architecture_icon3
                if ($Setting->architecture_icon3 != "" && $Setting->architecture_icon3 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon3);
                }
                $Setting->architecture_icon3 = "";
            }



            if ($fileFinalName10 != "") {
                $Setting->architecture_icon3 = $fileFinalName10;
            }


            $formFileName11 = "architecture_icon4";
            $fileFinalName11 = "";
            if ($request->$formFileName11 != "") {
                // Delete a architecture_icon4 photo
                if ($Setting->architecture_icon4 != "" && $Setting->architecture_icon4 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon4);
                }

                $fileFinalName11 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName11)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName11)->move($path, $fileFinalName11);
            }


            if ($request->photo_delete_ai1 == 1) {
                // Delete architecture_icon4
                if ($Setting->architecture_icon4 != "" && $Setting->architecture_icon4 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon4);
                }
                $Setting->architecture_icon4 = "";
            }



            if ($fileFinalName11 != "") {
                $Setting->architecture_icon4 = $fileFinalName11;
            }





            $formFileName12 = "why_choose_us_image";
            $fileFinalName12 = "";
            if ($request->$formFileName12 != "") {
                // Delete a why_choose_us_image photo
                if ($Setting->why_choose_us_image != "" && $Setting->why_choose_us_image != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->why_choose_us_image);
                }

                $fileFinalName12 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName12)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName12)->move($path, $fileFinalName12);
            }


            if ($request->photo_delete_wcu == 1) {
                // Delete why_choose_us_image
                if ($Setting->why_choose_us_image != "" && $Setting->why_choose_us_image != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->why_choose_us_image);
                }
                $Setting->why_choose_us_image = "";
            }



            if ($fileFinalName12 != "") {
                $Setting->why_choose_us_image = $fileFinalName12;
            }

            $Setting->why_choose_us_title = $request->why_choose_us_title;
            $Setting->experience_years = $request->experience_years;
            $Setting->experience_years_title = $request->experience_years_title;
            $Setting->successful_projects = $request->successful_projects;
            $Setting->successful_projects_title = $request->successful_projects_title;
            $Setting->expert_title = $request->expert_title;
            $Setting->investment_title = $request->investment_title;
            $Setting->why_choose_us_heading = $request->why_choose_us_heading;
            $Setting->why_choose_us_description = $request->why_choose_us_description;
            $Setting->why_choose_us_button_link = $request->why_choose_us_button_link;
            $Setting->land_query_mail = $request->land_query_mail;










            $formFileName79 = "about_us_image9";
            $fileFinalName79 = "";
            if ($request->$formFileName79 != "") {
                // Delete a about_us_image9 photo
                if ($Setting->about_us_image9 != "" && $Setting->about_us_image9 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->about_us_image9);
                }

                $fileFinalName79 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName79)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName79)->move($path, $fileFinalName79);
            }


            if ($request->photo_delete_bi9 == 1) {
                // Delete about_us_image9
                if ($Setting->about_us_image9 != "" && $Setting->about_us_image9 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->about_us_image9);
                }
                $Setting->about_us_image9 = "";
            }



            if ($fileFinalName79 != "") {
                $Setting->about_us_image9 = $fileFinalName79;
            }

            $Setting->about_us_title9 = $request->about_us_title9;
            $Setting->about_us_heading9 = $request->about_us_heading9;
            $Setting->about_us_description9 = $request->about_us_description9;



            $Setting->architecture_title19 = $request->architecture_title19;
            $Setting->architecture_title29 = $request->architecture_title29;
            $Setting->architecture_title39 = $request->architecture_title39;
            $Setting->architecture_title49 = $request->architecture_title49;


            $formFileName89 = "architecture_icon19";
            $fileFinalName89 = "";
            if ($request->$formFileName89 != "") {
                // Delete a architecture_icon19 photo
                if ($Setting->architecture_icon19 != "" && $Setting->architecture_icon19 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon19);
                }

                $fileFinalName89 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName89)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName89)->move($path, $fileFinalName89);
            }


            if ($request->photo_delete_ai19 == 1) {
                // Delete architecture_icon19
                if ($Setting->architecture_icon19 != "" && $Setting->architecture_icon19 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon19);
                }
                $Setting->architecture_icon19 = "";
            }



            if ($fileFinalName89 != "") {
                $Setting->architecture_icon19 = $fileFinalName89;
            }


            $formFileName99 = "architecture_icon29";
            $fileFinalName99 = "";
            if ($request->$formFileName99 != "") {
                // Delete a architecture_icon29 photo
                if ($Setting->architecture_icon29 != "" && $Setting->architecture_icon29 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon29);
                }

                $fileFinalName99 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName99)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName99)->move($path, $fileFinalName99);
            }


            if ($request->photo_delete_ai29 == 1) {
                // Delete architecture_icon29
                if ($Setting->architecture_icon29 != "" && $Setting->architecture_icon29 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon29);
                }
                $Setting->architecture_icon29 = "";
            }



            if ($fileFinalName99 != "") {
                $Setting->architecture_icon29 = $fileFinalName99;
            }

            $formFileName109 = "architecture_icon39";
            $fileFinalName109 = "";
            if ($request->$formFileName109 != "") {
                // Delete a architecture_icon39 photo
                if ($Setting->architecture_icon39 != "" && $Setting->architecture_icon39 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon39);
                }

                $fileFinalName109 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName109)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName109)->move($path, $fileFinalName109);
            }


            if ($request->photo_delete_ai3 == 1) {
                // Delete architecture_icon39
                if ($Setting->architecture_icon39 != "" && $Setting->architecture_icon39 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon39);
                }
                $Setting->architecture_icon39 = "";
            }



            if ($fileFinalName109 != "") {
                $Setting->architecture_icon39 = $fileFinalName109;
            }


            $formFileName119 = "architecture_icon49";
            $fileFinalName119 = "";
            if ($request->$formFileName119 != "") {
                // Delete a architecture_icon49 photo
                if ($Setting->architecture_icon49 != "" && $Setting->architecture_icon49 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon49);
                }

                $fileFinalName119 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName119)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName119)->move($path, $fileFinalName119);
            }


            if ($request->photo_delete_ai4 == 1) {
                // Delete architecture_icon49
                if ($Setting->architecture_icon49 != "" && $Setting->architecture_icon49 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon49);
                }
                $Setting->architecture_icon49 = "";
            }



            if ($fileFinalName119 != "") {
                $Setting->architecture_icon49 = $fileFinalName119;
            }



            $Setting->architecture_title17 = $request->architecture_title17;
            $Setting->architecture_title27 = $request->architecture_title27;
            $Setting->architecture_title37 = $request->architecture_title37;
            $Setting->architecture_title47 = $request->architecture_title47;
            $Setting->architecture_title57 = $request->architecture_title57;
            $Setting->architecture_title67 = $request->architecture_title67;


            $Setting->architecture_heading17 = $request->architecture_heading17;
            $Setting->architecture_heading27 = $request->architecture_heading27;
            $Setting->architecture_heading37 = $request->architecture_heading37;
            $Setting->architecture_heading47 = $request->architecture_heading47;
            $Setting->architecture_heading57 = $request->architecture_heading57;
            $Setting->architecture_heading67 = $request->architecture_heading67;


            $formFileName17 = "architecture_icon17";
            $fileFinalName17 = "";
            if ($request->$formFileName17 != "") {
                // Delete a architecture_icon17 photo
                if ($Setting->architecture_icon17 != "" && $Setting->architecture_icon17 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon17);
                }

                $fileFinalName17 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName17)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName17)->move($path, $fileFinalName17);
            }


            if ($request->photo_delete_ai17 == 1) {
                // Delete architecture_icon17
                if ($Setting->architecture_icon17 != "" && $Setting->architecture_icon17 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon17);
                }
                $Setting->architecture_icon17 = "";
            }



            if ($fileFinalName17 != "") {
                $Setting->architecture_icon17 = $fileFinalName17;
            }


            $formFileName27 = "architecture_icon27";
            $fileFinalName27 = "";
            if ($request->$formFileName27 != "") {
                // Delete a architecture_icon27 photo
                if ($Setting->architecture_icon27 != "" && $Setting->architecture_icon27 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon27);
                }

                $fileFinalName27 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName27)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName27)->move($path, $fileFinalName27);
            }


            if ($request->photo_delete_ai27 == 1) {
                // Delete architecture_icon27
                if ($Setting->architecture_icon27 != "" && $Setting->architecture_icon27 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon27);
                }
                $Setting->architecture_icon27 = "";
            }



            if ($fileFinalName27 != "") {
                $Setting->architecture_icon27 = $fileFinalName27;
            }

            $formFileName37 = "architecture_icon37";
            $fileFinalName37 = "";
            if ($request->$formFileName37 != "") {
                // Delete a architecture_icon37 photo
                if ($Setting->architecture_icon37 != "" && $Setting->architecture_icon37 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon37);
                }

                $fileFinalName37 = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName37)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName37)->move($path, $fileFinalName37);
            }


            if ($request->photo_delete_ai37 == 1) {
                // Delete architecture_icon37
                if ($Setting->architecture_icon37 != "" && $Setting->architecture_icon37 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon37);
                }
                $Setting->architecture_icon37 = "";
            }



            if ($fileFinalName37 != "") {
                $Setting->architecture_icon37 = $fileFinalName37;
            }


            


            $formFileName47 = "architecture_icon47";
            $fileFinalName47 = "";
            if ($request->$formFileName47 != "") {
                // Delete architecture_icon47 photo
                if ($Setting->architecture_icon47 != "" && $Setting->architecture_icon47 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon47);
                }

                $fileFinalName47 = time() . rand(1111, 9999) . '.' . $request->file($formFileName47)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName47)->move($path, $fileFinalName47);
            }

            if ($request->photo_delete_ai47 == 1) {
                // Delete architecture_icon47
                if ($Setting->architecture_icon47 != "" && $Setting->architecture_icon47 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon47);
                }
                $Setting->architecture_icon47 = "";
            }

            if ($fileFinalName47 != "") {
                $Setting->architecture_icon47 = $fileFinalName47;
            }




            $formFileName57 = "architecture_icon57";
            $fileFinalName57 = "";
            if ($request->$formFileName57 != "") {
                // Delete architecture_icon57 photo
                if ($Setting->architecture_icon57 != "" && $Setting->architecture_icon57 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon57);
                }

                $fileFinalName57 = time() . rand(1111, 9999) . '.' . $request->file($formFileName57)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName57)->move($path, $fileFinalName57);
            }

            if ($request->photo_delete_ai57 == 1) {
                // Delete architecture_icon57
                if ($Setting->architecture_icon57 != "" && $Setting->architecture_icon57 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon57);
                }
                $Setting->architecture_icon57 = "";
            }

            if ($fileFinalName57 != "") {
                $Setting->architecture_icon57 = $fileFinalName57;
            }


            $formFileName67 = "architecture_icon67";
            $fileFinalName67 = "";
            if ($request->$formFileName67 != "") {
                // Delete architecture_icon67 photo
                if ($Setting->architecture_icon67 != "" && $Setting->architecture_icon67 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon67);
                }

                $fileFinalName67 = time() . rand(1111, 9999) . '.' . $request->file($formFileName67)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName67)->move($path, $fileFinalName67);
            }

            if ($request->photo_delete_ai67 == 1) {
                // Delete architecture_icon67
                if ($Setting->architecture_icon67 != "" && $Setting->architecture_icon67 != "footer-bg.webp") {
                    File::delete($this->uploadPath . $Setting->architecture_icon67);
                }
                $Setting->architecture_icon67 = "";
            }

            if ($fileFinalName67 != "") {
                $Setting->architecture_icon67 = $fileFinalName67;
            }







            // setting by mamun end


            $Setting->updated_by = Auth::user()->id;

            $Setting->save();
            return redirect()->action('Dashboard\SettingsController@edit')
                ->with('doneMessage', __('backend.saveDone'))
                ->with('active_tab', $request->active_tab);
        } else {
            return redirect()->route('adminHome');
        }
    }

}
