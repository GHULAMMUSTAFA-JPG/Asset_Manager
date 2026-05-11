<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\CompanyRequests\RegisterCompanyRequest;
use App\Http\Requests\CompanyRequests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;

class CompanyController extends Controller
{
    public function register(RegisterCompanyRequest $request)
    {
        $company = Company::create($request->validated());
        return ApiResponse::created(new CompanyResource($company), 'Company registered successfully');
    }

    public function index()
    {
        $companies = Company::paginate(15);
        return ApiResponse::success(CompanyResource::collection($companies));
    }

    public function show(int $id)
    {
        $company = Company::findOrFail($id); // throws 404 automatically
        return ApiResponse::success(new CompanyResource($company));
    }

    public function update(UpdateCompanyRequest $request, int $id)
    {
        $company = Company::findOrFail($id);
        $company->update($request->validated());
        return ApiResponse::success(new CompanyResource($company), 'Company updated');
    }

    public function toggleStatus(int $id)
    {
        $company = Company::findOrFail($id);
        $company->update(['is_active' => !$company->is_active]);
        $status = $company->is_active ? 'activated' : 'deactivated';
        return ApiResponse::success(new CompanyResource($company), "Company {$status}");
    }
}