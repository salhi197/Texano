<?php
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use App\User;
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


Route::get('/clear', function () {
    $middleware = Artisan::call('migrate:refresh');
    echo "done from creating the middleware !! ";
});


// when user is authenticated don't show him the welcome page
Route::group(array('after' => 'auth'), function() {

    Route::get('/', function () {
        return redirect('text');

    })->middleware(['lang','auth']);

});

// when user is not authenticated (= guest) show him the welcome page
Route::group(array('middleware' => 'guest'), function() {

    Route::get('/', function () {
        return view('welcome');
    })->middleware('lang');

});

Auth::routes(['verify' => true]);
//show upload file view 
Route::get('/text/upload-file', 'TextController@upload')->name('upload')->middleware(['auth','lang','cors']);

//post method to send ajax request ..
Route::post('/autosave', 'TextController@autosave')->middleware(['auth']);

//Route::get('/home', 'TextController@index')->name('home')->middleware(['auth','lang','cors']);
Route::post('/text/{id}', 'TextController@editAndStore')->name('text.editAndStore')->middleware(['auth','lang','cors']);
Route::resource('text','TextController')->middleware(['auth','lang','cors']);

//========================================= delete multiple elements =================================================  

Route::post('/text/delete/elements', 'TextController@destroy_s')->name('text.destroy_s')->middleware(['auth','lang','cors']);

//Route::get('/my-account/tab/{tab}', 'TextController@home')->name('dashboard')->middleware(['auth','lang','cors']);



//========================================= Home settings , user dashboard =================================================  

Route::get('/my-account/tab/{tab}', 'HomeController@index')->name('home')->middleware(['auth','lang','cors']);

Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

//========================================= internalisation=================================================  
Route::get('/lang/{lang}', 'LangController@setLang')->middleware(['auth','lang','cors']);

//========================================= payment =================================================  

Route::get('profile/membership', 'ProfileController@membership')->name('membership')->middleware('auth');
Route::post('profile/upgrade', 'ProfileController@updgrade');
Route::post('upgrade', 'SubscriptionController@upgradeToPro')->name('upgrade')->middleware(['auth','lang','cors']);
Route::post('contact', 'SubscriptionController@contact')->name('contact')->middleware(['auth','lang','cors']);

//========================================= Rest API Route =================================================  

Route::post('/classify', 'ClassifyController@classify')->middleware(['auth','lang']);

//========================================= Update Password =================================================  

Route::post('/update/password', 'UserController@updatePassword')->name('update-password')->middleware(['auth','lang']);


Auth::routes();


//========================================= paypal =================================================  
Route::post('/paypal/api/create-payment', 'PaypalController@create')->name('create-payment')->middleware(['auth','lang']);
Route::post('/paypal/api/execute-payment', 'PaypalController@execute')->name('execute-payment')->middleware(['auth','lang']);

//=============================================== sendmail ===============================================
