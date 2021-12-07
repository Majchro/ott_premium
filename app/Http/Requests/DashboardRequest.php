<?php

namespace App\Http\Requests;

use Auth;
use App;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class DashboardRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user' => $this->user ?? Auth::user()->id,
            'month' => $this->month ?? Carbon::now()->format("Y-m"),
        ]);
    }

    public function rules()
    {
        return [
            'user' => ['integer'],
            'month' => ['nullable', 'date_format:Y-m']
        ];
    }

    protected function getRedirectUrl()
    {
        return App::abort(400);
    }
}
