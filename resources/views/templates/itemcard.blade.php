<div class="col-4" style="margin-bottom: 32px;">
    <div class="card">
        @if (Session::has('login'))
            <a href="./item.delete/{{ $item->id }}" class="btn btn-danger" style="border-radius: 0">Remove</a>
        @endif

        <img class="card-img-top" src="{{ asset('items/'.$item->image) }}" style="border-radius: 0">
        <div class="card-body">
            <h4 class="card-title">
                {{ $item->name }}
            </h4>
            <p class="card-text text-justify">
                {{ $item->description }}
            </p>
            {{--<p class="card-text text-right">--}}
            <div class="text-right">
                <h3>
                <span class="badge badge-success">
                    Rp. {{ $item->price }}
                </span>
                </h3>
            </div>
            {{--</p>--}}
            <div class="row">
                <div class="col text-left">
                    <a href="#" class="btn btn-outline-success">Beli di Tokopedia</a>
                </div>
                <div class="col text-right">
                    <a href="#" class="btn btn-outline-warning">Beli di Bukalapak</a>
                </div>
            </div>
        </div>
    </div>
</div>