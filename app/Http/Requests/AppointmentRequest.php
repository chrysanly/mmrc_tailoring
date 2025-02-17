<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        toast('Validation Error', 'warning');
        
        return [
            'school' => 'required',
            'top' => 'nullable',
            'bottom' => 'nullable',
            'set' => 'required',

            'polo_chest' => 'required_if:top,polo',
            'polo_length' => 'required_if:top,polo',
            'polo_hips' => 'required_if:top,polo',
            'polo_shoulder' => 'required_if:top,polo',
            'polo_sleeve' => 'required_if:top,polo',
            'polo_armhole' => 'required_if:top,polo',
            'polo_lower_arm_girth' => 'required_if:top,polo',

            'vest_armhole' => 'required_if:top,vest',
            'vest_full_length' => 'required_if:top,vest',
            'vest_shoulder_width' => 'required_if:top,vest',
            'vest_neck_circumference' => 'required_if:top,vest',

            'blazer_chest' => 'required_if:top,blazer',
            'blazer_shoulder_width' => 'required_if:top,blazer',
            'blazer_length' => 'required_if:top,blazer',
            'blazer_sleeve_length' => 'required_if:top,blazer',
            'blazer_waist' => 'required_if:top,blazer',
            'blazer_hips' => 'required_if:top,blazer',
            'blazer_armhole' => 'required_if:top,blazer',
            'blazer_wrist' => 'required_if:top,blazer',
            'blazer_back_width' => 'required_if:top,blazer',
            'blazer_lower_arm_girth' => 'required_if:top,blazer',

            'pants_length' => 'required_if:bottom,pants',
            'pants_waist' => 'required_if:bottom,pants',
            'pants_hips' => 'required_if:bottom,pants',
            'pants_scrotch' => 'required_if:bottom,pants',
            'pants_knee_height' => 'required_if:bottom,pants',
            'pants_knee_circumference' => 'required_if:bottom,pants',
            'pants_bottom_circumferem' => 'required_if:bottom,pants',

            'short_waist' => 'required_if:bottom,short',
            'short_hips' => 'required_if:bottom,short',
            'short_length' => 'required_if:bottom,short',
            'short_thigh_circumference' => 'required_if:bottom,short',
            'short_inseam_length' => 'required_if:bottom,short',
            'short_leg_opening' => 'required_if:bottom,short',
            'short_rise' => 'required_if:bottom,short',

            'skirt_length' => 'required_if:bottom,skirt',
            'skirt_waist' => 'required_if:bottom,skirt',
            'skirt_hips' => 'required_if:bottom,skirt',
            'skirt_hip_depth' => 'required_if:bottom,skirt',

            'blouse_bust' => 'required_if:top,blouse',
            'blouse_length' => 'required_if:top,blouse',
            'blouse_waist' => 'required_if:top,blouse',
            'blouse_figure' => 'required_if:top,blouse',
            'blouse_hips' => 'required_if:top,blouse',
            'blouse_shoulder' => 'required_if:top,blouse',
            'blouse_sleeve' => 'required_if:top,blouse',
            'blouse_arm_hole' => 'required_if:top,blouse',
            'blouse_lower_arm_girth' => 'required_if:top,blouse',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'The file is required.',
            'school.required' => 'The school is required.',
            'set.required' => 'The set is required.',

            'polo_chest.required_if' => 'The polo chest measurement is required when uniform top is polo.',
            'polo_length.required_if' => 'The polo length measurement is required when uniform top is polo.',
            'polo_hips.required_if' => 'The polo hips measurement is required when uniform top is polo.',
            'polo_shoulder.required_if' => 'The polo shoulder measurement is required when uniform top is polo.',
            'polo_sleeve.required_if' => 'The polo sleeve measurement is required when uniform top is polo.',
            'polo_armhole.required_if' => 'The polo armhole measurement is required when uniform top is polo.',
            'polo_lower_arm_girth.required_if' => 'The polo lower arm girth measurement is required when uniform top is polo.',

            'vest_armhole.required_if' => 'The vest armhole measurement is required when uniform top is vest.',
            'vest_full_length.required_if' => 'The vest full length measurement is required when uniform top is vest.',
            'vest_shoulder_width.required_if' => 'The vest shoulder width measurement is required when uniform top is vest.',
            'vest_neck_circumference.required_if' => 'The vest neck circumference measurement is required when uniform top is vest.',

            'blazer_chest.required_if' => 'The blazer chest measurement is required when uniform top is blazer.',
            'blazer_shoulder_width.required_if' => 'The blazer shoulder width measurement is required when uniform top is blazer.',
            'blazer_length.required_if' => 'The blazer length measurement is required when uniform top is blazer.',
            'blazer_sleeve_length.required_if' => 'The blazer sleeve length measurement is required when uniform top is blazer.',
            'blazer_waist.required_if' => 'The blazer waist measurement is required when uniform top is blazer.',
            'blazer_hips.required_if' => 'The blazer hips measurement is required when uniform top is blazer.',
            'blazer_armhole.required_if' => 'The blazer armhole measurement is required when uniform top is blazer.',
            'blazer_wrist.required_if' => 'The blazer wrist measurement is required when uniform top is blazer.',
            'blazer_back_width.required_if' => 'The blazer back width measurement is required when uniform top is blazer.',
            'blazer_lower_arm_girth.required_if' => 'The blazer lower arm girth measurement is required when uniform top is blazer.',


            'blouse_bust' => 'The blouse bust measurement is required when uniform top is blouse.',
            'blouse_length' => 'The blouse length measurement is required when uniform top is blouse',
            'blouse_waist' => 'The blouse waist measurement is required when uniform top is blouse',
            'blouse_figure' => 'The blouse figure measurement is required when uniform top is blouse',
            'blouse_hips' => 'The blouse hips measurement is required when uniform top is blouse',
            'blouse_shoulder' => 'The blouse shoulder measurement is required when uniform top is blouse',
            'blouse_sleeve' => 'The blouse sleeve measurement is required when uniform top is blouse',
            'blouse_arm_hole' => 'The blouse arm hole measurement is required when uniform top is blouse',
            'blouse_lower_arm_girth' => 'The blouse lower arm girth measurement is required when uniform top is blouse',

            'pants_length.required_if' => 'The pants length measurement is required when uniform bottom is pants.',
            'pants_waist.required_if' => 'The pants waist measurement is required when uniform bottom is pants.',
            'pants_hips.required_if' => 'The pants hips measurement is required when uniform bottom is pants.',
            'pants_scrotch.required_if' => 'The pants scrotch measurement is required when uniform bottom is pants.',
            'pants_knee_height.required_if' => 'The pants knee height measurement is required when uniform bottom is pants.',
            'pants_knee_circumference.required_if' => 'The pants knee circumference measurement is required when uniform bottom is pants.',
            'pants_bottom_circumferem.required_if' => 'The pants bottom circumference measurement is required when uniform bottom is pants.',

            'short_waist.required_if' => 'The short waist measurement is required when uniform bottom is short.',
            'short_hips.required_if' => 'The short hips measurement is required when uniform bottom is short.',
            'short_length.required_if' => 'The short length measurement is required when uniform bottom is short.',
            'short_thigh_circumference.required_if' => 'The short thigh circumference measurement is required when uniform bottom is short.',
            'short_inseam_length.required_if' => 'The short inseam length measurement is required when uniform bottom is short.',
            'short_leg_opening.required_if' => 'The short leg opening measurement is required when uniform bottom is short.',
            'short_rise.required_if' => 'The short rise measurement is required when uniform bottom is short.',

            'skirt_length.required_if' => 'The skirt length measurement is required when uniform bottom is skirt.',
            'skirt_waist.required_if' => 'The skirt waist measurement is required when uniform bottom is skirt.',
            'skirt_hips.required_if' => 'The skirt hips measurement is required when uniform bottom is skirt.',
            'skirt_hip_depth.required_if' => 'The skirt hip depth measurement is required when uniform bottom is skirt.',
        ];
    }
}
