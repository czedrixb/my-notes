<x-app-layout>
    <div class="py-12">
        <div class="container flex justify-center max-auto px-5 max-w-7xl mx-auto lg:px-8">
            <div class="w-full md:max-w-md">
                <x-card>
                    @php
                        $colors = [
                            'bg-red-200',
                            'bg-blue-200',
                            'bg-green-200',
                            'bg-yellow-200',
                            'bg-purple-200',
                            'bg-pink-200',
                            'bg-orange-200',
                        ];
                        $color = $colors[array_rand($colors)];
                    @endphp
                    <x-slot name="slot" :class="$color">
                        <livewire:notes.create-notes />

                    </x-slot>
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
