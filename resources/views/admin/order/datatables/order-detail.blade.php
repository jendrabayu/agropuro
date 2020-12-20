  @foreach ($order_details as $item)
    <div class="d-flex justify-content-between">
      <div class="font-weight-normal">{{ $item->product->nama }}</div>
      <div>x{{ $item->quantity }} </div>
    </div>
  @endforeach
