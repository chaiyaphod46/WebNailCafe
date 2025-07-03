<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Models\BusinessHour;
use App\Models\Reserv;

class ReservRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function prepareForValidation()
    {
        $this->isValid();
    }

  
    public function rules()
    {
        return [
            'date' => ['required','date_format:Y-m-d'],
            'time' => ['required','date_format:Y-m-d']
        ];
    }

    private function isValid()
    {
        
        $dayName = $this->date('date')->format('l');
        $businessHours = BusinessHour::where('day',$dayName)->first()->TimesPeriod;

        
    }
}
