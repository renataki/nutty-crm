<?php

use App\Http\Controllers\AccessDeniedController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\DatabaseImportController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportUserController;
use App\Http\Controllers\ReportWebsiteController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\SettingApiController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\WorksheetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemplateController;


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

Route::group(["middleware" => ["authentication"]], function() {

    Route::get("/", [IndexController::class, "index"]);

    Route::get("/database", [DatabaseController::class, "index"]);
    Route::get("/database/entry", [DatabaseController::class, "add"]);
    Route::get("/database/entry/{id}", [DatabaseController::class, "edit"]);

    Route::get("/database/import", [DatabaseImportController::class, "index"]);
    Route::get("/database/import/history", [DatabaseImportController::class, "history"]);

    Route::get("/license", [LicenseController::class, "index"]);
    Route::get("/license/entry/{id}", [LicenseController::class, "edit"]);

    Route::get("/login", [LoginController::class, "index"]);

    Route::get("/register", [RegisterController::class, "index"]);

    Route::get("/report/user", [ReportUserController::class, "index"]);
    Route::get("/report/user/{id}", [ReportUserController::class, "detail"]);
    Route::get("/report/website", [ReportWebsiteController::class, "index"]);

    Route::get("/security/encryption", [SecurityController::class, "encryption"]);

    Route::get("/setting/api", [SettingApiController::class, "index"]);
    Route::get("/setting/api/entry", [SettingApiController::class, "add"]);
    Route::get("/setting/api/entry/{id}", [SettingApiController::class, "edit"]);

    Route::get("/user", [UserController::class, "index"]);
    Route::get("/user/entry", [UserController::class, "add"]);
    Route::get("/user/entry/{id}", [UserController::class, "edit"]);
    Route::get("/user/profile", [UserController::class, "profile"]);

    Route::get("/user/group", [UserGroupController::class, "index"]);
    Route::get("/user/group/entry", [UserGroupController::class, "add"]);
    Route::get("/user/group/entry/{id}", [UserGroupController::class, "edit"]);

    Route::get("/user/role", [UserRoleController::class, "index"]);
    Route::get("/user/role/entry", [UserRoleController::class, "add"]);
    Route::get("/user/role/entry/{id}", [UserRoleController::class, "edit"]);

    Route::get("/website", [WebsiteController::class, "index"]);
    Route::get("/website/entry", [WebsiteController::class, "add"]);
    Route::get("/website/entry/{id}", [WebsiteController::class, "edit"]);

    Route::get("/worksheet", [WorksheetController::class, "index"]);
    Route::get("/worksheet/call/{websiteId}/{id}", [WorksheetController::class, "call"]);
    Route::get("/worksheet/crm", [WorksheetController::class, "crm"]);
    Route::get("/worksheet/result", [WorksheetController::class, "result"]);
    Route::get("/worksheet/result/{id}", [WorksheetController::class, "resultUser"]);

});

Route::get("/access-denied", [AccessDeniedController::class, "index"]);
Route::get("/migration/generate-last-deposit", [MigrationController::class, "generateLastDeposit"]);
Route::get("/migration/generate-unclaimed-deposit", [MigrationController::class, "generateUnclaimedDeposit"]);
Route::get("/migration/migrate", [MigrationController::class, "migrate"]);
Route::get("/system/info", [SystemController::class, "info"]);
Route::get("/system/find-player-transaction/{date}", [SystemController::class, "findPlayerTransaction"]);
Route::get("/system/generate-unclaimed-deposit-queue/{date}", [
    SystemController::class,
    "generateUnclaimedDepositQueue"
]);
Route::get("/system/sync-player-transaction/{websiteId}", [SystemController::class, "syncPlayerTransaction"]);

Route::post("/database/delete", [DatabaseController::class, "delete"]);
Route::post("/database/initialize-data", [DatabaseController::class, "initializeData"]);
Route::post("/database/insert", [DatabaseController::class, "insert"]);
Route::post("/database/table", [DatabaseController::class, "table"]);
Route::post("/database/update", [DatabaseController::class, "update"]);

