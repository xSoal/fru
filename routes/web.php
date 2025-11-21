<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


/* Telegram webhook */
Route::post('/webhook/telegram',['uses'=>'\App\Http\Controllers\Front\TelegramController@index','as'=>'front.telegram']);


/* Анкета */
Route::get('/questionary',['uses'=>'\App\Http\Controllers\Front\QuestionnaireController@index','as'=>'front.questionary']);
Route::post('/questionary',['uses'=>'\App\Http\Controllers\Front\QuestionnaireController@post','as'=>'front.postQuestionary']);

// API ROUTE
Route::group(['prefix' => 'api', 'middleware' => 'web'], function () {
    
    Route::post('/find-next-post', ['uses' => '\App\Http\Controllers\API\APIController@findNextPost']);

    // Admin API route
    Route::group(['prefix' => 'admin', 'middleware' => 'auth' ], function () {
        Route::post('/genslug', ['uses' => '\App\Http\Controllers\API\APIController@genSlug']);
        Route::post('/getUserInfo', ['uses' => '\App\Http\Controllers\API\APIController@getUserInfo']);
        Route::post('/change-active', ['uses' => '\App\Http\Controllers\API\APIController@changeActive']);
        Route::post('/create-row', ['uses' => '\App\Http\Controllers\API\APIController@createRow']);
        Route::post('/remove-row', ['uses' => '\App\Http\Controllers\API\APIController@removeRow']);
        Route::post('/update-row-name', ['uses' => '\App\Http\Controllers\API\APIController@updateRowName']);
        Route::post('/update-row-color', ['uses' => '\App\Http\Controllers\API\APIController@updateRowColor']);
    });
});
//--------------------------------


// Авторизация
Auth::routes();


// main route
Route::group(['prefix' => '/admin', 'middleware' => 'auth'], function() {


    Route::get('/',function(){
        $data = [
            'title' => 'Особистий кабінет',
        ];
        return view('admin.index',$data);
    });


    Route::group(['prefix' => 'users'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\UsersController@list', 'as' => 'admin.users']);
        Route::get('/add', ['uses' => '\App\Http\Controllers\Admin\UsersController@add', 'as' => 'admin.addUser']);
        Route::get('/{id}', ['uses' => '\App\Http\Controllers\Admin\UsersController@view', 'as' => 'admin.viewUser']);
        Route::post('/', ['uses' => '\App\Http\Controllers\Admin\UsersController@post', 'as' => 'admin.postUsers']);
    });


    Route::group(['prefix' => 'post'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\PostController@list', 'as' => 'admin.post']);
        Route::get('/add', ['uses' => '\App\Http\Controllers\Admin\PostController@add', 'as' => 'admin.addPost']);
        Route::get('/{id}', ['uses' => '\App\Http\Controllers\Admin\PostController@view', 'as' => 'admin.viewPost']);
        Route::post('/', ['uses' => '\App\Http\Controllers\Admin\PostController@post', 'as' => 'admin.postPost']);
    });


    Route::group(['prefix' => 'questionnaire'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\QuestionnaireController@list', 'as' => 'admin.questionnaire']);
        Route::get('/{id}', ['uses' => '\App\Http\Controllers\Admin\QuestionnaireController@view', 'as' => 'admin.viewQuestionnaire']);
        Route::post('/', ['uses' => '\App\Http\Controllers\Admin\QuestionnaireController@post', 'as' => 'admin.postQuestionnaire']);
    });

    Route::group(['prefix' => 'ats'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\ATSController@list', 'as' => 'admin.ats']);
        Route::post('/', ['uses' => '\App\Http\Controllers\Admin\ATSController@post', 'as' => 'admin.postATS']);
    });

    Route::group(['prefix' => 'project'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\ProjectController@list', 'as' => 'admin.project']);
        
        Route::get('/add', ['uses' => '\App\Http\Controllers\Admin\ProjectController@add', 'as' => 'admin.addProject']);
        Route::get('/{id}', ['uses' => '\App\Http\Controllers\Admin\ProjectController@view', 'as' => 'admin.viewProject']);
        Route::get('/{id}/kpp', ['uses' => '\App\Http\Controllers\Admin\ProjectController@projectKPP', 'as' => 'admin.projectKPP']);
        Route::get('/{id}/schedule', ['uses' => '\App\Http\Controllers\Admin\ProjectController@schedule', 'as' => 'admin.schedule']);
        Route::get('/{id}/limit', ['uses' => '\App\Http\Controllers\Admin\ProjectController@limit', 'as' => 'admin.limit']);
        Route::get('/{id}/expedition', ['uses' => '\App\Http\Controllers\Admin\ProjectController@expedition', 'as' => 'admin.expedition']);

        Route::post('/', ['uses' => '\App\Http\Controllers\Admin\ProjectController@post', 'as' => 'admin.postProject']);
    });


    Route::group(['prefix' => 'news'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\NewsController@list', 'as' => 'admin.news']);
        Route::get('/add', ['uses' => '\App\Http\Controllers\Admin\NewsController@add', 'as' => 'admin.addNews']);
        Route::get('/{id}', ['uses' => '\App\Http\Controllers\Admin\NewsController@view', 'as' => 'admin.viewNews']);

        Route::post('/', ['uses' => '\App\Http\Controllers\Admin\NewsController@post', 'as' => 'admin.postNews']);

    });

    Route::group(['prefix' => 'companies'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\CompaniesController@list', 'as' => 'admin.companies']);
        Route::get('/add', ['uses' => '\App\Http\Controllers\Admin\CompaniesController@add', 'as' => 'admin.addCompany']);
        Route::get('/{id}', ['uses' => '\App\Http\Controllers\Admin\CompaniesController@view', 'as' => 'admin.viewCompany']);
        Route::post('/', ['uses' => '\App\Http\Controllers\Admin\CompaniesController@post', 'as' => 'admin.postCompany']);
    });

    Route::group(['prefix' => 'clients'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\ClientsController@list', 'as' => 'admin.clients']);
        Route::get('/add', ['uses' => '\App\Http\Controllers\Admin\ClientsController@add', 'as' => 'admin.addClient']);
        Route::get('/{id}', ['uses' => '\App\Http\Controllers\Admin\ClientsController@view', 'as' => 'admin.viewClient']);
        Route::post('/', ['uses' => '\App\Http\Controllers\Admin\ClientsController@post', 'as' => 'admin.postClient']);
    });

});


