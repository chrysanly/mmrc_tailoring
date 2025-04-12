@props(['title' => '', 'pieChartId' => '', 'col' => ''])

<div class="card {{ $col }} col-sm-12 mb-4 d-flex justify-content-center align-items-center p-2 pieCountCard">
    <h4 class="text-danger fw-bold">{{ $title }}</h4>
    <div class="loading" style="display: none; text-align: center;">
        <div class="spinner-grow text-primary spinner-grow-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary spinner-grow-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-success spinner-grow-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-danger spinner-grow-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <canvas id="{{ $pieChartId }}"></canvas>
</div>
