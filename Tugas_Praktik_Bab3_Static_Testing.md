# Uji Kualitas Perangkat Lunak — Tugas Praktik Bab 3
## Versi Ringkas

**Program Studi:** Sistem Informasi  
**Mata Kuliah:** Uji Kualitas Perangkat Lunak  
**Bab:** 3 — Static Testing

---

## Komponen Tugas

| Komponen | Ketentuan |
|---|---|
| Bentuk Tugas | Praktik individu (mandiri), dikerjakan dalam 1 sesi kerja |
| Objek Uji (dipersempit) | 5–8 requirement/user story terkait 1 fitur + 1 fungsi/modul kecil source code (±50–150 baris) dari proyek RBPL |
| Output | Lembar Kerja (terisi lengkap + hasil static analysis tool + bukti perbaikan 3 issue prioritas) |

---

## A. Tujuan

- Menerapkan tahapan inti proses review (bagian 3.2.2) secara mandiri.
- Memahami tanggung jawab peran-peran review (bagian 3.2.3).
- Menggunakan static analysis tool sebagai pembanding independen terhadap temuan review manual.
- Membedakan efektivitas static testing dibanding dynamic testing berdasarkan pengalaman langsung.

---

## B. Ruang Lingkup

- **Dokumen requirement:** pilih 5–8 requirement atau user story yang berkaitan dengan **SATU fitur** (bukan seluruh SRS).
- **Source code:** pilih **SATU fungsi/method atau file kecil (±50–150 baris)** yang paling kompleks/berisiko pada fitur tersebut.
- **Tipe review yang dipakai:** **Informal Review** — cukup untuk versi ringkas karena tidak memerlukan dokumentasi proses yang berat, namun tetap efektif mendeteksi anomali (bagian 3.2.4).

---

## C. Alokasi Waktu Total

| Langkah | Aktivitas | Waktu |
|---:|---|---:|
| 1 | Persiapan & Planning | 20 menit |
| 2 | Jeda Singkat (Distancing Break) | 15 menit |
| 3 | Individual Review — Dokumen Requirement | 35 menit |
| 4 | Individual Review — Source Code | 35 menit |
| 5 | Static Analysis Tool | 35 menit |
| 6 | Klasifikasi Anomali & Penentuan Prioritas | 30 menit |
| 7 | Perbaikan 3 Issue Prioritas Tertinggi | 45 menit |
| 8 | Refleksi Singkat | 15 menit |

---

# D. Langkah Pengerjaan

## LANGKAH 1 — Persiapan & Planning (± 20 menit)

**Tentukan scope**

- Pilih 1 fitur dari proyek RBPL Anda, lalu tentukan 5–8 requirement/user story dan 1 fungsi/modul kecil terkait fitur tersebut.
- Tentukan tujuan review, exit criteria singkat, dan konfirmasi tipe review (**Informal Review**).
- Isi Bagian 1 Lembar Kerja.

---

## LANGKAH 2 — Jeda Singkat (Distancing Break) (± 15 menit)

Pengganti cold review multi-hari — cukup untuk mengubah sudut pandang dari "Author" menjadi "Reviewer" dalam satu sesi.

- Alihkan perhatian sepenuhnya dari dokumen/kode selama 15 menit.

---

## LANGKAH 3 — Individual Review — Dokumen Requirement (± 35 menit)

Periksa 5–8 requirement/user story yang dipilih memakai checklist.

- Gunakan checklist pada Bagian 2 Lembar Kerja (ambiguitas, kontradiksi, kelengkapan, testability).
- Catat **SETIAP anomali** yang ditemukan — anomali belum tentu defect, status ditentukan di Langkah 6.

---

## LANGKAH 4 — Individual Review — Source Code (± 35 menit)

Telusuri fungsi/modul kecil yang dipilih mengikuti skenario penggunaan utamanya.

- Gunakan checklist pada Bagian 2 Lembar Kerja (variabel tak terpakai, unreachable code, konsistensi penamaan, kompleksitas berlebih).
- Catat setiap anomali pada tabel yang sama di Bagian 2.

---

## LANGKAH 5 — Static Analysis Tool (± 35 menit)

Jalankan static analysis tool sebagai pembanding independen.

- Pilih tool sesuai bahasa:
  - **ESLint** (JS/TS)
  - **Pylint/Flake8** (Python)
  - **Checkstyle/PMD** (Java)
  - **SonarLint** (multi-bahasa)
  - atau tool lain yang relevan.
- Jalankan **HANYA** pada fungsi/modul yang dipilih di Langkah 1 — bukan seluruh proyek, agar hasil tetap fokus dan cepat direkap.
- Isi Bagian 3 Lembar Kerja: ringkasan jumlah issue dan 3 issue teratas.

---

## LANGKAH 6 — Klasifikasi Anomali & Penentuan Prioritas (± 30 menit)

Gabungkan temuan Langkah 3–5 dalam satu daftar, lalu putuskan statusnya.

- Untuk setiap anomali: tentukan apakah **defect, bukan defect, atau masih pertanyaan**.
- Pilih **3 anomali dengan prioritas tertinggi** untuk diperbaiki pada langkah berikutnya.
- Isi Bagian 4 Lembar Kerja.

---

## LANGKAH 7 — Perbaikan 3 Issue Prioritas Tertinggi (± 45 menit)

Perbaiki **HANYA 3 issue prioritas tertinggi** — bukan seluruh anomali yang tercatat, agar waktu cukup.

- Perbaiki dokumen requirement dan/atau source code untuk ketiga issue tersebut.
- Simpan bukti **before/after (screenshot singkat)** untuk masing-masing.
- Lengkapi kolom **"Perbaikan Dilakukan"** pada Bagian 4 Lembar Kerja.

---

## LANGKAH 8 — Refleksi Singkat & Pengumpulan (± 15 menit)

Tutup sesi dengan 2 pertanyaan reflektif singkat.

- Isi Bagian 5 Lembar Kerja, lalu lengkapi pernyataan keaslian pada Bagian 6.
- Kumpulkan Lembar Kerja beserta lampiran (hasil static analysis, bukti before/after 3 issue).

---

# E. Output yang Dikumpulkan

- Lembar Kerja Static Testing.
- Screenshot/ekspor ringkas hasil static analysis tool.
- Bukti before/after untuk 3 issue yang diperbaiki.
- Seluruh berkas dikumpulkan dalam satu folder terkompresi:

`[NIM]_StaticTesting_[NamaProyekRBPL]`

---

# F. Referensi

- ISTQB. (2024). *Certified Tester Foundation Level Syllabus v4.0.1*, Bab 3 — Static Testing.
- ISO/IEC 20246 — *Software and systems engineering — Work product reviews*.
