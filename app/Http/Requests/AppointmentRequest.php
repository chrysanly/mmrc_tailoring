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

            'polo_chest' => 'nullable|required_if:top,polo|numeric|min:3',
            'polo_length' => 'nullable|required_if:top,polo|numeric|min:3',
            'polo_hips' => 'nullable|required_if:top,polo|numeric|min:3',
            'polo_shoulder' => 'nullable|required_if:top,polo|numeric|min:3',
            'polo_sleeve' => 'nullable|required_if:top,polo|numeric|min:3',
            'polo_armhole' => 'nullable|required_if:top,polo|numeric|min:3',
            'polo_lower_arm_girth' => 'nullable|required_if:top,polo|numeric|min:3',

            'vest_armhole' => 'nullable|required_if:top,vest|numeric|min:3',
            'vest_full_length' => 'nullable|required_if:top,vest|numeric|min:3',
            'vest_shoulder_width' => 'nullable|required_if:top,vest|numeric|min:3',
            'vest_neck_circumference' => 'nullable|required_if:top,vest|numeric|min:3',

            'blazer_chest' => 'nullable|required_if:top,blazer|numeric|min:3',
            'blazer_shoulder_width' => 'nullable|required_if:top,blazer|numeric|min:3',
            'blazer_length' => 'nullable|required_if:top,blazer|numeric|min:3',
            'blazer_sleeve_length' => 'nullable|required_if:top,blazer|numeric|min:3',
            'blazer_waist' => 'nullable|required_if:top,blazer|numeric|min:3',
            'blazer_hips' => 'nullable|required_if:top,blazer|numeric|min:3',
            'blazer_armhole' => 'nullable|required_if:top,blazer|numeric|min:3',
            'blazer_wrist' => 'nullable|required_if:top,blazer|numeric|min:3',
            'blazer_back_width' => 'nullable|required_if:top,blazer|numeric|min:3',
            'blazer_lower_arm_girth' => 'nullable|required_if:top,blazer|numeric|min:3',

            'pants_length' => 'nullable|required_if:bottom,pants|numeric|min:3',
            'pants_waist' => 'nullable|required_if:bottom,pants|numeric|min:3',
            'pants_hips' => 'nullable|required_if:bottom,pants|numeric|min:3',
            'pants_scrotch' => 'nullable|required_if:bottom,pants|numeric|min:3',
            'pants_knee_height' => 'nullable|required_if:bottom,pants|numeric|min:3',
            'pants_knee_circumference' => 'nullable|required_if:bottom,pants|numeric|min:3',
            'pants_bottom_circumferem' => 'nullable|required_if:bottom,pants|numeric|min:3',

            'short_waist' => 'nullable|required_if:bottom,short|numeric|min:3',
            'short_hips' => 'nullable|required_if:bottom,short|numeric|min:3',
            'short_length' => 'nullable|required_if:bottom,short|numeric|min:3',
            'short_thigh_circumference' => 'nullable|required_if:bottom,short|numeric|min:3',
            'short_inseam_length' => 'nullable|required_if:bottom,short|numeric|min:3',
            'short_leg_opening' => 'nullable|required_if:bottom,short|numeric|min:3',
            'short_rise' => 'nullable|required_if:bottom,short|numeric|min:3',

            'skirt_length' => 'nullable|required_if:bottom,skirt|numeric|min:3',
            'skirt_waist' => 'nullable|required_if:bottom,skirt|numeric|min:3',
            'skirt_hips' => 'nullable|required_if:bottom,skirt|numeric|min:3',
            'skirt_hip_depth' => 'nullable|required_if:bottom,skirt|numeric|min:3',

            'blouse_bust' => 'nullable|required_if:top,blouse|numeric|min:3',
            'blouse_length' => 'nullable|required_if:top,blouse|numeric|min:3',
            'blouse_waist' => 'nullable|required_if:top,blouse|numeric|min:3',
            'blouse_figure' => 'nullable|required_if:top,blouse|numeric|min:3',
            'blouse_hips' => 'nullable|required_if:top,blouse|numeric|min:3',
            'blouse_shoulder' => 'nullable|required_if:top,blouse|numeric|min:3',
            'blouse_sleeve' => 'nullable|required_if:top,blouse|numeric|min:3',
            'blouse_arm_hole' => 'nullable|required_if:top,blouse|numeric|min:3',
            'blouse_lower_arm_girth' => 'nullable|required_if:top,blouse|numeric|min:3',
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

            // minimum length

            'polo_chest.min' => 'The polo chest must be at least 3 inches.',
            'polo_length.min' => 'The polo length must be at least 3 inches.',
            'polo_hips.min' => 'The polo hips must be at least 3 inches.',
            'polo_shoulder.min' => 'The polo shoulder must be at least 3 inches.',
            'polo_sleeve.min' => 'The polo sleeve must be at least 3 inches.',
            'polo_armhole.min' => 'The polo armhole must be at least 3 inches.',
            'polo_lower_arm_girth.min' => 'The polo lower arm girth must be at least 3 inches.',

            'vest_armhole.min' => 'The vest armhole must be at least 3 inches.',
            'vest_full_length.min' => 'The vest full length must be at least 3 inches.',
            'vest_shoulder_width.min' => 'The vest shoulder width must be at least 3 inches.',
            'vest_neck_circumference.min' => 'The vest neck circumference must be at least 3 inches.',

            'blazer_chest.min' => 'The blazer chest must be at least 3 inches.',
            'blazer_shoulder_width.min' => 'The blazer shoulder width must be at least 3 inches.',
            'blazer_length.min' => 'The blazer length must be at least 3 inches.',
            'blazer_sleeve_length.min' => 'The blazer sleeve length must be at least 3 inches.',
            'blazer_waist.min' => 'The blazer waist must be at least 3 inches.',
            'blazer_hips.min' => 'The blazer hips must be at least 3 inches.',
            'blazer_armhole.min' => 'The blazer armhole must be at least 3 inches.',
            'blazer_wrist.min' => 'The blazer wrist must be at least 3 inches.',
            'blazer_back_width.min' => 'The blazer back width must be at least 3 inches.',
            'blazer_lower_arm_girth.min' => 'The blazer lower arm girth must be at least 3 inches.',


            'blouse_bust.min' => 'The blouse bust must be at least 3 inches.',
            'blouse_length.min' => 'The blouse length must be at least 3 inches',
            'blouse_waist.min' => 'The blouse waist must be at least 3 inches',
            'blouse_figure.min' => 'The blouse figure must be at least 3 inches',
            'blouse_hips.min' => 'The blouse hips must be at least 3 inches',
            'blouse_shoulder.min' => 'The blouse shoulder must be at least 3 inches',
            'blouse_sleeve.min' => 'The blouse sleeve must be at least 3 inches',
            'blouse_arm_hole.min' => 'The blouse arm hole must be at least 3 inches',
            'blouse_lower_arm_girth.min' => 'The blouse lower arm girth must be at least 3 inches',

            'pants_length.min' => 'The pants length must be at least 3 inches.',
            'pants_waist.min' => 'The pants waist must be at least 3 inches.',
            'pants_hips.min' => 'The pants hips must be at least 3 inches.',
            'pants_scrotch.min' => 'The pants scrotch must be at least 3 inches.',
            'pants_knee_height.min' => 'The pants knee height must be at least 3 inches.',
            'pants_knee_circumference.min' => 'The pants knee circumference must be at least 3 inches.',
            'pants_bottom_circumferem.min' => 'The pants bottom circumference must be at least 3 inches.',

            'short_waist.min' => 'The short waist must be at least 3 inches.',
            'short_hips.min' => 'The short hips must be at least 3 inches.',
            'short_length.min' => 'The short length must be at least 3 inches.',
            'short_thigh_circumference.min' => 'The short thigh circumference must be at least 3 inches.',
            'short_inseam_length.min' => 'The short inseam length must be at least 3 inches.',
            'short_leg_opening.min' => 'The short leg opening must be at least 3 inches.',
            'short_rise.min' => 'The short rise must be at least 3 inches.',

            'skirt_length.min' => 'The skirt length must be at least 3 inches.',
            'skirt_waist.min' => 'The skirt waist must be at least 3 inches.',
            'skirt_hips.min' => 'The skirt hips must be at least 3 inches.',
            'skirt_hip_depth.min' => 'The skirt hip depth must be at least 3 inches.',
        ];
    }
}
