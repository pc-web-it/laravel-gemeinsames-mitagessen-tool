<x-layout>
<div class="rezeptContainer max-w-6xl mx-auto mt-8 p-10 bg-white ">
<div class="max-w-5xl mx-auto mt-8 ">
        <div class="flex justify-between items-center mb-4">
        <a href="/recipes" class="backBtn  font-bold text-lg py-2 px-2 focus:outline-none focus:shadow-outline"> <img src="{{ asset('back2.jpg') }}" alt="Back" class="w-6 inline mr-2 mb-1">Zurück</a>
            @if (isset($recipe->image))
                @if ($recipe->image == null)
                    <img src="{{ asset('recipesImages/defaultFood.jpg') }}" alt="" class="w-32 h-32">
                @else
                    <img src="{{ route('display.recipeImage', $recipe->image) }}" alt="" class="w-32 h-32">
                @endif
            @else
                <img src="{{ asset('recipesImages/defaultFood.jpg') }}" alt="" class="w-32 h-32">
            @endif
        </div>
        <div class="flex items-center mb-4">
            <div>
                <h1 class="rezeptTitel text-2xl font-bold mb-5">{{ $recipe->title }}</h1>
                <div class="flex items-center mb-5 text-xl">Gekocht:
                    <div>
                        @if (isset($employee->file_hash))
                            @if ($employee->file_hash == null)
                                <img src="{{ asset('Profil.jpg') }}" alt=""
                                    class="ml-8 w-9 h-9 rounded-full z-10">
                            @else
                                <img src="{{ route('display.image', $employee->file_hash) }}" alt=""
                                    class="ml-8 w-9 h-9 rounded-full object-cover">
                            @endif
                        @else
                            <img src="{{ asset('Profil.jpg') }}" alt="" class="ml-8 w-9 h-9 rounded-full z-10">
                        @endif
                    </div>
                    <p class="text-gray-700 ml-3">{{ $employee->name }}</p>
                </div>
            </div>
        </div>
        <p class="text-xl text-center mb-10">{{ $recipe->description }}</p>
        <div class="flex justify-between">
            @if ($recipe->pdf_path)
                <a href="{{ route('display.pdf', $recipe->pdf_path) }}" target="_blank">
                    <img src="{{ asset('pdf.png') }}" alt=""
                        class="pdfFile col-span-1 ml-8 w-14 h-14 opacity-60 hover:opacity-70" />
                </a>
            @endif
            <a href="/recipes/{{ $recipe->id }}/edit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded-lg focus:outline-none focus:shadow-outline">Bearbeiten</a>
            <form action="/recipes/{{ $recipe->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-4 px-4 rounded-lg focus:outline-none focus:shadow-outline">Löschen</button>
            </form>
        </div>
        </div>
    </div>

</x-layout>
