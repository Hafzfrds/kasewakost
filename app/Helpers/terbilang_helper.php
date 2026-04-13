<?php

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

    if ($nilai < 12) {
        return " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        return penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        return penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        return " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        return penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        return " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        return penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        return penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    }
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        return "minus" . trim(penyebut($nilai));
    } else {
        return trim(penyebut($nilai));
    }
}