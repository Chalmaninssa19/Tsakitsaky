<div>
    <form action="{{ route('import_vente_billet') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="messages">
            @if (isset($success))
            <div class="alert alert-success">
                {{ $success }}
            </div>
            @endif
        </div>
        <div class="fields">
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="import_csv" name="import_csv" accept=".csv">
                <label class="input-group-text" for="import_csv">Upload</label>
            </div>
        </div>
        @if(isset($error))
            <div class="mt-3">
                <p class="text-danger text-small">{{ $error; }}</p>
            </div>
        @endif
        <button type="submit" class="btn btn-success">Import CSV</button>
    </form>
</div>