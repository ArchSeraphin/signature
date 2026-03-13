<?php
// api.php - Backend sécurisé
session_start();
header('Content-Type: application/json');

// SÉCURITÉ : Si pas connecté, on bloque tout
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    http_response_code(403);
    echo json_encode(['error' => 'Non autorisé']);
    exit;
}

$DATA_DIR = 'data';
$action = $_GET['action'] ?? '';

// 1. LISTER
if ($action === 'list') {
    $projects = [];
    if (is_dir($DATA_DIR)) {
        $dirs = array_diff(scandir($DATA_DIR), array('..', '.'));
        foreach ($dirs as $dir) {
            if (is_dir($DATA_DIR . '/' . $dir) && file_exists($DATA_DIR . '/' . $dir . '/data.json')) {
                $json = json_decode(file_get_contents($DATA_DIR . '/' . $dir . '/data.json'), true);
                $projects[] = [
                    'slug' => $dir,
                    'name' => $json['name'] ?? $dir,
                    'job' => $json['job'] ?? ''
                ];
            }
        }
    }
    echo json_encode($projects);
    exit;
}

// 2. CHARGER
if ($action === 'load' && isset($_GET['slug'])) {
    $slug = basename($_GET['slug']);
    $file = $DATA_DIR . '/' . $slug . '/data.json';
    if (file_exists($file)) {
        echo file_get_contents($file);
    } else {
        echo json_encode(['error' => 'Not found']);
    }
    exit;
}

// 3. SAUVEGARDER
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'save') {
    $input = json_decode(file_get_contents('php://input'), true);
    $slug = $input['slug'] ?? '';
    $slug = preg_replace('/[^a-z0-9-]/', '', strtolower($slug));

    if (!$slug) { echo json_encode(['error' => 'Slug invalide']); exit; }

    $targetDir = $DATA_DIR . '/' . $slug;
    if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

    file_put_contents($targetDir . '/data.json', json_encode($input, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo json_encode(['success' => true, 'slug' => $slug]);
    exit;
}

// 4. UPLOAD LOGO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'upload_logo') {
    $slug = $_POST['slug'] ?? '';
    $slug = preg_replace('/[^a-z0-9-]/', '', strtolower($slug));
    if (!$slug) { echo json_encode(['error' => 'Slug requis']); exit; }

    $targetDir = $DATA_DIR . '/' . $slug;
    if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

    if (isset($_FILES['logo_file'])) {
        $ext = strtolower(pathinfo($_FILES['logo_file']['name'], PATHINFO_EXTENSION));
        $allowedExts = ['png', 'jpg', 'jpeg', 'gif', 'webp', 'svg'];
        if (!in_array($ext, $allowedExts)) {
            echo json_encode(['error' => 'Format non autorisé. Utilisez : ' . implode(', ', $allowedExts)]);
            exit;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['logo_file']['tmp_name']);
        finfo_close($finfo);
        $allowedMimes = ['image/png', 'image/jpeg', 'image/gif', 'image/webp', 'image/svg+xml'];
        if (!in_array($mime, $allowedMimes)) {
            echo json_encode(['error' => 'Type MIME non autorisé : ' . $mime]);
            exit;
        }

        $filename = 'logo.' . $ext;
        if (move_uploaded_file($_FILES['logo_file']['tmp_name'], $targetDir . '/' . $filename)) {
            $url = 'data/' . $slug . '/' . $filename . '?v=' . time();
            echo json_encode(['url' => $url]);
        } else {
            echo json_encode(['error' => 'Upload failed']);
        }
    }
    exit;
}

// 5. SUPPRIMER UN PROJET
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete') {
    $slug = $_GET['slug'] ?? '';
    $slug = preg_replace('/[^a-z0-9-]/', '', strtolower($slug));
    if (!$slug) { echo json_encode(['error' => 'Slug invalide']); exit; }

    $targetDir = $DATA_DIR . '/' . $slug;
    if (!is_dir($targetDir)) {
        echo json_encode(['error' => 'Projet introuvable']);
        exit;
    }

    // Suppression récursive du dossier
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($targetDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($files as $file) {
        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
    rmdir($targetDir);

    echo json_encode(['success' => true]);
    exit;
}

echo json_encode(['error' => 'Action inconnue']);
?>