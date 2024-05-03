@extends('layouts.master')
@section('content')
<div class="flex flex-col items-center">

    <form action="{{ url('/ingredient/' . $ingredient->id) }}" method="POST" class="w-50">
        @csrf
        @method('PUT') <!-- Tambahkan metode PUT untuk mengirimkan formulir sebagai metode PUT -->
        <div class="shadow sm:rounded-md sm:overflow-hidden">
          <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div class="flex justify-center w-max">
              <h1 class="text-lg">Edit Ingredients</h1>
            </div>
            <div>
              <div class="col-span-3 sm:col-span-2">
                <label for="ingredient-name" class="block text-lg font-medium text-gray-700"> Ingredient Name </label>
                <div class="mt-1 flex flex-col rounded-md">
                  <input required type="text" name="name" id="ingredient-name" class="shadow-sm @error('name') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300" placeholder="Flour" value="{{ $ingredient->name }}"> <!-- Tambahkan nilai dari kolom 'name' -->
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
            </div>
      
            <div>
              <label for="ingredient-price" class="block text-lg font-medium text-gray-700"> Price </label>
              <div class="mt-1">
                <input required type="number" name="harga_bahan" id="ingredient-price" class="shadow-sm @error('harga_bahan') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300" placeholder="20000" value="{{ $ingredient->harga_bahan }}"> <!-- Tambahkan nilai dari kolom 'harga_bahan' -->
                @error('harga_bahan')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
      
            <div>
              <label for="ingredient-stock" class="block text-lg font-medium text-gray-700"> Stock </label>
              <div class="mt-1">
                <input required type="number" name="stock" id="ingredient-stock" class="shadow-sm @error('stock') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300" placeholder="100" value="{{ $ingredient->stock }}"> <!-- Tambahkan nilai dari kolom 'stock' -->
                @error('stock')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
      
            <div>
              <label for="ingredient-unit" class="block text-lg font-medium text-gray-700"> Unit </label>
              <div class="mt-1">
                <select required name="unit" id="ingredient-unit" class="shadow-sm @error('unit') is-invalid @enderror p-1 border focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-lg border-gray-300">
                  <option value="" selected disabled>Select Unit</option>
                  <option value="Gram" {{ $ingredient->unit === 'Gram' ? 'selected' : '' }}>Gram</option> <!-- Tambahkan logika untuk menentukan pilihan yang dipilih berdasarkan nilai 'unit' -->
                  <option value="Kilogram" {{ $ingredient->unit === 'Kilogram' ? 'selected' : '' }}>Kilogram</option>
                  <option value="Liter" {{ $ingredient->unit === 'Liter' ? 'selected' : '' }}>Liter</option>
                  <!-- Add more options as needed -->
                </select>
                @error('unit')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
      
            <div class="px-4 py-3 text-right sm:px-6">
              <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-lg font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update</button> <!-- Ubah teks tombol menjadi "Update" -->
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

  function updateRemoveButtons() {
    // Get all remove buttons
    var removeButtons = document.querySelectorAll('.ingredient-row .btn-primary');

    // If there's only one ingredient row, disable its remove button
    if (document.querySelectorAll('.ingredient-row').length === 1) {
      removeButtons.forEach(function(button) {
        button.disabled = true;
      });
    } else {
      removeButtons.forEach(function(button) {
        button.disabled = false;
      });
    }
  }
</script>
@endpush