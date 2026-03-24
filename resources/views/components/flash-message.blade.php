@props(['on' => 'flash'])

<div x-data="{ show: false, message: '', type: 'success' }"
     x-on:flash.window="
        show = true;
        message = $event.detail.message || $event.detail[0].message;
        type = $event.detail.type || $event.detail[0].type || 'success';
        setTimeout(() => { show = false; }, 3000);
     "
     x-show="show"
     x-transition:enter="transition ease-out duration-300 transform"
     x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
     x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display: none;"
     class="fixed bottom-4 right-4 z-50 rounded-lg p-4 shadow-lg text-white"
     :class="{
        'bg-green-600': type === 'success',
        'bg-red-600': type === 'error',
        'bg-yellow-500': type === 'warning',
        'bg-blue-600': type === 'info'
     }">
     
    <div class="flex items-center space-x-3">
        <!-- Success Icon -->
        <svg x-show="type === 'success'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        
        <!-- Error Icon -->
        <svg x-show="type === 'error'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        
        <!-- Warning Icon -->
        <svg x-show="type === 'warning'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        
        <!-- Info Icon -->
        <svg x-show="type === 'info'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        
        <p class="font-medium text-sm" x-text="message"></p>
        
        <button @click="show = false" class="text-white hover:text-gray-200 focus:outline-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
</div>
