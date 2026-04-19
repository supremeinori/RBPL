# Alur Kerja Sistem (Workflow)

Dokumen ini menjelaskan alur teknis dan logika bisnis yang diterapkan dalam sistem RBPL menggunakan diagram visual.

---

## 1. Diagram Status Pesanan (Order Lifecycle)

Setiap pesanan (`Order`) memiliki siklus hidup yang ditentukan oleh statusnya. Berikut adalah transisi status yang terjadi:

```mermaid
stateDiagram-v2
    [*] --> Baru: Admin buat order
    Baru --> Dalam_Proses: Admin tugaskan Desainer
    Dalam_Proses --> Menunggu_Approval: Desainer upload draft
    Menunggu_Approval --> Revisi: Admin minta perbaikan
    Revisi --> Menunggu_Approval: Desainer upload ulang
    Menunggu_Approval --> Disetujui: Admin klik Approve
    Disetujui --> Menunggu_Pembayaran: Admin input kesepakatan harga
    Menunggu_Pembayaran --> Menunggu_Validasi: Customer bayar & Upload bukti
    Menunggu_Validasi --> Selesai: Akuntan Approve pembayaran
    Menunggu_Validasi --> Menunggu_Pembayaran: Akuntan Reject (Bukti salah)
    Selesai --> [*]
```

---

## 2. Interaksi Antar Peran (Role Interaction)

Diagram ini menunjukkan bagaimana setiap aktor berinteraksi dengan sistem dan satu sama lain:

```mermaid
graph TD
    subgraph "Admin Area"
        A[Admin] -->|1. Create| O(Order)
        A -->|2. Assign| D[Desainer]
        A -->|4. Review| DR(Draft Desain)
        A -->|5. Approve/Reject| DR
        A -->|6. Set Harga| P(Pembayaran)
    end

    subgraph "Production Area"
        D -->|3. Upload| DR
    end

    subgraph "Finance Area"
        AK[Akuntan] -->|7. Validasi| P
        AK -->|8. Generate| L[Laporan Keuangan]
    end

    subgraph "System Admin"
        SA[Super Admin] -->|Manage| U[Users]
        SA -->|Backup| DB[(Database)]
    end
```

---

## 3. Penjelasan Teknis Singkat

- **Autentikasi**: Menggunakan sistem auth bawaan Laravel dengan middleware `role`.
- **Penyimpanan File**: Draft desain dan bukti pembayaran disimpan di folder `storage/app/public` dan diakses melalui symbolic link.
- **Relasi Database**:
    - `User` has many `Order` (sebagai pembuat atau desainer).
    - `Order` has many `Desain` (untuk riwayat iterasi).
    - `Order` has one `Pembayaran`.
    - `Customer` has many `Order`.
