@if ($message = Session::get('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
        <div class="flex mx-3">
            <div class="self-center">
                <strong>{{ $message }}</strong>
            </div>
            <div class="flex-auto"></div>
            <div class="self-center">
                <button type="button" onclick="window.location.reload(true)" class="close text-lg" data-dismiss="alert">×</button>
            </div>
        </div>
    </div>
@endif


@if ($message = Session::get('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
        <div class="flex mx-3">
            <div class="self-center">
                <strong>{{ $message }}</strong>
            </div>
            <div class="flex-auto"></div>
            <div class="self-center">
                <button type="button" onclick="window.location.reload(true)" class="close text-lg" data-dismiss="alert">×</button>
            </div>
        </div>
    </div>
@endif


@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block mx-2">
        <div class="flex mx-3">
            <div class="self-center">
                <strong>{{ $message }}</strong>
            </div>
            <div class="flex-auto"></div>
            <div class="self-center">
                <button type="button" onclick="window.location.reload(true)" class="close text-lg" data-dismiss="alert">×</button>
            </div>
        </div>
    </div>
@endif


@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block mx-2">
        <div class="flex mx-3">
            <div class="self-center">
                <strong>{{ $message }}</strong>
            </div>
            <div class="flex-auto"></div>
            <div class="self-center">
                <button type="button" onclick="window.location.reload(true)" class="close text-lg" data-dismiss="alert">×</button>
            </div>
        </div>
    </div>
@endif


{{-- @if ($errors->any())
    <div class="alert alert-danger mx-2">
        <div class="flex mx-3">
            <div class="self-center">
                <strong>Please check the form below for errors.</strong>
            </div>
            <div class="flex-auto"></div>
            <div class="self-center">
                <button type="button" onclick="window.location.reload(true)" class="close text-lg" data-dismiss="alert">×</button>
            </div>
        </div>
    </div>
@endif --}}