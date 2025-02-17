 <div class="row mb-3">
     <div class="col-md-6 fw-bold">Pants Length (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->pants_length ?? '-' }}</span>
     </div>
     <div class="col-md-6 fw-bold">Waist (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->pants_waist ?? '-' }}</span></div>
 </div>
 <div class="row mb-3">
     <div class="col-md-6 fw-bold">Hip (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->pants_hips ?? '-' }}</span></div>
     <div class="col-md-6 fw-bold">Crotch (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->pants_scrotch ?? '-' }}</span></div>
 </div>
 <div class="row mb-3">
     <div class="col-md-6 fw-bold">Knee Height (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->pants_knee_height ?? '-' }}</span></div>
     <div class="col-md-6 fw-bold">Knee Circumference (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->pants_knee_circumference ?? '-' }}</span></div>
 </div>
 <div class="row mb-3">
     <div class="col-md-6 fw-bold">Bottom Circumference (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->pants_bottom_circumferem ?? '-' }}</span></div>
 </div>
