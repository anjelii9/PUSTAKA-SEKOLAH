<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kartu Anggota — {{ $member->name }}</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Archivo:wght@400;500;600;700&family=Archivo+Expanded:wght@700;800&display=swap">
@php
$c39 = ['0'=>'nnnwwnwnn','1'=>'wnnwnnnnw','2'=>'nnwwnnnnw','3'=>'wnwwnnnnn','4'=>'nnnwwnnnw','5'=>'wnnwwnnnn','6'=>'nnwwwnnnn','7'=>'nnnwnnwnw','8'=>'wnnwnnwnn','9'=>'nnwwnnwnn','A'=>'wnnnnwnnw','B'=>'nnwnnwnnw','C'=>'wnwnnwnnn','D'=>'nnnnwwnnw','E'=>'wnnnwwnnn','F'=>'nnwnwwnnn','G'=>'nnnnnwwnw','H'=>'wnnnnwwnn','I'=>'nnwnnwwnn','J'=>'nnnnwwwnn','K'=>'wnnnnnnww','L'=>'nnwnnnnww','M'=>'wnwnnnnwn','N'=>'nnnnwnnww','O'=>'wnnnwnnwn','P'=>'nnwnwnnwn','Q'=>'nnnnnnwww','R'=>'wnnnnnwwn','S'=>'nnwnnnwwn','T'=>'nnnnwnwwn','U'=>'wwnnnnnnw','V'=>'nwwnnnnnw','W'=>'wwwnnnnnn','X'=>'nwnnwnnnw','Y'=>'wwnnwnnnn','Z'=>'nwwnwnnnn','-'=>'nwnnnnwnw','.'=>'wwnnnnwnn',' '=>'nwwnnnwnn','*'=>'nwnnwnwnn'];
$enc = '*'.strtoupper(preg_replace('/[^0-9A-Za-z\-\. ]/', '', (string) $member->member_code)).'*';
$bars = []; $x = 0;
foreach (str_split($enc) as $ch) {
if (! isset($c39[$ch])) continue;
foreach (str_split($c39[$ch]) as $k => $el) {
$w = $el === 'w' ? 3 : 1;
if ($k % 2 === 0) $bars[] = [$x, $w];
$x += $w;
}
$x += 1;
}
$bw = max($x - 1, 1);
$photo = $member->photo_url ?? null;
$ini = \Illuminate\Support\Str::upper(collect(preg_split('/\s+/', trim($member->name)))->filter()->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode(''));
$len = mb_strlen($member->name);
$nc = $len > 28 ? 'xs' : ($len > 19 ? 'sm' : '');
$on = $member->status === 'aktif';
$logo = asset('images/logo-smkn5.png');
@endphp
<style>
:root{--cream:#f5f1e8;--bone:#efe9dc;--ink:#16140f;--soft:#3a362c;--line:#dcd4c0;--m1:#6b3220;--m2:#4a2116;--m3:#2b140d;--gold:#c6a15b;--gl:#e4c989;--gt:#f1ddb0}
*{box-sizing:border-box}html,body{margin:0;padding:0}
body{background:var(--cream);color:var(--ink);font-family:"Archivo",system-ui,sans-serif;-webkit-print-color-adjust:exact;print-color-adjust:exact}
.bar{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;padding:16px 24px;background:linear-gradient(180deg,var(--m1),var(--m3));border-bottom:1px solid #7a4028}
.bar .t{font-family:"Bebas Neue",sans-serif;font-size:24px;letter-spacing:.08em;color:var(--gl)}
.bar .t small{font:12px "Archivo",sans-serif;color:var(--gt);opacity:.8;margin-left:10px}
.bar .a{display:flex;gap:10px}
.btn{display:inline-block;padding:10px 22px;border:1.5px solid var(--gold);font:700 13px "Archivo",sans-serif;text-transform:uppercase;letter-spacing:.06em;color:var(--gl);background:transparent;cursor:pointer;text-decoration:none;transition:.18s}
.btn:hover{background:var(--gold);color:var(--m3);transform:translateY(-2px)}.btn.s{background:var(--gold);color:var(--m3)}
.stage{padding:32px 16px 48px;display:flex;flex-direction:column;align-items:center;gap:28px}
.lb{font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--soft);margin-bottom:10px;text-align:center}
.sc{zoom:2.2}@media(max-width:900px){.sc{zoom:1.7}}@media(max-width:520px){.sc{zoom:.9}}
.hint{max-width:560px;text-align:center;font-size:13px;color:var(--soft);line-height:1.6}
.card{position:relative;width:85.6mm;height:54mm;border-radius:3.2mm;overflow:hidden;box-shadow:0 1.2mm 3.5mm rgba(43,20,13,.28);line-height:1.2}
.front{background:linear-gradient(135deg,var(--m1) 0%,var(--m2) 52%,var(--m3) 100%);color:var(--gt)}
.front::before{content:"";position:absolute;inset:0;background:linear-gradient(115deg,rgba(255,255,255,.17),rgba(255,255,255,0) 44%)}
.front::after{content:"";position:absolute;right:-14mm;bottom:-18mm;width:46mm;height:46mm;border-radius:50%;border:.5mm solid rgba(198,161,91,.35);box-shadow:0 0 0 3mm rgba(198,161,91,.08),0 0 0 6mm rgba(198,161,91,.05)}
.fin{position:relative;z-index:2;height:100%;padding:4.2mm 5mm;display:flex;flex-direction:column}
.brow{display:flex;align-items:center;gap:2.6mm}
.lg{width:9mm;height:9mm;flex-shrink:0}.lg img{width:100%;height:100%;object-fit:contain;filter:drop-shadow(0 .3mm .5mm rgba(0,0,0,.45))}
.brand{font-family:"Bebas Neue",sans-serif;font-size:13.5pt;line-height:1;letter-spacing:.07em;color:var(--gl);text-shadow:0 .2mm .4mm rgba(0,0,0,.45)}
.bsub{margin-top:.9mm;font-size:4.3pt;font-weight:600;letter-spacing:.22em;text-transform:uppercase;opacity:.85}
.rule{height:.35mm;margin:2.4mm 0 2.6mm;background:linear-gradient(90deg,var(--gold),rgba(198,161,91,.15))}
.body{display:flex;gap:4.2mm;align-items:center;flex:1;min-height:0}
.ph{width:18mm;height:24mm;flex-shrink:0;overflow:hidden;border-radius:1.4mm;border:.45mm solid var(--gold);box-shadow:0 0 0 .4mm var(--m2),0 .6mm 1.4mm rgba(0,0,0,.35);background:linear-gradient(145deg,var(--gl),var(--gold));display:flex;align-items:center;justify-content:center}
.ph img{width:100%;height:100%;object-fit:cover;object-position:center top}
.ph span{font-family:"Archivo Expanded",sans-serif;font-weight:800;font-size:13pt;color:var(--m3)}
.info{min-width:0;flex:1}
.l{font-size:3.9pt;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:var(--gold)}
.nm{margin-top:.5mm;font-family:"Archivo Expanded",sans-serif;font-weight:800;text-transform:uppercase;font-size:9pt;line-height:1.12;color:var(--gl);overflow-wrap:anywhere}
.nm.sm{font-size:7.6pt}.nm.xs{font-size:6.6pt}
.meta{display:grid;grid-template-columns:auto auto;gap:2mm 5mm;margin-top:3mm;width:max-content;max-width:100%}
.v{margin-top:.5mm;font-size:6.6pt;font-weight:700;letter-spacing:.04em;white-space:nowrap}
.st{display:inline-flex;align-items:center;gap:1mm;margin-top:.4mm;font-size:5.4pt;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:.5mm 2mm;border-radius:99mm}
.st::before{content:"";width:1.1mm;height:1.1mm;border-radius:50%;background:currentColor}
.st.on{background:rgba(228,201,137,.18);color:var(--gl);border:.25mm solid rgba(228,201,137,.5)}
.st.off{background:rgba(255,255,255,.12);color:#f3b8ad;border:.25mm solid rgba(243,184,173,.6)}
.back{background:linear-gradient(160deg,#f8f4ea,var(--bone) 55%,#e7decb);border:.25mm solid var(--line)}
.back::before{content:"";position:absolute;left:0;right:0;top:0;height:8mm;background:linear-gradient(180deg,var(--m1),var(--m3));border-bottom:.5mm solid var(--gold)}
.bin{position:relative;z-index:2;height:100%;padding:0 5mm 3.8mm;display:flex;flex-direction:column}
.top{height:8mm;display:flex;align-items:center;gap:2mm}.top .lg{width:6.2mm;height:6.2mm}.top .brand{font-size:10.5pt}
.top .tag{margin-left:auto;font-size:4.2pt;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:var(--gt);opacity:.85}
.bc{margin-top:3.4mm;padding:2.2mm 3mm 1.4mm;background:#fff;border:.25mm solid var(--line);border-radius:1.6mm;text-align:center}
.bc svg{display:block;width:100%;height:9.5mm}
.bc div{margin-top:.9mm;font:700 6.4pt "Courier New",monospace;letter-spacing:.28em}
.rules{margin:2.8mm 0 0;padding:0;list-style:none}
.rules li{position:relative;padding-left:3mm;font-size:5.1pt;line-height:1.5;color:var(--soft)}
.rules li::before{content:"";position:absolute;left:0;top:1.05mm;width:1.1mm;height:1.1mm;border-radius:50%;background:var(--gold)}
.foot{margin-top:auto;display:flex;justify-content:space-between;font-size:4.6pt;letter-spacing:.1em;text-transform:uppercase;color:var(--soft)}
.foot b{color:var(--m1)}
@page{size:A4;margin:14mm}
@media print{body{background:#fff}.bar,.hint,.lb{display:none!important}.stage{padding:0;gap:8mm;align-items:flex-start}.sc{zoom:1}.card{box-shadow:none;break-inside:avoid;outline:.2mm dashed #b9b09b;outline-offset:1mm}}
</style>
</head>
<body>
<div class="bar">
<div class="t">Kartu Anggota <small>{{ $member->name }}</small></div>
<div class="a">
<a href="{{ $backUrl ?? route('admin.members.index') }}" class="btn">Kembali</a>
<button type="button" class="btn s" onclick="window.print()">Cetak Kartu</button>
</div>
</div>
<div class="stage">
<div>
<div class="lb">Tampak Depan</div>
<div class="sc">
<div class="card front"><div class="fin">
<div class="brow">
<div class="lg"><img src="{{ $logo }}" alt="Logo SMK Negeri 5 Surakarta"></div>
<div><div class="brand">SMK Negeri 5 Surakarta</div><div class="bsub">Kartu Anggota Perpustakaan</div></div>
</div>
<div class="rule"></div>
<div class="body">
<div class="ph">@if($photo)<img src="{{ $photo }}" alt="Foto {{ $member->name }}">@else<span>{{ $ini }}</span>@endif</div>
<div class="info">
<div class="l">Nama</div>
<div class="nm {{ $nc }}">{{ $member->name }}</div>
<div class="meta">
<div><div class="l">No. Anggota</div><div class="v">{{ $member->member_code }}</div></div>
<div><div class="l">Kelas</div><div class="v">{{ $member->class ?: '-' }}</div></div>
<div><div class="l">Status</div><div class="st {{ $on ? 'on' : 'off' }}">{{ $on ? 'Aktif' : 'Nonaktif' }}</div></div>
</div>
</div>
</div>
</div></div>
</div>
</div>
<div>
<div class="lb">Tampak Belakang</div>
<div class="sc">
<div class="card back"><div class="bin">
<div class="top">
<div class="lg"><img src="{{ $logo }}" alt="Logo"></div>
<div class="brand">SMK Negeri 5 Surakarta</div>
<div class="tag">Perpustakaan</div>
</div>
<div class="bc">
<svg viewBox="0 0 {{ $bw }} 40" preserveAspectRatio="none" shape-rendering="crispEdges">
@foreach($bars as $b)<rect x="{{ $b[0] }}" y="0" width="{{ $b[1] }}" height="40" fill="#16140f"/>@endforeach
</svg>
<div>{{ $member->member_code }}</div>
</div>
<ul class="rules">
<li>Kartu wajib dibawa saat meminjam dan mengembalikan buku.</li>
<li>Kartu bersifat pribadi dan tidak boleh dipinjamkan kepada orang lain.</li>
<li>Kartu hilang atau rusak, segera lapor kepada petugas perpustakaan.</li>
</ul>
<div class="foot">
<span>Terdaftar: <b>{{ optional($member->created_at)->format('d/m/Y') ?? '-' }}</b></span>
<span>Berlaku selama berstatus <b>aktif</b></span>
</div>
</div></div>
</div>
</div>
<p class="hint">Cetak dengan ukuran asli kartu (85,6 &times; 54 mm): atur <b>Skala 100%</b> dan aktifkan <b>Background graphics</b>. Gunakan kertas tebal lalu gunting mengikuti garis putus-putus.</p>
</div>
</body>
</html>