@extends('layouts.app')

@section('title', 'Kartu Anggota')

@push('styles')
<style>
.kc-progress{height:8px;background:var(--bone);border:1px solid var(--line);border-radius:99px;overflow:hidden}
.kc-progress span{display:block;height:100%;background:linear-gradient(90deg,var(--gold),var(--gold-light));border-radius:99px}
.kc-check{list-style:none;margin:14px 0 20px;padding:0;display:grid;grid-template-columns:1fr 1fr;gap:8px 16px}
.kc-check li{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:var(--ink-soft)}
.kc-check .dot{width:18px;height:18px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;border:1.5px solid var(--line);background:#fff;color:transparent}
.kc-check li.ok{color:var(--available)}
.kc-check li.ok .dot{background:var(--available);border-color:var(--available);color:#fff}
.kc-foto{display:flex;gap:16px;align-items:flex-start}
.kc-thumb{width:84px;aspect-ratio:3/4;flex-shrink:0;overflow:hidden;border:1px solid var(--line);border-radius:4px;background:var(--bone);display:flex;align-items:center;justify-content:center;font-size:11px;text-align:center;color:var(--ink-soft);padding:6px}
.kc-thumb img{width:100%;height:100%;object-fit:cover;object-position:center top;display:block}
.kc-hint{font-size:12px;color:var(--ink-soft);margin-top:6px;line-height:1.5}
.kc-off{opacity:.45;cursor:not-allowed;pointer-events:none}
@media(max-width:520px){.kc-check{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
<div class="container" style="padding:48px 24px; max-width:720px;">
    <h2 style="font-size:32px; margin-bottom:8px;">Kartu Anggota</h2>
    <p style="color:var(--ink-soft); font-size:14px; margin-bottom:28px;">
        Lengkapi data dirimu dan unggah foto formal, lalu cetak kartu anggota perpustakaan.
    </p>

    @if(! $member)
        <div class="card">
            <h3 style="font-size:16px; text-transform:none; letter-spacing:normal; margin-bottom:8px;">Belum terdaftar sebagai anggota</h3>
            <p style="font-size:14px; color:var(--ink-soft);">
                Akunmu belum terhubung dengan data anggota perpustakaan. Silakan hubungi petugas perpustakaan.
            </p>
        </div>
    @else
        @php
            $labels   = ['class' => 'Kelas', 'phone' => 'No. HP', 'address' => 'Alamat', 'photo' => 'Foto formal'];
            $done     = count($labels) - count($missing);
            $complete = empty($missing);
            $percent  = (int) round($done / count($labels) * 100);
        @endphp

        <div class="card">
            <h3 style="font-size:16px; text-transform:none; letter-spacing:normal; margin-bottom:6px;">Data untuk Kartu</h3>
            <p style="font-size:12px; color:var(--ink-soft); margin-bottom:14px;">
                {{ $done }} dari {{ count($labels) }} data sudah lengkap
                @if($complete) &mdash; kartu siap dicetak. @else &mdash; lengkapi dulu untuk bisa mencetak. @endif
            </p>

            <div class="kc-progress"><span style="width:{{ $percent }}%;"></span></div>

            <ul class="kc-check">
                @foreach($labels as $key => $label)
                    <li class="{{ array_key_exists($key, $missing) ? '' : 'ok' }}">
                        <span class="dot">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        </span>
                        {{ $label }}
                    </li>
                @endforeach
            </ul>

            <div style="margin-bottom:18px; padding-bottom:18px; border-bottom:1px solid var(--line);">
                <div style="font-size:11px; text-transform:uppercase; letter-spacing:.04em; color:var(--ink-soft); margin-bottom:2px;">Nama &amp; Kode Anggota</div>
                <div style="font-weight:700;">{{ $member->name }}</div>
                <div style="font-size:13px; color:var(--ink-soft);">{{ $member->member_code }}</div>
            </div>

            <form method="POST" action="{{ route('student.card.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="class">Kelas</label>
                    <input type="text" id="class" name="class" class="form-control" value="{{ old('class', $member->class) }}" placeholder="contoh: XII RPL C" required>
                    @error('class') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="phone">No. HP</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $member->phone) }}" placeholder="contoh: 081234567890" required>
                    @error('phone') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="address">Alamat</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $member->address) }}" required>
                    @error('address') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="photo">Foto Formal</label>
                    <div class="kc-foto">
                        <div class="kc-thumb" id="kcThumb">
                            @if($member->photo_url)
                                <img src="{{ $member->photo_url }}" alt="Foto saat ini">
                            @else
                                Belum ada foto
                            @endif
                        </div>
                        <div style="flex:1; min-width:0;">
                            <input type="file" id="photo" name="photo" class="form-control" accept="image/png,image/jpeg,image/webp" {{ $member->photo_url ? '' : 'required' }}>
                            <div class="kc-hint">
                                Foto formal rasio 3&times;4 (tampak wajah dan bahu, latar polos), JPG/PNG/WEBP, maksimal 2 MB.
                                @if($member->photo_url) Kosongkan jika tidak ingin mengganti foto. @endif
                            </div>
                            @error('photo') <div class="error-text">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-solid" style="width:100%;">Simpan Data</button>
            </form>
        </div>

        <div class="card" style="margin-top:20px; text-align:center;">
            <h3 style="font-size:16px; text-transform:none; letter-spacing:normal; margin-bottom:6px;">Cetak Kartu</h3>

            @if($complete)
                <p style="font-size:13px; color:var(--ink-soft); margin-bottom:16px;">
                    Data sudah lengkap. Kartu akan terbuka di tab baru, lalu klik tombol cetak di sana.
                </p>
                <a href="{{ route('student.card.print') }}" target="_blank" class="btn btn-solid" style="min-width:220px;">Cetak Kartu</a>
            @else
                <p style="font-size:13px; color:var(--unavailable); margin-bottom:16px;">
                    Lengkapi dulu: {{ implode(', ', $missing) }}.
                </p>
                <span class="btn btn-solid kc-off" style="min-width:220px;">Cetak Kartu</span>
            @endif
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
(function () {
    var input = document.getElementById('photo');
    var thumb = document.getElementById('kcThumb');
    if (!input || !thumb) return;

    input.addEventListener('change', function () {
        var file = this.files && this.files[0];
        if (!file) return;

        thumb.innerHTML = '';
        var img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.alt = 'Pratinjau foto baru';
        thumb.appendChild(img);
    });
})();
</script>
@endpush