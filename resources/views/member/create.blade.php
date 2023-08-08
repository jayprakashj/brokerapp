<x-layouts.app :title="$title">
    <x-app-partials.page-header
            :title="$title"
            :breadcrumbs="$breadcrumbs"
        />
        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12">
                <div class="card p-4 sm:p-5">
                    <p class="text-base font-medium text-slate-700 dark:text-navy-100">
                        {{ $title }}
                    </p>
                    <div >
                        <form class="mt-4 space-y-4" action="{{ route('member.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $member->id }}">
                            <label class="block">
                                <span>Email</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Email" type="text" name="email" value="{{ old('email', $member->email) }}">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-building text-base"></i>
                                    </span>
                                </span>

                                @error('email')
                                    <span class="text-tiny+ text-error">{{ $message }}</span>
                                @enderror
                            </label>
                            <div>
                                <h3 class="text-base font-medium text-slate-600 dark:text-navy-100">
                                    Selected Company:
                                </h3>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300">
                                    {{ auth()->user()->retrieveDefaultCompany()->name ?? 'N/A' }}
                                </p>
                            </div>
                            <label class="block mt-2">
                                <span>Role</span>
                                <select
                                    name="role_id"
                                  class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                >
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>

                                    @endforeach
                                </select>

                                @error('role_id')
                                    <span class="text-tiny+ text-error">{{ $message }}</span>
                                @enderror
                            </label>
                            <div class="flex justify-end space-x-2">
                                <button
                                type="submit"
                                    class="btn space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    <i class="fa fa-save"></i>
                                    <span>{{ $member->id? 'Update': 'Save' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-layouts.app>
