-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Jul 2022 pada 06.20
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `db_project_assessments_apps`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_a_projects`
--

CREATE TABLE `tbl_a_projects` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `project_detail_id` int(32) NOT NULL,
  `project_team_id` int(32) NOT NULL,
  `project_type_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_a_project_details`
--

CREATE TABLE `tbl_a_project_details` (
  `id` int(32) NOT NULL,
  `text` text NOT NULL,
  `version` varchar(32) NOT NULL,
  `project_url` varchar(32) NOT NULL,
  `repository_link` varchar(255) NOT NULL,
  `documentation_file` varchar(255) NOT NULL,
  `user_manual` varchar(255) NOT NULL,
  `lang_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_a_project_languages`
--

CREATE TABLE `tbl_a_project_languages` (
  `id` int(32) NOT NULL,
  `name` int(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_a_project_photos`
--

CREATE TABLE `tbl_a_project_photos` (
  `id` int(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `path` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_a_project_teams`
--

CREATE TABLE `tbl_a_project_teams` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(16) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_a_project_teams`
--

INSERT INTO `tbl_a_project_teams` (`id`, `code`, `name`, `description`, `email`, `phone_number`, `is_active`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, '001', 'Authors', 'Menara BNI jalan pejompongan lantai 14', 'authors@bni.co.id', '02123232345', 1, 3, '2022-06-29 07:26:59', 2, '2022-07-20 08:30:44'),
(2, '002', 'ISU-ISB', '-', 'isu-isb@bni.co.id', '021321321321', 1, 3, '2022-06-29 07:54:30', 3, '2022-06-29 07:54:30'),
(3, '003', 'Developer Apps', '', 'dev-apps@bni.co.id', '02132183', 1, 3, '2022-06-29 08:21:47', 3, '2022-06-29 08:21:47'),
(4, '004', 'Developer Web', '', 'dev-web@bni.co.id', '02132123', 1, 3, '2022-06-29 08:22:05', 3, '2022-06-29 08:22:05'),
(5, '005', 'Developer Desktop', '', 'dev-desk@bni.co.id', '0213273212', 1, 3, '2022-06-29 08:23:09', 3, '2022-06-29 08:23:09'),
(6, '006', 'Pentester', '', 'pentest@gmoal.com', '085231732136', 1, 3, '2022-06-29 08:23:36', 3, '2022-06-29 08:23:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_a_project_team_users`
--

CREATE TABLE `tbl_a_project_team_users` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(155) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `phone_number` varchar(16) NOT NULL,
  `team_id` int(32) NOT NULL,
  `is_logged_in` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_a_project_types`
--

CREATE TABLE `tbl_a_project_types` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_a_project_types`
--

INSERT INTO `tbl_a_project_types` (`id`, `name`, `description`, `is_active`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 'website', '-', 1, 1, '2022-06-20 05:31:11', 2, '2022-07-20 01:10:04'),
(2, 'restapi', '-', 1, 1, '2022-06-20 05:31:11', 1, '2022-06-20 05:31:11'),
(3, 'apps - android', '-', 1, 1, '2022-06-20 05:31:11', 2, '2022-07-19 09:45:12'),
(4, 'apps - ios', '-', 1, 1, '2022-06-20 05:31:11', 1, '2022-06-20 05:31:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_b_pentest_request`
--

CREATE TABLE `tbl_b_pentest_request` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `request_by` int(32) NOT NULL,
  `handle_by` int(32) NOT NULL,
  `authorize_by` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_b_pentest_results`
--

CREATE TABLE `tbl_b_pentest_results` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `critical_issue_total` int(12) NOT NULL,
  `critical_issue_summary` text NOT NULL,
  `high_issue_total` int(12) NOT NULL,
  `high_issue_summary` text NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_b_pentest_timelines`
--

CREATE TABLE `tbl_b_pentest_timelines` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `dayname` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` int(5) NOT NULL,
  `critical_issue_total` varchar(6) NOT NULL,
  `critical_issue_summary` text NOT NULL,
  `critical_issue_notes` mediumtext NOT NULL,
  `high_issue_total` varchar(6) NOT NULL,
  `high_issue_summary` text NOT NULL,
  `high_issue_notes` mediumtext NOT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_b_pentest_vendors`
--

CREATE TABLE `tbl_b_pentest_vendors` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `phone_number` varchar(16) NOT NULL,
  `fax_number` varchar(16) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_b_pentest_vendor_users`
--

CREATE TABLE `tbl_b_pentest_vendor_users` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `mobile_phone` int(16) NOT NULL,
  `address` text NOT NULL,
  `photos` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_c_source_code_assessments`
--

CREATE TABLE `tbl_c_source_code_assessments` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `project_summary` text NOT NULL,
  `critical_issue_total` int(12) NOT NULL,
  `critical_issue_summary` text NOT NULL,
  `high_issue_total` int(12) NOT NULL,
  `high_issue_summary` text NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_d_project_assessments`
--

CREATE TABLE `tbl_d_project_assessments` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `consequence_to_server` mediumtext NOT NULL,
  `consequence_to_website` mediumtext NOT NULL,
  `consequence_to_brand` mediumtext NOT NULL,
  `project_id` int(32) NOT NULL,
  `source_code_assessment_id` int(32) NOT NULL,
  `pentest_request_id` int(32) NOT NULL,
  `pentest_result_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_d_project_memo`
--

CREATE TABLE `tbl_d_project_memo` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `memo_to` varchar(255) NOT NULL,
  `memo_from` tinytext NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `attachment` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(32) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_a_projects`
--
ALTER TABLE `tbl_a_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_a_project_details`
--
ALTER TABLE `tbl_a_project_details`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_a_project_languages`
--
ALTER TABLE `tbl_a_project_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_a_project_photos`
--
ALTER TABLE `tbl_a_project_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_a_project_teams`
--
ALTER TABLE `tbl_a_project_teams`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_a_project_team_users`
--
ALTER TABLE `tbl_a_project_team_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_a_project_types`
--
ALTER TABLE `tbl_a_project_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_b_pentest_request`
--
ALTER TABLE `tbl_b_pentest_request`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_b_pentest_results`
--
ALTER TABLE `tbl_b_pentest_results`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_b_pentest_timelines`
--
ALTER TABLE `tbl_b_pentest_timelines`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_b_pentest_vendors`
--
ALTER TABLE `tbl_b_pentest_vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_b_pentest_vendor_users`
--
ALTER TABLE `tbl_b_pentest_vendor_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_c_source_code_assessments`
--
ALTER TABLE `tbl_c_source_code_assessments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_d_project_assessments`
--
ALTER TABLE `tbl_d_project_assessments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_d_project_memo`
--
ALTER TABLE `tbl_d_project_memo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_a_projects`
--
ALTER TABLE `tbl_a_projects`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_a_project_details`
--
ALTER TABLE `tbl_a_project_details`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_a_project_languages`
--
ALTER TABLE `tbl_a_project_languages`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_a_project_photos`
--
ALTER TABLE `tbl_a_project_photos`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_a_project_teams`
--
ALTER TABLE `tbl_a_project_teams`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_a_project_team_users`
--
ALTER TABLE `tbl_a_project_team_users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_a_project_types`
--
ALTER TABLE `tbl_a_project_types`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_b_pentest_request`
--
ALTER TABLE `tbl_b_pentest_request`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_b_pentest_results`
--
ALTER TABLE `tbl_b_pentest_results`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_b_pentest_timelines`
--
ALTER TABLE `tbl_b_pentest_timelines`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_b_pentest_vendors`
--
ALTER TABLE `tbl_b_pentest_vendors`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_b_pentest_vendor_users`
--
ALTER TABLE `tbl_b_pentest_vendor_users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_c_source_code_assessments`
--
ALTER TABLE `tbl_c_source_code_assessments`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_d_project_assessments`
--
ALTER TABLE `tbl_d_project_assessments`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_d_project_memo`
--
ALTER TABLE `tbl_d_project_memo`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;
COMMIT;
