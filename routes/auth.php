<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\AuthenticatedAdminSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\NewPasswordAdminController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\PasswordResetLinkAdminController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\RegisterAdminController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UAEventController;
use App\Http\Controllers\AccountActivationController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\PublishedFormController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\ProfilePhotoController;
use App\Http\Controllers\TwilioController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\TracerController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyResponseController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    
    Route::get('administrator-login', [AuthenticatedAdminSessionController::class, 'create'])
        ->name('admin-login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::post('administrator-login-auth', [AuthenticatedAdminSessionController::class, 'store'])
        ->name('admin-login-auth');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');
});

Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/forgot-password', [PasswordResetLinkAdminController::class, 'create'])
        ->name('admin.password.request');
    
    Route::post('/admin/forgot-password', [PasswordResetLinkAdminController::class, 'store'])
        ->name('admin.password.email');

    Route::get('/admin/reset-password/{token}', [NewPasswordAdminController::class, 'create'])
        ->name('admin.password.reset');

    Route::post('/admin/reset-password', [NewPasswordAdminController::class, 'store'])
        ->name('admin.password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::post('/proccessPaymongo', [DonationController::class, 'proccessPaymongoPaymongo']);
    Route::prefix('donations')->group(function () {
        Route::post('/monetary', [DonationController::class, 'saveMonetaryDonation'])->name('donations.monetary.save');
        Route::post('/in-kind', [DonationController::class, 'saveInKindDonation'])->name('donations.in-kind.save');
        Route::post('/facilty', [DonationController::class, 'saveFacilityDonation'])->name('donations.facility.save');
        // Route::post('/get-paymongo-payment-status', [DonationController::class, 'getPaymongoPaymkindinentStatus'])
        //     ->name('donations.paymongo-payment-status.get');
        Route::post('/facilty-received', [DonationController::class, 'updateStatusFacilityDonation'])->name('donation.facility.received');
    });

    Route::post('/save-alumni-event', [UAEventController::class, 'store'])->name('save-alumni-event');
    
    Route::post('/save-question', [FieldController::class, 'store'])->name('save-question');
    Route::post('/field-update/{id}', [FieldController::class, 'update'])->name('field-update');
    Route::delete('/field-delete/{id}', [FieldController::class, 'deleteFieldAndOptions'])->name('field-delete');

    // Route::post('/donation-generate-paymongo-report', [DonationController::class, 'generatePaymongoReport'])->name('donation-generate-paymongo-report');
    // Route::post('/donation-generate-monetary-report', [DonationController::class, 'generateMonetaryDonationReport'])->name('donation-generate-monetary-report');
    // Route::post('/donation-generate-in-kind-report', [DonationController::class, 'generateInKindDonationReport'])->name('donation-generate-in-kind-report');
    // Route::post('/donation-generate-facility-report', [DonationController::class, 'generateFacilityDonationReport'])->name('donation-generate-facility-report');

    // Route::post('/uaevents-generate-report', [UAEventController::class, 'generateReport'])->name('uaevents-generate-report');
    // Route::post('/user-accounts-generate-report', [AccountController::class, 'generateUserAccountsReport'])->name('user-accounts-generate-report');
    Route::post('/tracer-response-generate-report', [ResponseController::class, 'generateTracerResponses'])->name('tracer-response-generate-report');

    Route::post('/send-sms', [TwilioController::class, 'sendSms'])->name('send-sms');
    
    // Route::post('/send-account-activation-email', [EmailController::class, 'sendAccountActivationEmail'])->name('send-account-activation-email');
});

Route::middleware('auth.any')->group(function () {
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::prefix('/tracer')->group(function () {
        Route::post('/get-response', [ResponseController::class, 'getTracerResponse'])->name('tracer.get-response');
    });

    Route::prefix('/survey')->group(function () {
        Route::post('/get-response', [SurveyResponseController::class, 'getResponse'])->name('survey.get-response');
    });
});

