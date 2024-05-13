@extends('layouts.master')
@section('content')



<div class="overflow-x-auto shadow-md sm:rounded-lg">
    <div class="flex flex-col items-center" style="height: 100vh;">
        <div class="flex flex-col items-center w-4/5">
            <div class="flex justify-between items-center w-full row">
                <div class="col-6">
                    <h2 style="font-size:20px" class="py-auto">Product List</h2>
                </div>
                
                <div class="col-6 self-end pb-2">
                    
                    <button onclick="location.href='/food/addfood'" style="font-size:20px" class="flex py-2 px-4 border border-transparent shadow-sm text-lg 
                    font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Add <i class="material-icons self-center">add</i></button>
                </div>
                
            </div>
            
            <table class="p-10 border-collapse border bg-white w-100 w-full">
                <thead>
                    <tr>
                        <th class="border px-2 py-2">ID</th>
                        <th class="border px-2 py-2">Name</th>
                        <th class="border px-2 py-2">Description</th>
                        <th class="border px-2 py-2">Price</th>
                        <th class="border px-2 py-2">Ingredients</th>
                        <th class="border px-2 py-2">Picture</th>
                    </tr>
                </thead>
                @foreach($foods as $food)
                <tbody>
                    <tr>
                        <td class="border px-2 py-2">{{$loop->iteration}}</td>
                        <td class="border px-2 py-2">{{$food['name']}}</td>
                        <td class="border px-2 py-2">{{$food['description']}}</td>
                        <td class="border px-2 py-2">{{$food['price']}}</td>
                        <td class="border px-2 py-2">
                            <!-- You can open the modal using ID.showModal() method -->
                            <!-- Modal toggle -->
                            <div class="flex justify-center items-center h-full">
                                <button data-modal-target="static-modal{{$food->id}}" data-modal-toggle="static-modal{{$food->id}}" class="block text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2.5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                  Toggle modal
                                </button>
                            </div>
                            <!-- Main modal -->
                            <div id="static-modal{{$food->id}}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden  rounded-lg overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative modal-box p-4 w-full max-w-2xl max-h-full">
                                    <!-- Modal content -->
                                    <!-- Modal header -->
                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Cost Of Production {{$food['name']}}
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal{{$food->id}}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <div class="relative overflow-x-auto">
                                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 ">
                                                        Ingredients
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Qty
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 ">
                                                        Price
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $totalCost = 0;
                                                @endphp
                                            @foreach ($food->ingredients as $ingredient)
                                            <tr class="bg-white dark:bg-gray-800">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    @if ($ingredient)
                                                        {{ $ingredient->name }}
                                                    @else
                                                        Ingredient Not Found
                                                    @endif
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{-- Assuming $ingredient->pivot->quantity is the pivot column --}}
                                                    {{ $ingredient->pivot->quantity}} {{$ingredient->unit}}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{-- Assuming $ingredient->harga_bahan is the price column --}}
                                                    @if ($ingredient)
                                                        Rp.{{ $ingredient->harga_bahan }}
                                                        @php
                                                            $totalCost += $ingredient->pivot->quantity * $ingredient->harga_bahan;
                                                            
                                                        @endphp
                                                    @else
                                                        Price Not Found
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
    
                                                
                                            </tbody>
                                            <tfoot class="bg-gray-100 dark:bg-gray-700 dark:text-gray-400 rounded-b">
                                                <tr class="font-semibold text-gray-900 dark:text-white">
                                                    <th scope="row" class="px-6 py-3 text-base">Total</th>
                                                    <td></td>
                                                    <td class="px-6 py-3">Rp. {{ $totalCost }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="border px-2 py-2"><img class="h-20 w-full object-cover" src="{{ Storage::url($food['picture'])}}" alt="Mountain"></td>
                        <td class="border px-2 py-2">
                            @can('update', $food)
                            <form action="{{route('food.edit', ['food' => $food['id']])}}" method="GET">
                                @csrf
                                <button type="submit" class="text-sky-600">Edit</button>
                            </form>
                            @endcan
                        </td>
                        <td class="border px-2 py-2">
                            @can('delete', $food)
                            <form action="/food/{{$food['id']}}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="text-red-600">Delete</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
            <span class="p-5">
                {{$foods -> links()}}
            </span>
        </div>
    </div>
</div>
@endsection
