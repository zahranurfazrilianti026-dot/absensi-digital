<x-app-layout>
    <x-slot name="header"><h2>Edit Kelas</h2></x-slot>

    <div class="card" style="max-width:480px;">
        <form method="POST" action="{{ route('admin.classes.update', $class) }}">
            @csrf
            @method('PUT')
            <div class="field">
                <label>Nama Kelas</label>
                <input type="text" name="class_name" value="{{ old('class_name', $class->class_name) }}">
                @error('class_name') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label>Jurusan (opsional)</label>
                <input type="text" name="major" value="{{ old('major', $class->major) }}">
                @error('major') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.classes.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
