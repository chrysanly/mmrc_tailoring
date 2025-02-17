 <div class="row mb-3">
     <div class="col-md-6 fw-bold">Skirt Length (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->skirt_length ?? '-' }}</span>
     </div>
     <div class="col-md-6 fw-bold">Waist (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->skirt_waist ?? '-' }}</span></div>
 </div>
 <div class="row mb-3">
     <div class="col-md-6 fw-bold">Hips (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->skirt_hips ?? '-' }}</span></div>
     <div class="col-md-6 fw-bold">Hip Depth (inches): <span class="fw-light">{{ $appointment->bottomMeasurement->measurable->skirt_hip_depth ?? '-' }}</span></div>
 </div>