Route::middleware('auth:admin')->group(function () {
    Route::post('admin/logout', [AuthenticatedAdminSessionController::class, 'destroy'])
        ->name('admin.logout');

    Route::prefix('account')->group(function () {
        Route::get('registration', [RegisterUserController::class, 'create'])
            ->name('account.registration');
        Route::post('register', [RegisterUserController::class, 'store'])
            ->name('account.register');
        Route::get('admin/registration', [RegisterAdminController::class, 'create'])
            ->name('admin.registration');
    });

    Route::prefix('donation')->group(function () {
        Route::post('/facilty-received', [DonationController::class, 'updateStatusFacilityDonation'])->name('donation.facility.received');
        Route::post('/in-kind-received', [DonationController::class, 'updateStatusInKindDonation'])->name('donation.in-kind.received');
        Route::post('/monetary-received', [DonationController::class, 'updateStatusMonetatyDonation'])->name('donation.monetary.received');
    });

    Route::post('/donation-generate-paymongo-report', [DonationController::class, 'generatePaymongoReport'])
        ->name('donation-generate-paymongo-report');
    Route::post('/donation-generate-monetary-report', [DonationController::class, 'generateMonetaryDonationReport'])
        ->name('donation-generate-monetary-report');
    Route::post('/donation-generate-in-kind-report', [DonationController::class, 'generateInKindDonationReport'])
        ->name('donation-generate-in-kind-report');
    Route::post('/donation-generate-facility-report', [DonationController::class, 'generateFacilityDonationReport'])
        ->name('donation-generate-facility-report');

    Route::prefix('tracerManagement')->group(function () {
        Route::post('/create-form', [FormController::class, 'store'])->name('tracerManagement.create-form');
        Route::post('/update-form/{form_id}', [FormController::class, 'update'])->name('tracerManagement.update-form');
        Route::delete('/delete-form/{form_id}', [FormController::class, 'delete'])->name('tracerManagement.delete-form');
    });

    Route::prefix('/form')->group(function () {
        Route::post('/publish-form', [FormController::class, 'publish'])->name('form.publish-form');
        Route::post('/unpublish-form', [FormController::class, 'unpublish'])->name('form.unpublish-form');
    });

    Route::prefix('events')->group(function () {
        Route::post('/uaevent-save', [UAEventController::class, 'store'])->name('event.save');
        Route::delete('/uaevent/{id}', [UAEventController::class, 'destroy'])->name('event.delete');;
        Route::get('/uaevent-edit/{id}', [UAEventController::class, 'showEvent'])->name('event.edit');
        Route::get('/uaevent-edit-previous/{id}', [UAEventController::class, 'showPreviousEvent'])->name('event.edit-previous');
        Route::post('/uaevent-update/{id}', [UAEventController::class, 'update'])->name('event.update');
    });

    Route::post('/admin-profile/save-photo/{admin_id}', [ProfilePhotoController::class, 'uploadAdminProfilePhoto'])
        ->name('admin-profile.save-photo');

    Route::prefix('survey')->group(function () {
        Route::post('/set-target-participants', [SurveyController::class, 'setTargetParticipants'])->name('survey.set-target-participants');
    });
});

Route::middleware('auth:web')->group(function () {
    Route::prefix('donations')->group(function () {
        Route::post('/get-paymongo-payment-status', [DonationController::class, 'getPaymongoPaymentStatus'])
            ->name('donations.paymongo-payment-status.get');
    });

    Route::post('reset-password-user', [NewPasswordController::class, 'storeNewPassword'])
        ->name('user.password.store');

    Route::prefix('/tracer')->group(function () {
        Route::post('/save-response/{form_id}', [ResponseController::class, 'storeResponse'])
            ->name('tracer.save-response');
        Route::post('/save-documents/{form_id}', [ResponseController::class, 'storeDocuments'])
            ->name('tracer.save-documents');
        Route::post('/update-response/{form_id}', [ResponseController::class, 'updateResponse'])
            ->name('tracer.update-response');
        Route::post('/process-consent', [TracerController::class, 'processConsent'])
            ->name('tracer.process-consent');
    });

    Route::prefix('survey')->group(function () {
        Route::post('/save-response/{form_id}', [SurveyResponseController::class, 'storeResponse'])
            ->name('survey.save-response');
        Route::post('/update-response/{form_id}', [SurveyResponseController::class, 'updateResponse'])
            ->name('survey.update-response');
        Route::post('/save-documents/{form_id}', [SurveyResponseController::class, 'storeDocuments'])
            ->name('survey.save-documents');
    });

    Route::post('/profile/save-photo/{user_id}', [ProfilePhotoController::class, 'uploadProfilePhoto'])
        ->name('profile.save-photo');
});
