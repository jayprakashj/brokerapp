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
                        <form action="{{ route('role.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $role->id }}">
                            <label class="block">
                                <span>Role name</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Name..." type="text" name="role_name" value="{{ old('role_name', $role->name) }}">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-building text-base"></i>
                                    </span>
                                </span>

                                @error('role_name')
                                    <span class="text-tiny+ text-error">{{ $message }}</span>
                                @enderror
                            </label>
                            @if( $permissions->count() )
                                @foreach( $permissions as $item )
                                <div class="card px-4 pb-4 sm:px-5 mt-6 {{ $loop->last ? 'mb-5' :'' }}" x-data="{selectAll: false}">
                                    <div class="my-3 flex h-8 items-center justify-between">
                                        <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                                            <input
                                                name="permission_group[{{ $item->group_name }}]"
                                                class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                type="checkbox" x-model="selectAll">
                                            {{ $item->group_name }}
                                        </h2>
                                    </div>
                                    <div class="max-w-100">
                                        <div class="mt-5 grid grid-cols-2 place-items-start gap-6 sm:grid-cols-4">
                                            @foreach( $item->subPermissions as $subPermission )
                                                <label class="inline-flex items-center space-x-2">
                                                    <input
                                                        name="permissions[]"
                                                        x-bind:checked="selectAll"
                                                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                        type="checkbox" {{ in_array( $subPermission->id, old('permissions', []))? 'checked' :'' }}>
                                                    <span>{{ $subPermission->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            <div class="flex justify-end space-x-2">
                                <button
                                type="submit"
                                    class="btn space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    <i class="fa fa-save"></i>
                                    <span>{{ $role->id? 'Update': 'Save' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-layouts.app>
