<x-layouts.app title="Company Management">
    <x-app-partials.page-header
            title="Company Management"
            :menus="$menus"
        />
        <x-flash-message />
    @if( $companies->count() )
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6 xl:grid-cols-4">
        @foreach ($companies as $item)
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
                                    <a href="{{ route('company.edit', $item) }}"
                                        class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                        <i class="fa fa-pencil"></i> Edit
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
                <p class="text-xs+">Creator: <b>{{ $item->getOwnerName() }}</b></p>
                <div class="inline-space mt-3 flex grow flex-wrap items-start">
                    @if( $item->isDefault() )
                    <span
                        class="tag rounded-full bg-success/10 text-success hover:bg-success/20 focus:bg-success/20 active:bg-success/25">
                        Default
                    </span>
                    @endif
                    @if( $item->isActive() )
                    <span
                        class="tag rounded-full bg-success/10 text-success hover:bg-success/20 focus:bg-success/20 active:bg-success/25">
                        Active
                    </span>
                    @else
                    <span
                        class="tag rounded-full badge rounded-full bg-error text-white">
                        In-Active
                    </span>
                    @endif
                </div>
                @if( !$item->isDefault() )
                <div class="mt-6 grid w-full grid-cols-2 gap-2">

                    @if( $item->isOwnedByMe() )
                    <a href="{{ route('company.change_status', $item) }}"
                        class="btn space-x-2 bg-primary px-0 font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        @if( $item->isActive() )
                        <i class="fa fa-ban"></i>
                        @else
                        <i class="fa fa-check"></i>
                        @endif
                        <span>
                            {{ $item->isActive() ? 'Deactive': 'Active' }}
                        </span>
                    </a>

                    @endif
                    @if( $item->isActive()  )
                    <a href="{{ route('company.set_default', $item) }}"
                        class="btn space-x-2 bg-slate-150 px-0 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <span> Set Default </span>
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    {{ $companies->links() }}
    @else
    <x-no-data />
    @endif
</x-layouts.app>
