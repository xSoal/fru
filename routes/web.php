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

    Route::group(['prefix' => 'super_users'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\SuperUsersController@list', 'as' => 'admin.super_users']);
        Route::get('/add', ['uses' => '\App\Http\Controllers\Admin\SuperUsersController@add', 'as' => 'admin.addSuperUser']);
        Route::get('/{id}', ['uses' => '\App\Http\Controllers\Admin\SuperUsersController@view', 'as' => 'admin.viewSuperUser']);
        Route::post('/', ['uses' => '\App\Http\Controllers\Admin\SuperUsersController@post', 'as' => 'admin.postSuperUsers']);
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
        Route::get('/add', ['uses' => '\App\Http\Controllers\Admin\NewsController@add', 'as' => 'admin.add_news']);
        Route::get('/{id}', ['uses' => '\App\Http\Controllers\Admin\NewsController@view', 'as' => 'admin.view_news']);

        Route::post('/', ['uses' => '\App\Http\Controllers\Admin\NewsController@post', 'as' => 'admin.post_news']);

    });

    Route::group(['prefix' => 'rules'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\NewsController@list', 'as' => 'admin.rules']);
        Route::get('/add', ['uses' => '\App\Http\Controllers\Admin\NewsController@add', 'as' => 'admin.add_rules']);
        Route::get('/{id}', ['uses' => '\App\Http\Controllers\Admin\NewsController@view', 'as' => 'admin.view_rules']);

        Route::post('/', ['uses' => '\App\Http\Controllers\Admin\NewsController@post', 'as' => 'admin.post_rules']);

    });

    Route::group(['prefix' => 'support'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\NewsController@list', 'as' => 'admin.support']);
        Route::get('/add', ['uses' => '\App\Http\Controllers\Admin\NewsController@add', 'as' => 'admin.add_support']);
        Route::get('/{id}', ['uses' => '\App\Http\Controllers\Admin\NewsController@view', 'as' => 'admin.view_support']);

        Route::post('/', ['uses' => '\App\Http\Controllers\Admin\NewsController@post', 'as' => 'admin.post_support']);

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

    // Route::group(['prefix' => 'equipment_request'], function () {
    //     Route::get('/', ['uses' => '\App\Http\Controllers\Admin\EquipmentRequestController@index', 'as' => 'admin.equipment_request']);
    //     Route::get('/search', ['uses' => '\App\Http\Controllers\Admin\EquipmentRequestController@search', 'as' => 'admin.equipment_request_search']);
    // });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\SettingsController@index', 'as' => 'admin.settings']);
        Route::post('/updateEmail', ['uses' => '\App\Http\Controllers\Admin\SettingsController@updateEmail', 'as' => 'admin.settings_updateEmail']);
    
    });

    Route::group(['prefix' => 'logs'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\LogsController@index', 'as' => 'admin.logs']);
        Route::get('/search', ['uses' => '\App\Http\Controllers\Admin\LogsController@search', 'as' => 'admin.logsSearch']);
    });

    Route::group(['prefix' => 'seo'], function () {
        Route::get('/', ['uses' => '\App\Http\Controllers\Admin\SeoController@index', 'as' => 'admin.seo']);
        Route::post('/edit', ['uses' => '\App\Http\Controllers\Admin\SeoController@edit', 'as' => 'admin.seoEdit']);
    });

});


Route::group(['prefix' => '/messenger', 'middleware' => 'auth'], function() {
    Route::get('/{id}', ['uses' => '\App\Http\Controllers\MessengerController@index', 'as' => 'messenger']);
    Route::get('/{id}/{chatId}', ['uses' => '\App\Http\Controllers\MessengerController@single', 'as' => 'messenger.single']);
    
    Route::post('/addMessage', ['uses' => '\App\Http\Controllers\MessengerController@addMessage', 'as' => 'messenger.add_message']);
});


