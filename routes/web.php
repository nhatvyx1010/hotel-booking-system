<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\RoomTypeController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Frontend\FrontendRoomController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Backend\RoomListController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\CommentController;
use App\Http\Controllers\Backend\AdminReviewController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\ReportIssueController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\AdminHotelController;
use App\Http\Controllers\Frontend\VnpayController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\FilterController;
use App\Http\Controllers\Backend\CustomerController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'Index']);

Route::get('/dashboard', function () {
    return view('frontend.dashboard.user_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/profile/store', [UserController::class, 'UserStore'])->name('profile.store');
    Route::get('/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/password/change/password', [UserController::class, 'ChangePasswordStore'])->name('password.change.store');
});

require __DIR__.'/auth.php';

//Admin Group Middleware
Route::middleware(['auth', 'roles:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
});

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

Route::middleware(['auth', 'roles:admin'])->group(function(){
    Route::controller(TeamController::class)->group(function(){
        Route::get('/all/team', 'AllTeam')->name('all.team')->middleware('permission:team.all');
        Route::get('/add/team', 'AddTeam')->name('add.team')->middleware('permission:team.add');
        Route::post('/team/store', 'StoreTeam')->name('team.store');
        Route::get('/edit/team/{id}', 'EditTeam')->name('edit.team');
        Route::post('/team/update', 'UpdateTeam')->name('team.update');
        Route::get('/delete/team/{id}', 'DeleteTeam')->name('delete.team');
    });

    Route::controller(CityController::class)->group(function(){
        Route::get('/all/city', 'CityAll')->name('all.city');
        Route::get('/add/city', 'CityAdd')->name('add.city');
        Route::post('/city/store', 'CityStore')->name('city.store');
        Route::get('/edit/city/{id}', 'CityEdit')->name('edit.city');
        Route::post('/city/update', 'CityUpdate')->name('city.update');
        Route::get('/delete/city/{id}', 'CityDestroy')->name('delete.city');
    });

    Route::controller(TeamController::class)->group(function(){
        Route::get('/book/area', 'BookArea')->name('book.area');
        Route::post('/book/area/update', 'BookAreaUpdate')->name('book.area.update');
    });
    Route::controller(RoomTypeController::class)->group(function(){
        Route::get('/room/type/list', 'RoomTypeList')->name('room.type.list');
        Route::get('/add/room/type', 'AddRoomType')->name('add.room.type');
        Route::post('/room/type/store', 'RoomTypeStore')->name('room.type.store');
    });

    Route::controller(RoomController::class)->group(function(){

        Route::get('/edit/room/{id}', 'EditRoom')->name('edit.room');
        Route::post('/update/room/{id}', 'UpdateRoom')->name('update.room');
        Route::get('/multi/image/delete/{id}', 'MultiImageDelete')->name('multi.image.delete');
    
        Route::post('/store/room/number/{id}', 'StoreRoomNumber')->name('store.room.number');
        Route::get('/edit/roomno/{id}', 'EditRoomNumber')->name('edit.roomno');
        Route::post('/update/roomno/{id}', 'UpdateRoomNumber')->name('update.roomno');
        Route::get('/delete/roomno/{id}', 'DeleteRoomNumber')->name('delete.roomno');
    
        Route::get('/delete/room/{id}', 'DeleteRoom')->name('delete.room');
          
    });

    Route::controller(BookingController::class)->group(function(){
        Route::get('/booking/list', 'BookingList')->name('booking.list');
        Route::get('/edit_booking/{id}', 'EditBooking')->name('edit_booking');
        Route::get('/download/invoice/{id}', 'DownloadInvoice')->name('download.invoice');
    });

    Route::controller(RoomListController::class)->group(function(){
        Route::get('/view/room/list', 'ViewRoomList')->name('view.room.list');
        Route::get('/add/room/list', 'AddRoomList')->name('add.room.list');
        Route::post('/store/roomlist', 'StoreRoomList')->name('store.roomlist');
    });

    Route::controller(SettingController::class)->group(function(){
        Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting');
        Route::post('/smtp/update', 'SmtpUpdate')->name('smtp.update');
    });

    Route::controller(TestimonialController::class)->group(function(){
        Route::get('/all/testimonial', 'AllTestimonial')->name('all.testimonial');
        Route::get('/add/testimonial', 'AddTestimonial')->name('add.testimonial');
        Route::post('/store/testimonial', 'StoreTestimonial')->name('testimonial.store');

        Route::get('/edit/testimonial/{id}', 'EditTestimonial')->name('edit.testimonial');
        Route::post('/update/testimonial', 'UpdateTestimonial')->name('testimonial.update');
        Route::get('/delete/testimonial/{id}', 'DeleteTestimonial')->name('delete.testimonial');
    });

    Route::controller(BlogController::class)->group(function(){
        Route::get('/blog/category', 'BlogCategory')->name('blog.category');
        Route::post('/store/blog/category', 'StoreBlogCategory')->name('store.blog.category');
        Route::get('/edit/blog/category/{id}', 'EditBlogCategory');
        Route::post('/update/blog/category', 'UpdateBlogCategory')->name('update.blog.category');
        Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category');
    });

    Route::controller(BlogController::class)->group(function(){
        Route::get('/all/blog/post', 'AllBlogPost')->name('all.blog.post');
        Route::get('/add/blog/post', 'AddBlogPost')->name('add.blog.post');
        Route::post('/store/blog/post', 'StoreBlogPost')->name('store.blog.post');
        Route::get('/edit/blog/post/{id}', 'EditBlogPost')->name('edit.blog.post');
        Route::post('/update/blog/post', 'UpdateBlogPost')->name('update.blog.post');
        Route::get('/delete/blog/post/{id}', 'DeleteBlogPost')->name('delete.blog.post');
    });

    Route::controller(CommentController::class)->group(function(){

        Route::get('/all/comment/', 'AllComment')->name('all.comment');
        Route::post('/update/comment/status', 'UpdateCommentStatus')->name('update.comment.status');
    });

    Route::controller(AdminReviewController::class)->group(function(){
        Route::get('/all/review/', 'AllReview')->name('all.review');
        Route::post('/update/review/status', 'UpdateReviewStatus')->name('update.review.status');
    });

    Route::controller(ReportIssueController::class)->group(function(){
        Route::get('/all/report/', 'AllReport')->name('all.report');
        Route::post('/update/report/status', 'UpdateReportStatus')->name('update.report.status');
    });

    Route::controller(ReportController::class)->group(function(){

        Route::get('/booking/report/', 'BookingReport')->name('booking.report');
        Route::post('/search-by-date', 'SearchByDate')->name('search-by-date');
        Route::get('/admin/bookings/export-excel', 'ExportExcel')->name('booking.export.excel');

    });

    Route::controller(SettingController::class)->group(function(){
        Route::get('/site/setting', 'SiteSetting')->name('site.setting');
        Route::post('/site/update', 'SiteUpdate')->name('site.update');
    });

    Route::controller(GalleryController::class)->group(function(){
        Route::get('/all/gallery', 'AllGallery')->name('all.gallery');
        Route::get('/add/gallery', 'AddGallery')->name('add.gallery');
        Route::post('/store/gallery', 'StoreGallery')->name('store.gallery');
        Route::get('/edit/gallery/{id}', 'EditGallery')->name('edit.gallery');
        Route::post('/update/gallery', 'UpdateGallery')->name('update.gallery');
        Route::get('/delete/gallery/{id}', 'DeleteGallery')->name('delete.gallery');
        Route::post('/delete/gallery/multiple', 'DeleteGalleryMultiple')->name('delete.gallery.multiple');
        
        Route::get('/contact/message', 'ManageContactMessage')->name('contact.message');
    });

    Route::controller(RoleController::class)->group(function(){
        Route::get('/all/permission', 'AllPermission')->name('all.permission');
        Route::get('/add/permission', 'AddPermission')->name('add.permission');
        Route::post('/store/permission', 'StorePermission')->name('store.permission');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
        Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');
        Route::get('/import/permission', 'ImportPermission')->name('import.permission');
        Route::get('/export', 'Export')->name('export');
        Route::post('/import', 'Import')->name('import');
    });

    Route::controller(RoleController::class)->group(function(){
        Route::get('/all/roles', 'AllRoles')->name('all.roles');
        Route::get('/add/roles', 'AddRoles')->name('add.roles');
        Route::post('/store/roles', 'StoreRoles')->name('store.roles');
        Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');
        Route::post('/update/roles', 'UpdateRoles')->name('update.roles');
        Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');
    
    
        Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');
        Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');
        Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');
        
        Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles');
        Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');
        Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles');
    });

    Route::controller(AdminController::class)->group(function(){
        Route::get('/all/admin', 'AllAdmin')->name('all.admin');
        Route::get('/add/admin', 'AddAdmin')->name('add.admin');
        Route::post('/store/admin', 'StoreAdmin')->name('store.admin');
        Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin');
        Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');
        Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin');
    });

    Route::controller(AdminHotelController::class)->group(function(){
        Route::get('/all/hotel', 'AllHotel')->name('all.hotel');
        Route::get('/all/hotel/inactive', 'AllHotelInactive')->name('all.hotel.inactive');
        Route::get('/all/hotel/pending', 'AllHotelPending')->name('all.hotel.pending');
        Route::get('/all/hotel/cancelled', 'AllHotelCancelled')->name('all.hotel.cancelled');
        Route::get('/add/hotel', 'AddHotel')->name('add.hotel');
        Route::post('/store/hotel', 'StoreHotel')->name('store.hotel');
        Route::get('/edit/hotel/{id}', 'EditHotel')->name('edit.hotel');
        Route::get('/edit/hotel/pending/{id}', 'EditHotelPending')->name('edit.hotel.pending');
        Route::post('/update/hotel/{id}', 'UpdateHotel')->name('update.hotel');
        Route::post('/update/hotel/pending/{id}', 'UpdateHotelPending')->name('update.hotel.pending');
        Route::get('/delete/hotel/{id}', 'DeleteHotel')->name('delete.hotel');
    });
    
    Route::controller(CustomerController::class)->group(function(){
        Route::get('/all-customer', 'AllCustomer')->name('all.customer');
        Route::get('/add-customer', 'AddCustomer')->name('add.customer');
        Route::post('/store-customer', 'StoreCustomer')->name('customer.store');
    
        Route::get('/edit-customer/{id}', 'EditCustomer')->name('customer.edit');
        Route::post('/update-customer/{id}', 'UpdateCustomer')->name('customer.update');
        
        Route::get('/delete-customer/{id}', 'DeleteCustomer')->name('customer.delete'); 
    });
});

