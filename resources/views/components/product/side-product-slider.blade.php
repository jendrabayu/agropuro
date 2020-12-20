<div class="latest-product__slider__item">
  @foreach ($products as $index => $product)
    @if ($index < 3)
      <a href="#" class="latest-product__item">
        <div class="latest-product__item__pic">
          <img class="" style="width: 110px" src="{{ Storage::url($product->gambar) }}" alt="">
        </div>
        <div class="latest-product__item__text">
          <h6 class="m-0">{{ $product->nama }}</h6>
          <p class="text-info m-0">{{ $product->category->name }}</p>
          <span>{{ rupiah_format($product->harga) }}</span>
        </div>
      </a>
    @endif
  @endforeach
</div>

<div class="latest-product__slider__item">
  @foreach ($products as $index => $product)
    @if ($index > 2 && $index < 6)
      <a href="#" class="latest-product__item">
        <div class="latest-product__item__pic">
          <img class="" style="width: 110px" src="{{ Storage::url($product->gambar) }}" alt="">
        </div>
        <div class="latest-product__item__text">
          <h6 class="m-0">{{ $product->nama }}</h6>
          <p class="text-info m-0">{{ $product->category->name }}</p>
          <span>{{ rupiah_format($product->harga) }}</span>
        </div>
      </a>
    @endif
  @endforeach
</div>

<div class="latest-product__slider__item">
  @foreach ($products as $index => $product)
    @if ($index > 5 && $index < 9)
      <a href="#" class="latest-product__item">
        <div class="latest-product__item__pic">
          <img class="" style="width: 110px" src="{{ Storage::url($product->gambar) }}" alt="">
        </div>
        <div class="latest-product__item__text">
          <h6 class="m-0">{{ $product->nama }}</h6>
          <p class="text-info m-0">{{ $product->category->name }}</p>
          <span>{{ rupiah_format($product->harga) }}</span>
        </div>
      </a>
    @endif
  @endforeach
</div>
