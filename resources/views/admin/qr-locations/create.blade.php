<x-app-layout>
    <x-slot name="header">
        <h2>Tambah Lokasi QR</h2>
    </x-slot>

    <div class="card" style="max-width:520px;">
        <form method="POST" action="{{ route('admin.qr-locations.store') }}">
            @csrf

            <div class="field">
                <label>Nama Lokasi</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Gerbang Utama">
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label>Kode Lokasi</label>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="Contoh: GERBANG">
                <small>Digunakan sebagai identitas unik lokasi ini.</small>
                @error('code') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div class="field" style="margin:0;">
                    <label>Latitude</label>
                    <input type="number" step="any" name="latitude" value="{{ old('latitude') }}">
                    @error('latitude') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="field" style="margin:0;">
                    <label>Longitude</label>
                    <input type="number" step="any" name="longitude" value="{{ old('longitude') }}">
                    @error('longitude') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="field">
                <label>Radius (meter)</label>
                <input type="number" name="radius" value="{{ old('radius') }}" placeholder="Contoh: 50">
                <small>Jarak toleransi absen dari titik koordinat, dalam meter.</small>
                @error('radius') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field" style="display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width:auto;">
                <label style="margin:0;">Lokasi aktif</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.qr-locations.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
