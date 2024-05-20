@extends('layouts.master')
@section('content')



<div class="overflow-x-scroll shadow-md sm:rounded-lg">
    <div class="flex flex-col items-center" style="height: 100vh">
        <div class="flex flex-col  w-4/5">
            
                <div class="flex justify-between items-center w-full row">
                    <div class="col-6">
                        <h2 style="font-size:20px" class="py-auto">Orders List</h2>
                    </div>
                    
                    {{-- <div class="col-6 self-end pb-2">
                        
                        <button onclick="location.href=''" style="font-size:20px" class="flex py-2 px-4 border border-transparent shadow-sm text-lg 
                        font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Add <i class="material-icons self-center">add</i></button>
                    </div> --}}
                    
                </div>
                
    
          
            
            <table class=" p-10 border-collapse border bg-white  w-full">
                <thead>
                    <tr class="md:flex-col">
                        <th class=" border px-2 py-2">No.</th>
                        <th class="border px-2 py-2">Customer's Name</th>
                        <th class="border px-2 py-2">Menu</th>
                        <th class="border px-2 py-2">Payment Proof</th>
                        <th class="border px-2 py-2">Date</th>
                        <th class="border px-2 py-2">Status</th>
                        <th class="border px-2 py-2">Phone</th>
                        
                    </tr>
                </thead>
                @foreach($orders as $order)
                <tbody>
                    <tr>
                        <td class="border px-2 py-2 text-nowrap">{{$loop->iteration}}</td>
                        <td class="border px-2 py-2 text-nowrap">{{ $order->user->name }}</td>
                        <td class="border px-2 py-2 text-nowrap">
                            <ul>
                                @foreach($order->food as $food)
                                    <li>{{ $food->name }} (Quantity: {{ $food->pivot->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="border px-2 py-2 text-nowrap ">
                            <div class="flex justify-center items-center h-full">
                            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                Klick to see
                              </button>
                            </div>
                        </td>
                        <td class="border px-2 py-2 text-nowrap">
                            {{ \Carbon\Carbon::parse($order->date)->format('d-m-Y') }}
                        </td>
                        <td class="border px-2 py-2 text-nowrap">
                            @php
                                $buttonClasses = [
                                    'pending' => 'bg-yellow-500  focus:ring-yellow-300 dark:bg-yellow-400 dark: dark:focus:ring-yellow-600',
                                    'In Process' => 'bg-blue-700  focus:ring-blue-300 dark:bg-blue-600 dark: dark:focus:ring-blue-800',
                                    'Rejected' => 'bg-red-600  focus:ring-red-300 dark:bg-red-500 dark: dark:focus:ring-red-700',
                                    'Canceled' => 'bg-gray-600  focus:ring-gray-300 dark:bg-gray-500 dark: dark:focus:ring-gray-700',
                                    'Completed' => 'bg-green-600  focus:ring-green-300 dark:bg-green-500 dark: dark:focus:ring-green-700',
                                ];
                                $currentStatus = $order->status;
                                $currentClass = $buttonClasses[$currentStatus] ?? 'bg-blue-700 hover:bg-blue-800 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800';
                            @endphp
                        
                            <button  class="text-white w-full font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none {{ $currentClass }}">
                                {{ $currentStatus }}
                            </button>                            
                            <button data-modal-target="status-modal" data-modal-toggle="status-modal" class="block w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                Change Status
                              </button>
                        </td>
                        <td class="border px-2 py-2 text-nowrap">
                            {{ $order->user->phone }}
                        </td>
                        
    
                        {{-- <td class="border px-2 py-2"> --}}
                            {{-- @can('update', $igd) --}}
                            {{-- <button onclick="window.location=''" class="text-sky-600">Edit</button> --}}
                            {{-- @endcan
                            @can('delete', $igd) --}}
                                {{-- <form action="" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Delete</button>
                                </form> --}}
                            {{-- @endcan --}}
                        {{-- </td> --}}
                    </tr>
                </tbody>
                @endforeach
            </table>
            {{-- <span class="p-5">
                {{$ingredients-> links()}}
            </span> --}}
        </div>
    </div>
</div>
<div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Payment Proof
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                @if($order->image_path)
                                <img src="{{ asset($order->image_path) }}" alt="Order Image" class="w-full object-cover">
                            @else
                                No Image
                            @endif
            </div>
        </div>
    </div>
</div>

<div id="status-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-max max-w-none max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Change Status Order
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="status-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4" action="{{ route('order.updateStatus') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                
                    <ul class="items-center w-max text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-max border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center ps-3 text-nowrap">
                                <input id="status-pending" type="radio" value="Pending" name="status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" {{ $order->status == 'pending' ? 'checked' : '' }}>
                                <label for="status-pending" class="w-max py-3 px-2 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Pending</label>
                            </div>
                        </li>
                        <li class="w-max border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center ps-3 text-nowrap">
                                <input id="status-in-process" type="radio" value="In Process" name="status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" {{ $order->status == 'In Process' ? 'checked' : '' }}>
                                <label for="status-in-process" class="w-max py-3 px-2 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">In Process</label>
                            </div>
                        </li>
                        <li class="w-max border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center ps-3 text-nowrap">
                                <input id="status-rejected" type="radio" value="Rejected" name="status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" {{ $order->status == 'Rejected' ? 'checked' : '' }}>
                                <label for="status-rejected" class="w-max py-3 px-2 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Rejected</label>
                            </div>
                        </li>
                        <li class="w-max dark:border-gray-600">
                            <div class="flex items-center ps-3 text-nowrap">
                                <input id="status-canceled" type="radio" value="Canceled" name="status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" {{ $order->status == 'Canceled' ? 'checked' : '' }}>
                                <label for="status-canceled" class="w-max py-3 px-2 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Canceled</label>
                            </div>
                        </li>
                        <li class="w-max dark:border-gray-600">
                            <div class="flex items-center ps-3 text-nowrap">
                                <input id="status-completed" type="radio" value="Completed" name="status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" {{ $order->status == 'Completed' ? 'checked' : '' }}>
                                <label for="status-completed" class="w-max py-3 px-2 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Completed</label>
                            </div>
                        </li>
                    </ul>
                    <div class="flex justify-center">
                        <button type="submit" class="w-max text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 px-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Proceed</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    // Get the modal element
    const modal = document.getElementById('authentication-modal');

    // Get the button that opens the modal
    const openModalButton = document.querySelector('[data-modal-show="authentication-modal"]');

    // Get the button that closes the modal
    const closeModalButton = modal.querySelector('[data-modal-hide="authentication-modal"]');

    // Function to open the modal
    function openModal() {
        modal.classList.remove('hidden');
    }

    // Function to close the modal
    function closeModal() {
        modal.classList.add('hidden');
    }

    // Event listener to open the modal
    if (openModalButton) {
        openModalButton.addEventListener('click', openModal);
    }

    // Event listener to close the modal
    if (closeModalButton) {
        closeModalButton.addEventListener('click', closeModal);
    }

    // Close the modal when clicking outside the modal content
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });
});

    </script>
@endpush