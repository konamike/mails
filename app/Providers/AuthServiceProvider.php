<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Allfile;
use App\Models\Category;
use App\Models\Contractor;
use App\Models\File;
use App\Models\Filedispatch;
use App\Models\Filetreat;
use App\Models\Letter;
use App\Models\Letterdispatch;
use App\Models\Lettertreat;
use App\Models\Memo;
use App\Models\Memodispatch;
use App\Models\Memotreat;
use App\Policies\ActivityPolicy;
use App\Policies\AllfilePolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ContractorPolicy;
use App\Policies\FiledispatchPolicy;
use App\Policies\FilePolicy;
use App\Policies\FiletreatPolicy;
use App\Policies\LetterdispatchPolicy;
use App\Policies\LetterPolicy;
use App\Policies\LettertreatPolicy;
use App\Policies\MemodispatchPolicy;
use App\Policies\MemoPolicy;
use App\Policies\MemotreatPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Contractor::class => ContractorPolicy::class,
        File::class => FilePolicy::class,
        Letter::class => LetterPolicy::class,
        Memo::class => MemoPolicy::class,
        Filetreat::class => FiletreatPolicy::class,
        Lettertreat::class => LettertreatPolicy::class,
        Memotreat::class => MemotreatPolicy::class,
        Filedispatch::class =>  FiledispatchPolicy::class,
        Letterdispatch::class => LetterdispatchPolicy::class,
        Memodispatch::class => MemodispatchPolicy::class,
        Allfile::class => AllfilePolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        Activity::class => ActivityPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
