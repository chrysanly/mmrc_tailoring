<?php

namespace App\Http\Traits;

use App\Models\Polo;
use App\Models\Vest;
use App\Models\Pants;
use App\Models\Short;
use App\Models\Skirt;
use App\Models\Blazer;
use App\Models\Blouse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

trait UniformTrait
{
    public function storeUniform(Request $request, Model $model)
    {
        $this->storeTop($request, $model);
        $this->storeBottom($request, $model);
    }

    private function storeTop(Request $request, Model $model): void
    {
        $storeTopType = [
            'polo' => [
                'class' => Polo::class,
                'data' => 'storePolo',
            ],
            'blouse' => [
                'class' => Blouse::class,
                'data' => 'storeBlouse',
            ],
            'vest' => [
                'class' => Vest::class,
                'data' => 'storeVest',
            ],
            'blazer' => [
                'class' => Blazer::class,
                'data' => 'storeBlazer',
            ],
        ];

        if ($request->top && isset($storeTopType[$request->top])) {
            $selectedTop = $storeTopType[$request->top];

            $data = $this->{$selectedTop['data']}($request);
            $model->topMeasurement()->create([
                'top_measure_type' => $selectedTop['class'],
                'top_measure_id' => $data->id,
            ]);
        }
    }

    private function storeBottom(Request $request, Model $model): void
    {
        $storeBottomType = [
            'short' => [
                'class' => Short::class,
                'data' => 'storeShort',
            ],
            'pants' => [
                'class' => Pants::class,
                'data' => 'storePants',
            ],
            'skirt' => [
                'class' => Skirt::class,
                'data' => 'storeSkirt',
            ],
        ];

        if ($request->bottom && isset($storeBottomType[$request->bottom])) {
            $selectedBottom = $storeBottomType[$request->bottom];

            $data = $this->{$selectedBottom['data']}($request);
            $model->bottomMeasurement()->create([
                'bottom_measure_type' => $selectedBottom['class'],
                'bottom_measure_id' => $data->id,
            ]);
        }
    }

    private function storePolo(Request $request): Model|Polo
    {
        return Polo::create([
            'polo_chest' => $request->polo_chest,
            'polo_length' => $request->polo_length,
            'polo_hips' => $request->polo_hips,
            'polo_shoulder' => $request->polo_shoulder,
            'polo_sleeve' => $request->polo_sleeve,
            'polo_armhole' => $request->polo_armhole,
            'polo_lower_arm_girth' => $request->polo_lower_arm_girth,
        ]);
    }

    private function storeBlouse(Request $request): Blouse|Model
    {
        return Blouse::create([
            'blouse_bust' => $request->blouse_bust,
            'blouse_length' => $request->blouse_length,
            'blouse_waist' => $request->blouse_waist,
            'blouse_figure' => $request->blouse_figure,
            'blouse_hips' => $request->blouse_hips,
            'blouse_shoulder' => $request->blouse_shoulder,
            'blouse_sleeve' => $request->blouse_sleeve,
            'blouse_arm_hole' => $request->blouse_arm_hole,
            'blouse_lower_arm_girth' => $request->blouse_lower_arm_girth,
        ]);
    }
    private function storeVest(Request $request): Model|Vest
    {
        return Vest::create([
            'vest_armhole' => $request->vest_armhole,
            'vest_full_length' => $request->vest_full_length,
            'vest_shoulder_width' => $request->vest_shoulder_width,
            'vest_neck_circumference' => $request->vest_neck_circumference,
        ]);
    }
    private function storeBlazer(Request $request): Blazer|Model
    {
        return Blazer::create([
            'blazer_chest' => $request->blazer_chest,
            'blazer_shoulder_width' => $request->blazer_shoulder_width,
            'blazer_length' => $request->blazer_length,
            'blazer_sleeve_length' => $request->blazer_sleeve_length,
            'blazer_waist' => $request->blazer_waist,
            'blazer_hips' => $request->blazer_hips,
            'blazer_armhole' => $request->blazer_armhole,
            'blazer_wrist' => $request->blazer_wrist,
            'blazer_back_width' => $request->blazer_back_width,
            'blazer_lower_arm_girth' => $request->blazer_lower_arm_girth,
        ]);
    }

    private function storePants(Request $request): Model|Pants
    {
        return Pants::create([
            'pants_length' => $request->pants_length,
            'pants_waist' => $request->pants_waist,
            'pants_hips' => $request->pants_hips,
            'pants_scrotch' => $request->pants_scrotch,
            'pants_knee_height' => $request->pants_knee_height,
            'pants_knee_circumference' => $request->pants_knee_circumference,
            'pants_bottom_circumferem' => $request->pants_bottom_circumferem,
        ]);
    }

    private function storeShort(Request $request): Model|Short
    {
        return Short::create([
            'short_waist' => $request->short_waist,
            'short_hips' => $request->short_hips,
            'short_length' => $request->short_length,
            'short_thigh_circumference' => $request->short_thigh_circumference,
            'short_inseam_length' => $request->short_inseam_length,
            'short_leg_opening' => $request->short_leg_opening,
            'short_rise' => $request->short_rise,
        ]);
    }
    private function storeSkirt(Request $request): Model|Skirt
    {
        return Skirt::create([
            'skirt_length' => $request->skirt_length,
            'skirt_waist' => $request->skirt_waist,
            'skirt_hips' => $request->skirt_hips,
            'skirt_hip_depth' => $request->skirt_hip_depth,
        ]);
    }
}
