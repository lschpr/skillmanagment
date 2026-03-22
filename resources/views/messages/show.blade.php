<x-app-layout>
    {{-- Dit is het scherm waar ik het gesprek met iemand anders kan zien --}}
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('messages.index') }}" class="mr-4 text-gray-500 hover:text-gray-700">&larr;</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gesprek met') }} {{ $user->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="h-[400px] overflow-y-auto mb-6 p-4 bg-gray-50 rounded-lg flex flex-col space-y-4" id="chat-window">
                        @foreach($messages as $msg)
                            <div class="flex {{ $msg->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[70%] p-3 rounded-lg {{ $msg->sender_id == Auth::id() ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-gray-200 text-gray-800 rounded-tl-none' }}">
                                    <p class="text-sm">{{ $msg->content }}</p>
                                    <div class="text-[10px] mt-1 opacity-70 text-right">
                                        {{ $msg->created_at->format('H:i') }}
                                        @if($msg->sender_id == Auth::id())
                                            @if($msg->read_at) <span class="ml-1" title="Gelezen">✓✓</span> @else <span class="ml-1">✓</span> @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ route('messages.store') }}" method="POST" class="flex space-x-2">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                        <input type="text" name="content" class="flex-1 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Type hier je bericht..." required autofocus>
                        <x-primary-button>Verstuur</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Scroll naar beneden bij laden
        const chat = document.getElementById('chat-window');
        chat.scrollTop = chat.scrollHeight;
    </script>
</x-app-layout>
