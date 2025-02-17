<div class="row mb-3">
    <div class="col-md-6 fw-bold">Armhole (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->vest_armhole ?? '-' }}</span></div>
    <div class="col-md-6 fw-bold">Full Length (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->vest_full_length ?? '-' }}</span></div>
</div>
<div class="row">
    <div class="col-md-6 fw-bold">Shoulder Width (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->vest_shoulder_width ?? '-' }}</span></div>
    <div class="col-md-6 fw-bold">Neck Circumference (inches): <span class="fw-light">{{ $appointment->topMeasurement->measurable->vest_neck_circumference ?? '-' }}</span></div>
</div>
