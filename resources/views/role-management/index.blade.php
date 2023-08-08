<x-layouts.app title="Role Management">
    <x-app-partials.page-header
            title="Role Management"
            :menus="$menus"
        />
        <x-flash-message />
    @if( $roles->count() )
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6 xl:grid-cols-4">
        @foreach ($roles as $item)
        <div class="card">
            <div class="p-2 text-right">
                <div x-data="usePopper({placement:'bottom-end',offset:4})"
                    @click.outside="isShowPopper &amp;&amp; (isShowPopper = false)" class="inline-flex">
                    <button x-ref="popperRef" @click="isShowPopper = !isShowPopper"
                        class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                            </path>
                        </svg>
                    </button>

                    <div x-ref="popperRoot" class="popper-root" :class="isShowPopper &amp;&amp; 'show'"
                        style="position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-1121px, 188px);"
                        data-popper-placement="bottom-end">
                        <div
                            class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                            <ul>
                                <li>
                                    <a href="{{ route('role.edit', $item) }}"
                                        class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                        <i class="fa fa-pencil mr-2"></i> Edit
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex grow flex-col items-center px-4 pb-5 sm:px-5">
                {{-- <div class="avatar h-20 w-20">
                    <img class="rounded-full" src="images/100x100.png" alt="avatar">
                </div> --}}
                <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                    {{ $item->name }}
                </h3>
                <div class="mt-6 grid w-full grid-cols-2 gap-2">

                    <a href="{{ route('role.delete', $item) }}"
                        class="btn space-x-2 bg-primary px-0 font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        <i class="fa fa-trash text-red-500"></i>
                        <span class="ml-2">
                            Delete
                        </span>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $roles->links() }}
    @else
    <x-no-data />
    @endif
</x-layouts.app>
