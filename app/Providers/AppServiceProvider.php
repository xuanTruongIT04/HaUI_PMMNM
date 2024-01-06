<?php

namespace App\Providers;

use App\Infrastructure\Repositories\Category\CategoryRepository;
use App\Infrastructure\Repositories\Category\ICategoryRepository;
use App\Infrastructure\Repositories\Fee\FeeRepository;
use App\Infrastructure\Repositories\Fee\IFeeRepository;
use App\Infrastructure\Repositories\MedicalRegistrationForm\IMedicalRegistrationFormRepository;
use App\Infrastructure\Repositories\MedicalRegistrationForm\MedicalRegistrationFormRepository;
use App\Infrastructure\Repositories\Medicine\IMedicineRepository;
use App\Infrastructure\Repositories\Medicine\MedicineRepository;
use App\Infrastructure\Repositories\PasswordResetToken\IPasswordResetTokenRepository;
use App\Infrastructure\Repositories\PasswordResetToken\PasswordResetTokenRepository;
use App\Infrastructure\Repositories\Patient\IPatientRepository;
use App\Infrastructure\Repositories\Patient\PatientRepository;
use App\Infrastructure\Repositories\Prescription\IPrescriptionRepository;
use App\Infrastructure\Repositories\Prescription\PrescriptionRepository;
use App\Infrastructure\Repositories\Product\IProductRepository;
use App\Infrastructure\Repositories\Product\ProductRepository;
use App\Infrastructure\Repositories\Status\IStatusRepository;
use App\Infrastructure\Repositories\Status\StatusRepository;
use App\Infrastructure\Repositories\TestResult\ITestResultRepository;
use App\Infrastructure\Repositories\TestResult\TestResultRepository;
use App\Infrastructure\Repositories\User\IUserRepository;
use App\Infrastructure\Repositories\User\UserRepository;
use App\UseCase\Category\CategoryService;
use App\UseCase\Category\CategoryUseCase;
use App\UseCase\Master\MasterService;
use App\UseCase\Master\MasterUseCase;
use App\UseCase\MedicalRegistrationForm\MedicalRegistrationFormService;
use App\UseCase\MedicalRegistrationForm\MedicalRegistrationFormUseCase;
use App\UseCase\Medicine\MedicineService;
use App\UseCase\Medicine\MedicineUseCase;
use App\UseCase\Patient\PatientService;
use App\UseCase\Patient\PatientUseCase;
use App\UseCase\Product\ProductService;
use App\UseCase\Product\ProductUseCase;
use App\UseCase\TestResult\TestResultService;
use App\UseCase\TestResult\TestResultUseCase;
use App\UseCase\User\UserService;
use App\UseCase\User\UserUseCase;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(ProductUseCase::class, ProductService::class);

        //User
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(UserUseCase::class, UserService::class);

        //Password Reset Token
        $this->app->bind(IPasswordResetTokenRepository::class, PasswordResetTokenRepository::class);

        //Patient
        $this->app->bind(IPatientRepository::class, PatientRepository::class);
        $this->app->bind(PatientUseCase::class, PatientService::class);

        //Medicine
        $this->app->bind(IMedicineRepository::class, MedicineRepository::class);
        $this->app->bind(MedicineUseCase::class, MedicineService::class);

        //Category
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(CategoryUseCase::class, CategoryService::class);

        //Medical Registration Form
        $this->app->bind(IMedicalRegistrationFormRepository::class, MedicalRegistrationFormRepository::class);
        $this->app->bind(MedicalRegistrationFormUseCase::class, MedicalRegistrationFormService::class);

        //Master data
        $this->app->bind(IStatusRepository::class, StatusRepository::class);
        $this->app->bind(MasterUseCase::class, MasterService::class);

        //Fee
        $this->app->bind(IFeeRepository::class, FeeRepository::class);

        //Prescription
        $this->app->bind(IPrescriptionRepository::class, PrescriptionRepository::class);

        //Test Result
        $this->app->bind(ITestResultRepository::class, TestResultRepository::class);
        $this->app->bind(TestResultUseCase::class, TestResultService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Log query SQL
        if (config('app.debug')) {
            DB::listen(function ($query) {
                $sqlWithPlaceholders = str_replace(['%', '?', '%s%s'], ['%%', '%s', '?'], $query->sql);

                $bindings = $query->connection->prepareBindings($query->bindings);
                $pdo = $query->connection->getPdo();
                $realSql = $sqlWithPlaceholders;

                if (count($bindings) > 0) {
                    $realSql = vsprintf($sqlWithPlaceholders, array_map([$pdo, 'quote'], $bindings));
                }

                error_log($realSql);
            });
        }
    }
}
