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
                    <div class="mt-4 space-y-4">
                        <form action="{{ route('company.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $company->id }}">
                            <label class="block">
                                <span>Company name</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Your Company" type="text" name="company_name" value="{{ old('company_name', $company->name) }}">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-building text-base"></i>
                                    </span>
                                </span>

                                @error('company_name')
                                    <span class="text-tiny+ text-error">{{ $message }}</span>
                                @enderror
                            </label>
                            @if( !$company->isDefault() )
                            <div class="flex-wrap items-start space-y-2 pt-2 sm:flex sm:space-x-5 sm:space-y-0">
                                <label class="inline-flex items-center space-x-2">
                                    <input
                                        name="status"
                                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                        type="checkbox" {{ old('status', $company->status) == 1? 'checked' :'' }}>
                                    <span>Active?</span>
                                </label>
                            </div>
                            @endif
                            <div class="flex justify-end space-x-2">
                                <button
                                type="submit"
                                    class="btn space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    <i class="fa fa-save"></i>
                                    <span>{{ $company->id? 'Update': 'Save' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-layouts.app>
