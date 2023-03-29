<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Appname title + page name --}}
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>

<body>
    <h1>Detail Optiepakket</h1>


    {{-- Form --}}
    <form action="{{ route('reserveringen.update', $id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Dropdown met alle opties --}}
        <div class="row">
            <div class="col-2">
                <h3>Optiepakket:</h3>
            </div>
            <div class="col-6">
                {{-- Verstuur het geselecteerde item als pakket_optie_id mee in de form --}}
                <select class="form-select" name="pakket_optie_id">
                    @foreach ($pakketOpties as $pakketOptie)
                    <option value="{{ $pakketOptie->id }}">{{ $pakketOptie->naam }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Submit button --}}
        <div class="row">
            <div class="col-2">
                <button type="submit" class="btn btn-primary">Wijzig</button>
            </div>
        </div>
    </form>

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous">
    </script>
</body>

</html>