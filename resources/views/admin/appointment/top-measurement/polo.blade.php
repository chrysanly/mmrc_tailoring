<div class="row mb-3">
    <div class="col-md-6 fw-bold">Chest (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->polo_chest ?? '-' }}</span></div>
    <div class="col-md-6 fw-bold">Polo's Length (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->polo_length ?? '-' }}</span></div>
</div>
<div class="row mb-3">
    <div class="col-md-6 fw-bold">Hips (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->polo_hips ?? '-' }}</span></div>
    <div class="col-md-6 fw-bold">Shoulder Measurement (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->polo_shoulder ?? '-' }}</span></div>
</div>
<div class="row mb-3">
    <div class="col-md-6 fw-bold">Sleeve Length (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->polo_sleeve ?? '-' }}</span></div>
    <div class="col-md-6 fw-bold">Armhole (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->polo_armhole ?? '-' }}</span></div>
</div>
<div class="row mb-3">
    <div class="col-md-6 fw-bold">Lower Arm Girth (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->polo_lower_arm_girth ?? '-' }}</span></div>
</div>
