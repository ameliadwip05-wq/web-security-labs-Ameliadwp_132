**DESKRIPSI**
Repository ini berisi analisis praktikum kerentanan web application yang mencakup empat jenis serangan utama:

SQL Injection - Manipulasi query database
Cross-Site Scripting (XSS) - Injeksi script berbahaya
Upload Vulnerability - Eksploitasi fitur upload file
Broken Access Control - Bypass otorisasi akses

Setiap kerentanan memiliki dua versi: VULNERABLE (Rentan) dan SAFE (Aman) untuk mendemonstrasikan perbedaan implementasi keamanan.

**Test SQL Injection**
1. Buka: http://localhost/sqlinjection/login_vul.php
2. Username: ameliadwp'--
3. Password: (isi apa saja)
4. Hasil: Berhasil login tanpa password valid
5. Buka: http://localhost/sqlinjection/login_safe.php
6. Coba payload yang sama
7. Hasil: Login gagal, sistem aman

**Test XSS**
1. Login ke http://localhost/praktikum_xss/login.php
2. Buka post_vul.php
3. Ketik: <script>alert('XSS')</script>
4. Hasil: Alert muncul (XSS berhasil)

5. Buka post_safe.php
6. Ketik script yang sama
7. Hasil: Script ditampilkan sebagai text, tidak dieksekusi

**Test Upload**
1. Login ke http://localhost/upload-vul/
2. Buka artikel_vul.php
3. Upload file shell.php
4. Akses: http://localhost/upload-vul/uploads/shell.php?cmd=whoami
5. Hasil: Command dieksekusi
6. Buka artikel_safe.php
7. Coba upload shell.php
8. Hasil: File ditolak

**Test Broken Access Control**
1. Login sebagai alice
2. Buka dashboard_vul.php
3. Lihat URL: ?id=1
4. Ubah jadi: ?id=2
5. Hasil: Bisa lihat data user lain
6. Buka dashboard_safe.php
7. Coba ubah UUID dan token di URL
8. Hasil: Access denied
