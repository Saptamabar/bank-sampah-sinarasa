@props(['title', 'value', 'icon' => null, 'description' => null])

<div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-xl relative group hover:shadow-md transition-shadow">
    <div class="p-6">
        <div class="flex items-center">
            @if($icon)
                <div class="flex-shrink-0 p-3 rounded-lg bg-brand/10 text-brand">
                    {!! $icon !!}
                </div>
            @endif
            <div class="{{ $icon ? 'ml-4' : '' }} w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        {{ $title }}
                    </dt>
                    <dd>
                        <div class="text-2xl font-bold text-gray-900 font-heading">
                            {{ $value }}
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
        @if($description)
            <div class="mt-4 text-xs text-gray-500">
                {{ $description }}
            </div>
        @endif
    </div>
    <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-brand-light to-brand-dark opacity-0 group-hover:opacity-100 transition-opacity"></div>
</div>
