<?php

use App\Models\Permindok;
use App\Models\Suboutput;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\CapaianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArchieveController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\CapaianKinerja\RealisasiController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermindokController;
use App\Http\Controllers\SuboutputController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\PerjadinController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SasaranController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\TujuanController;
use App\Http\Controllers\Perjadin\FormulirController;
use App\Http\Controllers\Perjadin\LaporanController;
use App\Http\Controllers\Perjadin\RingkasanController;
use App\Models\Submission;

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

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('permindok/monitoring', [PermindokController::class, 'monitoring'])->name('permindok.monitoring');
    Route::get('permindok/monitoring/{permindok}', [PermindokController::class, 'monitoringShow'])->name('permindok.monitoring.show');

    Route::post('team/filter', [TeamController::class, 'filter'])->name('filter-team');
    Route::middleware('admin')->group(function () {
        Route::get('user/reset-password/{user}', [UserController::class, 'resetpassword'])->name('reset-password-user');
        Route::resource('user', UserController::class);

        Route::resource('team', TeamController::class);
    });

    Route::middleware('admin.provinsi')->group(function () {
        Route::resource('period', PeriodController::class);

        Route::get('permindok/{permindok}/document', [PermindokController::class, 'document'])->name('permindok.documents');
        Route::get('permindok/{permindok}/enrollment', [PermindokController::class, 'enrollment'])->name('permindok.enrollment');
        Route::get('permindok/{permindok}/re-enrollment', [SubmissionController::class, 'fresh'])->name('permindok.reenrollment');
        Route::resource('permindok', PermindokController::class);

        Route::get('document/{document}/criteria', [DocumentController::class, 'criteria'])->name('document.criterias');
        Route::resource('document', DocumentController::class);

        Route::resource('criteria', CriteriaController::class);

        Route::resource('perjanjian-kinerja/tujuan', TujuanController::class);
        Route::resource('perjanjian-kinerja/sasaran', SasaranController::class);
        Route::resource('perjanjian-kinerja/indicator', IndicatorController::class);
        // Route::resource('fra/target', TargetController::class);
    });

    Route::resource('capaian-kinerja/target', TargetController::class)->names('capaian-kinerja.target');
    Route::resource('capaian-kinerja/realisasi', RealisasiController::class)->names('capaian-kinerja.realisasi');

    Route::get('submission/result/{submission}/detail', [SubmissionController::class, 'detail'])->name('submission.detail');
    Route::get('submission/result', [SubmissionController::class, 'result'])->name('submission.result');

    Route::get('submission/supervision', [SubmissionController::class, 'supervision'])->name('submission.supervision');
    Route::get('submission/supervision/{submission}/archieve', [SubmissionController::class, 'archieveSupervision'])->name('submission.archieves.supervision');
    Route::get('submission/supervision/archieve/{archieve}/audit', [ArchieveController::class, 'auditSupervision'])->name('submission.audit.supervision');

    Route::get('submission/{submission}/archieve', [SubmissionController::class, 'archieve'])->name('submission.archieves');
    Route::resource('submission', SubmissionController::class);


    Route::put('archieve/{archieve}/update-link', [ArchieveController::class, 'updateLink'])->name('archieve.updatelink');
    Route::put('archieve/{archieve}/update-status', [ArchieveController::class, 'updateStatus'])->name('archieve.updatestatus');

    Route::put('audit/{audit}/update-status', [AuditController::class, 'update'])->name('audit.update');

    //Penilaian Kinerja Satuan Kerja
    Route::post('output/team-fetch', [OutputController::class, 'teamFetch'])->name('output-fetch');

    Route::get('evaluation/monitoring', [EvaluationController::class, 'monitoring'])->name('evaluation-monitoring');
    Route::post('evaluation/monitoring/fetch', [EvaluationController::class, 'fetchMonitoring'])->name('evaluation-fetchmonitoring');

    Route::post('evaluation/final', [EvaluationController::class, 'final'])->name('final-evaluation');
    Route::post('evaluation/fetch-filter', [EvaluationController::class, 'fetchFilter'])->name('evaluation-fetch-filter');
    Route::get('evaluation/export/{year}/{month}', [EvaluationController::class, 'export'])->name('evaluation-export');
    Route::get('evaluation/finalisasi', [EvaluationController::class, 'finalisasi'])->name('evaluation-finalization');
    Route::get('evaluation/detail/{year}/{month}/{satker}', [EvaluationController::class, 'detail'])->name('detail-evaluation');

    Route::get('evaluation/result', [EvaluationController::class, 'result'])->name('evaluation-result');
    Route::post('evaluation/recap', [EvaluationController::class, 'getRecap'])->name('evaluation-recap');

    Route::get('evaluation/approval', [EvaluationController::class, 'approval'])->name('evaluation-approval');
    Route::post('evaluation/approve-all', [EvaluationController::class, 'approve_all'])->name('approveall-evaluation');
    Route::post('evaluation/fetchApproval', [EvaluationController::class, 'fetchApproval'])->name('fetch-approval');
    Route::get('evaluation/approve/{evaluation}', [EvaluationController::class, 'approve'])->name('approve-evaluation');

    Route::post('evaluation/filter', [EvaluationController::class, 'filter'])->name('filter-evaluation');
    Route::get('evaluation/submit/{evaluation}', [EvaluationController::class, 'submit'])->name('submit-evaluation');
    Route::post('evaluation/create/none', [EvaluationController::class, 'create_null'])->name('create-null');
    Route::resource('evaluation', EvaluationController::class);

    Route::post('documentation/filter', [DocumentationController::class, 'filter'])->name('filter-documentation');
    Route::resource('documentation', DocumentationController::class);

    Route::get('output/{output}/suboutput/create', [SuboutputController::class, 'create'])->name('suboutput-create');
    Route::resource('output', OutputController::class);

    Route::resource('suboutput', SuboutputController::class);

    Route::get('capaian-kinerja/monitoring', [CapaianController::class, 'monitoring'])->name('capaian-monitoring');

    Route::get('perjadin/formulir', [FormulirController::class, 'index'])->name('perjadin.formulir.index');
    Route::post('perjadin/formulir', [FormulirController::class, 'store'])->name('perjadin.formulir.store');
    Route::get('perjadin/formulir/{formulir}/edit', [FormulirController::class, 'edit'])->name('perjadin.formulir.edit');
    Route::post('perjadin/formulir/{formulir}/update', [FormulirController::class, 'update'])->name('perjadin.formulir.update');
    Route::delete('perjadin/formulir/{formulir}', [FormulirController::class, 'destroy'])->name('perjadin.formulir.destroy');

    Route::get('perjadin/ringkasan', [RingkasanController::class, 'index'])->name('perjadin.ringkasan.index');
    Route::get('perjadin/ringkasan/create', [RingkasanController::class, 'create'])->name('perjadin.ringkasan.create');
    Route::post('perjadin/ringkasan', [RingkasanController::class, 'store'])->name('perjadin.ringkasan.store');
    Route::get('perjadin/ringkasan/{ringkasan}/edit', [RingkasanController::class, 'edit'])->name('perjadin.ringkasan.edit');
    Route::post('perjadin/ringkasan/{ringkasan}/update', [RingkasanController::class, 'update'])->name('perjadin.ringkasan.update');
    Route::delete('perjadin/ringkasan/{ringkasan}', [RingkasanController::class, 'destroy'])->name('perjadin.ringkasan.destroy');
    // Route::get('perjadin/formulir', FormulirController::class);

    Route::get('perjadin/laporan', [LaporanController::class, 'index'])->name('perjadin.laporan.index');
    Route::get('perjadin/laporan/create', [LaporanController::class, 'create'])->name('perjadin.laporan.create');
    Route::post('perjadin/laporan', [LaporanController::class, 'store'])->name('perjadin.laporan.store');
    Route::get('perjadin/laporan/{laporan}/edit', [LaporanController::class, 'edit'])->name('perjadin.laporan.edit');
    Route::post('perjadin/laporan/{laporan}/update', [LaporanController::class, 'update'])->name('perjadin.laporan.update');
    Route::delete('perjadin/laporan/{laporan}', [LaporanController::class, 'destroy'])->name('perjadin.laporan.destroy');
});

require __DIR__ . '/auth.php';
