<x-layouts.app title="Invitation">
    <x-app-partials.page-header
            title="Invitation"
            :menus="[]"
        />
        <x-flash-message />
    <div class="grid place-items-center">
        <div class="card mt-20 w-1/2">
            <div class="flex grow flex-col items-center px-4 pb-5 sm:px-5">
                <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                    {{ $member->company->name }}
                </h3>
                <p class="text-xs+">Creator: <b>{{ $member->createdUser->name ?? '' }}</b></p>
                @if( $member->isPending() )
                <div class="mt-6 w-full ">
                    <form  action="{{route('member.accept_invitation', $member)}}" method="POST" class="w-full flex items-center">
                        @csrf
                        <button type="submit" class="btn space-x-2 w-1/2 m-auto bg-primary px-0 font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa fa-check"></i>
                            <span>Accept</span>
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
