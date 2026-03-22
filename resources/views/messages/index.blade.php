<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mijn Berichten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($conversations->isEmpty())
                        <p class="text-gray-500 text-center py-8 italic">Je hebt nog geen gesprekken.</p>
                    @else
                        <div class="divide-y">
                            @foreach($conversations as $userId => $group)
                                @php
                                    $lastMessage = $group->first();
                                    $otherUser = $lastMessage->sender_id == Auth::id() ? $lastMessage->receiver : $lastMessage->sender;
                                    $unreadCount = $group->where('receiver_id', Auth::id())->whereNull('read_at')->count();
                                @endphp
                                <a href="{{ route('messages.show', $otherUser) }}" class="block p-4 hover:bg-gray-50 transition flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold mr-4">
                                            {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $otherUser->name }}</div>
                                            <div class="text-sm text-gray-500 truncate w-64 md:w-96">
                                                {{ $lastMessage->sender_id == Auth::id() ? 'Jij: ' : '' }}{{ $lastMessage->content }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-gray-400 mb-1">{{ $lastMessage->created_at->diffForHumans() }}</div>
                                        @if($unreadCount > 0)
                                            <span class="bg-indigo-600 text-white text-[10px] px-2 py-0.5 rounded-full font-bold">
                                                {{ $unreadCount }}
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
