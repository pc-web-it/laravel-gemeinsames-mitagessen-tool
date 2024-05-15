@props(['name'])

@error($name)
    <small class="text-sm text-red-500 font-semibold mt-1">{{ $message }}</small>
@enderror
