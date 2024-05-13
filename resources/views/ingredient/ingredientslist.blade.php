@extends('layouts.master')
@section('content')



<div class="overflow-x-auto shadow-md sm:rounded-lg">
    <div class="flex flex-col items-center" style="height: 100vh">
        <div class="flex flex-col items-center w-4/5">
            
                <div class="flex justify-between items-center w-full row">
                    <div class="col-6">
                        <h2 style="font-size:20px" class="py-auto">Ingredients List</h2>
                    </div>
                    
                    <div class="col-6 self-end pb-2">
                        
                        <button onclick="location.href='{{ route('ingredients.create')}}'" style="font-size:20px" class="flex py-2 px-4 border border-transparent shadow-sm text-lg 
                        font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Add <i class="material-icons self-center">add</i></button>
                    </div>
                    
                </div>
                
    
          
            
            <table class="p-10 border-collapse border bg-white  w-full">
                <thead>
                    <tr>
                        <th class="border px-2 py-2">No.</th>
                        <th class="border px-2 py-2">Name</th>
                        <th class="border px-2 py-2">Stock</th>
                        <th class="border px-2 py-2">Price</th>
                        <th class="border px-2 py-2">Action</th>
                        
                    </tr>
                </thead>
                @foreach($ingredient as $igd)
                <tbody>
                    <tr>
                        <td class="border px-2 py-2">{{$loop->iteration}}</td>
                        <td class="border px-2 py-2">{{$igd['name']}}</td>
                        <td class="border px-2 py-2">{{$igd['stock']}} {{$igd['unit']}}</td>
                        <td class="border px-2 py-2">
                            @php
                                $harga_bahan = $igd->harga_bahan; // Assuming $igd is your model instance
                                $priceunit = $igd->priceunit; // Assuming $ingredient is your model instance
                        
                                // Conversion logic based on selected unit
                                switch ($priceunit) {
                                    case 'Kilogram':
                                        
                                        $pricePerUnit = $harga_bahan * 1000; 
                                        break;
                                    case 'Liter':
                                        $pricePerUnit = $harga_bahan * 1000; 
                                        break;
                                    // Add cases for other units as needed
                                }
                            @endphp
                            {{ $pricePerUnit.'/'.$igd->priceunit }} {{-- Display the converted price --}}
                        </td>
                        
    
                        <td class="border px-2 py-2">
                            {{-- @can('update', $igd) --}}
                            <button onclick="window.location='/ingredient/{{$igd->id}}/edit'" class="text-sky-600">Edit</button>
                            {{-- @endcan
                            @can('delete', $igd) --}}
                                <form action="/ingredient/{{$igd->id}}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Delete</button>
                                </form>
                            {{-- @endcan --}}
                        </td>
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
@endsection