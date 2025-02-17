<div class="row mb-3">
    <div class="col-md-6 fw-bold">Chest (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->blazer_chest ?? '-' }}</span></div>
    <div class="col-md-6 fw-bold">Shoulder Width (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->blazer_shoulder_width ?? '-' }}</span></div>
</div>
<div class="row mb-3">
    <div class="col-md-6 fw-bold">Blazer Length (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->blazer_length ?? '-' }}</span></div>
    <div class="col-md-6 fw-bold">Sleeve Length (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->blazer_sleeve_length ?? '-' }}</span></div>
</div>
<div class="row mb-3">
    <div class="col-md-6 fw-bold">Waist (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->blazer_waist ?? '-' }}</span></div>
    <div class="col-md-6 fw-bold">Hips (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->blazer_hips ?? '-' }}</span></div>
</div>
<div class="row mb-3">
    <div class="col-md-6 fw-bold">Armhole (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->blazer_armhole ?? '-' }}</span></div>
    <div class="col-md-6 fw-bold">Wrist (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->blazer_wrist ?? '-' }}</span></div>
</div>
<div class="row mb-3">
    <div class="col-md-6 fw-bold">Back Width (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->blazer_back_width ?? '-' }}</span></div>
    <div class="col-md-6 fw-bold">Lower Arm Girth (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->blazer_lower_arm_girth ?? '-' }}</span></div>
</div>
