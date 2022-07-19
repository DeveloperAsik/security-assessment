-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Jul 2022 pada 03.52
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `db_project_assessments_api`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_a_api_join_classes`
--

CREATE TABLE `tbl_a_api_join_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `param_select` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `param_1` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `param_2` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `param_3` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `join_type` tinyint(4) NOT NULL DEFAULT 1,
  `is_active` tinyint(4) NOT NULL DEFAULT 0,
  `join_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_a_api_main_classes`
--

CREATE TABLE `tbl_a_api_main_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `select` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `condition` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_by` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_by` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `offset` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `limit` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `select_type` tinyint(4) NOT NULL DEFAULT 1,
  `is_active` tinyint(4) NOT NULL DEFAULT 0,
  `join_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_a_api_modules`
--

CREATE TABLE `tbl_a_api_modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_class_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `join_class_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 0,
  `join_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_a_api_join_classes`
--
ALTER TABLE `tbl_a_api_join_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_a_api_main_classes`
--
ALTER TABLE `tbl_a_api_main_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_a_api_modules`
--
ALTER TABLE `tbl_a_api_modules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_a_api_join_classes`
--
ALTER TABLE `tbl_a_api_join_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_a_api_main_classes`
--
ALTER TABLE `tbl_a_api_main_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_a_api_modules`
--
ALTER TABLE `tbl_a_api_modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
