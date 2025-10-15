<?php

use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\SiteMapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandQueryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\EmiController;
use App\Http\Controllers\BulkSmsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Language Route
Route::post('/lang', [LanguageController::class, 'index'])->middleware('LanguageSwitcher')->name('lang');
// For Language direct URL link
Route::get('/lang/{lang}', [LanguageController::class, 'change'])->middleware('LanguageSwitcher')->name('langChange');
Route::get('/locale/{lang}', [LanguageController::class, 'locale'])->middleware('LanguageSwitcher')->name('localeChange');
// .. End of Language Route

// Not Found
Route::get('/{lang?}/404', [HomeController::class, 'page_404'])->name('NotFound');


// RSS Feed Routes
if (config('smartend.rss_status')) {
    Route::feeds();
}

// Social Auth
Route::get('/oauth/{driver}', [SocialAuthController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('/oauth/{driver}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');

Route::Group(['prefix' => config('smartend.backend_path')], function () {
    Auth::routes();
});

// Add your custom routes here
Route::post('/submit-land-query', [LandQueryController::class, 'submit'])->name('land.query.submit');
Route::get('/projects', [HomeController::class, 'projects'])->name('projects');
Route::get('/details/{project_id?}', [HomeController::class, 'details'])->name('details');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::post('/login-new', [BookingController::class, 'loginbookinguser'])->name('booking.loginbookinguser');
Route::get('/change-password', [ChangePassword::class, 'index'])->name('change-password')->middleware('user');
Route::post('/change-password', [ChangePassword::class, 'update'])->name('change-password.update')->middleware('user');

// Start of Frontend Routes
// - site map
Route::get('/sitemap.xml', [SiteMapController::class, 'siteMap'])->name('siteMap');
Route::get('/{lang}/sitemap', [SiteMapController::class, 'siteMap'])->name('siteMapByLang');

// - Public form submit
Route::post('/form-submit', [HomeController::class, 'form_submit'])->name('formSubmit');

// - Newsletter form submit
Route::post('/subscribe', [HomeController::class, 'subscribe_submit'])->name('subscribeSubmit');

// - Comment form submit
Route::post('/comment', [HomeController::class, 'comment_submit'])->name('commentSubmit');

// - Order form submit
Route::post('/order', [HomeController::class, 'order_submit'])->name('orderSubmit');

// - Contact page form submit
Route::post('/contact-submit', [HomeController::class, 'contact_submit'])->name('contactPageSubmit');
Route::post('/get-project-flats', [BookingController::class, 'getFlats'])->name('get.project.flats');

Route::middleware(['force.password.change'])->group(function() {
    Route::get('/dashboard-new', [BookingController::class, 'dashboard'])->name('dashboard-new')->middleware('user');
    Route::post('/dashboard-new', [BookingController::class, 'dashboard'])->name('dashboard-new-post')->middleware('user');
    Route::get('/emi/flat-details', [EmiController::class, 'getFlatDetails'])->name('emi.flat.details');
    Route::get('/emi/customer/flats', [EmiController::class, 'getCustomerFlats'])->name('emi.customer.flats');
    Route::post('/emi/store', [EmiController::class, 'storeEmi'])->name('emi.store');
    Route::get('/emiapprove/{id}', [EmiController::class, 'approve'])->name('emi.approve');
    Route::get('/emi/reject/{id}', [EmiController::class, 'reject'])->name('emi.reject');
    Route::delete('/emidelete/{id}', [EmiController::class, 'destroy'])->name('emi.destroy');

    Route::get('/emi/document/{id}', [EmiController::class, 'showDocument'])->name('emi.document.show');
    Route::get('/emi/document/{id}/download', [EmiController::class, 'downloadDocument'])->name('emi.document.download');
    Route::post('/send-sms', [BulkSmsController::class, 'bulksms'])->name('bulk.sms');

});

Route::get('/login-new', [BookingController::class, 'UserLogin'])->name('login-new');
Route::post('/user/logout', [BookingController::class, 'UserLogout'])->name('user.logout');

// - Tags
Route::get('/tag/{tag_slug?}', [HomeController::class, 'tag'])->name('tag');

// - All Other slugs
Route::get('/{part1?}/{part2?}/{part3?}/{part4?}/{part5?}/{part6?}', [HomeController::class, 'seo'])->name("frontendRoute");
// End of Frontend Route
