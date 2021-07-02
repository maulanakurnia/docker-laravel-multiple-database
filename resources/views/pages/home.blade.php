<x-base-layout title="Dashboard">
    <header class="flex justify-end items-center border-b p-2">
        <!-- Navbar right -->
        <div class="ml-auto justify-end relative flex items-center space-x-3">
            <div class="items-center hidden space-x-3 md:flex">
                <!-- avatar button -->
                <div class="relative" x-data="{ isOpen: false }">
                    <button @click="isOpen = !isOpen" class="p-1 bg-gray-200 rounded-full focus:outline-none">
                    @php
                        $name = implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 2));
                    @endphp
                    <img class="object-cover w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{$name}}&color=6dbda1&background=bcf0da" alt="{{ $name }}" aria-hidden="true" />
                    </button>
                    <!-- green dot -->
                    <div class="absolute right-0 p-1 bg-green-400 rounded-full bottom-3 animate-ping"></div>
                    <div class="absolute right-0 p-1 bg-green-400 border border-white rounded-full bottom-3"></div>

                    <!-- Dropdown card -->
                    <div @click.away="isOpen = false" x-show.transition.opacity="isOpen" class="absolute mt-3 transform -translate-x-full bg-white rounded-md shadow-lg min-w-max">
                        <div class="flex flex-col p-4 space-y-1 font-medium border-b">
                            <span class="text-gray-800">{{Auth::user()->name}}</span>
                            <span class="text-sm text-gray-400">{{Auth::user()->email}}</span>
                        </div>
                        <ul class="px-4 my-2" aria-label="submenu">
                            <li>
                                <a class="flex items-center text-red-500" href="{{ route('logout') }}">
                                    <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>{{ __('Logout') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container w-2/3 mx-auto mt-4 flex flex-col">
        @if($update)
            <form method="POST" class="flex mb-4" action="{{ route('tasks.updateTask') }}">
                @csrf
                <input name="id" type="hidden" value={{ $task->id }}>
                <input name="title" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-blue-500 focus:ring-1.5 focus:border-blue-500 focus:z-10 sm:text-sm mr-5" placeholder="Enter task name" value="{{ $task->title }}">
                <button type="submit" class="relative w-32 flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Task
                </button>
            </form>
        @else
            <form method="POST" class="flex mb-4" action="{{ route('tasks.store') }}">
                @csrf
                <input name="title" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-blue-500 focus:ring-1.5 focus:border-blue-500 focus:z-10 sm:text-sm mr-5" placeholder="Enter task name">
                <button type="submit" class="relative w-32 flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Add Task
                </button>
            </form>
        @endif
        @if (session('status'))
            <div class="alert flex flex-row items-center bg-green-200 p-5 rounded border-b-2 border-green-300" x-data="{ show: true }" x-show="show">
                <div class="alert-icon flex items-center bg-green-100 border-2 border-green-500 justify-center h-6 w-6 flex-shrink-0 rounded-full">
                    <span class="text-green-500">
                        <svg fill="currentColor" viewBox="0 0 20 20" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"clip-rule="evenodd"></path>
                        </svg>
                    </span>
                </div>
                <div class="alert-content flex items-center ml-4 w-full">
                    <div class="alert-title font-bold text-green-800">
                        SUCCESS
                    </div>
                    <div class="alert-description ml-2 text-green-600">
                        {{ session('status') }}
                    </div>
                </div>
                <div class="flex flex-auto flex-row-reverse">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" @click={show=false} width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-green-400 rounded-full w-5 h-5 ml-2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
            </div>
        @endif
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-4">
            <div class="px-4 py-3 sm:px-6 bg-gray-100">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                Task
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                list your task
                </p>
            </div>
            <div class="border-t border-gray-200">
                @if(count($tasks) > 0)
                <table class="w-full">
                    @foreach ($tasks as $task)
                        <tr class="hover:bg-gray-50 border-b border-gray-100 cursor-pointer">
                            <td class="px-6 py-4 whitespace-nowrap" style="width:70%">
                                @if ($task->is_complete)
                                    <s>{{ $task->title }}</s>
                                @else
                                    {{ $task->title }}
                                @endif
                            </td>
                            <td class="text-right px-6 py-4 whitespace-nowrap flex">
                                @if (! $task->is_complete)
                                    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-40 relative flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-green-800 bg-green-300 hover:bg-green-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">Complete</button>
                                    </form>
                                    <form method="GET" action="{{ route('tasks.edit', $task->id) }}">
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="ml-2 w-full relative flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-yellow-800 bg-yellow-300 hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-600">Update</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-40 relative flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-gray-800 bg-gray-200 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">Cancel Complete</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-4 w-full relative flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-red-800 bg-red-300 hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                @else
                <div class="p-4 text-center text-gray-500">
                    <span>any new task will appear here</span>
                </div>
                @endif
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</x-base-layout>