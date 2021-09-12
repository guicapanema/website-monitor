<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Websites') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex justify-end">
            <a
                href="{{ route('website.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
            >
                {{ __('Add website') }}
            </a>
        </div>

        <div class="flex flex-col mt-4">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Website
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Last Change
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($this->websites as $website)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a
                                                href="{{ $website->url }}"
                                                target="_blank"
                                                class="block"
                                            >
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $website->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $website->url }}
                                                </div>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if ($website->enabled) bg-green-100 text-green-800 @else bg-gray-100 text-gray-600 @endif">
                                                {{ $website->enabled ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $website->latestSnapshot?->created_at->diffForHumans() ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <x-dropdown align="right" width="48">

                                                <x-slot name="trigger">
                                                    <button class="flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-900 hover:text-indigo-900 focus:outline-none focus:text-indigo-900 focus:border-indigo-900 transition duration-150 ease-in-out ml-auto">
                                                        <div>Options</div>

                                                        <div class="ml-1">
                                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    </button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <x-dropdown-link :href="route('website.edit', ['website' => $website])">
                                                        Edit
                                                    </x-dropdown-link>

                                                    <!-- Authentication -->
                                                    <form
                                                        method="POST"
                                                        action="{{ route('website.destroy', ['website' => $website]) }}"
                                                    >
                                                        @csrf
                                                        @method('delete')

                                                        <x-dropdown-link
                                                            :href="route('website.destroy', ['website' => $website])"
                                                            @click.prevent="$el.closest('form').submit()"
                                                        >
                                                            Delete
                                                        </x-dropdown-link>
                                                    </form>
                                                </x-slot>
                                            </x-dropdown>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

