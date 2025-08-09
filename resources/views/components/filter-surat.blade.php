<form method="GET" action="{{ $action }}" class="row g-3 mb-3">
    <div class="col-md-3">
        <input type="text" name="no_surat" value="{{ request('no_surat') }}" class="form-control" placeholder="No Surat">
    </div>
    <div class="col-md-3">
        <input type="text" name="pengirim" value="{{ request('pengirim') }}" class="form-control" placeholder="{{ $pengirimLabel }}">
    </div>
    <div class="col-md-3">
        <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" placeholder="Dari Tanggal">
    </div>
    <div class="col-md-3">
        <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" placeholder="Sampai Tanggal">
    </div>
    <div class="col-md-3">
        <select name="has_file" class="form-control">
            <option value="">-- Semua File --</option>
            <option value="1" {{ request('has_file') == '1' ? 'selected' : '' }}>Ada File</option>
            <option value="0" {{ request('has_file') == '0' ? 'selected' : '' }}>Tidak Ada</option>
        </select>
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
</form>