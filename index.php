<?php
session_start();

// --- CONFIGURATION ---
$MOT_DE_PASSE = "voilavoila";

// LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// LOGIN CHECK
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === $MOT_DE_PASSE) {
        $_SESSION['logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Mot de passe incorrect";
    }
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — voilà voilà</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg: #faf8f5;
            --surface: #ffffff;
            --text: #1a1a1a;
            --text-muted: #8a8580;
            --accent: #c8956c;
            --accent-hover: #b37e58;
            --border: #e8e4df;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        .login-card {
            position: relative;
            z-index: 1;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 56px 48px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 8px 32px rgba(0,0,0,0.06);
            animation: cardIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(12px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .brand {
            font-family: 'Instrument Serif', serif;
            font-size: 2.25rem;
            color: var(--text);
            letter-spacing: -0.02em;
            font-style: italic;
            margin-bottom: 4px;
        }

        .brand-sub {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 40px;
        }

        .login-input {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 0.9rem;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: var(--bg);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            margin-bottom: 16px;
        }

        .login-input::placeholder { color: var(--text-muted); }
        .login-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(200, 149, 108, 0.12);
        }

        .login-btn {
            width: 100%;
            background: var(--text);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            letter-spacing: 0.02em;
        }

        .login-btn:hover { background: #333; }
        .login-btn:active { transform: scale(0.985); }

        .login-error {
            color: #c44;
            font-size: 0.8rem;
            margin-bottom: 12px;
            font-weight: 500;
        }

        .login-deco {
            position: fixed;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(200,149,108,0.08), transparent 70%);
            pointer-events: none;
        }
        .login-deco-1 { top: -80px; right: -60px; }
        .login-deco-2 { bottom: -100px; left: -80px; width: 400px; height: 400px; }
    </style>
</head>
<body>
    <div class="login-deco login-deco-1"></div>
    <div class="login-deco login-deco-2"></div>
    <div class="login-card">
        <div class="brand">voilà voilà</div>
        <div class="brand-sub">Signature Manager</div>
        <form method="POST">
            <input type="password" name="password" placeholder="Mot de passe" class="login-input" autofocus>
            <?php if($error): ?>
                <p class="login-error"><?php echo $error; ?></p>
            <?php endif; ?>
            <button type="submit" class="login-btn">Se connecter</button>
        </form>
    </div>
</body>
</html>
<?php exit; } ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>voilà voilà — Signature Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Instrument+Serif:ital@0;1&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg: #faf8f5;
            --surface: #ffffff;
            --surface-raised: #ffffff;
            --sidebar-bg: #1a1a1a;
            --sidebar-text: #b0aca7;
            --sidebar-text-bright: #f0ece8;
            --sidebar-hover: #252525;
            --sidebar-active: #2a2724;
            --text: #1a1a1a;
            --text-secondary: #6b6560;
            --text-muted: #9e9890;
            --accent: #c8956c;
            --accent-hover: #b37e58;
            --accent-light: rgba(200, 149, 108, 0.08);
            --accent-border: rgba(200, 149, 108, 0.25);
            --border: #e8e4df;
            --border-light: #f0ece8;
            --input-bg: #faf8f5;
            --danger: #c44040;
            --danger-bg: rgba(196, 64, 64, 0.06);
            --success: #3a8a5c;
            --radius: 10px;
            --radius-lg: 14px;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 2px 8px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-lg: 0 4px 24px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.04);
            --transition: 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            height: 100vh;
            overflow: hidden;
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
        }

        /* Noise texture overlay */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.025'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
        }

        /* ========== SCROLLBAR ========== */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d0cbc5; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #b0aca7; }

        /* ========== SIDEBAR ========== */
        .sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: relative;
            z-index: 40;
            animation: sidebarIn 0.5s var(--transition) both;
        }

        @keyframes sidebarIn {
            from { opacity: 0; transform: translateX(-16px); }
        }

        .sidebar-brand {
            padding: 28px 24px 24px;
        }

        .sidebar-brand h1 {
            font-family: 'Instrument Serif', serif;
            font-style: italic;
            font-size: 1.6rem;
            color: var(--sidebar-text-bright);
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .sidebar-brand span {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            color: var(--sidebar-text);
            display: block;
            margin-top: 6px;
            font-weight: 500;
        }

        .sidebar-new-btn {
            margin: 0 16px 20px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 11px 16px;
            font-size: 0.8rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: background var(--transition), transform 0.1s;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-new-btn:hover { background: var(--accent-hover); }
        .sidebar-new-btn:active { transform: scale(0.98); }

        .sidebar-new-btn svg { width: 14px; height: 14px; stroke-width: 2.5; }

        .sidebar-section-label {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: #5a5550;
            padding: 0 24px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .sidebar-list {
            flex: 1;
            overflow-y: auto;
            padding: 0 12px;
        }

        .sidebar-list::-webkit-scrollbar-thumb { background: #333; }

        .sidebar-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: background var(--transition);
            margin-bottom: 2px;
            group: true;
        }

        .sidebar-item:hover { background: var(--sidebar-hover); }
        .sidebar-item.active { background: var(--sidebar-active); }

        .sidebar-item-info { flex: 1; min-width: 0; }

        .sidebar-item-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--sidebar-text-bright);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-item-meta {
            font-size: 0.7rem;
            color: var(--sidebar-text);
            margin-top: 1px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-item-delete {
            opacity: 0;
            color: #666;
            font-size: 0.75rem;
            padding: 4px 6px;
            border-radius: 4px;
            transition: all var(--transition);
            cursor: pointer;
            flex-shrink: 0;
            margin-left: 8px;
            border: none;
            background: none;
            font-family: 'DM Sans', sans-serif;
        }

        .sidebar-item:hover .sidebar-item-delete { opacity: 1; }
        .sidebar-item-delete:hover { color: var(--danger); background: rgba(196, 64, 64, 0.15); }

        .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid #2a2a2a;
        }

        .sidebar-logout {
            color: #5a5550;
            font-size: 0.75rem;
            text-decoration: none;
            font-weight: 500;
            transition: color var(--transition);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sidebar-logout:hover { color: var(--danger); }

        /* ========== MAIN FORM AREA ========== */
        .main-area {
            flex: 1;
            overflow-y: auto;
            position: relative;
        }

        .main-inner {
            max-width: 540px;
            margin: 0 auto;
            padding: 0 32px 80px;
        }

        /* Sticky header */
        .top-bar {
            position: sticky;
            top: 0;
            z-index: 30;
            background: var(--bg);
            padding: 24px 32px 16px;
        }

        .top-bar::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border);
        }

        .top-bar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .top-bar-left h2 {
            font-family: 'Instrument Serif', serif;
            font-size: 1.3rem;
            font-weight: 400;
            color: var(--text);
            letter-spacing: -0.01em;
        }

        .top-bar-status {
            font-size: 0.72rem;
            color: var(--text-muted);
            margin-top: 2px;
            font-weight: 500;
        }

        .save-btn {
            background: var(--text);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 9px 20px;
            font-size: 0.8rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: background var(--transition), transform 0.1s;
            display: flex;
            align-items: center;
            gap: 7px;
            letter-spacing: 0.02em;
        }

        .save-btn:hover { background: #333; }
        .save-btn:active { transform: scale(0.97); }
        .save-btn svg { width: 15px; height: 15px; }

        /* ========== FORM SECTIONS ========== */
        .form-section {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            margin-bottom: 12px;
            overflow: hidden;
            transition: box-shadow var(--transition);
            animation: sectionIn 0.4s var(--transition) both;
        }

        .form-section:hover { box-shadow: var(--shadow-sm); }

        @keyframes sectionIn {
            from { opacity: 0; transform: translateY(8px); }
        }

        .form-section:nth-child(1) { animation-delay: 0.05s; }
        .form-section:nth-child(2) { animation-delay: 0.1s; }
        .form-section:nth-child(3) { animation-delay: 0.15s; }
        .form-section:nth-child(4) { animation-delay: 0.2s; }
        .form-section:nth-child(5) { animation-delay: 0.25s; }
        .form-section:nth-child(6) { animation-delay: 0.3s; }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            cursor: pointer;
            user-select: none;
            transition: background var(--transition);
        }

        .section-header:hover { background: var(--accent-light); }

        .section-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .section-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text);
            letter-spacing: 0.01em;
        }

        .section-chevron {
            width: 18px;
            height: 18px;
            color: var(--text-muted);
            transition: transform 0.3s var(--transition);
            flex-shrink: 0;
        }

        .section-chevron.collapsed { transform: rotate(-90deg); }

        .section-body {
            padding: 0 20px 20px;
            overflow: hidden;
            transition: max-height 0.35s var(--transition), opacity 0.25s, padding 0.35s;
            max-height: 600px;
            opacity: 1;
        }

        .section-body.collapsed {
            max-height: 0;
            opacity: 0;
            padding-top: 0;
            padding-bottom: 0;
        }

        /* ========== FORM ELEMENTS ========== */
        .field-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .field-full { grid-column: 1 / -1; }

        .field label {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }

        .field input[type="text"],
        .field input[type="email"],
        .field input[type="number"],
        .field input[type="url"],
        .field textarea,
        .field select {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 0.85rem;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: var(--input-bg);
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        .field input:focus,
        .field textarea:focus,
        .field select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-light);
            background: #fff;
        }

        .field input::placeholder,
        .field textarea::placeholder {
            color: var(--text-muted);
        }

        .field .mono-input {
            font-family: 'DM Mono', monospace;
            font-size: 0.82rem;
            letter-spacing: 0.02em;
        }

        .field textarea {
            resize: vertical;
            min-height: 72px;
        }

        .field select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239e9890' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        /* Range slider */
        .range-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .range-value {
            font-family: 'DM Mono', monospace;
            font-size: 0.72rem;
            font-weight: 500;
            color: var(--accent);
            background: var(--accent-light);
            padding: 2px 8px;
            border-radius: 4px;
        }

        input[type=range] {
            -webkit-appearance: none;
            width: 100%;
            height: 4px;
            background: var(--border);
            border-radius: 2px;
            outline: none;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--accent);
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 1px 4px rgba(0,0,0,0.15);
        }

        input[type=range]::-webkit-slider-thumb:hover {
            transform: scale(1.15);
            box-shadow: 0 2px 8px rgba(200, 149, 108, 0.4);
        }

        /* Color picker */
        .color-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .color-swatch {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 2px solid var(--border);
            cursor: pointer;
            padding: 0;
            overflow: hidden;
            flex-shrink: 0;
        }

        .color-swatch input[type="color"] {
            width: 56px;
            height: 56px;
            border: none;
            padding: 0;
            cursor: pointer;
            transform: translate(-8px, -8px);
        }

        /* Toggle */
        .toggle-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-top: 14px;
            border-top: 1px solid var(--border-light);
            margin-top: 4px;
        }

        .toggle {
            position: relative;
            width: 36px;
            height: 20px;
            flex-shrink: 0;
        }

        .toggle input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .toggle-track {
            position: absolute;
            inset: 0;
            background: var(--border);
            border-radius: 10px;
            cursor: pointer;
            transition: background var(--transition);
        }

        .toggle-track::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            background: #fff;
            border-radius: 50%;
            transition: transform var(--transition);
            box-shadow: 0 1px 3px rgba(0,0,0,0.15);
        }

        .toggle input:checked + .toggle-track {
            background: var(--accent);
        }

        .toggle input:checked + .toggle-track::after {
            transform: translateX(16px);
        }

        .toggle-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Logo upload */
        .upload-zone {
            border: 1.5px dashed var(--border);
            border-radius: var(--radius);
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color var(--transition), background var(--transition);
            background: var(--input-bg);
        }

        .upload-zone:hover {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .upload-zone label {
            cursor: pointer;
            text-transform: none;
            letter-spacing: normal;
            font-size: 0.82rem;
            color: var(--accent);
            font-weight: 600;
        }

        .upload-zone .upload-hint {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 4px;
            font-weight: 400;
        }

        .upload-status {
            font-size: 0.78rem;
            font-weight: 600;
            margin-top: 8px;
            min-height: 20px;
        }

        /* Google review field */
        .review-field {
            padding-top: 14px;
            border-top: 1px solid var(--border-light);
            margin-top: 4px;
        }

        .review-field label {
            color: var(--accent) !important;
        }

        .review-field .field-hint {
            font-size: 0.68rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Links */
        .links-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .links-add-btn {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--accent);
            background: var(--accent-light);
            border: 1px solid var(--accent-border);
            border-radius: 6px;
            padding: 5px 12px;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: all var(--transition);
        }

        .links-add-btn:hover {
            background: var(--accent);
            color: #fff;
        }

        .link-item {
            display: grid;
            grid-template-columns: 1fr 2fr auto;
            gap: 8px;
            align-items: center;
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px 10px;
            margin-bottom: 6px;
            transition: border-color var(--transition);
        }

        .link-item:hover { border-color: var(--accent-border); }

        .link-item select,
        .link-item input {
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 7px 10px;
            font-size: 0.8rem;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: #fff;
            outline: none;
            transition: border-color var(--transition);
        }

        .link-item select:focus,
        .link-item input:focus {
            border-color: var(--accent);
        }

        .link-item select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%239e9890' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
            padding-right: 26px;
        }

        .link-delete {
            width: 28px;
            height: 28px;
            border: none;
            background: none;
            color: var(--text-muted);
            cursor: pointer;
            border-radius: 6px;
            font-size: 1rem;
            transition: all var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .link-delete:hover {
            color: var(--danger);
            background: var(--danger-bg);
        }

        .links-empty {
            text-align: center;
            padding: 16px;
            color: var(--text-muted);
            font-size: 0.8rem;
            font-style: italic;
        }

        /* ========== PREVIEW PANEL ========== */
        .preview-panel {
            width: 560px;
            background: #edebe8;
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            animation: previewIn 0.5s var(--transition) 0.15s both;
        }

        @keyframes previewIn {
            from { opacity: 0; transform: translateX(16px); }
        }

        .preview-toolbar {
            padding: 14px 20px;
            border-bottom: 1px solid #ddd8d3;
            background: #e5e2de;
        }

        .preview-toolbar h3 {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: var(--text-muted);
            font-weight: 600;
            text-align: center;
        }

        .preview-body {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
        }

        /* Email simulation window */
        .email-window {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(0,0,0,0.08);
        }

        .email-titlebar {
            background: linear-gradient(180deg, #f8f7f6, #efeeed);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 7px;
            border-bottom: 1px solid #ddd;
        }

        .email-dot {
            width: 11px;
            height: 11px;
            border-radius: 50%;
        }

        .email-dot-close { background: #ff5f57; border: 1px solid #e14640; }
        .email-dot-min { background: #ffbd2e; border: 1px solid #dfa123; }
        .email-dot-max { background: #28c940; border: 1px solid #1dad2b; }

        .email-meta {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-light);
        }

        .email-meta-label {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--text-muted);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .email-meta-row {
            font-size: 0.82rem;
            color: var(--text-secondary);
            margin-bottom: 3px;
        }

        .email-meta-row strong {
            color: var(--text);
            font-weight: 600;
        }

        .email-content {
            padding: 28px 24px;
        }

        .email-content p {
            font-size: 0.85rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 12px;
            font-family: 'DM Sans', sans-serif;
        }

        .email-content p:last-of-type { margin-bottom: 28px; }

        #preview-output { width: 100%; }

        /* Copy button */
        .copy-bar {
            padding: 16px 24px;
            background: #fff;
            border-top: 1px solid var(--border);
        }

        .copy-btn {
            width: 100%;
            background: var(--text);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-size: 0.85rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: background var(--transition), transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            letter-spacing: 0.02em;
        }

        .copy-btn:hover { background: #333; }
        .copy-btn:active { transform: scale(0.98); }

        .copy-btn.copied {
            background: var(--success);
        }

        .copy-btn svg { width: 16px; height: 16px; }

        .copy-compat {
            font-size: 0.68rem;
            color: var(--text-muted);
            text-align: center;
            margin-top: 8px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1200px) {
            .preview-panel { width: 480px; }
        }

        @media (max-width: 1024px) {
            .sidebar { display: none; }
            .preview-panel { display: none; }
        }

        /* ========== TOAST ========== */
        .toast {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: var(--text);
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 600;
            z-index: 10000;
            opacity: 0;
            transition: all 0.3s var(--transition);
            pointer-events: none;
            box-shadow: 0 4px 16px rgba(0,0,0,0.2);
            font-family: 'DM Sans', sans-serif;
        }

        .toast.visible {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .toast.success { background: var(--success); }
    </style>
</head>
<body>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h1>voilà voilà</h1>
            <span>Signature Manager</span>
        </div>

        <button onclick="createNewProject()" class="sidebar-new-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouveau projet
        </button>

        <div class="sidebar-section-label">Projets</div>

        <nav id="project-list" class="sidebar-list">
            <div style="color:#5a5550; font-size:0.8rem; padding:8px 12px; font-style:italic;">Chargement...</div>
        </nav>

        <div class="sidebar-footer">
            <a href="?logout=true" class="sidebar-logout">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Déconnexion
            </a>
        </div>
    </aside>

    <!-- ===== MAIN FORM ===== -->
    <main class="main-area">
        <div class="top-bar">
            <div class="top-bar-inner">
                <div class="top-bar-left">
                    <h2>Projet en cours</h2>
                    <div id="status-msg" class="top-bar-status">Modifications non enregistrées</div>
                </div>
                <button onclick="saveProject()" class="save-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Sauvegarder
                </button>
            </div>
        </div>

        <div class="main-inner" style="margin-top: 16px;">

            <!-- SECTION: Project Config -->
            <div class="form-section">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon" style="background: #f0ece8; color: var(--text-secondary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6m11-7h-6m-6 0H1m17.36-5.64l-4.24 4.24M10.88 13.12L6.64 17.36m0-10.72l4.24 4.24m2.24 2.24l4.24 4.24"/></svg>
                        </div>
                        <span class="section-title">Configuration</span>
                    </div>
                    <svg class="section-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="section-body">
                    <div class="field field-full">
                        <label>ID unique (slug)</label>
                        <input type="text" id="slug" placeholder="ex: nicolas-gallet" class="mono-input" oninput="sanitizeSlug(this)">
                    </div>
                </div>
            </div>

            <!-- SECTION: Style -->
            <div class="form-section">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon" style="background: rgba(200,149,108,0.1); color: var(--accent);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <span class="section-title">Style & Apparence</span>
                    </div>
                    <svg class="section-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="section-body">
                    <div class="field-grid">
                        <div class="field field-full">
                            <label>Template</label>
                            <select id="styleTemplate" onchange="updateSignature()">
                                <option value="classic">Classique — Barre latérale</option>
                                <option value="horizontal">Horizontal — Épuré</option>
                                <option value="header">Vertical — Logo au-dessus</option>
                            </select>
                        </div>

                        <div class="field field-full">
                            <div class="range-header">
                                <label style="margin-bottom:0">Taille du logo</label>
                                <span id="logoWidthDisplay" class="range-value">100px</span>
                            </div>
                            <input type="range" id="logoWidth" min="50" max="350" value="100" oninput="updateSignature()">
                        </div>

                        <div class="field">
                            <label>Couleur principale</label>
                            <div class="color-row">
                                <div class="color-swatch">
                                    <input type="color" id="primaryColor" value="#000000" oninput="updateSignature()">
                                </div>
                                <input type="text" id="primaryColorText" value="#000000" class="mono-input" oninput="document.getElementById('primaryColor').value = this.value; updateSignature()">
                            </div>
                        </div>

                        <div class="field">
                            <label>Taille police (px)</label>
                            <input type="number" id="fontSize" value="14" min="10" max="20" oninput="updateSignature()">
                        </div>
                    </div>

                    <div class="toggle-row">
                        <label class="toggle">
                            <input type="checkbox" id="showBorder" onchange="updateSignature()">
                            <span class="toggle-track"></span>
                        </label>
                        <span class="toggle-label">Afficher le cadre autour de la signature</span>
                    </div>
                </div>
            </div>

            <!-- SECTION: Identity -->
            <div class="form-section">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon" style="background: #eef0f4; color: #5a6577;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <span class="section-title">Identité</span>
                    </div>
                    <svg class="section-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="section-body">
                    <div class="field-grid">
                        <div class="field">
                            <label>Prénom & Nom</label>
                            <input type="text" id="name" placeholder="Jean Dupont" oninput="updateSignature()">
                        </div>
                        <div class="field">
                            <label>Poste / Fonction</label>
                            <input type="text" id="job" placeholder="Chef de projet" oninput="updateSignature()">
                        </div>
                        <div class="field field-full">
                            <label>Texte libre / Slogan</label>
                            <textarea id="tagline" rows="3" placeholder="Service Comptabilité&#10;il/lui" oninput="updateSignature()"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION: Contact -->
            <div class="form-section">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon" style="background: #edf5f0; color: #3a8a5c;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <span class="section-title">Coordonnées</span>
                    </div>
                    <svg class="section-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="section-body">
                    <div class="field-grid">
                        <div class="field">
                            <label>Email</label>
                            <input type="email" id="email" placeholder="jean@example.com" oninput="updateSignature()">
                        </div>
                        <div class="field">
                            <label>Téléphone</label>
                            <input type="text" id="phone" placeholder="+33 6 00 00 00 00" oninput="updateSignature()">
                        </div>
                        <div class="field field-full">
                            <label>Adresse postale</label>
                            <input type="text" id="address" placeholder="12 Rue de la Paix, 75000 Paris" oninput="updateSignature()">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION: Company & Logo -->
            <div class="form-section">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon" style="background: #f3eef8; color: #7c5caa;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        </div>
                        <span class="section-title">Entreprise & Logo</span>
                    </div>
                    <svg class="section-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="section-body">
                    <div class="field-grid" style="margin-bottom:14px;">
                        <div class="field">
                            <label>Nom de l'entreprise</label>
                            <input type="text" id="company" placeholder="Voila Voila" oninput="updateSignature()">
                        </div>
                        <div class="field">
                            <label>Site Web</label>
                            <input type="text" id="website" placeholder="www.voilavoila.com" oninput="updateSignature()">
                        </div>
                    </div>

                    <div class="upload-zone" onclick="document.getElementById('logoInput').click()">
                        <label>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; margin-right:6px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Uploader un logo
                            <input type="file" id="logoInput" style="display:none" accept="image/*" onchange="uploadLogo()">
                        </label>
                        <div class="upload-hint">PNG, JPG, SVG ou WebP</div>
                        <input type="hidden" id="logoUrl">
                        <div id="logoPreview" class="upload-status"></div>
                    </div>

                    <div class="review-field" style="margin-top:14px;">
                        <div class="field">
                            <label>Lien avis Google</label>
                            <input type="text" id="googleReviewUrl" placeholder="https://g.page/r/..." oninput="updateSignature()">
                            <div class="field-hint">Laissez vide pour masquer le bouton d'avis.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION: Social -->
            <div class="form-section">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon" style="background: #eef3fa; color: #4a7cc9;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        </div>
                        <span class="section-title">Réseaux sociaux</span>
                    </div>
                    <svg class="section-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="section-body">
                    <div class="links-header">
                        <span style="font-size:0.75rem; color:var(--text-muted);">Liens avec icônes</span>
                        <button onclick="addCustomLink()" class="links-add-btn">+ Ajouter</button>
                    </div>
                    <div id="links-list"></div>
                </div>
            </div>

        </div>
    </main>

    <!-- ===== PREVIEW PANEL ===== -->
    <aside class="preview-panel">
        <div class="preview-toolbar">
            <h3>Aperçu — Simulation email</h3>
        </div>

        <div class="preview-body">
            <div class="email-window">
                <div class="email-titlebar">
                    <div class="email-dot email-dot-close"></div>
                    <div class="email-dot email-dot-min"></div>
                    <div class="email-dot email-dot-max"></div>
                </div>
                <div class="email-meta">
                    <div class="email-meta-label">Nouveau message</div>
                    <div class="email-meta-row"><strong>À :</strong> client@exemple.com</div>
                    <div class="email-meta-row"><strong>Objet :</strong> Proposition commerciale — Projet X</div>
                </div>
                <div class="email-content">
                    <p>Bonjour,</p>
                    <p>Voici la proposition finale comme convenu. N'hésitez pas à revenir vers moi si vous avez des questions.</p>
                    <p>Bien cordialement,</p>
                    <div id="preview-output"></div>
                </div>
            </div>
        </div>

        <div class="copy-bar">
            <button id="copy-btn" onclick="copyToClipboard()" class="copy-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                Copier la signature
            </button>
            <div class="copy-compat">Compatible Outlook, Gmail, Apple Mail</div>
        </div>
    </aside>

    <!-- Toast -->
    <div id="toast" class="toast"></div>

    <script>
        const ICONS = {
            linkedin: "https://img.icons8.com/ios-filled/50/ffffff/linkedin.png",
            instagram: "https://img.icons8.com/ios-filled/50/ffffff/instagram-new.png",
            facebook: "https://img.icons8.com/ios-filled/50/ffffff/facebook-f.png",
            web: "https://img.icons8.com/ios-filled/50/ffffff/internet.png",
            calendar: "https://img.icons8.com/ios-filled/50/ffffff/calendar.png",
            other: "https://img.icons8.com/ios-filled/50/ffffff/link.png",
            email: "https://cdn-icons-png.flaticon.com/512/542/542689.png",
            phone: "https://cdn-icons-png.flaticon.com/512/455/455705.png",
            address: "https://cdn-icons-png.flaticon.com/512/535/535239.png",
            web_black: "https://cdn-icons-png.flaticon.com/512/1006/1006771.png"
        };

        let customLinks = [];

        // ===== UTILS =====
        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function showToast(message, type = '') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = 'toast' + (type ? ' ' + type : '');
            requestAnimationFrame(() => { toast.classList.add('visible'); });
            setTimeout(() => { toast.classList.remove('visible'); }, 2500);
        }

        function toggleSection(header) {
            const body = header.nextElementSibling;
            const chevron = header.querySelector('.section-chevron');
            body.classList.toggle('collapsed');
            chevron.classList.toggle('collapsed');
        }

        // ===== PROJECT MANAGEMENT =====
        async function deleteProject(slug) {
            if (!confirm('Supprimer le projet "' + slug + '" ?')) return;
            try {
                const res = await fetch('api.php?action=delete&slug=' + encodeURIComponent(slug), { method: 'POST' });
                const result = await res.json();
                if (result.success) { fetchProjects(); createNewProject(); showToast('Projet supprimé'); }
                else { showToast('Erreur: ' + (result.error || 'Suppression impossible')); }
            } catch(e) { showToast('Erreur réseau'); }
        }

        async function fetchProjects() {
            const listEl = document.getElementById('project-list');
            listEl.innerHTML = '<div style="color:#5a5550; font-size:0.8rem; padding:8px 12px; font-style:italic;">Chargement...</div>';
            try {
                const res = await fetch('api.php?action=list');
                if(res.status === 403) { window.location.reload(); return; }
                const projects = await res.json();
                listEl.innerHTML = '';
                if(projects.length === 0) {
                    listEl.innerHTML = '<div style="color:#5a5550; font-size:0.8rem; padding:12px; text-align:center; font-style:italic;">Aucun projet</div>';
                    return;
                }
                projects.forEach(p => {
                    const div = document.createElement('div');
                    div.className = 'sidebar-item';
                    div.innerHTML = `
                        <div class="sidebar-item-info" onclick="loadProject('${p.slug}')">
                            <div class="sidebar-item-name">${escapeHtml(p.name) || 'Sans nom'}</div>
                            <div class="sidebar-item-meta">${escapeHtml(p.job) || p.slug}</div>
                        </div>
                        <button onclick="event.stopPropagation(); deleteProject('${p.slug}')" class="sidebar-item-delete" title="Supprimer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>`;
                    listEl.appendChild(div);
                });
            } catch (e) { listEl.innerHTML = '<div style="color:#c44; font-size:0.75rem; padding:12px;">Erreur serveur</div>'; }
        }

        async function saveProject() {
            const slug = document.getElementById('slug').value;
            if(!slug) { showToast('Ajoutez un ID Unique avant de sauvegarder.'); return; }
            const btn = document.querySelector('.save-btn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span style="opacity:0.7">Sauvegarde...</span>';
            const data = getFormData();
            data.customLinks = customLinks;
            data.slug = slug;
            try {
                const res = await fetch('api.php?action=save', { method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(data) });
                const result = await res.json();
                if(result.success) {
                    document.getElementById('status-msg').innerText = "Sauvegardé — " + new Date().toLocaleTimeString();
                    fetchProjects();
                    showToast('Projet sauvegardé', 'success');
                } else { showToast('Erreur: ' + result.error); }
            } catch(e) { showToast('Erreur connexion'); }
            btn.innerHTML = originalText;
        }

        async function loadProject(slug) {
            try {
                const res = await fetch(`api.php?action=load&slug=${slug}`);
                const data = await res.json();
                if(data.error) { showToast('Projet introuvable'); return; }
                document.getElementById('slug').value = slug;
                if(data.template) document.getElementById('styleTemplate').value = data.template;
                document.getElementById('name').value = data.name || '';
                document.getElementById('job').value = data.job || '';
                document.getElementById('tagline').value = data.tagline || '';
                document.getElementById('email').value = data.email || '';
                document.getElementById('phone').value = data.phone || '';
                document.getElementById('address').value = data.address || '';
                document.getElementById('company').value = data.company || '';
                document.getElementById('website').value = data.website || '';
                document.getElementById('logoUrl').value = data.logoUrl || '';
                document.getElementById('logoPreview').innerText = data.logoUrl ? "Logo chargé" : "";
                document.getElementById('logoPreview').style.color = data.logoUrl ? 'var(--success)' : '';
                document.getElementById('primaryColor').value = data.primaryColor || '#000000';
                document.getElementById('primaryColorText').value = data.primaryColor || '#000000';
                document.getElementById('fontSize').value = data.fontSize || 14;
                document.getElementById('logoWidth').value = data.logoWidth || 100;
                document.getElementById('googleReviewUrl').value = data.googleReviewUrl || '';
                document.getElementById('showBorder').checked = data.showBorder || false;
                customLinks = data.customLinks || [];
                renderLinkInputs(); updateSignature();
                document.getElementById('status-msg').innerText = "Projet chargé — " + slug;

                // Highlight active item
                document.querySelectorAll('.sidebar-item').forEach(el => el.classList.remove('active'));
                event && event.target && event.target.closest('.sidebar-item')?.classList.add('active');
            } catch(e) {}
        }

        async function uploadLogo() {
            const slug = document.getElementById('slug').value;
            if(!slug) { showToast("Définissez d'abord un ID Unique."); return; }
            const fileInput = document.getElementById('logoInput');
            if(!fileInput.files[0]) return;
            const formData = new FormData();
            formData.append('logo_file', fileInput.files[0]);
            formData.append('slug', slug);
            document.getElementById('logoPreview').innerText = "Upload en cours...";
            document.getElementById('logoPreview').style.color = 'var(--accent)';
            try {
                const res = await fetch('api.php?action=upload_logo', { method: 'POST', body: formData });
                const result = await res.json();
                if(result.url) {
                    document.getElementById('logoUrl').value = result.url;
                    document.getElementById('logoPreview').innerText = "Logo chargé";
                    document.getElementById('logoPreview').style.color = 'var(--success)';
                    updateSignature();
                    showToast('Logo uploadé', 'success');
                } else { showToast('Erreur upload'); }
            } catch(e) { showToast('Erreur réseau'); }
        }

        function sanitizeSlug(input) { input.value = input.value.replace(/[^a-z0-9-]/g, '').toLowerCase(); }

        function createNewProject() {
            resetForm();
            document.getElementById('slug').value = "";
            document.getElementById('status-msg').innerText = "Nouveau projet";
            document.querySelectorAll('.sidebar-item').forEach(el => el.classList.remove('active'));
        }

        function addCustomLink(type = 'web', label = '', url = '') { customLinks.push({ id: Date.now(), type, label, url }); renderLinkInputs(); updateSignature(); }
        function removeLink(id) { customLinks = customLinks.filter(l => l.id !== id); renderLinkInputs(); updateSignature(); }
        function updateLinkData(id, field, value) { const link = customLinks.find(l => l.id === id); if(link) { link[field] = value; updateSignature(); } }

        function renderLinkInputs() {
            const container = document.getElementById('links-list');
            container.innerHTML = '';
            if (customLinks.length === 0) {
                container.innerHTML = '<div class="links-empty">Aucun lien ajouté</div>';
                return;
            }
            customLinks.forEach(link => {
                const div = document.createElement('div');
                div.className = 'link-item';
                div.innerHTML = `
                    <select onchange="updateLinkData(${link.id}, 'type', this.value)">
                        <option value="none" ${link.type === 'none' ? 'selected' : ''}>Sans icône</option>
                        <option value="web" ${link.type === 'web' ? 'selected' : ''}>Site Web</option>
                        <option value="linkedin" ${link.type === 'linkedin' ? 'selected' : ''}>LinkedIn</option>
                        <option value="instagram" ${link.type === 'instagram' ? 'selected' : ''}>Instagram</option>
                        <option value="facebook" ${link.type === 'facebook' ? 'selected' : ''}>Facebook</option>
                        <option value="calendar" ${link.type === 'calendar' ? 'selected' : ''}>Calendrier</option>
                    </select>
                    <input type="text" value="${escapeHtml(link.url)}" placeholder="URL du profil" oninput="updateLinkData(${link.id}, 'url', this.value)">
                    <button onclick="removeLink(${link.id})" class="link-delete" title="Supprimer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>`;
                container.appendChild(div);
            });
        }

        // ===== SIGNATURE HTML GENERATION =====
        function generateIconsHTML(data) {
            if (customLinks.length === 0) return '';
            let iconsCells = '';
            customLinks.forEach(link => {
                const iconUrl = ICONS[link.type] || ICONS.other;
                let linkHref = link.url || '';
                if(linkHref && !linkHref.match(/^https?:\/\//)) { linkHref = 'https://' + linkHref; }
                if(link.url) {
                    iconsCells += `
                    <td width="30" align="center" valign="middle">
                        <table cellpadding="0" cellspacing="0" border="0" width="28">
                            <tr>
                                <td bgcolor="${data.primaryColor}" width="28" height="28" align="center" valign="middle" style="background-color: ${data.primaryColor}; border-radius: 4px; width: 28px; height: 28px;">
                                    <a href="${linkHref}" target="_blank" style="text-decoration: none; display: block; line-height: 0;">
                                        <img src="${iconUrl}" width="16" height="16" style="width: 16px; height: 16px; display: inline-block; border: 0;">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>`;
                }
            });
            return `<table cellpadding="0" cellspacing="0" border="0" style="margin-top: 10px;"><tr>${iconsCells}</tr></table>`;
        }

        function generateHTML(data) {
            let finalLogoUrl = data.logoUrl;
            if (finalLogoUrl && !finalLogoUrl.startsWith('http')) { finalLogoUrl = window.location.origin + window.location.pathname.replace('index.php', '') + finalLogoUrl; }

            const iconsHtml = generateIconsHTML(data);
            const fs = parseInt(data.fontSize) || 14;
            const commonStyles = `font-family: Arial, sans-serif; font-size: ${fs}px; line-height: 1.4; color: #333333; mso-line-height-rule: exactly;`;
            const taglineHtml = data.tagline ? escapeHtml(data.tagline).replace(/\n/g, '<br>') : '';
            const safeName = escapeHtml(data.name);
            const safeJob = escapeHtml(data.job);
            const safeCompany = escapeHtml(data.company);
            const safeEmail = escapeHtml(data.email);
            const safePhone = escapeHtml(data.phone);
            const safeAddress = escapeHtml(data.address);
            const safeWebsite = escapeHtml((data.website || '').replace(/^https?:\/\//, ''));
            let webHref = data.website || '';
            if(webHref && !webHref.match(/^https?:\/\//)) { webHref = 'https://' + webHref; }
            const logoW = data.logoWidth || 100;
            const mapUrl = 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(data.address || '');

            const iconEmailImg = `<img src="${ICONS.email}" width="14" height="14" style="vertical-align:middle; width:14px; height:14px; border:0;" alt="Email">`;
            const iconPhoneImg = `<img src="${ICONS.phone}" width="14" height="14" style="vertical-align:middle; width:14px; height:14px; border:0;" alt="Tel">`;
            const iconWebImg = `<img src="${ICONS.web_black}" width="14" height="14" style="vertical-align:middle; width:14px; height:14px; border:0;" alt="Web">`;
            const iconAddrImg = `<img src="${ICONS.address}" width="14" height="14" style="vertical-align:middle; width:14px; height:14px; border:0;" alt="Adresse">`;

            function contactRow(iconImg, href, text) {
                return `<tr><td width="22" valign="middle" style="padding:0 5px 4px 0;">${iconImg}</td><td valign="middle" style="padding:0 0 4px 0; font-size:${fs}px; font-family:Arial,sans-serif;"><a href="${href}" style="color:#333333; text-decoration:none;" target="_blank">${text}</a></td></tr>`;
            }

            function contactTable() {
                let rows = '';
                if(data.email) rows += contactRow(iconEmailImg, `mailto:${data.email}`, safeEmail);
                if(data.phone) rows += contactRow(iconPhoneImg, `tel:${data.phone}`, safePhone);
                if(data.address) rows += contactRow(iconAddrImg, mapUrl, safeAddress);
                if(data.website) rows += contactRow(iconWebImg, webHref, safeWebsite);
                if (!rows) return '';
                return `<table cellpadding="0" cellspacing="0" border="0" style="font-size:${fs}px;">${rows}</table>`;
            }

            let reviewBtnHtml = '';
            if (data.googleReviewUrl) {
                let reviewHref = data.googleReviewUrl;
                if(!reviewHref.match(/^https?:\/\//)) { reviewHref = 'https://' + reviewHref; }
                reviewBtnHtml = `
                <table cellpadding="0" cellspacing="0" border="0" role="presentation">
                    <tr>
                        <td height="28" bgcolor="${data.primaryColor}" style="height:28px; background-color:${data.primaryColor}; border-radius:4px; mso-padding-alt:0 12px; vertical-align:middle;">
                            <a href="${reviewHref}" target="_blank" style="color:#ffffff; text-decoration:none; font-weight:bold; font-size:12px; font-family:Arial,sans-serif; display:inline-block; line-height:28px; padding:0 12px; mso-line-height-rule:exactly;">
                                &#11088; Laissez un avis
                            </a>
                        </td>
                    </tr>
                </table>`;
            }

            function footerRow() {
                if (!iconsHtml && !reviewBtnHtml) return '';
                return `
                <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="padding-top:10px;">
                    <tr>
                        <td valign="middle" style="padding-right:15px;">${iconsHtml}</td>
                        <td valign="middle">${reviewBtnHtml}</td>
                    </tr>
                </table>`;
            }

            let innerContent = "";

            if (data.template === 'classic') {
                innerContent = `
                <table cellpadding="0" cellspacing="0" border="0" role="presentation" width="100%" style="${commonStyles}">
                    <tr>
                        ${finalLogoUrl ? `<td valign="top" width="${logoW}" style="padding-right:15px;"><img src="${finalLogoUrl}" alt="${safeCompany || 'Logo'}" width="${logoW}" height="auto" style="width:${logoW}px; border-radius:4px; display:block; border:0;"></td>` : ''}
                        <td valign="top" width="2" style="padding-right:15px;">
                            <table cellpadding="0" cellspacing="0" border="0" role="presentation" width="2" style="width:2px;">
                                <tr><td bgcolor="${data.primaryColor}" width="2" height="100" style="width:2px; height:100px; background-color:${data.primaryColor}; font-size:1px; line-height:1px;">&nbsp;</td></tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="font-family:Arial,sans-serif;">
                                <tr><td style="font-weight:bold; font-size:${fs + 4}px; color:#000000; padding-bottom:2px; line-height:1.3; mso-line-height-rule:exactly;">${safeName}</td></tr>
                                <tr><td style="color:${data.primaryColor}; font-weight:bold; font-size:${fs}px; padding-bottom:6px;">${safeJob}${safeCompany ? ' | ' + safeCompany : ''}</td></tr>
                                ${taglineHtml ? `<tr><td style="font-size:${fs - 1}px; color:#666666; padding-bottom:8px; font-style:italic;">${taglineHtml}</td></tr>` : `<tr><td style="padding-bottom:8px; font-size:1px; line-height:1px;">&nbsp;</td></tr>`}
                                <tr><td>${contactTable()}</td></tr>
                                <tr><td>${footerRow()}</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>`;
            }

            if (data.template === 'horizontal') {
                let infoRows = '';
                if(data.email) infoRows += contactRow(iconEmailImg, `mailto:${data.email}`, safeEmail);
                if(data.phone) infoRows += contactRow(iconPhoneImg, `tel:${data.phone}`, safePhone);
                if(data.website) infoRows += contactRow(iconWebImg, webHref, safeWebsite);
                if(data.address) infoRows += contactRow(iconAddrImg, mapUrl, safeAddress);

                innerContent = `
                <table cellpadding="0" cellspacing="0" border="0" role="presentation" width="100%" style="${commonStyles}">
                    <tr>
                        ${finalLogoUrl ? `<td valign="top" width="${logoW}" style="padding-right:20px;"><img src="${finalLogoUrl}" alt="${safeCompany || 'Logo'}" width="${logoW}" height="auto" style="width:${logoW}px; border-radius:50%; display:block; border:0;"></td>` : ''}
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="font-family:Arial,sans-serif;">
                                <tr><td style="font-weight:bold; font-size:${fs + 4}px; color:#000000; line-height:1.3; mso-line-height-rule:exactly;">${safeName}</td></tr>
                                <tr><td style="font-size:${fs}px; color:#555555; padding-bottom:2px;">${safeJob} @ ${safeCompany}</td></tr>
                                ${taglineHtml ? `<tr><td style="font-size:${fs - 2}px; color:#888888;">${taglineHtml}</td></tr>` : ''}
                                <tr><td style="padding-top:8px; padding-bottom:8px;">
                                    <table cellpadding="0" cellspacing="0" border="0" role="presentation" width="100%"><tr><td bgcolor="${data.primaryColor}" height="1" style="height:1px; font-size:1px; line-height:1px; background-color:${data.primaryColor};">&nbsp;</td></tr></table>
                                </td></tr>
                                ${infoRows ? `<tr><td><table cellpadding="0" cellspacing="0" border="0" style="font-size:${fs}px;">${infoRows}</table></td></tr>` : ''}
                                <tr><td>
                                    <table cellpadding="0" cellspacing="0" border="0" role="presentation" width="100%" style="padding-top:5px;">
                                        <tr>
                                            <td align="left" valign="middle">${iconsHtml}</td>
                                            <td align="right" valign="middle">${reviewBtnHtml}</td>
                                        </tr>
                                    </table>
                                </td></tr>
                            </table>
                        </td>
                    </tr>
                </table>`;
            }

            if (data.template === 'header') {
                innerContent = `
                <table cellpadding="0" cellspacing="0" border="0" role="presentation" width="100%" style="${commonStyles}">
                    ${finalLogoUrl ? `<tr><td style="padding-bottom:15px;"><img src="${finalLogoUrl}" alt="${safeCompany || 'Logo'}" width="${logoW}" height="auto" style="width:${logoW}px; display:block; border:0;"></td></tr>` : ''}
                    <tr>
                        <td style="border-left:4px solid ${data.primaryColor}; padding-left:15px;">
                            <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="font-family:Arial,sans-serif;">
                                <tr><td style="font-weight:bold; font-size:${fs + 6}px; color:#000000; line-height:1.3; mso-line-height-rule:exactly;">${safeName}</td></tr>
                                <tr><td style="color:${data.primaryColor}; font-weight:bold; font-size:${fs}px; text-transform:uppercase;">${safeJob}</td></tr>
                                ${taglineHtml ? `<tr><td style="font-size:${fs - 2}px; color:#666666; padding-bottom:12px; padding-top:2px;">${taglineHtml}</td></tr>` : `<tr><td style="padding-bottom:12px; font-size:1px; line-height:1px;">&nbsp;</td></tr>`}
                                <tr><td>${contactTable()}</td></tr>
                                <tr><td>${footerRow()}</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>`;
            }

            const borderStyle = data.showBorder ? 'border:1px solid #eeeeee; border-radius:12px;' : '';

            return `<!--[if mso]><table role="presentation" width="650" cellpadding="0" cellspacing="0" border="0" align="left"><tr><td><![endif]-->
            <table cellpadding="0" cellspacing="0" border="0" role="presentation" align="left" style="width:100%; max-width:650px; background-color:#ffffff; ${borderStyle}">
                <tr>
                    <td style="padding:20px;">
                        ${innerContent}
                    </td>
                </tr>
            </table>
            <!--[if mso]></td></tr></table><![endif]-->`;
        }

        function getFormData() {
            return {
                template: document.getElementById('styleTemplate').value,
                name: document.getElementById('name').value,
                job: document.getElementById('job').value,
                tagline: document.getElementById('tagline').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                address: document.getElementById('address').value,
                company: document.getElementById('company').value,
                website: document.getElementById('website').value,
                logoUrl: document.getElementById('logoUrl').value,
                primaryColor: document.getElementById('primaryColor').value,
                fontSize: document.getElementById('fontSize').value,
                logoWidth: document.getElementById('logoWidth').value,
                googleReviewUrl: document.getElementById('googleReviewUrl').value,
                showBorder: document.getElementById('showBorder').checked
            };
        }

        function updateSignature() {
            const data = getFormData();
            document.getElementById('logoWidthDisplay').innerText = data.logoWidth + "px";
            document.getElementById('primaryColorText').value = data.primaryColor;
            document.getElementById('preview-output').innerHTML = generateHTML(data);
        }

        function resetForm() {
            document.querySelectorAll('input, textarea').forEach(i => {
                if(i.type === 'checkbox') i.checked = false;
                else if(i.type !== 'color' && i.type !== 'number' && i.type !== 'range') i.value = '';
            });
            document.getElementById('primaryColor').value = '#000000';
            document.getElementById('primaryColorText').value = '#000000';
            document.getElementById('fontSize').value = '14';
            document.getElementById('logoWidth').value = '100';
            document.getElementById('logoPreview').innerText = "";
            customLinks = [];
            renderLinkInputs();
            updateSignature();
        }

        async function copyToClipboard() {
            const html = generateHTML(getFormData());
            const btn = document.getElementById('copy-btn');
            try {
                await navigator.clipboard.write([new ClipboardItem({
                    'text/html': new Blob([html], { type: 'text/html' }),
                    'text/plain': new Blob([html], { type: 'text/plain' })
                })]);
                btn.classList.add('copied');
                btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Copié !';
                showToast('Signature copiée dans le presse-papier', 'success');
                setTimeout(() => {
                    btn.classList.remove('copied');
                    btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copier la signature';
                }, 2000);
            } catch (err) {
                navigator.clipboard.writeText(html);
                showToast('Copié en HTML brut');
            }
        }

        // Init
        fetchProjects();
        updateSignature();
        renderLinkInputs();
    </script>
</body>
</html>