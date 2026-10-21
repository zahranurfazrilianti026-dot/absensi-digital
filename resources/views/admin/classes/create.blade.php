<x-app-layout>
    <x-slot name="header"><h2>Tambah Kelas</h2></x-slot>

    <div class="card" style="max-width:480px;">
        <form method="POST" action="{{ route('admin.classes.store') }}">
            @csrf
            <div class="field">
                <label>Nama Kelas</label>
                <input type="text" name="class_name" value="{{ old('class_name') }}" placeholder="Contoh: XII RPL 1">
                @error('class_name') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label>Jurusan (opsional)</label>
                <input type="text" name="major" value="{{ old('major') }}" placeholder="Contoh: RPL">
                @error('major') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.classes.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
