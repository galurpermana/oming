@extends('layouts.master')
@section('content')
<div class="flex flex-col items-center">
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  <form action="{{ route('food.store') }}" method="POST" enctype="multipart/form-data" class="w-50">
    @csrf
    <div class="shadow sm:rounded-md sm:overflow-hidden">
      <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div class="flex justify-center w-max">
          <h1 class="text-lg">Add Menu</h1>
        </div>
        <div>
          <div class="col-span-3 sm:col-span-2">
            <label for="name" class="block text-lg font-medium text-gray-700"> Food Name </label>
            <div class="mt-1 flex flex-col rounded-md">
              <input required type="text" name="name" id="name" class="shadow-sm @error('name') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300" placeholder="Cheeseburger">
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
        </div>

        <div>
          <label for="description" class="block text-lg font-medium text-gray-700"> Food Description </label>
          <div class="mt-1">
            <textarea required id="description" name="description" rows="3" class="@error('description') is-invalid @enderror resize-none p-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-lg border border-gray-300 rounded-md" placeholder=""></textarea>
            @error('description')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>

        <div class="row">
          <label for="price" class="block text-lg font-medium text-gray-700"> Food Price </label>
          <div class="mt-1 col flex flex-col rounded-md">
              <input required type="number" name="price" id="price" class="shadow-sm @error('price') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300" placeholder="20000">
              @error('price')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
        </div>

        <div class="row">
          <div class="repeatable" id="ingredient-section">
            <label for="ingredients" class="block text-lg font-medium text-gray-700">Ingredient</label>
            @foreach(old('ingredients', [[]]) as $index => $ingredientData)
            
            <div class="ingredient-row">
              <div class="row">
                <div class="col-md-5">
                  <select name="ingredients[{{ $index }}][type]" class="ingredient-select flex justify-center mt-1 flex rounded-md shadow-sm p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300">
                    
                    @foreach($ingredients as $ingredientOption)
                      <option value="{{ $ingredientOption->id }}">{{ $ingredientOption->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <input type="number" name="ingredients[{{ $index }}][quantity]" placeholder="amount" class="shadow-sm p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300">
                </div>
                <div class="col-md-3">
                  <select required name="ingredients[{{ $index }}][unit]" id="ingredient-unit" class="shadow-sm @error('unit') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300">
                    
                    <option value="Gram">Gram</option>
                    <option value="Kilogram">Kilogram</option>
                    <option value="Liter">Liter</option>
                <!-- Add more options as needed -->
                 </select>
              @error('unit')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-danger active" onclick="removeIngredient(this)"><i class="fa-solid fa-trash"></i></button>
                </div>
              </div>
            </div>
            @endforeach
            
            
          </div>
        </div>

        <!-- Add Ingredient Button -->
        <div class="mt-3">
          <button type="button" class="btn btn-primary active" onclick="addIngredient()">Add Ingredient</button>
        </div>

        <div class="mt-3">
          <label for="picture" class="block text-lg font-medium text-gray-700"> Food Photo  </label>
          <div class="mt-1 flex flex-col rounded-md">
              <input required type="file" name="picture" id="picture" class="block w-full text-sm  border  rounded-lg cursor-pointer  text-gray-400 focus:outline-none bg-gray-50 border-gray-600 placeholder-gray-400" placeholder="https://www.google.com/">
              @error('picture')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
        </div>
        
        <div class="px-4 py-3 text-right sm:px-6">
          <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Add</button>
        </div>
      </div>
    </div>
  </form>
</div>


@endsection

@push('script')
<script>
function addIngredient() {
    // Clone the ingredient row
    var ingredientRow = document.querySelector('.ingredient-row').cloneNode(true);

    // Clear the values
    var selectElement = ingredientRow.querySelector('select');
    var inputElement = ingredientRow.querySelector('input[type="number"]');
    selectElement.selectedIndex = 0;
    inputElement.value = '';

    // Append the cloned row to the ingredient section
    document.getElementById('ingredient-section').appendChild(ingredientRow);

    // Update the name attribute of select and input fields with unique indices
    var ingredientRows = document.querySelectorAll('.ingredient-row');
    ingredientRows.forEach(function(row, index) {
        var select = row.querySelector('select');
        var input = row.querySelector('input[type="number"]');
        select.name = 'ingredients[' + index + '][type]';
        input.name = 'ingredients[' + index + '][quantity]';
        // Update the name for the unit dropdown
        var unitSelect = row.querySelector('select#ingredient-unit');
        unitSelect.name = 'ingredients[' + index + '][unit]';
    });

    // Update the remove buttons state
    updateRemoveButtons();
}


//   $(document).ready(function() {
//     $.ajax({
//         url: '/food/addfood', // URL to fetch ingredients data
//         type: 'GET',
//         dataType: 'json',
//         success: function(response) {
//             // Loop through the ingredients data and append options to the select element
//             response.forEach(function(ingredient) {
//                 $('.ingredient-select').append('<option value="' + ingredient.id + '">' + ingredient.name + '</option>');
//             });
//         },
//         error: function(xhr, status, error) {
//             console.error(xhr.responseText);
//         }
//     });
// });

</script>
@endpush