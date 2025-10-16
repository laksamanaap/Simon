<?php

$scoresFile = 'scores.json';

if (file_exists($scoresFile)) {
    echo "✓ File scores.json sudah ada<br>";
    
    if (is_writable($scoresFile)) {
        echo "✓ File dapat ditulis (writable)<br>";
    } else {
        echo "✗ File TIDAK dapat ditulis! Coba chmod 666<br>";
        if (chmod($scoresFile, 0666)) {
            echo "✓ Permission berhasil diubah<br>";
        } else {
            echo "✗ Gagal mengubah permission. Ubah manual via FTP/cPanel<br>";
        }
    }
    
    $content = file_get_contents($scoresFile);
    echo "<br>Isi file:<br>";
    echo "<pre>" . htmlspecialchars($content) . "</pre>";
    
} else {
    echo "File scores.json belum ada. Membuat file...<br>";
    
    $initialData = [];
    $result = file_put_contents($scoresFile, json_encode($initialData, JSON_PRETTY_PRINT));
    
    if ($result !== false) {
        echo "✓ File berhasil dibuat<br>";
        
        if (chmod($scoresFile, 0666)) {
            echo "✓ Permission berhasil di-set (0666)<br>";
        } else {
            echo "⚠ Permission mungkin perlu diubah manual<br>";
        }
    } else {
        echo "✗ Gagal membuat file! Cek permission folder<br>";
        echo "⚠ Pastikan folder memiliki permission 755 atau 777<br>";
    }
}


?>