Route::post("/database/import/history/delete", [DatabaseImportController::class, "historyDelete"]);
Route::post("/database/import/history/table", [DatabaseImportController::class, "historyTable"]);
Route::post("/database/import/import", [DatabaseImportController::class, "import"]);
Route::post("/database/import/initialize-data", [DatabaseImportController::class, "initializeData"]);

Route::post("/license/delete", [LicenseController::class, "delete"]);
Route::post("/license/initialize-data", [LicenseController::class, "initializeData"]);
Route::post("/license/table", [LicenseController::class, "table"]);
Route::post("/license/update", [LicenseController::class, "update"]);

Route::post("/login/login", [LoginController::class, "login"]);
Route::post("/login/logout", [LoginController::class, "logout"]);

Route::post("/register/register", [RegisterController::class, "register"]);

Route::post("/report/user/table", [ReportUserController::class, "table"]);
Route::post("/report/user/detail/table", [ReportUserController::class, "detailTable"]);
Route::post("/report/website/table", [ReportWebsiteController::class, "table"]);

Route::post("/security/encryption/encrypt", [SecurityController::class, "encrypt"]);
Route::post("/security/initialize-account", [SecurityController::class, "initializeAccount"]);

Route::post("/setting/api/initialize-data", [SettingApiController::class, "initializeData"]);
Route::post("/setting/api/sync", [SettingApiController::class, "sync"]);
Route::post("/setting/api/table", [SettingApiController::class, "table"]);
Route::post("/setting/api/update", [SettingApiController::class, "update"]);

Route::post("/user/delete", [UserController::class, "delete"]);
Route::post("/user/initialize-data", [UserController::class, "initializeData"]);
Route::post("/user/insert", [UserController::class, "insert"]);
Route::post("/user/table", [UserController::class, "table"]);
Route::post("/user/update", [UserController::class, "update"]);
Route::post("/user/update-password", [UserController::class, "updatePassword"]);

Route::post("/user/group/delete", [UserGroupController::class, "delete"]);
Route::post("/user/group/initialize-data", [UserGroupController::class, "initializeData"]);
Route::post("/user/group/insert", [UserGroupController::class, "insert"]);
Route::post("/user/group/table", [UserGroupController::class, "table"]);
Route::post("/user/group/update", [UserGroupController::class, "update"]);

Route::post("/user/role/delete", [UserRoleController::class, "delete"]);
Route::post("/user/role/initialize-data", [UserRoleController::class, "initializeData"]);
Route::post("/user/role/insert", [UserRoleController::class, "insert"]);
Route::post("/user/role/table", [UserRoleController::class, "table"]);
Route::post("/user/role/update", [UserRoleController::class, "update"]);

Route::post("/website/delete", [WebsiteController::class, "delete"]);
Route::post("/website/initialize-data", [WebsiteController::class, "initializeData"]);
Route::post("/website/insert", [WebsiteController::class, "insert"]);
Route::post("/website/table", [WebsiteController::class, "table"]);
Route::post("/website/update", [WebsiteController::class, "update"]);

Route::post("/worksheet/call/initialize-data", [WorksheetController::class, "callInitializeData"]);
Route::post("/worksheet/crm/table", [WorksheetController::class, "crmTable"]);
Route::post("/worksheet/initialize-data", [WorksheetController::class, "initializeData"]);
Route::post("/worksheet/result/table", [WorksheetController::class, "resultTable"]);
Route::post("/worksheet/start", [WorksheetController::class, "start"]);
Route::post("/worksheet/update", [WorksheetController::class, "update"]);

Route::get("/template", [TemplateController::class, "index"]);
Route::get("/template/entry", [TemplateController::class, "add"]);
Route::get("/template/entry/{id}", [TemplateController::class, "edit"]);

Route::post("/template/delete", [TemplateController::class, "delete"]);
Route::post("/template/initialize-data", [TemplateController::class, "initializeData"]);
Route::post("/template/insert", [TemplateController::class, "insert"]);
Route::post("/template/table", [TemplateController::class, "table"]);
Route::post("/template/update", [TemplateController::class, "update"]);