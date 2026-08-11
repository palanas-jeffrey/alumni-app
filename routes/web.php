<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\UAEventController;
use App\Http\Controllers\AccountController;
use App\Http\Middleware\CheckAccountActivation;
use App\Http\Controllers\UserSessionController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\PublishedFormController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\TracerController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\SubmissionScheduleController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyResponseController;

use Illuminate\Support\Facades\Route;

Route::middleware('auth.any')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('accounts')->group(function () { 
        Route::get("/programs", [AccountController::class, "getProgram"])->name("accounts.programs");
        Route::get("/account-details/{id}", [AccountController::class, "getAccountDetails"])
            ->name("accounts.account-details");
        Route::get("/view-details/{id}", [AccountController::class, "viewAccountDetails"])
            ->name("accounts.view-details");
    });

    Route::prefix('tracer')->group(function () {
        Route::get("/questionaire/{form_id}", [TracerController::class, "showQuestionaire"])->name("tracer.questionaire");
        Route::get('/view-response/{response_id}', [ResponseController::class, 'viewResponse'])->name('tracer.view-response');
    });

    Route::prefix('survey')->group(function () {
        Route::get("/questionaire/{form_id}", [SurveyController::class, "showQuestionaire"])->name("survey.questionaire");
        Route::get('/view-response/{response_id}', [SurveyResponseController::class, 'viewResponse'])->name('survey.view-response');
    });
});

Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::middleware('auth:admin')->group(function () {

    Route::get('/admin-dashboard', [DashboardController::class, 'index'])->name('admin-dashboard');

    Route::get('/eventManagement', [UAEventController::class, 'index'])->name('eventManagement');
    
    Route::get('/donationLogs', [DonationController::class, 'getDonationTransactions'])
        ->name('donationLogs');
    
    Route::get('/accountManagement', [AccountController::class, 'index'])
        ->name('accountManagement');

    Route::prefix('/tracerManagement')->group(function () {
        Route::get('/', [FormController::class, 'viewTracerOverview'])
            ->name('tracerManagement');
        Route::get('/form-list', [FormController::class, 'viewFormList'])
            ->name('tracerMgmt.form-list');
    });

    Route::prefix('accounts')->group(function () {
        Route::delete('/account-delete/{account_id}', [AccountController::class, 'deleteAccount'])
            ->name('accounts.account-delete');
        Route::get("/admin-edit/{account_id}", [AccountController::class, "editAdminAccount"])
            ->name("accounts.admin-edit");
        Route::get("/administrators", [AccountController::class, "getAdminList"])
            ->name("accounts.administrators");
        Route::get("/alumni-edit/{account_id}", [AccountController::class, "editAlumniAccount"])
            ->name("account.alumni-edit");
    });

    Route::post('/form-save-questions', [FormController::class, 'show'])->name('form-save-questions');

    Route::get('/field-get/{id}', [FieldController::class, 'showFieldWithOptions'])->name('field-get');
    
    Route::get('/form/{id}', [FormController::class, 'show'])->name('form');

    Route::prefix('tracer')->group(function () {
        Route::get('/form-edit/{form_id}', [FormController::class, 'show'])->name('tracer.form-edit');
        Route::get('/form-report-overview/{id}', [TracerController::class, 'viewTracerOverviewPerProgram'])->name('tracer.form-report-overview');
        Route::get('/responses-per-program/{form_id}/{program_id}', [TracerController::class, 'viewTracerResponsesPerProgram'])->name('tracer.responses-per-program');
        Route::get('/report-overview/batches/{form_id}/{program_id}', [TracerController::class, 'viewTracerOverviewPerProgramPerBatch'])
            ->name('tracer.report-overview.batches');
        Route::get('/report-overview/batch/{form_id}/{program_id}/{batch_id}', [TracerController::class, 'viewTracerResponseStatsPerProgramPerBatch'])
            ->name('tracer.report-overview.batch');
        // Route::get('/response-edit/{response_id}', [TracerController::class, 'editTracerResponse'])->name('tracer.response-edit');
        Route::post('/generate-report', [TracerController::class, 'generateTracerReport'])->name('tracer.generate-report');
        Route::get('/submission-reminders', [SubmissionScheduleController::class, 'showSubmissionSchedule'])
            ->name('tracer.submission-reminders');
    });

    Route::prefix('configurations')->group(function () {
        Route::get('/', [ConfigurationController::class, 'showMain'])->name('configurations');
        Route::get('/admin-key', [ConfigurationController::class, 'showAdminKeyConfiguration'])
            ->name('configuration.admin-key');
    });

    Route::prefix('survey')->group(function () {
        Route::get('/', [SurveyController::class, 'index'])->name('survey.main');
        Route::get('/survey-form-edit/{form_id}', [SurveyController::class, 'editSurveyForm'])
            ->name('survey.form-edit');
        Route::get('/survey-form-overview/{form_id}', [SurveyController::class, 'viewSurveyFormOverview'])
            ->name('survey.survey-form-overview');
        Route::get('/survey-report-periods-overview/{form_id}', [SurveyController::class, 'viewSurveyOverviewPerPeriod'])
            ->name('survey.survey-report-periods-overview');
        Route::get('/survey-report-programs-overview/{form_id}/{period_id}', [SurveyController::class, 'viewSurveyOverviewPerProgram'])
            ->name('survey.survey-report-programs-overview');
        Route::get('/survey-report-overview/batches/{form_id}/{program_id}/{period_id}', [SurveyController::class, 'viewTracerResponseStatsPerProgramPerBatch'])
            ->name('survey.report-overview.batches');
        Route::get('/survey-report-analysis/{form_id}/{program_id}/{period_id}/{batch}', [SurveyController::class, 'viewSurveyResponseAnalysis'])
            ->name('survey.survey-report-analysis');
        Route::post('/generate-report', [SurveyController::class, 'generateReport'])
            ->name('survey.generate-report');
    });
});

Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/events', [UAEventController::class, 'showEvents'])->name('alumniEvents');

    Route::get('/tracer-completion', function () {
        return view('alumni.tracerCompletion');
    })->name('tracer-completion');

    Route::get('/donation-thank-you', function () {
        return view('alumni.donation-post-process');
    });

    Route::prefix('donation')->group(function () {
        Route::get('/', [DonationController::class, 'showDonationPage'])
            ->name('donation');
        Route::get('/history', [DonationController::class, 'showUserDonationHistory'])
            ->name('donation.history');
    });

    Route::prefix('tracer')->group(function () {
        Route::get("/participation", [TracerController::class, "viewTracerParticipation"])->name("tracer.participation");
        Route::get("/consent", [TracerController::class, "viewConsent"])->name("tracer.consent");
    });

     Route::get('/reset-password-user', function () {
        return view('auth.reset-password-user');
    })->name('user.password.change');

    Route::prefix('survey')->group(function () {
        Route::get("/participate", [SurveyController::class, "showUserSurveyLanding"])->name("survey.user-survey-landing");
        Route::get("/questionaire-respond/{form_id}/{period_id}", [SurveyController::class, "showQuestionaireToParticipate"])
            ->name("survey.questionaire-respond");
    });

    Route::get('/survey-completion', function () {
        return view('alumni.surveyCompletion');
    })->name('survey-completion');
});



require __DIR__.'/auth.php';