Route::controller(FrontendRoomController::class)->group(function(){

    Route::get('/rooms/', 'AllFrontendRoom')->name('frontend.room.all');
    Route::get('/room/details/{id}', 'RoomDetailsPage');
    Route::get('/bookings/', 'BookingSearch')->name('booking.search');
    Route::get('/booking_hotel/', 'BookingSearchHotel')->name('booking.search.hotel');
    Route::get('/hotel_detail/{id}', 'HotelDetail')->name('booking.search.hotel_detail');
    Route::get('/bookinglistroomsearch/', 'BookingListRoomSearch')->name('booking.list.room.search');
    Route::get('/hotelsearchcity/{id}', 'HotelSearchCity')->name('hotel.search.city');
    Route::get('/search/room/details/{id}', 'SearchRoomDetails')->name('search_room_details');
    
    Route::get('/check_room_availability/', 'CheckRoomAvailability')->name('check_room_availability');
    Route::get('/check_room_availability_hotel/', 'CheckRoomAvailabilityHotel')->name('check_room_availability_hotel');
});

Route::controller(FilterController::class)->group(function(){
    Route::post('/filter/hotel/', 'FilterHotel')->name('filter.hotel');
});

Route::middleware(['auth'])->group(function(){
    Route::controller(BookingController::class)->group(function(){

        Route::get('/checkout/', 'Checkout')->name('checkout');
        Route::post('/booking/store/', 'BookingStore')->name('user_booking_store');
        Route::post('/checkout/store/', 'CheckoutStore')->name('checkout.store');
        Route::match(['get', 'post'],'/stripe_pay', [BookingController::class, 'stripe_pay'])->name('stripe_pay');

        Route::post('/update/booking/status/{id}', 'UpdateBookingStatus')->name('update.booking.status');
        Route::post('/update/booking/{id}', 'UpdateBooking')->name('update.booking');

        Route::get('/assign_room/{id}', 'AssignRoom')->name('assign_room');
        Route::get('/assign_room/store/{booking_id}/{room_number_id}', 'AssignRoomStore')->name('assign_room_store');
        Route::get('/assign_room_delete/{id}', 'AssignRoomDelete')->name('assign_room_delete');

        Route::get('/user/booking/', 'UserBooking')->name('user.booking');
        Route::get('/user/booking_canceled/', 'UserBookingCanceled')->name('user.booking_canceled');

        Route::get('/user/booking/cancel-form/{id}','ShowCancelForm')->name('user.booking.cancel.form');
        Route::post('/user/booking/cancel-store/{id}', 'StoreCancelReason')->name('user.booking.cancel.store');

        Route::get('/user/booking/report-form/{id}','ShowReportForm')->name('user.booking.report.form');
        Route::post('/user/booking/report-store/{id}', 'StoreReportReason')->name('user.booking.report.store');
        
        Route::get('/user/invoice/{id}', 'UserInvoice')->name('user.invoice');
    });
});