Route::group(['prefix' => 'companyAdmin', 'middleware' => 'roleCompany.auth'], function () {
    Route::get('/{companyId}', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@index', 'as' => 'admin.companyAdmin']);
    Route::get('/clients/{id}/{companyId}', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@client', 'as' => 'admin.companyAdminClient']);
    Route::get('/search/{companyId}', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@search', 'as' => 'admin.companySearch']);
    Route::get('/equipment/{companyId}', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@equipment', 'as' => 'admin.companyEquipment']);
    Route::get('/equipment/{filterStr}/{companyId}', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@equipmentSearch', 'as' => 'admin.companyEquipmentSearch']);
    Route::get('/reference/{companyId}', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@reference', 'as' => 'admin.companyAdminReference']);
    Route::get('/service/{companyId}', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@service', 'as' => 'admin.companyAdminService']);
    

    // for SU
    Route::get('/partners/{companyId}', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@partnersList', 'as' => 'admin.companyAdminPartners']);
    Route::get('/partners/{id}/{companyId}', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@partnerSingle', 'as' => 'admin.companyAdminPartnerSingle']);
    // for SU

    Route::post('/addMessage', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@addMessage', 'as' => 'admin.companyAddMessage']);
    Route::post('/updateUserData/{userId}', ['uses' => '\App\Http\Controllers\CompanyAdmin\CompanyAdminController@updateUserData', 'as' => 'admin.companyUpdateUserData']);

});




Route::group(['prefix' => 'clientAdmin', 'middleware' => 'roleClient.auth'], function () {
    Route::get('/{clientId}', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@index', 'as' => 'admin.clientAdmin']);
    Route::get('/partners/{clientId}', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@partnersList', 'as' => 'admin.clientAdminPartners']);
    Route::get('/partners/{id}/{clientId}', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@partnerSingle', 'as' => 'admin.clientAdminPartnerSingle']);
    Route::get('/reference/{clientId}', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@reference', 'as' => 'admin.clientAdminReference']);
    Route::get('/service/{clientId}', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@service', 'as' => 'admin.clientAdminService']);
    

    Route::post('/addEquipmentRequest', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@addRequestEquipment', 'as' => 'admin.clientAdminAddRequest']);
    Route::post('/editEquipmentRequest', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@editRequestEquipment', 'as' => 'admin.clientAdminEditRequest']);
    Route::post('/addMessage', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@addMessage', 'as' => 'admin.clientAddMessage']);

    Route::post('/updateRequestStatus/{id}', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@updateRequestStatus', 'as' => 'admin.clientUpdateRequestStatus']);

    Route::post('/updateUserData/{userId}', ['uses' => '\App\Http\Controllers\ClientAdmin\ClientAdminController@updateUserData', 'as' => 'admin.clientUpdateUserData']);

});



Route::group(['prefix' => 'superAdmin', 'middleware' => 'roleSA.auth'], function () {
    Route::get('/companies', ['uses' => '\App\Http\Controllers\SuperAdminCabinet\SuperAdminCabinetController@index', 'as' => 'admin.superAdminPartners']);
    Route::get('/search', ['uses' => '\App\Http\Controllers\SuperAdminCabinet\SuperAdminCabinetController@search', 'as' => 'admin.superSearch']);
    Route::get('/equipment', ['uses' => '\App\Http\Controllers\SuperAdminCabinet\SuperAdminCabinetController@equipment', 'as' => 'admin.superEquipment']);
    Route::get('/equipment/{filterStr}', ['uses' => '\App\Http\Controllers\SuperAdminCabinet\SuperAdminCabinetController@equipmentSearch', 'as' => 'admin.superEquipmentSearch']);
    Route::get('/reference', ['uses' => '\App\Http\Controllers\SuperAdminCabinet\SuperAdminCabinetController@reference', 'as' => 'admin.superAdminReference']);
    Route::get('/service', ['uses' => '\App\Http\Controllers\SuperAdminCabinet\SuperAdminCabinetController@service', 'as' => 'admin.superAdminService']);
    

    Route::get('/', ['uses' => '\App\Http\Controllers\SuperAdminCabinet\SuperAdminCabinetController@index', 'as' => 'admin.superAdminParticipant']);
    Route::get('/clients/{id}/', ['uses' => '\App\Http\Controllers\SuperAdminCabinet\SuperAdminCabinetController@client', 'as' => 'admin.superAdminClient']);
    
    Route::get('/partners/', ['uses' => '\App\Http\Controllers\SuperAdminCabinet\SuperAdminCabinetController@partnersList', 'as' => 'admin.superAdminPartners']);
    Route::get('/partners/{id}', ['uses' => '\App\Http\Controllers\SuperAdminCabinet\SuperAdminCabinetController@partnerSingle', 'as' => 'admin.superAdminPartnerSingle']);
    Route::get('/reference/', ['uses' => '\App\Http\Controllers\SuperAdminCabinet\SuperAdminCabinetController@reference', 'as' => 'admin.superAdminReference']);




});


Route::get('/reference-information', ['uses' => '\App\Http\Controllers\MainPage\NewsController@reference', 'as' => 'main_page.reference']);


Route::group(['prefix' => 'news'], function() {
    Route::get('/', ['uses' => '\App\Http\Controllers\MainPage\NewsController@allNews', 'as' => 'main_page.news']);
    Route::get('/{slug}', ['uses' => '\App\Http\Controllers\MainPage\NewsController@single', 'as' => 'main_page.single_news']);
});

Route::group(['prefix' => 'rules'], function() {
    Route::get('/', ['uses' => '\App\Http\Controllers\MainPage\NewsController@allNews', 'as' => 'main_page.rules']);
    Route::get('/{slug}', ['uses' => '\App\Http\Controllers\MainPage\NewsController@single', 'as' => 'main_page.single_rules']);
});

Route::group(['prefix' => 'support'], function() {
    Route::get('/', ['uses' => '\App\Http\Controllers\MainPage\NewsController@allNews', 'as' => 'main_page.support']);
    Route::get('/{slug}', ['uses' => '\App\Http\Controllers\MainPage\NewsController@single', 'as' => 'main_page.single_support']);
});

Route::get('/search', ['uses' => '\App\Http\Controllers\MainPage\SearchController@index', 'as' => 'main_page.search']);

Route::get('/contacts', ['uses' => '\App\Http\Controllers\MainPage\ContactsController@index', 'as' => 'main_page.contacts']);
Route::post('/contactsSubmit', ['uses' => '\App\Http\Controllers\MainPage\ContactsController@submit', 'as' => 'main_page.contacts_submit']);


Route::get('/', ['uses' => '\App\Http\Controllers\MainPage\MainPageController@index', 'as' => 'main_page']);


