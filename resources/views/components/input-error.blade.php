@props(['messages'])

@if ($messages)
    @foreach ($messages as $message)
        <span class="text-danger">
            {{ $message }}
        </span>
    @endforeach
@endif