Route::controller(BlogController::class)->group(function(){

    Route::get('/blog/details/{slug}', 'BlogDetails');
    Route::get('/blog/cat/list/{id}', 'BlogCatList');
    Route::get('/blog', 'BlogList')->name('blog.list');
});

Route::controller(CommentController::class)->group(function(){

    Route::post('/store/comment/', 'StoreComment')->name('store.comment');
});

Route::controller(GalleryController::class)->group(function(){

    Route::get('/gallery', 'ShowGallery')->name('show.gallery');
    Route::get('/contact', 'ContactUs')->name('contact.us');
    Route::post('/store/contact', 'StoreContact')->name('store.contact');
});

Route::controller(BookingController::class)->group(function(){

    Route::post('/mark-notification-as-read/{notification}', 'MarkAsRead');
});

Route::controller(AboutController::class)->group(function(){

    Route::get('/about', 'AboutUs')->name('about.us');
    Route::get('/services', 'Service')->name('services.us');
    Route::get('/terms', 'TermsUs')->name('terms.us');
    Route::get('/privacy', 'PrivacyUs')->name('privacy.us');
    Route::get('/testimonials/list', 'TestimonialsList')->name('testimonials.list');
});

///////////////// VNPAY ///////////////
Route::post('/create-payment', [VnpayController::class, 'create']);
Route::get('/return-vnpay', [VnpayController::class, 'return'])->name('return-vnpay');