Route::group(['prefix' => '/messenger', 'middleware' => 'auth'], function() {
    Route::get('/{id}', ['uses' => '\App\Http\Controllers\MessengerController@index', 'as' => 'messenger']);
});


Route::group(['prefix' => 'companyAdmin', 'middleware' => 'roleCompany.auth'], function () {
    Route::get('/', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@index', 'as' => 'admin.companyAdmin']);
    Route::get('/clients/{id}', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@client', 'as' => 'admin.companyAdminClient']);
    Route::get('/search', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@search', 'as' => 'admin.companySearch']);
    
    Route::post('/addMessage', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@addMessage', 'as' => 'admin.companyAddMessage']);
});

Route::group(['prefix' => 'clientAdmin', 'middleware' => 'roleClient.auth'], function () {
    Route::get('/', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@index', 'as' => 'admin.clientAdmin']);
    Route::get('/partners', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@partnersList', 'as' => 'admin.clientAdminPartners']);
    Route::get('/partners/{id}', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@partnerSingle', 'as' => 'admin.clientAdminPartnerSingle']);

    Route::post('/addEquipmentRequest', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@addRequestEquipment', 'as' => 'admin.clientAdminAddRequest']);
    Route::post('/editEquipmentRequest', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@editRequestEquipment', 'as' => 'admin.clientAdminEditRequest']);
    Route::post('/addMessage', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@addMessage', 'as' => 'admin.clientAddMessage']);
});




Route::group(['prefix' => 'news'], function() {
    Route::get('/', ['uses' => '\App\Http\Controllers\MainPage\NewsController@allNews', 'as' => 'main_page.news']);
    Route::get('/{slug}', ['uses' => '\App\Http\Controllers\MainPage\NewsController@single', 'as' => 'main_page.singleNews']);
});

Route::get('/search', ['uses' => '\App\Http\Controllers\MainPage\SearchController@index', 'as' => 'main_page.search']);
Route::get('/contacts', ['uses' => '\App\Http\Controllers\MainPage\ContactsController@index', 'as' => 'main_page.contacts']);


Route::get('/', ['uses' => '\App\Http\Controllers\MainPage\MainPageController@index', 'as' => 'main_page']);


