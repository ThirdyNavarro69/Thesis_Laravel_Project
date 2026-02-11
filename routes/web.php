<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ClientMiddleware;
use App\Http\Middleware\OwnerMiddleware;
use App\Http\Middleware\FreelancerMiddleware;
use App\Http\Middleware\StudioPhotographerMiddleware;

// Auth Routes =========================================================================================================================================================
Route::prefix('auth')->group(function () {

    Route::get('/login',                [\App\Http\Controllers\Auth\AuthController::class, 'index'])->name('login');
    Route::get('/register',             [\App\Http\Controllers\Auth\AuthController::class, 'register'])->name('register');
    Route::get('/verify',               [\App\Http\Controllers\Auth\AuthController::class, 'verify'])->name('verify');
    Route::post('/register',            [\App\Http\Controllers\Auth\AuthController::class, 'store'])->name('auth.register.store');
    Route::post('/login',               [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('auth.login.store');
    Route::post('/logout',              [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/verify-email/{token}', [\App\Http\Controllers\Auth\AuthController::class, 'verifyEmail'])->name('auth.verify.email');

});

// Authenticated Routes ================================================================================================================================================
Route::middleware(['auth'])->group(function () {

    // Admin Routes ========================================================================================================================================================
    Route::prefix('admin')->middleware([AdminMiddleware::class])->group(function () {

        // Dashboard
        Route::get('/dashboard',                    [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        // Manage Users         
        Route::get('/view/users',                   [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user.index');
        Route::get('/users/data',                   [\App\Http\Controllers\Admin\UserController::class, 'getUsers'])->name('admin.user.data');
        Route::get('/users/{id}/details',           [\App\Http\Controllers\Admin\UserController::class, 'getUserDetails'])->name('admin.user.details');
        Route::delete('/users/{id}',                [\App\Http\Controllers\Admin\UserController::class, 'deleteUser'])->name('admin.user.delete');

        // Manage Studio            
        Route::get('/view/studio',                  [\App\Http\Controllers\Admin\StudioController::class, 'index'])->name('admin.studio.index');
        Route::get('/pending/studio',               [\App\Http\Controllers\Admin\StudioController::class, 'pending'])->name('admin.studio.pending');
        Route::post('/studio/{id}/approve',         [\App\Http\Controllers\Admin\StudioController::class, 'approve'])->name('admin.studio.approve');
        Route::post('/studio/{id}/reject',          [\App\Http\Controllers\Admin\StudioController::class, 'reject'])->name('admin.studio.reject');
        Route::delete('/studio/{id}',               [\App\Http\Controllers\Admin\StudioController::class, 'destroy'])->name('admin.studio.destroy');
    
        // Manage Freelancer    
        Route::get('/view/freelancers',             [\App\Http\Controllers\Admin\FreelancerController::class, 'index'])->name('admin.freelancer.index');
        Route::get('/freelancers/data',             [\App\Http\Controllers\Admin\FreelancerController::class, 'getFreelancers'])->name('admin.freelancer.data');
        Route::get('/freelancers/{id}/details',     [\App\Http\Controllers\Admin\FreelancerController::class, 'getFreelancerDetails'])->name('admin.freelancer.details');
    
        // Manage Categories    
        Route::get('/view/categories',              [\App\Http\Controllers\Admin\CategoriesController::class, 'index'])->name('admin.categories.index');
        Route::get('/create/categories',            [\App\Http\Controllers\Admin\CategoriesController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories',                  [\App\Http\Controllers\Admin\CategoriesController::class, 'store'])->name('admin.categories.store');
        Route::put('/categories/{id}',              [\App\Http\Controllers\Admin\CategoriesController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{id}',           [\App\Http\Controllers\Admin\CategoriesController::class, 'destroy'])->name('admin.categories.delete');
        
        // Manage Locations         
        Route::get('/view/location',                [\App\Http\Controllers\Admin\LocationController::class, 'index'])->name('admin.location.index');
        Route::get('/create/location',              [\App\Http\Controllers\Admin\LocationController::class, 'create'])->name('admin.location.create');
        Route::post('/location',                    [\App\Http\Controllers\Admin\LocationController::class, 'store'])->name('admin.location.store');
        Route::get('/location/{id}',                [\App\Http\Controllers\Admin\LocationController::class, 'show'])->name('admin.location.show');
        Route::get('/location/{id}/edit',           [\App\Http\Controllers\Admin\LocationController::class, 'edit'])->name('admin.location.edit');
        Route::put('/location/{id}',                [\App\Http\Controllers\Admin\LocationController::class, 'update'])->name('admin.location.update');
        Route::delete('/location/{id}',             [\App\Http\Controllers\Admin\LocationController::class, 'destroy'])->name('admin.location.destroy');
        Route::get('/location/data/all',            [\App\Http\Controllers\Admin\LocationController::class, 'getLocations'])->name('admin.location.data');
    });

    // Studio Owner Routes =================================================================================================================================================
    Route::prefix('owner')->middleware([OwnerMiddleware::class])->group(function () {

        // Dashboard
        Route::get('/dashboard',                                [\App\Http\Controllers\StudioOwner\DashboardController::class, 'index'])->name('owner.dashboard');

        // Manage Studio                            
        Route::get('/view/studio',                              [\App\Http\Controllers\StudioOwner\StudioController::class, 'index'])->name('owner.studio.index');
        Route::get('/create/studio',                            [\App\Http\Controllers\StudioOwner\StudioController::class, 'create'])->name('owner.studio.create');
        Route::post('/studio',                                  [\App\Http\Controllers\StudioOwner\StudioController::class, 'store'])->name('owner.studio.store');
        Route::get('/studio/barangays/{municipality}',          [\App\Http\Controllers\StudioOwner\StudioController::class, 'getBarangays'])->name('owner.studio.get-barangays');
        Route::delete('/studio/{id}',                           [\App\Http\Controllers\StudioOwner\StudioController::class, 'destroy'])->name('owner.studio.destroy');

        // Manage Bookings                          
        Route::get('/view/bookings',                            [\App\Http\Controllers\StudioOwner\BookingController::class, 'index'])->name('owner.booking.index');
        Route::get('/booking/history',                          [\App\Http\Controllers\StudioOwner\BookingController::class, 'history'])->name('owner.booking.history');
        Route::get('/bookings/{id}/details',                    [\App\Http\Controllers\StudioOwner\BookingController::class, 'getBookingDetails'])->name('owner.booking.details');
        Route::get('/bookings/{id}/available-photographers',    [\App\Http\Controllers\StudioOwner\BookingController::class, 'getAvailablePhotographers'])->name('owner.booking.available.photographers');
        Route::post('/bookings/{id}/assign-photographers',      [\App\Http\Controllers\StudioOwner\BookingController::class, 'assignPhotographers'])->name('owner.booking.assign.photographers');
        Route::delete('/assignments/{id}',                      [\App\Http\Controllers\StudioOwner\BookingController::class, 'removePhotographerAssignment'])->name('owner.booking.remove.assignment');
        Route::put('/assignments/{id}/status',                  [\App\Http\Controllers\StudioOwner\BookingController::class, 'updateAssignmentStatus'])->name('owner.booking.update.assignment.status');
        Route::put('/bookings/{id}/status',                     [\App\Http\Controllers\StudioOwner\BookingController::class, 'updateStatus'])->name('owner.booking.update.status');
        
        // Manage Studio Schedule                       
        Route::get('/view/schedules',                           [\App\Http\Controllers\StudioOwner\StudioScheduleController::class, 'index'])->name('owner.studio-schedule.index');
        Route::get('/setup/studio-schedules',                   [\App\Http\Controllers\StudioOwner\StudioScheduleController::class, 'setupStudioSchedule'])->name('owner.setup-studio-schedules');
        Route::post('/store/studio-schedules',                  [\App\Http\Controllers\StudioOwner\StudioScheduleController::class, 'store'])->name('owner.studio-schedule.store');
        Route::delete('/delete/studio-schedules/{id}',          [\App\Http\Controllers\StudioOwner\StudioScheduleController::class, 'destroy'])->name('owner.studio-schedule.destroy');

        // Studio Members                           
        Route::get('/view/members',                             [\App\Http\Controllers\StudioOwner\StudioMemberController::class, 'index'])->name('owner.members.index');
        Route::get('/invite/members',                           [\App\Http\Controllers\StudioOwner\StudioMemberController::class, 'invite'])->name('owner.members.invite');
        Route::get('/apply/members',                            [\App\Http\Controllers\StudioOwner\StudioMemberController::class, 'apply'])->name('owner.members.apply');
        Route::post('/members/invite',                          [\App\Http\Controllers\StudioOwner\StudioMemberController::class, 'store'])->name('owner.members.invite.store');
        Route::post('/members/{id}/cancel',                     [\App\Http\Controllers\StudioOwner\StudioMemberController::class, 'cancel'])->name('owner.members.cancel');
        Route::get('/members/freelancer/{id}/details',          [\App\Http\Controllers\StudioOwner\StudioMemberController::class, 'getFreelancerDetails'])->name('owner.members.freelancer.details');

        // Studio Photographers 
        Route::get('/view/studio-photographers',                [\App\Http\Controllers\StudioOwner\StudioPhotographersController::class, 'index'])->name('owner.studio-photographers.index');
        Route::get('/create/studio-photographers',              [\App\Http\Controllers\StudioOwner\StudioPhotographersController::class, 'create'])->name('owner.studio-photographers.create');
        Route::post('/studio-photographers',                    [\App\Http\Controllers\StudioOwner\StudioPhotographersController::class, 'store'])->name('owner.studio-photographers.store');
        Route::get('/studio-photographers/{id}',                [\App\Http\Controllers\StudioOwner\StudioPhotographersController::class, 'show'])->name('owner.studio-photographers.show');
        Route::get('/studio/{id}/services',                     [\App\Http\Controllers\StudioOwner\StudioPhotographersController::class, 'getStudioServices'])->name('owner.studio.services');

        // Manage Category Services                         
        Route::get('/view/services',                            [\App\Http\Controllers\StudioOwner\ServicesController::class, 'index'])->name('owner.services.index');
        Route::get('/create/services',                          [\App\Http\Controllers\StudioOwner\ServicesController::class, 'create'])->name('owner.services.create');
        Route::post('/services',                                [\App\Http\Controllers\StudioOwner\ServicesController::class, 'store'])->name('owner.services.store');
        Route::get('/services/{id}',                            [\App\Http\Controllers\StudioOwner\ServicesController::class, 'show'])->name('owner.services.show');
        Route::get('/services/{id}/edit',                       [\App\Http\Controllers\StudioOwner\ServicesController::class, 'edit'])->name('owner.services.edit');
        Route::put('/services/{id}',                            [\App\Http\Controllers\StudioOwner\ServicesController::class, 'update'])->name('owner.services.update');
        Route::delete('/services/{id}',                         [\App\Http\Controllers\StudioOwner\ServicesController::class, 'destroy'])->name('owner.services.destroy');
        Route::get('/services/data/get',                        [\App\Http\Controllers\StudioOwner\ServicesController::class, 'getServices'])->name('owner.services.data');

        // Manage Packages  
        Route::get('/view/packages',                            [\App\Http\Controllers\StudioOwner\PackagesController::class, 'index'])->name('owner.packages.index');
        Route::get('/create/packages',                          [\App\Http\Controllers\StudioOwner\PackagesController::class, 'create'])->name('owner.packages.create');
        Route::post('/packages',                                [\App\Http\Controllers\StudioOwner\PackagesController::class, 'store'])->name('owner.packages.store');
        Route::get('/packages/lists',                           [\App\Http\Controllers\StudioOwner\PackagesController::class, 'list'])->name('owner.packages.list');
        Route::get('/packages/{package}',                       [\App\Http\Controllers\StudioOwner\PackagesController::class, 'show'])->name('owner.packages.show');
    });

    // Freelancer Routes ===================================================================================================================================================
    Route::prefix('freelancer')->middleware([FreelancerMiddleware::class])->group(function () {

        // Dashboard
        Route::get('/dashboard',                            [\App\Http\Controllers\Freelancer\DashboardController::class, 'index'])->name('freelancer.dashboard');

        // Profile
        Route::get('view/profile',                          [\App\Http\Controllers\Freelancer\ProfileController::class, 'index'])->name('freelancer.profile.index');
        Route::get('setup/profile',                         [\App\Http\Controllers\Freelancer\ProfileController::class, 'setup'])->name('freelancer.profile.setup');
        Route::post('profile/store',                        [\App\Http\Controllers\Freelancer\ProfileController::class, 'store'])->name('freelancer.profile.store');
        Route::post('profile/get-barangays',                [\App\Http\Controllers\Freelancer\ProfileController::class, 'getBarangays'])->name('freelancer.profile.get-barangays');

        // Services
        Route::get('/view/services',                        [\App\Http\Controllers\Freelancer\ServicesController::class, 'index'])->name('freelancer.services.index');
        Route::get('/create/services',                      [\App\Http\Controllers\Freelancer\ServicesController::class, 'create'])->name('freelancer.services.create');
        Route::post('/services',                            [\App\Http\Controllers\Freelancer\ServicesController::class, 'store'])->name('freelancer.services.store');
        Route::get('/services/{id}',                        [\App\Http\Controllers\Freelancer\ServicesController::class, 'show'])->name('freelancer.services.show');
        Route::get('/services/{id}/edit',                   [\App\Http\Controllers\Freelancer\ServicesController::class, 'edit'])->name('freelancer.services.edit');
        Route::put('/services/{id}',                        [\App\Http\Controllers\Freelancer\ServicesController::class, 'update'])->name('freelancer.services.update');
        Route::delete('/services/{id}',                     [\App\Http\Controllers\Freelancer\ServicesController::class, 'destroy'])->name('freelancer.services.destroy');
        Route::get('/services/categories/get',              [\App\Http\Controllers\Freelancer\ServicesController::class, 'getCategories'])->name('freelancer.services.categories');

        // Packages
        Route::get('/view/packages',                        [\App\Http\Controllers\Freelancer\PackagesController::class, 'index'])->name('freelancer.packages.index');
        Route::get('/create/packages',                      [\App\Http\Controllers\Freelancer\PackagesController::class, 'create'])->name('freelancer.packages.create');
        Route::post('/packages',                            [\App\Http\Controllers\Freelancer\PackagesController::class, 'store'])->name('freelancer.packages.store');
        Route::get('/packages/lists',                       [\App\Http\Controllers\Freelancer\PackagesController::class, 'list'])->name('freelancer.packages.list');
        Route::get('/packages/data',                        [\App\Http\Controllers\Freelancer\PackagesController::class, 'getPackages'])->name('freelancer.packages.data');
        Route::get('/packages/categories',                  [\App\Http\Controllers\Freelancer\PackagesController::class, 'getCategories'])->name('freelancer.packages.categories');
        Route::delete('/packages/{id}',                     [\App\Http\Controllers\Freelancer\PackagesController::class, 'destroy'])->name('freelancer.packages.destroy');
        Route::get('/packages/{id}',                        [\App\Http\Controllers\Freelancer\PackagesController::class, 'show'])->name('freelancer.packages.show');
        
        // Member Invitations
        Route::get('view/member-invitation',                [\App\Http\Controllers\Freelancer\MemberInvitationController::class, 'index'])->name('freelancer.invitation.index');
        Route::get('invitation/{id}/details',               [\App\Http\Controllers\Freelancer\MemberInvitationController::class, 'getInvitationDetails'])->name('freelancer.invitation.details');
        Route::post('invitation/{id}/accept',               [\App\Http\Controllers\Freelancer\MemberInvitationController::class, 'accept'])->name('freelancer.invitation.accept');
        Route::post('invitation/{id}/reject',               [\App\Http\Controllers\Freelancer\MemberInvitationController::class, 'reject'])->name('freelancer.invitation.reject');

        // Manage Bookings                          
        Route::get('/view/bookings',                        [\App\Http\Controllers\Freelancer\BookingController::class, 'index'])->name('freelancer.booking.index');
        Route::get('/booking/history',                      [\App\Http\Controllers\Freelancer\BookingController::class, 'history'])->name('freelancer.booking.history');
        Route::get('/bookings/{id}/details',                [\App\Http\Controllers\Freelancer\BookingController::class, 'getBookingDetails'])->name('freelancer.booking.details');
        Route::put('/bookings/{id}/status',                 [\App\Http\Controllers\Freelancer\BookingController::class, 'updateStatus'])->name('freelancer.booking.update.status');
        Route::put('/bookings/{id}/payment-status',         [\App\Http\Controllers\Freelancer\BookingController::class, 'updatePaymentStatus'])->name('freelancer.booking.update.payment.status');
    });

    // Client Routes =======================================================================================================================================================
    Route::prefix('client')->middleware([ClientMiddleware::class])->group(function () {

        // Dashboard
        Route::get('/dashboard',                        [\App\Http\Controllers\Client\DashboardController::class, 'index'])->name('client.dashboard');
        Route::post('/dashboard/filter',                [\App\Http\Controllers\Client\DashboardController::class, 'filter'])->name('client.dashboard.filter');

        // Booking Details
        Route::get('/booking-details/{type}/{id}',      [\App\Http\Controllers\Client\BookingDetailsController::class, 'index'])->name('client.booking-details');

        // Client Bookings
        Route::get('/view/my-bookings',                 [\App\Http\Controllers\Client\MyBookingsController::class, 'index'])->name('client.my-bookings.index');
        Route::get('/view/bookings-history',            [\App\Http\Controllers\Client\MyBookingsController::class, 'history'])->name('client.my-bookings.history');
        Route::get('/bookings/{id}/details',            [\App\Http\Controllers\Client\MyBookingsController::class, 'getBookingDetails'])->name('client.booking.details');
        Route::post('/bookings/{id}/cancel',            [\App\Http\Controllers\Client\MyBookingsController::class, 'cancelBooking'])->name('client.booking.cancel');

        // Booking Process
        Route::get('/booking-form/{type}/{id}',         [\App\Http\Controllers\Client\BookingController::class, 'create'])->name('client.booking-forms');
        Route::post('/bookings',                        [\App\Http\Controllers\Client\BookingController::class, 'store'])->name('client.bookings.store');
        Route::post('/bookings/packages',               [\App\Http\Controllers\Client\BookingController::class, 'getPackages'])->name('client.bookings.packages');
        Route::post('/bookings/check-availability',     [\App\Http\Controllers\Client\BookingController::class, 'checkAvailability'])->name('client.bookings.check-availability');
        Route::post('/bookings/calendar-availability',  [\App\Http\Controllers\Client\BookingController::class, 'getCalendarAvailability'])->name('client.bookings.calendar-availability');
        Route::post('/bookings/summary',                [\App\Http\Controllers\Client\BookingController::class, 'getSummary'])->name('client.bookings.summary');
        
        // Payment
        Route::post('/payments/initialize',             [\App\Http\Controllers\Client\BookingController::class, 'initializePayment'])->name('client.payments.initialize');
        Route::get('/payment/verify/{reference}',       [\App\Http\Controllers\Client\BookingController::class, 'verifyPayment'])->name('client.payment.verify');
        Route::get('/payment/success/{reference}',      [\App\Http\Controllers\Client\BookingController::class, 'paymentSuccess'])->name('client.payment.success');
        Route::get('/payment/failed/{reference}',       [\App\Http\Controllers\Client\BookingController::class, 'paymentFailed'])->name('client.payment.failed');

    });

    // Studio-Photographer  =======================================================================================================================================================
    Route::prefix('studio-photographer')->middleware([StudioPhotographerMiddleware::class])->group(function () {

        // Dashboard
        Route::get('/dashboard',                        [\App\Http\Controllers\StudioPhotographer\DashboardController::class, 'index'])->name('studio-photographer.dashboard');

        // Assigned Studio
        Route::get('/view/studio',                      [\App\Http\Controllers\StudioPhotographer\AssignedStudioController::class, 'index'])->name('studio-photographer.studio.index');
        Route::get('/studio/{id}/details',              [\App\Http\Controllers\StudioPhotographer\AssignedStudioController::class, 'getStudioDetails'])->name('studio-photographer.studio.details');

        // Assigned Studio
        Route::get('/assigned-bookings',                [\App\Http\Controllers\StudioPhotographer\AssignedBookingController::class, 'index'])->name('assigned.bookings');
        Route::get('/assignment/{id}/details',          [\App\Http\Controllers\StudioPhotographer\AssignedBookingController::class, 'getBookingDetails'])->name('assignment.details');
        Route::post('/assignment/{id}/update-status',   [\App\Http\Controllers\StudioPhotographer\AssignedBookingController::class, 'updateAssignmentStatus'])->name('assignment.update-status');

    });

    // Home redirect based on authentication
    Route::get('/', function () {
        if (auth()->check()) {
            $user = auth()->user();
            $routes = [
                'admin' => 'admin.dashboard',
                'owner' => 'owner.dashboard',
                'freelancer' => 'freelancer.dashboard',
                'client' => 'client.dashboard',
                'studio-photographer' => 'studio-photographer.dashboard'
            ];
            
            return redirect()->route($routes[$user->role] ?? 'login');
        }
        
        return redirect()->route('login');
    });
});

// Fallback route for 404 errors (MUST BE AT THE END)
Route::fallback(function () {
    if (auth()->check()) {
        // Redirect authenticated users to their dashboard
        $user = auth()->user();
        $routes = [
            'admin' => 'admin.dashboard',
            'owner' => 'owner.dashboard',
            'freelancer' => 'freelancer.dashboard',
            'client' => 'client.dashboard',
            'studio-photographer' => 'studio-photographer.dashboard'
        ];
        
        return redirect()->route($routes[$user->role] ?? 'login');
    }
    
    // Redirect unauthenticated users to login
    return redirect()->route('login')->with('error', 'Page not found.');
});