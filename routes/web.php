<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeControllerController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NaildesignController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ManicuristController;

use App\Http\Controllers\OtherServiceController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\OpeningHourController;
use App\Http\Controllers\ShowReservController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ShowLikeController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ShowPromotionController;
use App\Http\Controllers\ShowTimeavailableController;
use App\Http\Controllers\ShowUserController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\PaymentController;

use App\Http\Controllers\StripeWebhookController;




use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Stripe\Webhook;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Stripe\Event;

use Stripe\Exception\SignatureVerificationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;



\Stripe\Stripe::setApiKey(env('STRIPE_WEBHOOK_SECRET'));




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



Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index']);

Route::get('/test', [App\Http\Controllers\WelcomeController::class, 'index1']);
Route::get('/logout', [App\Http\Controllers\WelcomeController::class, 'index2']);


Route::get('/login',[LoginController::class,'index']);
Route::get('/register',[RegisterController::class,'index']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');


/* เเก้ไขprofile*/
Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');


/* เพิ่มลายเล็บ*/
Route::get('/add_naildesign',[NaildesignController::class,'addview']);
Route::post('/upload_naildesign',[NaildesignController::class,'upload']);

/* ลบลายเล็บ*/
Route::get('/delete_naildesign/{nail_design_id}',[NaildesignController::class,'deletnaildesign']);

/* เเก้ไขลายเล็บ*/
Route::get('/edit_naildesign/{nail_design_id}',[NaildesignController::class,'editnaildesign']);
Route::post('/save_edit_naildesign/{nail_design_id}',[NaildesignController::class,'saveeditnaildesign']);





/* การจอง */
Route::get('/reserv', [ReservationController::class, 'index']);

//เลือกลายเล็บจากหน้าโฮม
Route::post('/reserv', [ReservationController::class, 'index'])->name('reserv');
Route::post('/create-reservation', [ReservationController::class, 'create'])->name('create-reservation');

Route::post('/check-promotion', [ReservationController::class, 'checkPromotion']);



/*Route::post('/book-time-slot', 'ReservationController@bookTimeSlot')->name('book.time.slot');*/

// Route::post('/book-time-slot', 'ReservationController@bookTimeSlot')->name('book.time.slot');



 /*จัดการเวลา
Route::get('/manage_time',[BusinessHourController::class,'index']);
Route::post('/manage_time',[BusinessHourController::class,'update'])->name('manage_time.update');


Route::post('/reserv',[ReservationController::class,'reserve'])->name('reserve');
*/


Route::get('/opening_hours', [OpeningHourController::class, 'showOpeningHours'])->name('openingHours');
Route::post('/save-closed-date', [OpeningHourController::class, 'saveClosedDate'])->name('saveClosedDate');
Route::get('/get-closed-dates', [OpeningHourController::class, 'getClosedDates']);

Route::post('/delete-closed-date', [OpeningHourController::class, 'deleteClosedDate'])->name('deleteClosedDate');


/*เพิ่มโปรโมชัน */
Route::get('/add_promotion', [PromotionController::class, 'index'])->name('add_promotion');
Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');

/* ลบโปรโมชัน*/
Route::get('/delete_promotion/{id}', [PromotionController::class, 'deletepromotion'])->name('delete_promotion');

/* เเก้ไขโปรโมชัน*/
Route::get('/edit_promotion/{id}', [PromotionController::class, 'editPromotion'])->name('promotions.edit');
Route::post('/save_edit_promotion/{id}', [PromotionController::class, 'saveEditPromotion'])->name('promotions.saveEdit');

/* เเสดงโปรโมชัน*/
Route::get('/showpromotion', [ShowPromotionController::class, 'showPromotion']);

/* เเสดงรายละเอียดโปรโมชัน*/
Route::get('/promotion/details/{id}', [ShowPromotionController::class, 'showPromotionDetails']);



/*เพิ่มบริการเสริม */
Route::get('/add_otherservice', [OtherServiceController::class, 'index']);
Route::post('/store_other_service', [OtherServiceController::class, 'store'])->name('store_other_service');

 /* เเก้ไขบริการเสริม*/
 Route::get('/edit_otherservice/{service_id}', [OtherServiceController::class, 'editotherservice'])->name('edit_other_service');
 Route::post('/save_edit_otherservice/{service_id}', [OtherServiceController::class, 'saveeditotherservice'])->name('save_edit_other_service');

/* ลบบริการเสริม*/
Route::get('/delete_otherservice/{service_id}',[OtherServiceController::class,'deletotherservice']);

/* เเสดงว่าใครจองเข้ามาในระบบ */
Route::get('admin/home', [HomeController::class, 'show'])->name('admin.home')->middleware('is_admin');



/* เเสดงการจองของเรา */
/*Route::get('/showreserv', [ShowReservController::class, 'showReservations']);*/
Route::get('/showreserv', [ShowReservController::class, 'showReservations'])->name('showreservations');

/* ยกเลิกการจองจากผู้ใช้ */
Route::delete('/showreservations/{reservs_id}/cancel', [ShowReservController::class, 'cancel'])->name('showreservations.cancel');

/* ยกเลิกการจองฝั่งเจ้าของร้าน */
Route::delete('/reservations/{reservs_id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
/* ยืนยันการจองฝั่งเจ้าของร้าน */
Route::patch('/reservations/{reservs_id}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');

/* เเสดงรายการถูกใจ */
Route::get('/showlikes', [ShowLikeController::class, 'viewshowlike'])->name('showlike');


/* ถูกใจ */
Route::post('/toggle-like', [LikeController::class, 'toggleLike'])->middleware('auth');
Route::get('/liked-designs', [LikeController::class, 'getLikedDesigns'])->middleware('auth');


/* เเสดงวันเวลาว่าง */
Route::get('/showtimeavailable', [ShowTimeavailableController::class, 'index']);


/* ดูรายละเอียดการจองของลูกค้า */
Route::get('/getReservationDetails', [HomeController::class, 'getReservationDetails']);

/* เเสดงผู้ใช้*/
Route::get('/showuser', [ShowUserController::class, 'index'])->name('showuser');



/* ชำระเงินมัดจำ*/
//Route::get('payment', [PaymentController::class, 'stripe']);

Route::get('/payment', function (Request $request) {
    return view('payment', ['reservs_id' => $request->query('reservs_id')]);
});



//payment
Route::get('/order/{id}', [PaymentController::class, 'getOrder']);
Route::get('/updateorder/{id}', [PaymentController::class, 'updateOrder']);

Route::post('/webhook', [StripeWebhookController::class, 'handleWebhook']);

Route::post('/checkout', function (Request $request) {
    $data = $request->validate([
        'reservs_id' => 'required|exists:timereservs,reservs_id',
        'user.name' => 'required|string',
        'user.address' => 'required|string',
        'product.name' => 'required|string',
        'product.price' => 'required|numeric',
        'product.quantity' => 'required|integer'
    ]);

    try {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $orderId = Str::uuid();

        $session = Session::create([
            'payment_method_types' => ['promptpay'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'thb',
                    'product_data' => ['name' => $data['product']['name']],
                    'unit_amount' => $data['product']['price'] * 100,
                ],
                'quantity' => $data['product']['quantity'],
            ]],
            'mode' => 'payment',
            'success_url' => url("/reserv?success={$orderId}&reservs_id={$data['reservs_id']}"),
'cancel_url' => url("/reserv?cancel={$orderId}"),
        ]);

        DB::table('payments')->insert([
            'reservs_id' => $data['reservs_id'],
            'amount' => $data['product']['price'] * $data['product']['quantity'],
            'session_id' => $session->id,
            'status' => 'รอชำระเงินมัดจำ',
            'order_id' => $orderId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Checkout success.',
            'id' => $session->id,
            'session' => $session
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error processing payment', 'exception' => $e->getMessage()], 400);
    }
})->middleware('api');




Route::get('/success/{id}', function (Request $request, $id) {
    $reservs_id = $request->query('reservs_id');

    // อัปเดตสถานะใน timereservs
    DB::table('timereservs')
        ->where('reservs_id', $reservs_id)
        ->update(['statusdetail' => 'ชำระเงินมัดจำแล้ว']);

    return redirect('/reserv?payment=success');
});

Route::get('/cancel/{id}', function () {
    return redirect('/reserv?payment=cancel');
});


// ส่วนนับเวลาถอยหลัง
Route::get('/get-expiration/{reservs_id}', [ReservationController::class, 'getExpiration']);
Route::post('/cancel-reservation/{reservs_id}', [ReservationController::class, 'cancelReservation']);



//Route::get('/payment/{reservs_id}', [PaymentController::class, 'index'])->middleware('payment.expiration');

// เช็คก่อนจะกดจองอีกครั้ง
Route::get('/check-pending-deposit', [ReservationController::class, 'checkPendingDeposit']);


/* เเสดงdashboard*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/dashboard/deposit-data', [DashboardController::class, 'getDepositData']);

Route::get('/dashboard/deposit-data-yearly', [DashboardController::class, 'getDepositDataYearly'])->name('dashboard.depositData');
Route::get('/dashboard/booking-statistics', [DashboardController::class, 'getBookingStatistics'])->name('dashboard.bookingStatistics');
