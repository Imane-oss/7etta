@extends('admin.layout')

@section('title', 'Messages & Support')

@section('content')
<div class="h-[calc(100vh-120px)] flex gap-6">
    <!-- Messages List -->
    <div class="w-1/3 bg-white border border-gray-200 rounded-2xl flex flex-col shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <div class="relative">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" placeholder="Search messages..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/10 transition-all">
            </div>
        </div>
        <div class="flex-1 overflow-y-auto">
            @forelse($messages as $msg)
                <a href="{{ route('admin.messages.show', $msg['id']) }}" class="block p-4 border-b border-gray-50 hover:bg-gray-50 transition-colors {{ isset($message) && $message['id'] === $msg['id'] ? 'bg-blue-50 border-l-4 border-l-blue-600' : '' }} {{ !$msg['read'] ? 'bg-white font-semibold' : '' }}">
                    <div class="flex justify-between items-start mb-1">
                        <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($msg['created_at'])->diffForHumans() }}</span>
                        @if(!$msg['read'])
                            <span class="h-2 w-2 bg-blue-600 rounded-full"></span>
                        @endif
                    </div>
                    <h4 class="text-sm text-gray-900 truncate">{{ $msg['subject'] }}</h4>
                    <p class="text-xs text-gray-500 truncate mb-2">{{ $msg['message'] }}</p>
                    <div class="flex items-center gap-2">
                        <div class="h-5 w-5 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-600">
                            {{ strtoupper(substr($msg['name'], 0, 1)) }}
                        </div>
                        <span class="text-[11px] text-gray-600">{{ $msg['name'] }}</span>
                        @if($msg['replied'])
                            <i class="bi bi-reply-fill text-green-500 ml-auto"></i>
                        @endif
                    </div>
                </a>
            @empty
                <div class="p-8 text-center">
                    <i class="bi bi-envelope-x text-4xl text-gray-200 mb-3 block"></i>
                    <p class="text-sm text-gray-400">No messages found</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Message Content -->
    <div class="flex-1 bg-white border border-gray-200 rounded-2xl flex flex-col shadow-sm overflow-hidden">
        @if(isset($message))
            <!-- Header -->
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white z-10">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg">
                        {{ strtoupper(substr($message['name'], 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">{{ $message['subject'] }}</h2>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="bi bi-envelope text-xs"></i>
                            <span>{{ $message['email'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($message['created_at'])->format('M d, Y H:i') }}</span>
                    @if(!$message['read'])
                        <span class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-1 rounded-md">NEW</span>
                    @endif
                </div>
            </div>

            <!-- Body -->
            <div class="flex-1 p-8 overflow-y-auto space-y-8 bg-gray-50/30">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative">
                    <div class="absolute -top-3 left-6 bg-white px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest border border-gray-100 rounded-full">User Message</div>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $message['message'] }}</p>
                </div>

                @if($message['replied'])
                    <div class="bg-blue-600 p-6 rounded-2xl shadow-md relative ml-12 text-white">
                        <div class="absolute -top-3 right-6 bg-blue-700 px-3 text-[10px] font-bold text-blue-100 uppercase tracking-widest rounded-full">Admin Reply</div>
                        <p class="leading-relaxed whitespace-pre-line">{{ $message['reply'] }}</p>
                    </div>
                @endif
            </div>

            <!-- Footer / Reply Form -->
            <div class="p-6 border-t border-gray-100 bg-white">
                @if(!$message['replied'])
                    <form action="{{ route('admin.messages.reply', $message['id']) }}" method="POST">
                        @csrf
                        <div class="relative">
                            <textarea name="reply" placeholder="Type your reply to {{ $message['name'] }} here..." class="w-full p-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/10 min-h-[120px] transition-all resize-none"></textarea>
                            <button type="submit" class="absolute bottom-4 right-4 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-medium shadow-lg shadow-blue-500/20 flex items-center gap-2 transition-all hover:scale-105">
                                <i class="bi bi-send-fill"></i>
                                Send Reply
                            </button>
                        </div>
                    </form>
                @else
                    <div class="flex items-center justify-center gap-2 text-green-600 bg-green-50 py-3 rounded-xl border border-green-100">
                        <i class="bi bi-check-circle-fill"></i>
                        <span class="text-sm font-medium">Replied sent successfully</span>
                    </div>
                @endif
            </div>
        @else
            <div class="flex-1 flex flex-col items-center justify-center text-gray-400">
                <div class="h-20 w-20 rounded-full bg-gray-50 flex items-center justify-center mb-4">
                    <i class="bi bi-envelope text-4xl text-gray-200"></i>
                </div>
                <p class="text-sm">Select a message to view details</p>
            </div>
        @endif
    </div>
</div>
@endsection
