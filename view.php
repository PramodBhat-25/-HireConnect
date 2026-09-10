<?php
require_once "dp.php";

$sql = "SELECT id, name, number, email, resume FROM student";
$result = mysqli_query($conn, $sql);
$total_students = $result ? mysqli_num_rows($result) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidates Directory</title>
    <!-- Modern Typography & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --primary-light: #eef2ff;
            --surface: #ffffff;
            --background: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius-lg: 16px;
            --radius-md: 10px;
            --radius-sm: 6px;
            --shadow-subtle: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-card: 0 20px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.03);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--background);
            color: var(--text-main);
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 1100px;
        }

        /* Top Action Bar */
        .header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .title-group h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .count-badge {
            font-size: 0.8rem;
            background: var(--primary-light);
            color: var(--primary);
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Search input */
        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .search-box input {
            padding: 10px 14px 10px 38px;
            border: 1px solid var(--border);
            background: var(--surface);
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            font-family: inherit;
            outline: none;
            transition: all 0.2s;
            width: 220px;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            width: 260px;
        }

        /* Add Button */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: #ffffff;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 10px 18px;
            border-radius: var(--radius-md);
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(99, 102, 241, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        /* Table Card Container */
        .table-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        thead {
            background-color: #fafbfc;
            border-bottom: 1px solid var(--border);
        }

        th {
            padding: 14px 20px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            color: var(--text-muted);
        }

        td {
            padding: 16px 20px;
            font-size: 0.9rem;
            color: var(--text-main);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tbody tr {
            transition: background 0.15s ease-in-out;
        }

        tbody tr:hover {
            background-color: #fcfdfe;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Name + Avatar layout */
        .student-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .student-name {
            font-weight: 600;
            color: var(--text-main);
        }

        /* Interactive Links */
        .link-text {
            color: var(--text-muted);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.15s;
        }

        .link-text:hover {
            color: var(--primary);
        }

        /* Resume Pill Button */
        .resume-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background-color: #fee2e2;
            color: #dc2626;
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .resume-btn:hover {
            background-color: #fecaca;
            transform: scale(1.02);
        }

        /* Empty State */
        .empty-row {
            text-align: center;
            padding: 48px 20px;
            color: var(--text-muted);
        }

        .empty-row i {
            font-size: 2.2rem;
            margin-bottom: 10px;
            color: #cbd5e1;
            display: block;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Action Bar -->
    <div class="header-bar">
        <div class="title-group">
            <h1>Candidates Records</h1>
            <span class="count-badge"><?php echo $total_students; ?> Candidates</span>
        </div>

        <div class="header-actions">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Filter by name, email..." onkeyup="filterTable()">
            </div>
            <a href="Employe.html" class="btn-primary">
                <i class="fa-solid fa-plus"></i> Add Candidate
            </a>
        </div>
    </div>

    <!-- Data Card -->
    <div class="table-card">
        <div class="table-responsive">
            <table id="studentTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>CANDIDATE</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Resume</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($total_students > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $name = htmlspecialchars($row['name']);
                            $initial = strtoupper(mb_substr($name, 0, 1));
                            $phone = htmlspecialchars($row['number']);
                            $email = htmlspecialchars($row['email']);
                            $resume = htmlspecialchars($row['resume']);
                    ?>
                        <tr>
                            <td style="color: var(--text-muted); font-weight: 500;">#<?php echo htmlspecialchars($row['id']); ?></td>
                            <td>
                                <div class="student-cell">
                                    <div class="avatar"><?php echo $initial; ?></div>
                                    <span class="student-name"><?php echo $name; ?></span>
                                </div>
                            </td>
                            <td>
                                <a href="tel:<?php echo $phone; ?>" class="link-text">
                                    <i class="fa-solid fa-phone" style="font-size: 0.75rem;"></i> <?php echo $phone; ?>
                                </a>
                            </td>
                            <td>
                                <a href="mailto:<?php echo $email; ?>" class="link-text">
                                    <i class="fa-solid fa-envelope" style="font-size: 0.75rem;"></i> <?php echo $email; ?>
                                </a>
                            </td>
                            <td>
                                <?php if (!empty($resume)): ?>
                                    <a href="<?php echo $resume; ?>" target="_blank" class="resume-btn">
                                        <i class="fa-regular fa-file-pdf"></i> View CV
                                    </a>
                                <?php else: ?>
                                    <span style="color: var(--text-muted); font-size: 0.85rem;">No file</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="5" class="empty-row">
                                <i class="fa-regular fa-folder-open"></i>
                                No records found.
                            </td>
                        </tr>
                    <?php
                    }
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Instant Filter Script -->
<script>
function filterTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    const table = document.getElementById("studentTable");
    const tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        const rowText = tr[i].textContent.toLowerCase();
        tr[i].style.display = rowText.includes(filter) ? "" : "none";
    }
}
</script>

</body>
</html>