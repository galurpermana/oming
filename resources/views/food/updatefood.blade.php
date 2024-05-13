
@extends('layouts.master')
@section('content')
<div class="flex flex-col items-center ">
      @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    
                @endforeach
            </ul>
        </div>
    @endif
  <form action="{{route('food.update', ['food' => $food->id])}}" method="POST" enctype="multipart/form-data" class="md:w-1/2 w-full">
    @csrf
    @method('PUT')
    <div class="shadow sm:rounded-md sm:overflow-hidden">
      <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div class="flex justify-center w-max">
          <h1 class="text-lg">Update Menu</h1>
        </div>
        <div>
          <div class="col-span-3 sm:col-span-2">
            <label for="name" class="block text-lg font-medium text-gray-700"> Food Name </label>
            <div class="mt-1 flex flex-col rounded-md">
              <input required type="text" name="name" id="name" class="shadow-sm @error('name') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300" placeholder="Cheeseburger " value="{{ $food->name }}">
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
            <textarea required id="description" name="description" rows="3" class="@error('description') is-invalid @enderror resize-none p-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-lg border border-gray-300 rounded-md" placeholder="" >{{ $food->description }}</textarea>
            @error('description')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>

        <div class="grid grid-cols-3 gap-2">
          <label for="price" class="block col-span-4 text-lg font-medium text-gray-700"> Food Price </label>
          <div class="mt-1 col-span-4 flex flex-col rounded-md">
              <input required type="number" value="{{ $food->price }}" name="price" id="price" class="shadow-sm @error('price') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300" placeholder="20000">
              @error('price')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
        </div>

        <div class="row">
          <div class="repeatable" id="ingredient-section">
              @foreach(old('ingredients', [[]]) as $index => $ingredientData)
              <div class="ingredient-row mt-1">
                <div class="grid grid-cols-1 gap-2 md:grid-cols-3 lg:grid-cols-7">
                  <div class="flex-none col-span-1 md:col-span-3 lg:col-span-3 ">
                      <select id="ingredients_{{ $index }}" name="ingredients[{{ $index  }}][type]" class="col-span-3 md:col-span-2 mt-1 ingredient-select rounded-md shadow-sm p-1 border focus:ring-indigo-500 focus:border-indigo-500  block w-full rounded-md sm:text-lg border-gray-300" required>
                          @foreach($ingredients as $ingredientOption)
                              <option value="{{ $ingredientOption->id }}" {{ old('ingredients.'.$index.'.type', '') == $ingredientOption->id ? 'selected' : '' }}>{{ $ingredientOption->name }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="md:col-span-3 lg:col-span-2 md:flex sm:flex-col">
                      <input type="number" name="ingredients[{{ $index }}][quantity]" placeholder="amount" class="mt-1 flex-none shadow-sm  p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300" value="{{ old('ingredients.'.$index.'.quantity', $ingredientData['quantity'] ?? '') }}" required>
                  </div>
                  <div class="md:col-span-3 lg:col-span-2 md:flex sm:flex-col sm:col-span-1">
                      <select name="ingredients[{{ $index }}][unit]" id="ingredient-unit_{{ $index }}" class="mt-1 shadow-sm @error('ingredients.'.$index.'.unit') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300" required>
                          <option value="Gram" {{ old('ingredients.'.$index.'.unit', '') == 'Gram' ? 'selected' : '' }}>Gram</option>
                          <option value="Kilogram" {{ old('ingredients.'.$index.'.unit', '') == 'Kilogram' ? 'selected' : '' }}>Kilogram</option>
                          <option value="Liter" {{ old('ingredients.'.$index.'.unit', '') == 'Liter' ? 'selected' : '' }}>Liter</option>
                          <!-- Add more options as needed -->
                      </select>
                      @error('ingredients.'.$index.'.unit')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
                  <div class="md:col-span-3 lg:col-span-7 col-span-1">
                      <button type="button" class="w-full focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="removeIngredient(this)"><i class="fa-solid fa-trash"></i></button>
                  </div>
              </div>
              
              
              
              </div>
              @endforeach
          </div>
      </div>
      

        <!-- Add Ingredient Button -->
        <div class=" flex flex-row-reverse ">
          <button type="button" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900" onclick="addIngredient()">Add Ingredient</button>
        </div>

        <div class="mt-3">
          <label for="picture" class="block text-lg font-medium text-gray-700"> Food Photo  </label>
          <div class="mt-1 flex flex-col rounded-md">
              <input  type="file" name="picture" id="picture" class="block w-full text-sm  border  rounded-lg cursor-pointer  text-gray-400 focus:outline-none bg-gray-50 border-gray-600 placeholder-gray-400" placeholder="https://www.google.com/">
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
function removeIngredient(button) {
    // Get the ingredient row
    var ingredientRow = button.closest('.ingredient-row');

    // Check if there's only one row remaining
    if (document.querySelectorAll('.ingredient-row').length === 1) {
      // If there's only one row remaining, clear its values instead of removing it
      var selectElement = ingredientRow.querySelector('select');
      var inputElement = ingredientRow.querySelector('input[type="number"]');
      selectElement.selectedIndex = 0;
      inputElement.value = '';
    } else {
      // If there's more than one row, remove the ingredient row
      ingredientRow.remove();
    }

    // Update the remove buttons state
    updateRemoveButtons();
  }




</script>
@endpush

