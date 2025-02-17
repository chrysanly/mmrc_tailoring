 <div class="row mb-3">
     <div class="col-md-6 fw-bold">Waist (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->short_waist ?? '-' }}</span>
     </div>
     <div class="col-md-6 fw-bold">Hip (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->short_hips ?? '-' }}</span></div>
 </div>
 <div class="row mb-3">
     <div class="col-md-6 fw-bold">Short Length (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->short_length ?? '-' }}</span></div>
     <div class="col-md-6 fw-bold">Thigh Circumference (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->short_thigh_circumference ?? '-' }}</span></div>
 </div>
 <div class="row mb-3">
     <div class="col-md-6 fw-bold">Inseam Length (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->short_inseam_length ?? '-' }}</span></div>
     <div class="col-md-6 fw-bold">Leg Opening (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->short_leg_opening ?? '-' }}</span></div>
 </div>
 <div class="row mb-3">
     <div class="col-md-6 fw-bold">Rise (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->short_rise ?? '-' }}</span></div>
 </div>
