@include('modals.line')
@include('modals.telegram')

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
            <div class="text-right">
                <h3>
                <span class="badge badge-success">
                    Rp. {{ $item->price }}
                </span>
                </h3>
            </div>
            <div class="row">
                <div class="col text-left">
                    <button class="btn btn-outline-success" data-toggle="modal" data-target="#lineModal" data-itemid="{{ $item->id }}">Beli lewat LINE</button>
                </div>
                <div class="col text-right">
                    <button class="btn btn-outline-primary" data-toggle="modal" data-target="#telegramModal" data-itemid="{{ $item->id }}">Beli lewat Telegram</button>
                </div>
            </div>
        </div>
    </div>
</div>