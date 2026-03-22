<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Een FormRequest verplaatst de validatie-logica uit de controller naar een aparte klasse.
 * Dit houdt de controller 'schoon' (Single Responsibility Principle).
 */
class ProfileUpdateRequest extends FormRequest
{
    /**
     * Definieer de validatieregels die op dit formulier van toepassing zijn.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                // Zorg dat het emailadres uniek is, maar negeer de huidige gebruiker zelf 
                // (anders kun je je eigen email niet opslaan zonder foutmelding).
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'bio' => ['nullable', 'string', 'max:1000'],
            'skills' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
        ];
    }
}
