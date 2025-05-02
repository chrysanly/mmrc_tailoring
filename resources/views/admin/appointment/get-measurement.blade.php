@extends('layouts.admin.app')

@section('title', 'Appointments')

@section('content')

    <div class="row">
        <div class="col-md-8 mx-auto">
            <h3>Get Measurement</h3>

            <div>
                <form action="{{ route('admin.appointment.store-measurement', $appointment) }}" method="POST">
                    @csrf
                    <x-uniform-type />
                    <div class="d-flex gap-2 justify-content-between mt-2">
                        @include('user.order.measurements_field')
                    </div>
                    <input type="hidden" name="top" id="hiddenTop" value="{{ old('top') }}">
                    <input type="hidden" name="bottom" id="hiddenBottom" value="{{ old('bottom') }}">
                    <button type="submit" class="btn btn-primary w-100 mt-2">Submit Order</button>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection

@push('scripts')
    <script>
        window.onload = function () {
            let url = window.location.href;
            let parts = url.split("/");
            let appointmentId = parts.pop(); // Extracts the last segment

            const getAppointmentMeasurement = `/admin/appointment/api/get-appointment-measurement/${appointmentId}`;

            fetch(getAppointmentMeasurement)
                .then(response => response.json())
                .then(data => {
                    const topMeasurable = data?.top_measurement?.measurable;
                    const bottomMeasurable = data?.bottom_measurement?.measurable;
                    console.log(data?.top, data?.bottom);
                    console.log(topMeasurable);
                    console.log(bottomMeasurable);

                    if (data?.set !== "N/A") {
                        $("#set").val(data.set.toLowerCase());
                        
                    }
                    if (data?.bottom !== "N/A") {
                        $("#bottom").val(data.bottom.toLowerCase());
                        $("#hiddenBottom").val(data.bottom.toLowerCase());
                        if (data.set.toLowerCase() === 'set-1' || data.set.toLowerCase() === 'set-2' || data.set.toLowerCase() === 'set-3') {
                            $("#bottom").prop("disabled", true);
                        }else {
                            $("#bottom").prop("disabled", false);
                        }
                        showBottom();
                        bottomMeasurement(data, bottomMeasurable);
                    }
                    if (data?.top !== "N/A") {
                        $("#top").val(data.top.toLowerCase());
                        $("#hiddenTop").val(data.top.toLowerCase());
                        if (data.set.toLowerCase() === 'set-1' || data.set.toLowerCase() === 'set-2' || data.set.toLowerCase() === 'set-3') {
                            $("#top").prop("disabled", true);
                        }else {
                            $("#top").prop("disabled", false);
                        }
                        showTop();
                        topMeasurement(data, topMeasurable);
                    }
                    if (data?.school !== "N/A") {
                        $("#school").val(data.school);
                    }
                })
                .catch(error => {
                    console.error("Error fetching available time:", error);
                });

        };

        function topMeasurement(data,measurable) {
            if (data.top === 'Vest') {
                $("#vest_armhole").val(measurable.vest_armhole);
                $("#vest_full_length").val(measurable.vest_full_length);
                $("#vest_neck_circumference").val(measurable.vest_neck_circumference);
                $("#vest_shoulder_width").val(measurable.vest_shoulder_width);
            }
            if (data.top === 'Polo') {
                $("#polo_armhole").val(measurable.polo_armhole);
                $("#polo_chest").val(measurable.polo_chest);
                $("#polo_hips").val(measurable.polo_hips);
                $("#polo_length").val(measurable.polo_length);
                $("#polo_lower_arm_girth").val(measurable.polo_lower_arm_girth);
                $("#polo_shoulder").val(measurable.polo_shoulder);
                $("#polo_sleeve").val(measurable.polo_sleeve);
            }
            if (data.top === 'Blouse') {
                $("#blouse_arm_hole").val(measurable.blouse_arm_hole);
                $("#blouse_bust").val(measurable.blouse_bust);
                $("#blouse_figure").val(measurable.blouse_figure);
                $("#blouse_hips").val(measurable.blouse_hips);
                $("#blouse_length").val(measurable.blouse_length);
                $("#blouse_lower_arm_girth").val(measurable.blouse_lower_arm_girth);
                $("#blouse_shoulder").val(measurable.blouse_shoulder);
                $("#blouse_sleeve").val(measurable.blouse_sleeve);
                $("#blouse_waist").val(measurable.blouse_waist);
            }
            if (data.top === 'Blazer') {
                $("#blazer_armhole").val(measurable.blazer_armhole);
                $("#blazer_back_width").val(measurable.blazer_back_width);
                $("#blazer_chest").val(measurable.blazer_chest);
                $("#blazer_hips").val(measurable.blazer_hips);
                $("#blazer_length").val(measurable.blazer_length);
                $("#blazer_lower_arm_girth").val(measurable.blazer_lower_arm_girth);
                $("#blazer_shoulder_width").val(measurable.blazer_shoulder_width);
                $("#blazer_sleeve_length").val(measurable.blazer_sleeve_length);
                $("#blazer_waist").val(measurable.blazer_waist);
                $("#blazer_wrist").val(measurable.blazer_wrist);
            }
        }

        function bottomMeasurement(data, measurable){
            if (data.bottom === 'Pants') {
                $("#pants_bottom_circumferem").val(measurable.pants_bottom_circumferem);
                $("#pants_hips").val(measurable.pants_hips);
                $("#pants_knee_circumference").val(measurable.pants_knee_circumference);
                $("#pants_knee_height").val(measurable.pants_knee_height);
                $("#pants_length").val(measurable.pants_length);
                $("#pants_scrotch").val(measurable.pants_scrotch);
                $("#pants_waist").val(measurable.pants_waist);
            } 
            if (data.bottom === 'Short') {
                $("#short_hips").val(measurable.short_hips);
                $("#short_inseam_length").val(measurable.short_inseam_length);
                $("#short_leg_opening").val(measurable.short_leg_opening);
                $("#short_length").val(measurable.short_length);
                $("#short_rise").val(measurable.short_rise);
                $("#short_thigh_circumference").val(measurable.short_thigh_circumference);
                $("#short_waist").val(measurable.short_waist);
            } 
            if (data.bottom === 'Skirt') {
                $("#skirt_hip_depth").val(measurable.skirt_hip_depth);
                $("#skirt_hips").val(measurable.skirt_hips);
                $("#skirt_length").val(measurable.skirt_length);
                $("#skirt_waist").val(measurable.skirt_waist);
            } 
        }
    </script>
@endpush