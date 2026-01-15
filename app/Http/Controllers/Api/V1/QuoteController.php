<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use Botble\Contact\Repositories\Interfaces\ContactInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuoteController extends ApiController
{
    public function __construct(protected ContactInterface $contactRepository)
    {
    }

    /**
     * Submit a B2B Quote Request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:120',
            'phone' => 'nullable|string|max:20',
            'company' => 'required|string|max:120',
            'siret' => 'nullable|string|max:20',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        // Format content to include B2B specific fields since we are using the generic Contact model
        $content = "DEMANDE DE DEVIS B2B\n\n";
        $content .= "Société: " . $request->input('company') . "\n";
        if ($request->input('siret')) {
            $content .= "SIRET: " . $request->input('siret') . "\n";
        }
        $content .= "--------------------------------\n";
        $content .= $request->input('content');

        try {
            $this->contactRepository->createOrUpdate([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'subject' => 'Demande de Devis B2B: ' . $request->input('company'),
                'content' => $content,
                'status' => 'unread',
            ]);

            return $this->success(null, 'Votre demande de devis a été envoyée avec succès. Un expert vous contactera sous peu.');
        } catch (\Exception $e) {
            return $this->error('Une erreur est survenue lors de l\'envoi de la demande.', 500);
        }
    }
}
