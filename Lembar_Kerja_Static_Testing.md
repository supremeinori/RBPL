# Lembar Kerja Static Testing — Bab 3

## UJI KUALITAS PERANGKAT LUNAK

# LEMBAR KERJA STATIC TESTING

## IDENTITAS MAHASISWA

| Field | Isi |
|---|---|
| Nama Mahasiswa | |
| NIM | |
| Kelas | |
| Nama Proyek RBPL | |
| Tanggal & Jam Mulai Pengerjaan | |

---

## BAGIAN 1 — Ringkasan & Rencana Review

> Pilih scope sesempit mungkin: 1 fitur, 5–8 requirement, dan 1 fungsi/modul kecil.

| Bagian | Isi |
|---|---|
| Fitur/Bagian Proyek yang Dipilih | |
| Requirement/User Story yang Direview (5–8 butir, sebutkan No./nama) | |
| Fungsi/Modul Kode yang Direview (nama file & fungsi) | |
| Tujuan Review | |
| Exit Criteria Singkat | |
| Tipe Review | |

**Catatan:** Tipe review yang dipakai pada versi ringkas ini adalah **Informal Review**. Peran manager/author/reviewer/moderator/scribe/review leader tetap Anda jalankan sendiri secara berurutan — lihat Langkah 2 (jeda singkat 15 menit) pada Lembar Tugas sebagai pengganti cold review bermalam.

---

## BAGIAN 2 — Review Mandiri (Individual Review)

**Petunjuk:** Langkah 3–4, total ±70 menit.

### A. Checklist Dokumen Requirement

- [ ] Apakah setiap requirement jelas / tidak ambigu?
- [ ] Apakah ada kontradiksi antar requirement yang direview?
- [ ] Apakah requirement lengkap untuk fitur yang dipilih?
- [ ] Apakah setiap requirement punya acceptance criteria yang testable?

### Daftar Anomali — Dokumen

| No | Requirement/Bagian | Deskripsi Anomali |
|---:|---|---|
| 1 | | |
| 2 | | |
| 3 | | |

### B. Checklist Source Code

- [ ] Apakah ada variabel tidak dideklarasikan/tidak digunakan?
- [ ] Apakah ada kode yang tidak pernah dijangkau (unreachable)?
- [ ] Apakah penamaan konsisten dengan coding standard?
- [ ] Apakah ada kompleksitas/nested condition berlebihan?

### Daftar Anomali — Kode

| No | File / Baris | Deskripsi Anomali |
|---:|---|---|
| 1 | | |
| 2 | | |
| 3 | | |

---

## BAGIAN 3 — Static Analysis Tool

**Petunjuk:** Langkah 5, ±35 menit. Jalankan **HANYA** pada fungsi/modul yang dipilih di Bagian 1.

| Bagian | Isi |
|---|---|
| Nama Tool & Versi/Rule | |
| Tanggal Dijalankan | |

### Ringkasan Jumlah Issue

| Kategori Issue | Jumlah | Severity Tertinggi |
|---|---:|---|
| | | |
| | | |
| | | |

### 3 Issue Teratas

| No | File / Baris | Deskripsi Issue |
|---:|---|---|
| 1 | | |
| 2 | | |
| 3 | | |

---

## BAGIAN 4 — Klasifikasi Anomali & Perbaikan

**Petunjuk:** Langkah 6–7, ±75 menit. Gabungkan temuan Bagian 2 & 3, tentukan status, lalu perbaiki 3 prioritas tertinggi.

| No | Anomali | Status (Defect/Bukan/Tanya) | Prioritas | Perbaikan Dilakukan (khusus 3 prioritas tertinggi) |
|---:|---|---|---|---|
| 1 | | | | |
| 2 | | | | |
| 3 | | | |
| 4 | | | |

---

## BAGIAN 5 — Refleksi Singkat

**Petunjuk:** Langkah 8, ±15 menit.

### 1. Jenis anomali apa yang lebih mudah ditemukan lewat review manual vs static analysis tool, dan mengapa?

**Jawaban:**




### 2. Faktor apa (persiapan, checklist, jeda singkat, dll.) yang paling membantu Anda tetap objektif saat mereview karya sendiri dalam waktu terbatas ini?

**Jawaban:**




