<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Resources\Company\CompanyResource;
use App\Jobs\SendInvitationEmail;
use App\Mail\InviteMail;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    /**
     * @param StoreCompanyRequest $request
     * @return JsonResponse
     */
    public function store(StoreCompanyRequest $request): JsonResponse
    {
        $company = Company::query()->create($request->validated());

        $user = auth()->user();
        $user->{'company_id'} = $company->id;
        $user->save();

        return response()->json([
            'company' => new CompanyResource($company)
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param Company $company
     * @return JsonResponse
     */
    public function invite(Request $request, Company $company): JsonResponse
    {
        $company->load('tariff');
        $maxUsers = $company->tariff->max_users;

        $existingUsersCount = $company->users()->count();
        $remainingInvites = $maxUsers - $existingUsersCount;

        if ($remainingInvites <= 0) {
            return response()->json([
                'message' => 'No invites available'
            ], Response::HTTP_BAD_REQUEST);
        }

        $emails = $request->input('emails');

        foreach ($emails as $email) {
            SendInvitationEmail::dispatch($email, $company);
        }

        return response()->json([
            'message' => 'Users was successfully invited',
        ]);
    }
}
