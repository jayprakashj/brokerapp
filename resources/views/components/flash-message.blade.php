@if( session()->has('error-message') || $errors->count() || session()->has('success-message') )
    <div class="m-2 p-2">
@endif

    @if( session()->has('error-message') )
        <div
            class="alert flex rounded-full bg-error/10 py-4 px-4 text-error dark:bg-error/15 sm:px-5"
        >
            {{ session()->get('error-message') }}
        </div>

    @elseif( $errors->count() )
        <div
        class="alert flex rounded-full bg-error/10 py-4 px-4 text-error dark:bg-error/15 sm:px-5"
        >
            Please correct all the field.
        </div>
    @endif
    @if( session()->has('success-message') )
        <div
            class="alert flex rounded-full bg-success/10 py-4 px-4 text-success dark:bg-success/15 sm:px-5"
        >
            {{ session()->get('success-message') }}
        </div>
    @endif

@if( session()->has('error-message') || $errors->count() || session()->has('success-message') )
    </div>
@endif
