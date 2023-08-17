@if( session('resend-verify') )

    <p class="text-gray-500 dark:text-gray-400">
        If you did not receive the verification mail, click here to send verify mail.
        <a href="{{ session('resend-verify') }}" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
            Resend Verification
            <svg class="w-4 h-4 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg>
        </a>
    </p>


@endif