///////////////// Hotel Group Middleware ///////////////
//
Route::middleware(['auth', 'roles:hotel'])->group(function(){
    Route::get('/hotel/dashboard', [HotelController::class, 'HotelDashboard'])->name('hotel.dashboard');
    Route::get('/hotel/logout', [HotelController::class, 'HotelLogout'])->name('hotel.logout');
    Route::get('/hotel/profile', [HotelController::class, 'HotelProfile'])->name('hotel.profile');
    Route::post('/hotel/profile/store', [HotelController::class, 'HotelProfileStore'])->name('hotel.profile.store');
    Route::get('/hotel/change/password', [HotelController::class, 'HotelChangePassword'])->name('hotel.change.password');
    Route::post('/hotel/password/update', [HotelController::class, 'HotelPasswordUpdate'])->name('hotel.password.update');

    
    Route::controller(TeamController::class)->group(function(){
        Route::get('/hotel/all/team', 'HotelAllTeam')->name('hotel.all.team');
        Route::get('/hotel/add/team', 'HotelAddTeam')->name('hotel.add.team');
        Route::post('/hotel/team/store', 'HotelStoreTeam')->name('hotel.team.store');
        Route::get('/hotel/edit/team/{id}', 'HotelEditTeam')->name('hotel.edit.team');
        Route::post('/hotel/team/update', 'HotelUpdateTeam')->name('hotel.team.update');
        Route::get('/hotel/delete/team/{id}', 'HotelDeleteTeam')->name('hotel.delete.team');
    });

    Route::controller(TeamController::class)->group(function(){
        Route::get('/hotel/book/area', 'HotelBookArea')->name('hotel.book.area');
        Route::post('/hotel/book/area/update', 'HotelBookAreaUpdate')->name('hotel.book.area.update');
    });

    Route::controller(RoomTypeController::class)->group(function(){
        Route::get('/hotel/room/type/list', 'HotelRoomTypeList')->name('hotel.room.type.list');
        Route::get('/hotel/add/room/type', 'HotelAddRoomType')->name('hotel.add.room.type');
        Route::post('/hotel/room/type/store', 'HotelRoomTypeStore')->name('hotel.room.type.store');
    });

    Route::controller(RoomController::class)->group(function(){

        Route::get('/hotel/edit/room/{id}', 'HotelEditRoom')->name('hotel.edit.room');
        Route::post('/hotel/update/room/{id}', 'HotelUpdateRoom')->name('hotel.update.room');
        Route::get('/hotel/multi/image/delete/{id}', 'HotelMultiImageDelete')->name('hotel.multi.image.delete');
    
        Route::post('/hotel/store/room/number/{id}', 'HotelStoreRoomNumber')->name('hotel.store.room.number');
        Route::get('/hotel/edit/roomno/{id}', 'HotelEditRoomNumber')->name('hotel.edit.roomno');
        Route::post('/hotel/update/roomno/{id}', 'HotelUpdateRoomNumber')->name('hotel.update.roomno');
        Route::get('/hotel/delete/roomno/{id}', 'HotelDeleteRoomNumber')->name('hotel.delete.roomno');
    
        Route::get('/hotel/delete/room/{id}', 'HotelDeleteRoom')->name('hotel.delete.room');
          
    });

    Route::controller(BookingController::class)->group(function(){
        Route::get('/hotel/booking/list', 'HotelBookingList')->name('hotel.booking.list');
        Route::get('/cancel/pending/list', 'HotelBookingCancelPendingList')->name('hotel.booking.cancel_pending.list');
        Route::get('/cancel/pending/detail/{id}', 'HotelBookingCancelPendingDetail')->name('hotel.booking.cancel_pending.detail');
        Route::get('/cancel/complete/list', 'HotelBookingCancelCompleteList')->name('hotel.booking.cancel_complete.list');
        Route::get('/cancel/complete/detail/{id}', 'HotelBookingCancelCompleteDetail')->name('hotel.booking.cancel_complete.detail');
        
        Route::get('/hotel/edit_booking/{id}', 'HotelEditBooking')->name('hotel.edit_booking');
        Route::get('/hotel/download/invoice/{id}', 'HotelDownloadInvoice')->name('hotel.download.invoice');

        //// BOOKING MANAGE ////
        Route::post('/hotel/update/booking/status/{id}', 'HotelUpdateBookingStatus')->name('hotel.update.booking.status');
        Route::post('/hotel/update/booking/cancel/status/{id}', 'HotelUpdateBookingCancelStatus')->name('hotel.update.booking.cancel.status');
        Route::post('/hotel/update/booking/{id}', 'HotelUpdateBooking')->name('hotel.update.booking');

        Route::get('/hotel/assign_room/{id}', 'HotelAssignRoom')->name('hotel.assign_room');
        Route::get('/hotel/assign_room/store/{booking_id}/{room_number_id}', 'HotelAssignRoomStore')->name('hotel.assign_room_store');
        Route::get('/hotel/assign_room_delete/{id}', 'HotelAssignRoomDelete')->name('hotel.assign_room_delete');

        Route::get('/hotel/check_room_availability/', 'HotelCheckRoomAvailability')->name('hotel.check_room_availability');

    });

    Route::controller(RoomListController::class)->group(function(){
        Route::get('/hotel/view/room/list', 'HotelViewRoomList')->name('hotel.view.room.list');
        Route::get('/hotel/add/room/list', 'HotelAddRoomList')->name('hotel.add.room.list');
        Route::post('/hotel/store/roomlist', 'HotelStoreRoomList')->name('hotel.store.roomlist');
    });

    Route::controller(ReportController::class)->group(function(){

        Route::get('/hotel/booking/report/', 'HotelBookingReport')->name('hotel.booking.report');
        Route::post('/hotel/search-by-date', 'HotelSearchByDate')->name('hotel.search-by-date');

        Route::get('/hotel/bookings/export-excel', 'HotelExportExcel')->name('hotel.booking.export.excel');
    });

    Route::controller(GalleryController::class)->group(function(){
        Route::get('/hotel/all/gallery', 'HotelAllGallery')->name('hotel.all.gallery');
        Route::get('/hotel/add/gallery', 'HotelAddGallery')->name('hotel.add.gallery');
        Route::post('/hotel/store/gallery', 'HotelStoreGallery')->name('hotel.store.gallery');
        Route::get('/hotel/edit/gallery/{id}', 'HotelEditGallery')->name('hotel.edit.gallery');
        Route::post('/hotel/update/gallery', 'HotelUpdateGallery')->name('hotel.update.gallery');
        Route::get('/hotel/delete/gallery/{id}', 'HotelDeleteGallery')->name('hotel.delete.gallery');
        Route::post('/hotel/delete/gallery/multiple', 'HotelDeleteGalleryMultiple')->name('hotel.delete.gallery.multiple');
    });
    
    Route::controller(ReviewController::class)->group(function(){
        Route::get('/hotel/all/review/', 'HotelAllReview')->name('hotel.all.review');
        Route::post('/reviews/{id}/reply', 'HotelReply')->name('reviews.reply');
    });

});
Route::get('/hotel/login', [HotelController::class, 'HotelLogin'])->name('hotel.login');
Route::get('/hotel/register', [HotelController::class, 'HotelRegister'])->name('hotel.register');
Route::post('/hotel/register/submit', [HotelController::class, 'HotelRegisterSubmit'])->name('hotel.register_submit');
Route::post('/hotel/login_submit', [HotelController::class, 'HotelLoginSubmit'])->name('hotel.login_submit');

