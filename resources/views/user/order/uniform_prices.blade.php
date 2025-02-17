<div class="card col-4">
    <div class="card-header">
        <h3>Uniform Prices</h3>
    </div>
    <div class="card-body">
        @foreach ($uniformPrices as $uniformPrice)
            <div class="mb-3">
                <h5>{{ $uniformPrice->name }}</h5>
                <ul>
                @foreach ($uniformPrice->items as $item)
                    <li>{{ $item->name }}: {{ $item->price }}</li>
                    
                    @endforeach
                </ul>
                
            </div>
        @endforeach
    </div>
</div>
