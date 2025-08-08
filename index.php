<?php
// File: index.php
// Halaman utama yang akan menampilkan form dan tabel

// Memanggil komponen header
require_once 'komponen/header.php';
?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Form Input Laporan -->
    <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-2xl font-semibold mb-6 border-b pb-3">Buat Laporan Baru</h2>
        <form id="laporanForm" class="space-y-4">
            <div>
                <label for="namaSiswa" class="block text-sm font-medium text-gray-700">Nama Siswa</label>
                <input type="text" id="namaSiswa" name="namaSiswa" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="kelasSiswa" class="block text-sm font-medium text-gray-700">Kelas</label>
                <input type="text" id="kelasSiswa" name="kelasSiswa" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="tanggalKejadian" class="block text-sm font-medium text-gray-700">Tanggal Kejadian</label>
                <input type="date" id="tanggalKejadian" name="tanggalKejadian" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="laporanKejadian" class="block text-sm font-medium text-gray-700">Deskripsi Laporan/Kejadian</label>
                <textarea id="laporanKejadian" name="laporanKejadian" rows="4" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            </div>
            <div>
                <label for="namaGuru" class="block text-sm font-medium text-gray-700">Nama Guru Pelapor</label>
                <input type="text" id="namaGuru" name="namaGuru" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Kirim Laporan
            </button>
        </form>
    </div>

    <!-- Tabel Rekapitulasi Laporan -->
    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h2 class="text-2xl font-semibold mb-3 sm:mb-0">Rekapitulasi Laporan</h2>
            <button id="downloadExcel" class="flex items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 9.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 7.414V13a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                Unduh Excel
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Laporan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru Pelapor</th>
                    </tr>
                </thead>
                <tbody id="laporanTableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Data akan dimuat oleh JavaScript -->
                </tbody>
            </table>
        </div>
         <p id="emptyState" class="text-center text-gray-500 py-8 hidden">Belum ada data laporan. Silakan isi form di samping.</p>
    </div>
</div>

<script>
// --- DOM Elements ---
const laporanForm = document.getElementById('laporanForm');
const laporanTableBody = document.getElementById('laporanTableBody');
const downloadExcelButton = document.getElementById('downloadExcel');
const emptyState = document.getElementById('emptyState');

// --- Data Storage ---
// Data sekarang akan diambil dari database, array ini hanya untuk menampung sementara
let laporanData = [];

// --- Functions ---

/**
 * Merender data laporan ke dalam tabel HTML.
 * @param {Array} data - Array of report objects from the server.
 */
function renderTable(data) {
    laporanTableBody.innerHTML = ''; // Kosongkan tabel

    if (data.length === 0) {
        emptyState.classList.remove('hidden');
        laporanTableBody.parentElement.classList.add('hidden');
    } else {
        emptyState.classList.add('hidden');
        laporanTableBody.parentElement.classList.remove('hidden');
        data.forEach((laporan, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${index + 1}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${laporan.nama_siswa}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${laporan.kelas}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${new Date(laporan.tanggal_kejadian).toLocaleDateString('id-ID')}</td>
                <td class="px-6 py-4 text-sm text-gray-500">${laporan.deskripsi}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${laporan.nama_guru}</td>
            `;
            laporanTableBody.appendChild(row);
        });
    }
}

/**
 * Mengambil data laporan dari server.
 */
async function fetchData() {
    try {
        const response = await fetch('proses/ambil_data.php');
        const data = await response.json();
        laporanData = data; // Simpan data ke variabel global
        renderTable(laporanData);
    } catch (error) {
        console.error('Gagal mengambil data:', error);
        alert('Terjadi kesalahan saat memuat data dari server.');
    }
}

// --- Event Listeners ---

/**
 * Menangani submit form untuk menambah laporan baru melalui AJAX.
 */
laporanForm.addEventListener('submit', async function(event) {
    event.preventDefault();

    const formData = new FormData(laporanForm);

    try {
        const response = await fetch('proses/tambah_laporan.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (result.status === 'success') {
            laporanForm.reset(); // Reset form
            fetchData(); // Ambil data terbaru dan render ulang tabel
        } else {
            alert('Gagal menyimpan laporan: ' + result.message);
        }
    } catch (error) {
        console.error('Error saat submit form:', error);
        alert('Terjadi kesalahan koneksi saat mengirim laporan.');
    }
});

/**
 * Menangani klik tombol download untuk mengekspor data ke Excel.
 */
downloadExcelButton.addEventListener('click', function() {
    if (laporanData.length === 0) {
        alert("Tidak ada data untuk diunduh.");
        return;
    }

    const dataForExcel = laporanData.map((laporan, index) => ({
        "No": index + 1,
        "Nama Siswa": laporan.nama_siswa,
        "Kelas": laporan.kelas,
        "Tanggal Kejadian": new Date(laporan.tanggal_kejadian).toLocaleDateString('id-ID'),
        "Deskripsi Laporan": laporan.deskripsi,
        "Guru Pelapor": laporan.nama_guru
    }));

    const worksheet = XLSX.utils.json_to_sheet(dataForExcel);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Rekap Laporan BK");

    worksheet['!cols'] = [
        { wch: 5 }, { wch: 25 }, { wch: 15 }, { wch: 15 }, { wch: 50 }, { wch: 25 }
    ];

    XLSX.writeFile(workbook, "Rekap_Laporan_BK.xlsx");
});

// --- Initial Load ---
// Panggil fetchData saat halaman pertama kali dimuat
document.addEventListener('DOMContentLoaded', fetchData);
</script>

<?php
// Memanggil komponen footer
require_once 'komponen/footer.php';
?>
