<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'csv' => 'required|file|mimes:csv|max:128',
        ];
    }

    public function messages()
    {
        return [
            'csv.required' => 'Campo obrigatório.',
            'csv.mimes' => 'O tipo de arquivo aceito é somente CSV.',
            'csv.max' => 'O tamanho do arquivo aceito é até 128 MB.'
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->hasFile('csv')) {
            return redirect()->back()
                ->withErrors(['message', 'Por favor, adicione um arquivo CSV que não esteja vazio.']);
        }
    }
}
