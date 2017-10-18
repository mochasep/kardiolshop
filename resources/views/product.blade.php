<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/jquery-3.2.1.slim.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <meta property="og:url"
          content="http://kardi-test.herokuapp.com/product/{{ $item->id }}"/>
    <meta property="og:title" content="{{ $item->name }}"/>
    <meta property="og:description" content="{{ $item->description }}"/>
    <meta property="og:image"
          content="{{ asset('items/'.$item->image) }}"/>
</head>

<body>
@include('modals.line')
@include('modals.telegram')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-3">{{ $item->name }}</h1>
        <p class="lead">{{ $item->description }}</p>
        <img class="img-fluid" src="{{ asset('items/'.$item->image) }}">
        <div class="text-right" style="margin-top: 24px">
            <h3>
                <span class="badge badge-success">
                    Rp. {{ $item->price }}
                </span>
            </h3>
        </div>
        <div class="row" style="margin-top: 24px">
            <div class="col text-left">
                <button class="btn btn-outline-success" data-toggle="modal" data-target="#lineModal"
                        data-itemid="{{ $item->id }}">Beli lewat LINE
                </button>
            </div>
            <div class="col text-right">
                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#telegramModal"
                        data-itemid="{{ $item->id }}">Beli lewat Telegram
                </button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
