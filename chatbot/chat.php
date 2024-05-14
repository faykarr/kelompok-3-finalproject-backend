<?php

// Baca isi file teks
$file = fopen("chatbot.txt", "r") or die("Tidak bisa membuka file!");
$commands = fread($file, filesize("chatbot.txt"));
fclose($file);

// Jalankan perintah-perintah dari file teks
echo "Running commands from chatbot.txt...\n";
$output = shell_exec($commands);
echo $output;