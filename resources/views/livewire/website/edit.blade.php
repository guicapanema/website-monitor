<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit website') }}
    </h2>
</x-slot>

<div class="py-12">
    <x-form-card>
        <form wire:submit.prevent="save">

            <!-- Name -->
            <div>
                <x-label
                    for="name"
                    :value="__('Name')"
                />

                <x-input
                    wire:model="website.name"
                    id="name"
                    class="block mt-1 w-full"
                    type="text"
                    required
                    autofocus
                />
            </div>

            <!-- URL -->
            <div class="mt-4">
                <x-label
                    for="url"
                    :value="__('URL')"
                />

                <x-input
                    wire:model="website.url"
                    id="url"
                    class="block mt-1 w-full"
                    type="text"
                    placeholder="https://example.com"
                    required
                />
            </div>

            <div class="flex justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Save') }}
                </x-button>
            </div>

        </form>
    </x-form-card>
</div>
