@include('navbar.admin', ['control_panel' => true])

<div class="container h-100 align-items-start" style="margin-top: 64px">
    <div class="row h-100 align-items-center justify-content-center">
        @include('forms.item')
    </div>
</div>