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
    <title>Connexion - Signature Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-900 flex items-center justify-center p-4">
    <div class="relative">
        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl blur opacity-25"></div>
        <div class="relative bg-white/95 backdrop-blur-sm p-10 rounded-2xl shadow-2xl w-full max-w-sm text-center">
            <div class="mb-2">
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl mx-auto flex items-center justify-center mb-4 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h1 class="text-2xl font-bold text-slate-800">Signature Manager</h1>
                <p class="text-sm text-slate-400 mt-1">Connectez-vous pour continuer</p>
            </div>
            <form method="POST" class="mt-6">
                <div class="mb-4">
                    <input type="password" name="password" placeholder="Mot de passe"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 placeholder-slate-400" autofocus>
                </div>
                <?php if($error): ?>
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-3 py-2"><?php echo $error; ?></div>
                <?php endif; ?>
                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg">Se connecter</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php exit; } ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signature Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#f0f0ff', 100:'#e0e1ff', 200:'#c7c8fe', 300:'#a5a7fc', 400:'#8183f8', 500:'#6366f1', 600:'#4f46e5', 700:'#4338ca', 800:'#3730a3', 900:'#312e81' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .input-group label { display: block; font-size: 0.8rem; font-weight: 500; color: #64748b; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.025em; }
        .input-group input, .input-group select, .input-group textarea {
            width: 100%; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 0.55rem 0.75rem;
            font-size: 0.875rem; color: #1e293b; background: #f8fafc; transition: all 0.2s;
        }
        .input-group input:focus, .input-group select:focus, .input-group textarea:focus {
            outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); background: #fff;
        }

        input[type=range] { width: 100%; height: 6px; background: #e2e8f0; border-radius: 5px; outline: none; -webkit-appearance: none; }
        input[type=range]::-webkit-slider-thumb { -webkit-appearance: none; width: 20px; height: 20px; border-radius: 50%; background: #6366f1; cursor: pointer; transition: all .15s; box-shadow: 0 1px 3px rgba(0,0,0,0.2); }
        input[type=range]::-webkit-slider-thumb:hover { background: #4f46e5; transform: scale(1.1); }

        .link-item { background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; border-radius: 8px; margin-bottom: 8px; transition: all 0.15s; }
        .link-item:hover { border-color: #c7d2fe; background: #faf5ff; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .section-card { background: #fff; padding: 1.5rem; border-radius: 0.75rem; border: 1px solid #f1f5f9; box-shadow: 0 1px 2px rgba(0,0,0,0.04); transition: all 0.2s; }
        .section-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
        .section-title { display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem; }
        .section-icon { width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

        .project-item { transition: all 0.15s; }
        .project-item.active { background: #f0f0ff; border-left: 3px solid #6366f1; }

        #toast-container { position: fixed; top: 1rem; right: 1rem; z-index: 9999; display: flex; flex-direction: column; gap: 0.5rem; pointer-events: none; }
        .toast { pointer-events: auto; padding: 0.75rem 1rem; border-radius: 0.5rem; font-size: 0.85rem; font-weight: 500; color: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.15); animation: toastIn 0.3s ease, toastOut 0.3s ease 2.7s forwards; display: flex; align-items: center; gap: 0.5rem; }
        .toast.success { background: #059669; }
        .toast.error { background: #dc2626; }
        .toast.info { background: #4f46e5; }
        @keyframes toastIn { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes toastOut { from { opacity: 1; } to { opacity: 0; transform: translateY(-10px); } }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-slate-50">

    <div id="toast-container"></div>

    <!-- SIDEBAR -->
    <aside class="w-72 bg-white border-r border-slate-100 flex flex-col justify-between hidden md:flex shrink-0 z-40">
        <div>
            <div class="p-5 pb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-sm font-bold text-slate-800 leading-tight">Signature Manager</h1>
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest">Email signatures</p>
                    </div>
                </div>
            </div>
            <div class="px-3 mb-4">
                <button onclick="createNewProject()" class="w-full bg-brand-600 text-white font-semibold py-2.5 px-4 rounded-lg hover:bg-brand-700 transition-all duration-200 shadow-sm hover:shadow text-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nouveau projet
                </button>
            </div>
            <div class="px-4 pb-2">
                <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Projets</h3>
            </div>
            <nav id="project-list" class="px-3 space-y-0.5 overflow-y-auto h-[calc(100vh-220px)]">
                <div class="text-xs text-slate-400 italic px-2 py-3">Chargement...</div>
            </nav>
        </div>
        <div class="p-4 border-t border-slate-100">
            <a href="?logout=true" class="flex items-center justify-center gap-2 text-slate-400 text-xs font-medium hover:text-red-500 transition-colors py-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Deconnexion
            </a>
        </div>
    </aside>

    <!-- MAIN FORM -->
    <main class="flex-1 overflow-y-auto relative h-full">
        <div class="px-6 pb-20">

            <!-- STICKY HEADER -->
            <div class="sticky top-0 z-30 bg-slate-50 pt-5 pb-3">
                <div class="flex justify-between items-center bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div id="status-dot" class="w-2.5 h-2.5 rounded-full bg-amber-400 ring-4 ring-amber-50 transition-colors"></div>
                        <div>
                            <h3 class="text-slate-800 font-semibold text-sm leading-tight">Projet en cours</h3>
                            <p id="status-msg" class="text-slate-400 text-[11px] mt-0.5">Modifications non enregistrees</p>
                        </div>
                    </div>
                    <button onclick="saveProject()" id="save-btn" class="text-sm bg-brand-600 text-white px-5 py-2 rounded-lg hover:bg-brand-700 transition-all duration-200 shadow-sm hover:shadow font-semibold flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        Sauvegarder
                    </button>
                </div>
            </div>

            <div class="max-w-lg mx-auto space-y-4 mt-1">

                <!-- SLUG -->
                <div class="section-card">
                    <div class="section-title">
                        <div class="section-icon bg-slate-100 text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                        </div>
                        Configuration Projet
                    </div>
                    <div class="input-group">
                        <label>ID Unique (Slug)</label>
                        <input type="text" id="slug" placeholder="ex: nicolas-gallet" class="font-mono !bg-white" oninput="sanitizeSlug(this)">
                    </div>
                </div>

                <!-- STYLE -->
                <div class="section-card !border-l-[3px] !border-l-brand-500">
                    <div class="section-title">
                        <div class="section-icon bg-brand-50 text-brand-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                        </div>
                        Style & Apparence
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="input-group col-span-2">
                            <label>Template</label>
                            <select id="styleTemplate" onchange="updateSignature()">
                                <option value="classic">Classique (Barre Laterale)</option>
                                <option value="horizontal">Horizontal (Epure)</option>
                                <option value="header">Vertical (Logo au-dessus)</option>
                            </select>
                        </div>

                        <div class="input-group col-span-2">
                            <div class="flex justify-between items-center mb-1">
                                <label class="!mb-0">Taille du Logo</label>
                                <span id="logoWidthDisplay" class="text-[11px] font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-md">100px</span>
                            </div>
                            <input type="range" id="logoWidth" min="50" max="350" value="100" class="w-full" oninput="updateSignature()">
                        </div>

                        <div class="input-group">
                            <label>Couleur Principale</label>
                            <div class="flex items-center gap-2">
                                <input type="color" id="primaryColor" value="#000000" class="h-9 w-11 p-0.5 border border-slate-200 rounded-lg cursor-pointer" oninput="updateSignature()">
                                <input type="text" id="primaryColorText" value="#000000" class="flex-1 font-mono text-xs" oninput="document.getElementById('primaryColor').value = this.value; updateSignature()">
                            </div>
                        </div>
                        <div class="input-group">
                            <label>Taille police (px)</label>
                            <input type="number" id="fontSize" value="14" min="10" max="20" oninput="updateSignature()">
                        </div>
                    </div>
                    <div class="flex items-center mt-4 pt-4 border-t border-slate-100">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="showBorder" class="sr-only peer" onchange="updateSignature()">
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-600"></div>
                            <span class="ml-3 text-sm font-medium text-slate-600">Cadre autour de la signature</span>
                        </label>
                    </div>
                </div>

                <!-- IDENTITE -->
                <div class="section-card">
                    <div class="section-title">
                        <div class="section-icon bg-emerald-50 text-emerald-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        Identite
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="input-group">
                            <label>Prenom & Nom</label>
                            <input type="text" id="name" placeholder="Jean Dupont" oninput="updateSignature()">
                        </div>
                        <div class="input-group">
                            <label>Poste / Fonction</label>
                            <input type="text" id="job" placeholder="Chef de projet" oninput="updateSignature()">
                        </div>
                        <div class="input-group col-span-2">
                            <label>Texte libre / Slogan</label>
                            <textarea id="tagline" rows="2" placeholder="Service Comptabilite&#10;il/lui" class="w-full" oninput="updateSignature()"></textarea>
                        </div>
                    </div>
                </div>

                <!-- COORDONNEES -->
                <div class="section-card">
                    <div class="section-title">
                        <div class="section-icon bg-sky-50 text-sky-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        Coordonnees
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="input-group">
                            <label>Email</label>
                            <input type="email" id="email" placeholder="jean@entreprise.com" oninput="updateSignature()">
                        </div>
                        <div class="input-group">
                            <label>Telephone</label>
                            <input type="text" id="phone" placeholder="+33 1 23 45 67 89" oninput="updateSignature()">
                        </div>
                        <div class="input-group col-span-2">
                            <label>Adresse Postale</label>
                            <input type="text" id="address" placeholder="12 Rue de la Paix, 75000 Paris" oninput="updateSignature()">
                        </div>
                    </div>
                </div>

                <!-- ENTREPRISE -->
                <div class="section-card">
                    <div class="section-title">
                        <div class="section-icon bg-amber-50 text-amber-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        Entreprise & Logo
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="input-group">
                            <label>Nom de l'entreprise</label>
                            <input type="text" id="company" placeholder="Mon Entreprise" oninput="updateSignature()">
                        </div>
                        <div class="input-group">
                            <label>Site Web</label>
                            <input type="text" id="website" placeholder="www.exemple.com" oninput="updateSignature()">
                        </div>
                    </div>
                    <div class="p-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-lg text-center mb-4 hover:border-brand-300 hover:bg-brand-50/30 transition-colors cursor-pointer">
                        <label class="cursor-pointer block">
                            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-sm font-medium text-brand-600">Cliquez pour uploader le Logo</span>
                            <input type="file" id="logoInput" class="hidden" accept="image/*" onchange="uploadLogo()">
                        </label>
                        <p class="text-[11px] text-slate-400 mt-1">PNG, JPG, SVG ou WebP</p>
                        <input type="hidden" id="logoUrl">
                        <div id="logoPreview" class="mt-2 h-5 text-xs text-emerald-600 font-semibold"></div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <div class="input-group">
                            <label class="!flex !items-center !gap-1.5 !text-amber-600">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                Lien Avis Google
                            </label>
                            <input type="text" id="googleReviewUrl" placeholder="https://g.page/r/..." oninput="updateSignature()">
                            <p class="text-[11px] text-slate-400 mt-1">Laissez vide pour masquer le bouton.</p>
                        </div>
                    </div>
                </div>

                <!-- RESEAUX SOCIAUX -->
                <div class="section-card">
                    <div class="flex justify-between items-center mb-4">
                        <div class="section-title !mb-0">
                            <div class="section-icon bg-violet-50 text-violet-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            </div>
                            Reseaux Sociaux
                        </div>
                        <button onclick="addCustomLink()" class="text-xs bg-brand-50 text-brand-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-brand-100 transition-colors">+ Ajouter</button>
                    </div>
                    <div id="links-list" class="space-y-2"></div>
                </div>
            </div>
        </div>
    </main>

    <!-- PREVIEW PANEL -->
    <aside class="w-[580px] bg-slate-100 border-l border-slate-200 flex flex-col hidden lg:flex shrink-0">
        <div class="p-3 border-b border-slate-200 bg-white text-center">
            <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Apercu Email</h3>
        </div>

        <div class="flex-1 flex flex-col p-5 overflow-auto">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200 w-full flex flex-col">
                <!-- Window Chrome -->
                <div class="bg-slate-50 px-4 py-2.5 border-b border-slate-100 flex items-center gap-1.5">
                    <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-amber-400"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-400"></div>
                    <div class="flex-1 flex justify-center">
                        <div class="bg-slate-100 rounded-md px-8 py-1 text-[10px] text-slate-400 font-medium">Nouveau message</div>
                    </div>
                </div>
                <!-- Email Header -->
                <div class="px-6 py-3 border-b border-slate-50 bg-white">
                    <div class="text-xs text-slate-700 mb-0.5"><span class="text-slate-400 font-medium">A :</span> client@exemple.com</div>
                    <div class="text-xs text-slate-700"><span class="text-slate-400 font-medium">Objet :</span> Proposition commerciale - Projet X</div>
                </div>

                <!-- Email Body -->
                <div class="p-6 bg-white flex-1 overflow-auto">
                    <p class="text-sm text-slate-500 mb-3 leading-relaxed">Bonjour,</p>
                    <p class="text-sm text-slate-500 mb-4 leading-relaxed">Voici la proposition finale comme convenu. N'hesitez pas a revenir vers moi si vous avez des questions.</p>
                    <p class="text-sm text-slate-500 mb-6 leading-relaxed">Bien cordialement,</p>

                    <div id="preview-output" class="w-full"></div>
                </div>
            </div>
        </div>

        <!-- COPY BUTTON -->
        <div class="p-4 bg-white border-t border-slate-200">
            <button onclick="copyToClipboard()" id="copy-btn" class="w-full bg-brand-600 text-white font-semibold py-3.5 rounded-xl hover:bg-brand-700 transition-all duration-200 shadow-sm hover:shadow-md text-sm flex items-center justify-center gap-2">
                <svg id="copy-icon" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                <span id="copy-text">Copier la signature</span>
            </button>
            <p class="text-[11px] text-center text-slate-400 mt-2">Compatible Outlook, Gmail, Apple Mail</p>
        </div>
    </aside>

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
        let activeSlug = null;

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function toast(message, type = 'info') {
            const container = document.getElementById('toast-container');
            const t = document.createElement('div');
            t.className = 'toast ' + type;
            const icons = { success: '&#10003;', error: '&#10007;', info: '&#8505;' };
            t.innerHTML = `<span>${icons[type] || ''}</span> ${escapeHtml(message)}`;
            container.appendChild(t);
            setTimeout(() => t.remove(), 3000);
        }

        async function deleteProject(slug) {
            if (!confirm('Supprimer le projet "' + slug + '" ?')) return;
            try {
                const res = await fetch('api.php?action=delete&slug=' + encodeURIComponent(slug), { method: 'POST' });
                const result = await res.json();
                if (result.success) { toast('Projet supprime', 'success'); fetchProjects(); if (activeSlug === slug) createNewProject(); }
                else { toast(result.error || 'Suppression impossible', 'error'); }
            } catch(e) { toast('Erreur reseau', 'error'); }
        }

        async function fetchProjects() {
            const listEl = document.getElementById('project-list');
            listEl.innerHTML = '<div class="text-xs text-slate-400 italic px-2 py-3">Chargement...</div>';
            try {
                const res = await fetch('api.php?action=list');
                if(res.status === 403) { window.location.reload(); return; }
                const projects = await res.json();
                listEl.innerHTML = '';
                if(projects.length === 0) listEl.innerHTML = '<div class="text-xs text-slate-400 px-2 py-6 text-center">Aucun projet</div>';
                projects.forEach(p => {
                    const div = document.createElement('div');
                    const isActive = activeSlug === p.slug;
                    div.className = 'project-item cursor-pointer px-3 py-2 hover:bg-slate-50 rounded-lg group transition-all flex justify-between items-center' + (isActive ? ' active' : '');
                    div.innerHTML = `
                        <div class="flex-1 min-w-0" onclick="loadProject('${p.slug}')">
                            <div class="font-semibold text-slate-700 text-sm truncate group-hover:text-brand-600 transition-colors">${escapeHtml(p.name) || 'Sans nom'}</div>
                            <div class="text-[11px] text-slate-400 truncate">${escapeHtml(p.job) || p.slug}</div>
                        </div>
                        <span onclick="event.stopPropagation(); deleteProject('${p.slug}')" class="text-slate-300 hover:text-red-500 text-sm font-bold opacity-0 group-hover:opacity-100 transition-all ml-2 p-1" title="Supprimer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </span>`;
                    listEl.appendChild(div);
                });
            } catch (e) { listEl.innerHTML = '<div class="text-red-500 text-xs px-2">Erreur serveur</div>'; }
        }

        async function saveProject() {
            const slug = document.getElementById('slug').value;
            if(!slug) { toast('Ajoutez un ID Unique (Slug) avant de sauvegarder.', 'error'); return; }
            const btn = document.getElementById('save-btn');
            btn.disabled = true; btn.classList.add('opacity-60');
            const data = getFormData();
            data.customLinks = customLinks;
            data.slug = slug;
            try {
                const res = await fetch('api.php?action=save', { method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(data) });
                const result = await res.json();
                if(result.success) {
                    activeSlug = slug;
                    document.getElementById('status-msg').innerText = "Sauvegarde a " + new Date().toLocaleTimeString();
                    document.getElementById('status-dot').className = 'w-2.5 h-2.5 rounded-full bg-emerald-400 ring-4 ring-emerald-50 transition-colors';
                    toast('Projet sauvegarde', 'success');
                    fetchProjects();
                } else { toast(result.error || 'Erreur', 'error'); }
            } catch(e) { toast('Erreur connexion', 'error'); }
            btn.disabled = false; btn.classList.remove('opacity-60');
        }

        async function loadProject(slug) {
            try {
                const res = await fetch(`api.php?action=load&slug=${slug}`);
                const data = await res.json();
                if(data.error) { toast('Projet introuvable', 'error'); return; }
                activeSlug = slug;
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
                document.getElementById('logoPreview').innerText = data.logoUrl ? "Logo charge" : "";
                document.getElementById('primaryColor').value = data.primaryColor || '#000000';
                document.getElementById('primaryColorText').value = data.primaryColor || '#000000';
                document.getElementById('fontSize').value = data.fontSize || 14;
                document.getElementById('logoWidth').value = data.logoWidth || 100;
                document.getElementById('googleReviewUrl').value = data.googleReviewUrl || '';
                document.getElementById('showBorder').checked = data.showBorder || false;
                customLinks = data.customLinks || [];
                renderLinkInputs(); updateSignature();
                document.getElementById('status-msg').innerText = "Projet charge : " + slug;
                document.getElementById('status-dot').className = 'w-2.5 h-2.5 rounded-full bg-emerald-400 ring-4 ring-emerald-50 transition-colors';
                fetchProjects();
            } catch(e) { toast('Erreur chargement', 'error'); }
        }

        async function uploadLogo() {
            const slug = document.getElementById('slug').value;
            if(!slug) { toast("Definissez d'abord un ID Unique.", 'error'); return; }
            const fileInput = document.getElementById('logoInput');
            if(!fileInput.files[0]) return;
            const formData = new FormData();
            formData.append('logo_file', fileInput.files[0]);
            formData.append('slug', slug);
            document.getElementById('logoPreview').innerText = "Upload en cours...";
            try {
                const res = await fetch('api.php?action=upload_logo', { method: 'POST', body: formData });
                const result = await res.json();
                if(result.url) { document.getElementById('logoUrl').value = result.url; document.getElementById('logoPreview').innerText = "Logo charge"; toast('Logo uploade', 'success'); updateSignature(); }
                else { toast(result.error || 'Erreur upload', 'error'); document.getElementById('logoPreview').innerText = ""; }
            } catch(e) { toast('Erreur reseau', 'error'); document.getElementById('logoPreview').innerText = ""; }
        }

        function sanitizeSlug(input) { input.value = input.value.replace(/[^a-z0-9-]/g, '').toLowerCase(); }
        function createNewProject() {
            activeSlug = null; resetForm();
            document.getElementById('slug').value = "";
            document.getElementById('status-msg').innerText = "Nouveau projet";
            document.getElementById('status-dot').className = 'w-2.5 h-2.5 rounded-full bg-amber-400 ring-4 ring-amber-50 transition-colors';
            fetchProjects();
        }
        function addCustomLink(type = 'web', label = '', url = '') { customLinks.push({ id: Date.now(), type, label, url }); renderLinkInputs(); updateSignature(); }
        function removeLink(id) { customLinks = customLinks.filter(l => l.id !== id); renderLinkInputs(); updateSignature(); }
        function updateLinkData(id, field, value) { const link = customLinks.find(l => l.id === id); if(link) { link[field] = value; updateSignature(); } }

        function renderLinkInputs() {
            const container = document.getElementById('links-list'); container.innerHTML = '';
            if (customLinks.length === 0) {
                container.innerHTML = '<div class="text-xs text-slate-400 text-center py-3">Aucun reseau ajoute</div>';
                return;
            }
            customLinks.forEach(link => {
                const div = document.createElement('div');
                div.className = 'link-item grid grid-cols-12 gap-2 items-center';
                div.innerHTML = `<div class="col-span-4"><select onchange="updateLinkData(${link.id}, 'type', this.value)" class="w-full border border-slate-200 p-1.5 rounded-lg text-xs bg-white focus:outline-none focus:border-brand-400"><option value="none" ${link.type === 'none' ? 'selected' : ''}>Sans icone</option><option value="web" ${link.type === 'web' ? 'selected' : ''}>Site Web</option><option value="linkedin" ${link.type === 'linkedin' ? 'selected' : ''}>LinkedIn</option><option value="instagram" ${link.type === 'instagram' ? 'selected' : ''}>Instagram</option><option value="facebook" ${link.type === 'facebook' ? 'selected' : ''}>Facebook</option><option value="calendar" ${link.type === 'calendar' ? 'selected' : ''}>Calendrier</option></select></div><div class="col-span-7"><input type="text" value="${escapeHtml(link.url)}" placeholder="URL" oninput="updateLinkData(${link.id}, 'url', this.value)" class="w-full border border-slate-200 p-1.5 rounded-lg text-xs focus:outline-none focus:border-brand-400"></div><div class="col-span-1 text-right"><span onclick="removeLink(${link.id})" class="text-slate-300 cursor-pointer hover:text-red-500 transition-colors inline-flex"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></span></div>`;
                container.appendChild(div);
            });
        }

        // --- ICONS GENERATOR ---
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
            document.getElementById('preview-output').innerHTML = generateHTML(data);
            // Mark as unsaved
            document.getElementById('status-dot').className = 'w-2.5 h-2.5 rounded-full bg-amber-400 ring-4 ring-amber-50 transition-colors';
            document.getElementById('status-msg').innerText = "Modifications non enregistrees";
        }

        function resetForm() {
            document.querySelectorAll('input, textarea').forEach(i => {
                if(i.type === 'checkbox') i.checked = false;
                else if(i.type !== 'color' && i.type !== 'number' && i.type !== 'range') i.value = '';
            });
            document.getElementById('logoPreview').innerText = "";
            customLinks = []; renderLinkInputs(); updateSignature();
        }

        async function copyToClipboard() {
            const html = generateHTML(getFormData());
            const btn = document.getElementById('copy-btn');
            const textEl = document.getElementById('copy-text');
            const iconEl = document.getElementById('copy-icon');
            try {
                await navigator.clipboard.write([new ClipboardItem({
                    'text/html': new Blob([html], { type: 'text/html' }),
                    'text/plain': new Blob([html], { type: 'text/plain' })
                })]);
                btn.classList.remove('bg-brand-600', 'hover:bg-brand-700');
                btn.classList.add('bg-emerald-500');
                iconEl.outerHTML = '<svg id="copy-icon" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                textEl.textContent = 'Copie !';
                setTimeout(() => {
                    btn.classList.add('bg-brand-600', 'hover:bg-brand-700');
                    btn.classList.remove('bg-emerald-500');
                    document.getElementById('copy-icon').outerHTML = '<svg id="copy-icon" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>';
                    textEl.textContent = 'Copier la signature';
                }, 2000);
            } catch (err) {
                navigator.clipboard.writeText(html);
                toast('Copie en HTML brut (fallback)', 'info');
            }
        }

        // Keyboard shortcut: Ctrl+S / Cmd+S to save
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                saveProject();
            }
        });

        fetchProjects(); updateSignature();
    </script>
</body>
</html>