Route::post('/send-message', [UserController::class, 'SendMessage'])->name('send.message');

Route::get('/admin/bookings/chart-data', [DashboardController::class, 'getBookingChartData']);
Route::get('/admin/bookings/chart-data-hotel', [DashboardController::class, 'getBookingChartDataHotel']);

Route::post('/validate-booking-review', [ReviewController::class, 'ValidateBooking'])->name('validate.booking.for.review');
Route::post('/reviews/store', [ReviewController::class, 'ReviewStore'])->name('reviews.store');

// Route::get('/hotel/logout', [HotelController::class, 'HotelLogout'])->name('hotel.logout');

// Route::middleware(['auth', 'roles:hotel'])->group(function(){




//     Route::controller(RoleController::class)->group(function(){
//         Route::get('/all/permission', 'AllPermission')->name('all.permission');
//         Route::get('/add/permission', 'AddPermission')->name('add.permission');
//         Route::post('/store/permission', 'StorePermission')->name('store.permission');
//         Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
//         Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
//         Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');
//         Route::get('/import/permission', 'ImportPermission')->name('import.permission');
//         Route::get('/export', 'Export')->name('export');
//         Route::post('/import', 'Import')->name('import');
//     });

//     Route::controller(RoleController::class)->group(function(){
//         Route::get('/all/roles', 'AllRoles')->name('all.roles');
//         Route::get('/add/roles', 'AddRoles')->name('add.roles');
//         Route::post('/store/roles', 'StoreRoles')->name('store.roles');
//         Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');
//         Route::post('/update/roles', 'UpdateRoles')->name('update.roles');
//         Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');
    
    
//         Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');
//         Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');
//         Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');
        
//         Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles');
//         Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');
//         Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles');
//     });

//     Route::controller(AdminController::class)->group(function(){
//         Route::get('/all/admin', 'AllAdmin')->name('all.admin');
//         Route::get('/add/admin', 'AddAdmin')->name('add.admin');
//         Route::post('/store/admin', 'StoreAdmin')->name('store.admin');
//         Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin');
//         Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');
//         Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin');
//     });
// });
