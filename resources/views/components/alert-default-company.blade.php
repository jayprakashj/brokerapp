@if( Helper::retrieveDefaultCompany() )

<div class=" w-full -mt-4" >
    <div  class="alert flex overflow-hidden rounded-lg bg-warning/10 text-warning dark:bg-warning/15">
        <div class="flex flex-1 items-center space-x-3 p-4">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                />
            </svg>
            <div class="flex-1">
                Your default company is {{ Helper::retrieveDefaultCompany()->name }}. You can change it by click <a href="{{ route('company.index') }}">here</a>.
            </div>
        </div>

        <div class="w-1.5 bg-warning"></div>
    </div>
</div>
@else
<div class="m-2 p-2">
    <div  class="alert flex overflow-hidden rounded-lg bg-warning/10 text-warning dark:bg-warning/15">
        <div class="flex flex-1 items-center space-x-3 p-4">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                />
            </svg>
            <div class="flex-1">
                There is no default company selected. Please make default any one company by clicking <a href="{{ route('company.index') }}">here</a>.
            </div>
        </div>

        <div class="w-1.5 bg-warning"></div>
    </div>
</div>

@endif
