<?= $this->extend('layout/sidebaradmin') ?>

<?= $this->section('content') ?>

<style>
    /* ===== MAIN CONTENT ===== */
    .page-wrapper {
        padding: 32px 36px;
        min-height: 100vh;
        background-color: #f0f4f8;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* ===== HEADER ROW ===== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }

    .btn-create {
        background-color: #2c6fad;
        color: #ffffff;
        padding: 10px 28px;
        border: none;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.2s ease, box-shadow 0.2s ease;
        display: inline-block;
    }

    .btn-create:hover {
        background-color: #1e5a96;
        box-shadow: 0 4px 12px rgba(44, 111, 173, 0.4);
        text-decoration: none;
        color: #ffffff;
    }

    /* ===== SEARCH BOX ===== */
    .search-container {
        background-color: #3b82c4;
        border-radius: 12px;
        padding: 20px 24px;
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 24px;
    }

    .search-container input[type="text"] {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #666;
        outline: none;
        background: #ffffff;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.08);
        font-style: italic;
    }

    .search-container input[type="text"]::placeholder {
        color: #aaa;
    }

    .btn-search {
        background-color: #ffffff;
        color: #1a1a2e;
        padding: 12px 28px;
        border: none;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.2s ease, box-shadow 0.2s ease;
        white-space: nowrap;
        text-decoration: none;
        display: inline-block;
    }

    .btn-search:hover {
        background-color: #e8f0fe;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        color: #1a1a2e;
    }

    .btn-reset {
        background-color: #e05c6a;
        color: #ffffff;
        padding: 12px 22px;
        border: none;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.2s ease;
        white-space: nowrap;
        text-decoration: none;
        display: inline-block;
    }

    .btn-reset:hover {
        background-color: #c94d5a;
        color: #ffffff;
        text-decoration: none;
    }

    /* ===== TABLE ===== */
    .table-wrapper {
        background-color: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
    }

    .user-table thead tr {
        background-color: #3b82c4;
        color: #ffffff;
    }

    .user-table thead th {
        padding: 14px 20px;
        text-align: left;
        font-size: 0.9rem;
        font-weight: 600;
        letter-spacing: 0.03em;
    }

    .user-table thead th:last-child {
        text-align: center;
    }

    .user-table tbody tr:nth-child(odd) {
        background-color: #e8e8e8;
    }

    .user-table tbody tr:nth-child(even) {
        background-color: #f5f5f5;
    }

    .user-table tbody tr:hover {
        background-color: #dce8f8;
        transition: background-color 0.15s ease;
    }

    .user-table tbody td {
        padding: 13px 20px;
        font-size: 0.9rem;
        color: #2d2d2d;
    }

    /* ===== ACTION BUTTONS ===== */
    .action-cell {
        display: flex;
        gap: 8px;
        align-items: center;
        justify-content: center;
    }

    .btn-edit,
    .btn-delete {
        padding: 7px 18px;
        border: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: opacity 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-edit {
        background-color: #4caf7d;
        color: #ffffff;
    }

    .btn-edit:hover {
        opacity: 0.88;
        box-shadow: 0 2px 8px rgba(76, 175, 125, 0.45);
        text-decoration: none;
        color: #ffffff;
    }

    .btn-delete {
        background-color: #e05c6a;
        color: #ffffff;
    }

    .btn-delete:hover {
        opacity: 0.88;
        box-shadow: 0 2px 8px rgba(224, 92, 106, 0.45);
        text-decoration: none;
        color: #ffffff;
    }
    /* ===== STATUS BADGE ===== */
    .badge-aktif {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-nonaktif {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 600;
        display: inline-block;
    }
</style>

<div class="page-wrapper">

    <!-- Header -->
    <div class="page-header">
        <h1>Kelola User</h1>
        <a href="/admin/user/create" class="btn-create">Create</a>
    </div>

    <!-- Search -->
    <form method="get" action="/admin/user" class="search-container">
        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari username / nama / role...">
        <button type="submit" class="btn-search">Search</button>
        <a href="/admin/user" class="btn-reset">Reset</a>
    </form>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="user-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $i => $u): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($u['username']) ?></td>
                    <td><?= esc($u['nama']) ?></td>
                    <td><?= esc($u['role']) ?></td>
                    <td><?= esc($u['status_user']) == 'aktif'
                        ? '<span class="badge-aktif">Aktif</span>'
                        : '<span class="badge-nonaktif">Nonaktif</span>' ?></td>
                    <td>
                        <div class="action-cell">
                            <a href="/admin/user/edit/<?= $u['id_user'] ?>" class="btn-edit">Edit</a>
                            <a href="/admin/user/delete/<?= $u['id_user'] ?>" class="btn-delete"
                               onclick="return confirm('Yakin ingin menghapus user ini?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>